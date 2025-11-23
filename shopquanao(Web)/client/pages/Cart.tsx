import { Link } from "react-router-dom";
import { useState } from "react";
import { useCart } from "@/components/cart/CartProvider";
import { Button } from "@/components/ui/button";
import { useToast } from "@/hooks/use-toast";

export default function CartPage() {
  const { items, updateQuantity, removeItem, subtotal, clear, applyCoupon, couponCode, removeCoupon, discount, shippingCity, setShippingCity, shippingCost, total } = useCart();
  const [code, setCode] = useState("");
  const { toast } = useToast();

  if (items.length === 0) {
    return (
      <div className="container mx-auto px-4 py-24 text-center">
        <h2 className="text-2xl font-semibold">Giỏ hàng của bạn đang trống</h2>
        <p className="mt-2 text-muted-foreground">Thêm sản phẩm và quay lại đây để thanh toán.</p>
        <div className="mt-4">
          <Link to="/catalog" className="rounded-md border px-4 py-2">Xem sản phẩm</Link>
        </div>
      </div>
    );
  }

  return (
    <div className="container mx-auto px-4 py-12">
      <h1 className="text-2xl font-bold">Giỏ hàng</h1>
      <div className="mt-6 grid gap-6 md:grid-cols-3">
        <div className="md:col-span-2 space-y-4">
          {items.map((it, idx) => (
            <div key={idx} className="flex items-center gap-4 rounded-lg border p-4">
              <img src={it.product.images[0]} alt={it.product.name} className="h-24 w-24 object-cover rounded-md" />
              <div className="flex-1">
                <div className="flex items-center justify-between">
                  <div>
                    <div className="font-medium">{it.product.name}</div>
                    <div className="text-sm text-muted-foreground">{it.color} • {it.size}</div>
                  </div>
                  <div className="font-semibold">{(it.product.price * it.quantity).toLocaleString("vi-VN")}₫</div>
                </div>
                <div className="mt-3 flex items-center gap-2">
                  <button onClick={() => updateQuantity(idx, it.quantity - 1)} className="rounded-md border px-3 py-1">-</button>
                  <div className="w-10 text-center">{it.quantity}</div>
                  <button onClick={() => updateQuantity(idx, it.quantity + 1)} className="rounded-md border px-3 py-1">+</button>
                  <button onClick={() => removeItem(idx)} className="ml-4 text-sm text-destructive">Xóa</button>
                </div>
              </div>
            </div>
          ))}
        </div>

        <aside className="space-y-4 rounded-lg border p-4">
          <h3 className="font-semibold">Tóm tắt đơn</h3>

          <div>
            <label className="text-sm font-medium">Mã giảm giá</label>
            <div className="mt-2 flex gap-2">
              <input value={code} onChange={(e) => setCode(e.target.value)} placeholder="Nhập mã" className="flex-1 rounded-md border px-3 py-2" />
              <button
                onClick={() => {
                  if (!code) return;
                  const ok = applyCoupon(code);
                  if (ok) {
                    toast({ title: "Áp mã thành công", description: `Mã ${code} đã được áp dụng` });
                    setCode("");
                  } else {
                    toast({ title: "Mã không hợp lệ", description: "Vui lòng thử lại" });
                  }
                }}
                className="rounded-md bg-primary px-4 py-2 text-primary-foreground"
              >Áp dụng</button>
            </div>
            {couponCode && (
              <div className="mt-2 text-sm text-muted-foreground">Mã áp dụng: {couponCode} <button onClick={() => { removeCoupon(); toast({ title: 'Đã xoá mã' }); }} className="ml-2 text-xs text-destructive">Xóa</button></div>
            )}
          </div>

          <div>
            <label className="text-sm font-medium">Địa chỉ nhận (Tỉnh/Thành)</label>
            <select value={shippingCity ?? ""} onChange={(e) => setShippingCity(e.target.value || null)} className="mt-2 w-full rounded-md border px-3 py-2">
              <option value="">Chọn tỉnh/thành</option>
              <option>Hồ Chí Minh</option>
              <option>Hà Nội</option>
              <option>Đà Nẵng</option>
              <option>Khác</option>
            </select>
            <div className="mt-2 text-sm text-muted-foreground">Phí vận chuyển: {shippingCost.toLocaleString("vi-VN")}₫</div>
          </div>

          <div className="border-t pt-3">
            <div className="flex items-center justify-between">
              <div className="text-sm text-muted-foreground">Tạm tính</div>
              <div className="font-semibold">{subtotal.toLocaleString("vi-VN")}₫</div>
            </div>
            <div className="flex items-center justify-between">
              <div className="text-sm text-muted-foreground">Giảm</div>
              <div className="font-semibold">{discount.toLocaleString("vi-VN")}₫</div>
            </div>
            <div className="flex items-center justify-between">
              <div className="text-sm text-muted-foreground">Vận chuyển</div>
              <div className="font-semibold">{shippingCost.toLocaleString("vi-VN")}₫</div>
            </div>
            <div className="flex items-center justify-between mt-2">
              <div className="text-sm">Tổng</div>
              <div className="text-2xl font-bold">{total.toLocaleString("vi-VN")}₫</div>
            </div>
          </div>

          <div>
            <Button asChild size="lg">
              <Link to="/checkout">Tiến hành thanh toán</Link>
            </Button>
          </div>
          <div>
            <button onClick={clear} className="text-sm text-muted-foreground">Xóa giỏ hàng</button>
          </div>
        </aside>
      </div>
    </div>
  );
}
