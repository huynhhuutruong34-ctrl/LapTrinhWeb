import { AdminLayout } from "@/components/admin/AdminLayout";
import { Link } from "react-router-dom";
import { Button } from "@/components/ui/button";

export default function AdminDashboard() {
  return (
    <AdminLayout>
      <div>
        <h2 className="text-xl font-semibold mb-6">Dashboard</h2>
        
        <div className="grid grid-cols-3 gap-6 mb-12">
          <div className="rounded-lg border bg-card p-6">
            <h3 className="text-sm font-medium text-muted-foreground">Tổng Sản phẩm</h3>
            <div className="mt-2 text-3xl font-bold">6</div>
          </div>
          
          <div className="rounded-lg border bg-card p-6">
            <h3 className="text-sm font-medium text-muted-foreground">Đơn hàng</h3>
            <div className="mt-2 text-3xl font-bold">0</div>
          </div>
          
          <div className="rounded-lg border bg-card p-6">
            <h3 className="text-sm font-medium text-muted-foreground">Doanh thu</h3>
            <div className="mt-2 text-3xl font-bold">0 ₫</div>
          </div>
        </div>

        <div className="grid grid-cols-2 gap-6">
          <div className="rounded-lg border bg-card p-6">
            <h3 className="font-semibold mb-4">Quản lý Sản phẩm</h3>
            <p className="text-sm text-muted-foreground mb-4">
              Thêm, chỉnh sửa hoặc xóa các sản phẩm trong cửa hàng.
            </p>
            <Button asChild>
              <Link to="/admin/products">Quản lý Sản phẩm</Link>
            </Button>
          </div>

          <div className="rounded-lg border bg-card p-6">
            <h3 className="font-semibold mb-4">Quản lý Đơn hàng</h3>
            <p className="text-sm text-muted-foreground mb-4">
              Xem và cập nhật trạng thái các đơn hàng.
            </p>
            <Button asChild>
              <Link to="/admin/orders">Quản lý Đơn hàng</Link>
            </Button>
          </div>
        </div>
      </div>
    </AdminLayout>
  );
}
