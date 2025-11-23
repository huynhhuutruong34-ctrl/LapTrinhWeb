import { useState, FormEvent } from "react";
import { useNavigate } from "react-router-dom";
import { useCart } from "@/components/cart/CartProvider";
import { Button } from "@/components/ui/button";
import { useToast } from "@/hooks/use-toast";

export default function CheckoutPage() {
  const { items, subtotal, clear } = useCart();
  const navigate = useNavigate();
  const { toast } = useToast();

  const [name, setName] = useState("");
  const [email, setEmail] = useState("");
  const [phone, setPhone] = useState("");
  const [address, setAddress] = useState("");
  const [city, setCity] = useState("");
  const [paymentMethod, setPaymentMethod] = useState("cod");
  const [loading, setLoading] = useState(false);

  const handleSubmit = async (e: FormEvent) => {
    e.preventDefault();
    if (items.length === 0) {
      toast({ title: "Giỏ hàng trống", description: "Vui lòng thêm sản phẩm trước khi thanh toán." });
      return;
    }

    setLoading(true);
    try {
      const resp = await fetch("/api/orders", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        credentials: "include",
        body: JSON.stringify({
          customer: { name, email, phone, address, city },
          items: items.map((it) => ({ productId: it.product.id, quantity: it.quantity })),
          subtotal,
          paymentMethod,
        }),
      });

      if (!resp.ok) throw new Error("Server error");
      const data = await resp.json();
      clear();
      toast({ title: "Đặt hàng thành công", description: `Mã đơn: ${data.id}` });
      navigate(`/order-success/${data.id}`);
    } catch (err) {
      console.error(err);
      toast({ title: "Lỗi", description: "Không thể hoàn tất đơn hàng. Vui lòng thử lại." });
    } finally {
      setLoading(false);
    }
  };

  if (items.length === 0) {
    return (
      <div className="container mx-auto px-4 py-24 text-center">
        <h2 className="text-2xl font-semibold">Giỏ hàng của bạn đang trống</h2>
        <p className="mt-2 text-muted-foreground">Thêm sản phẩm và quay lại đây để thanh toán.</p>
        <div className="mt-4">
          <a href="/catalog" className="rounded-md border px-4 py-2">Xem sản phẩm</a>
        </div>
      </div>
    );
  }

  return (
    <div className="container mx-auto px-4 py-12">
      <h1 className="text-2xl font-bold">Thanh toán</h1>
      <div className="mt-6 grid gap-6 md:grid-cols-3">
        <form className="md:col-span-2 space-y-4" onSubmit={handleSubmit}>
          <div>
            <label className="text-sm font-medium">Họ & Tên</label>
            <input required value={name} onChange={(e) => setName(e.target.value)} className="mt-2 w-full rounded-md border bg-background px-3 py-2" />
          </div>
          <div className="grid grid-cols-2 gap-4">
            <div>
              <label className="text-sm font-medium">Email</label>
              <input required type="email" value={email} onChange={(e) => setEmail(e.target.value)} className="mt-2 w-full rounded-md border bg-background px-3 py-2" />
            </div>
            <div>
              <label className="text-sm font-medium">Số điện thoại</label>
              <input required value={phone} onChange={(e) => setPhone(e.target.value)} className="mt-2 w-full rounded-md border bg-background px-3 py-2" />
            </div>
          </div>

          <div>
            <label className="text-sm font-medium">Địa chỉ</label>
            <input required value={address} onChange={(e) => setAddress(e.target.value)} className="mt-2 w-full rounded-md border bg-background px-3 py-2" />
          </div>

          <div>
            <label className="text-sm font-medium">Thành phố</label>
            <input required value={city} onChange={(e) => setCity(e.target.value)} className="mt-2 w-full rounded-md border bg-background px-3 py-2" />
          </div>

          <div>
            <label className="text-sm font-medium">Phương thức thanh toán</label>
            <div className="mt-2 flex items-center gap-3">
              <label className={`rounded-md border px-3 py-1 ${paymentMethod === "cod" ? "bg-primary text-primary-foreground" : ""}`}>
                <input type="radio" name="pay" checked={paymentMethod === "cod"} onChange={() => setPaymentMethod("cod")} className="mr-2" /> COD
              </label>
              <label className={`rounded-md border px-3 py-1 ${paymentMethod === "card" ? "bg-primary text-primary-foreground" : ""}`}>
                <input type="radio" name="pay" checked={paymentMethod === "card"} onChange={() => setPaymentMethod("card")} className="mr-2" /> Thẻ (giả lập)
              </label>
            </div>
          </div>

          <div className="mt-4">
            <Button type="submit" size="lg" disabled={loading}>{loading ? "Đang xử lý..." : "Thanh toán"}</Button>
          </div>
        </form>

        <aside className="space-y-4 rounded-lg border p-4">
          <h3 className="font-semibold">Đơn hàng</h3>
          <div className="space-y-3">
            {items.map((it, idx) => (
              <div key={idx} className="flex items-center justify-between">
                <div className="text-sm">{it.product.name} x {it.quantity}</div>
                <div className="font-semibold">{(it.product.price * it.quantity).toLocaleString("vi-VN")}₫</div>
              </div>
            ))}
          </div>
          <div className="border-t pt-3">
            <div className="flex items-center justify-between">
              <div className="text-sm text-muted-foreground">Tạm tính</div>
              <div className="font-semibold">{subtotal.toLocaleString("vi-VN")}₫</div>
            </div>
          </div>
        </aside>
      </div>
    </div>
  );
}
