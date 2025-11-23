import { Link, useParams } from "react-router-dom";

export default function OrderSuccess() {
  const { id } = useParams<{ id?: string }>();

  return (
    <div className="container mx-auto px-4 py-24 text-center">
      <h1 className="text-2xl font-bold">Cảm ơn bạn đã đặt hàng!</h1>
      <p className="mt-2 text-muted-foreground">Đơn hàng của bạn đã được nhận và đang được xử lý.</p>
      <div className="mt-4">
        <div className="inline-block rounded-md border bg-card p-4 text-left">
          <div className="text-sm text-muted-foreground">Mã đơn hàng</div>
          <div className="font-mono font-semibold mt-1">{id ?? "-"}</div>
        </div>
      </div>
      <div className="mt-6">
        <Link to="/catalog" className="rounded-md border px-4 py-2">Tiếp tục mua sắm</Link>
      </div>
    </div>
  );
}
