import { RequestHandler } from "express";

export interface Order {
  id: string;
  userId: number | null;
  customer: {
    name: string;
    email: string;
    phone: string;
    address: string;
    city: string;
  };
  items: Array<{
    productId: number;
    quantity: number;
  }>;
  subtotal: number;
  shippingCost: number;
  discount: number;
  total: number;
  paymentMethod: "cod" | "card";
  status: "pending" | "confirmed" | "shipped" | "delivered" | "cancelled";
  createdAt: Date;
}

let orders: Order[] = [];

function generateOrderId() {
  return "ORD" + Date.now() + Math.random().toString(36).substr(2, 9);
}

export const handleCreateOrder: RequestHandler = (req, res) => {
  const { customer, items, subtotal, shippingCost, discount, total, paymentMethod } = req.body;
  const userId = (req as any).user?.id || null;

  if (!customer || !items || !subtotal) {
    return res.status(400).json({ message: "Vui lòng cung cấp đủ thông tin đơn hàng" });
  }

  const order: Order = {
    id: generateOrderId(),
    userId,
    customer,
    items,
    subtotal,
    shippingCost: shippingCost || 0,
    discount: discount || 0,
    total: total || subtotal,
    paymentMethod: paymentMethod || "cod",
    status: "pending",
    createdAt: new Date(),
  };

  orders.push(order);
  res.status(201).json(order);
};

export const handleGetOrders: RequestHandler = (req, res) => {
  const userId = (req as any).user?.id;
  const userRole = (req as any).user?.role;

  // Admin can see all orders, users can only see their own
  if (userRole === "admin") {
    return res.json(orders);
  }

  if (userId) {
    const userOrders = orders.filter((o) => o.userId === userId);
    return res.json(userOrders);
  }

  res.status(401).json({ message: "Chưa đăng nhập" });
};

export const handleGetOrder: RequestHandler = (req, res) => {
  const orderId = req.params.id;
  const userId = (req as any).user?.id;
  const userRole = (req as any).user?.role;

  const order = orders.find((o) => o.id === orderId);

  if (!order) {
    return res.status(404).json({ message: "Đơn hàng không tìm thấy" });
  }

  // Check if user has access to this order
  if (userRole !== "admin" && order.userId !== userId) {
    return res.status(403).json({ message: "Không có quyền truy cập" });
  }

  res.json(order);
};

export const handleUpdateOrder: RequestHandler = (req, res) => {
  const orderId = req.params.id;
  const userRole = (req as any).user?.role;
  const { status } = req.body;

  if (userRole !== "admin") {
    return res.status(403).json({ message: "Chỉ admin mới có thể cập nhật đơn hàng" });
  }

  const order = orders.find((o) => o.id === orderId);

  if (!order) {
    return res.status(404).json({ message: "Đơn hàng không tìm thấy" });
  }

  if (status) {
    order.status = status;
  }

  res.json(order);
};
