import { ReactNode } from "react";
import { Link } from "react-router-dom";
import { Button } from "@/components/ui/button";
import { useUser } from "@/components/auth/UserContext";

interface AdminLayoutProps {
  children: ReactNode;
}

export function AdminLayout({ children }: AdminLayoutProps) {
  const { user } = useUser();

  if (user?.role !== "admin") {
    return (
      <div className="container mx-auto px-4 py-12 text-center">
        <h1 className="text-2xl font-bold">Truy cập bị từ chối</h1>
        <p className="mt-2 text-muted-foreground">Bạn không có quyền truy cập trang này.</p>
        <Button asChild className="mt-4">
          <Link to="/">Quay về trang chủ</Link>
        </Button>
      </div>
    );
  }

  return (
    <div className="flex min-h-screen">
      <nav className="w-64 border-r bg-muted/40">
        <div className="p-4">
          <h2 className="text-lg font-bold">Admin Panel</h2>
        </div>
        <ul className="space-y-2 p-4">
          <li>
            <Link
              to="/admin"
              className="block rounded-md px-3 py-2 hover:bg-accent"
            >
              Dashboard
            </Link>
          </li>
          <li>
            <Link
              to="/admin/products"
              className="block rounded-md px-3 py-2 hover:bg-accent"
            >
              Quản lý Sản phẩm
            </Link>
          </li>
          <li>
            <Link
              to="/admin/orders"
              className="block rounded-md px-3 py-2 hover:bg-accent"
            >
              Quản lý Đơn hàng
            </Link>
          </li>
          <li>
            <Button asChild variant="outline" className="w-full justify-start">
              <Link to="/">Quay về cửa hàng</Link>
            </Button>
          </li>
        </ul>
      </nav>

      <main className="flex-1">
        <div className="border-b bg-background p-4">
          <div className="container">
            <h1 className="text-2xl font-bold">Quản trị viên</h1>
          </div>
        </div>
        <div className="container p-6">{children}</div>
      </main>
    </div>
  );
}
