import { RequestHandler } from "express";
import { z } from "zod";

const CheckoutSchema = z.object({
  customer: z.object({
    name: z.string().min(1),
    email: z.string().email(),
    phone: z.string().min(7),
    address: z.string().min(3),
    city: z.string().min(1),
  }),
  items: z.array(z.object({ productId: z.number(), quantity: z.number().min(1) })),
  subtotal: z.number().min(0),
  paymentMethod: z.string().optional(),
});

export const handleCheckout: RequestHandler = (req, res) => {
  try {
    const parsed = CheckoutSchema.parse(req.body);

    const orderId = `ord_${Date.now()}`;

    // In a real app: persist order to DB, charge payment, send emails...
    console.log("New order:", { orderId, ...parsed });

    res.status(201).json({ orderId, message: "Order placed successfully" });
  } catch (err) {
    console.error("Checkout validation error", err);
    res.status(400).json({ error: "Invalid payload" });
  }
};
