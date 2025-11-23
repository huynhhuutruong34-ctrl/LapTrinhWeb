import { Link } from "react-router-dom";

export function Footer() {
  return (
    <footer className="border-t bg-background">
      <div className="container mx-auto px-4 py-12 grid grid-cols-1 gap-10 md:grid-cols-4">
        <div>
          <Link to="/" className="font-extrabold tracking-tight text-xl">
            <span className="text-primary">MODA</span>
            <span className="ml-1 text-muted-foreground">.vn</span>
          </Link>
          <p className="mt-3 text-sm text-muted-foreground">
            Cửa hàng thời trang hiện đại. Giao hàng toàn quốc. Đổi trả trong 7 ngày.
          </p>
        </div>
        <div>
          <h4 className="text-sm font-semibold mb-3">Danh mục</h4>
          <ul className="space-y-2 text-sm text-muted-foreground">
            <li><Link to="/catalog/nam" className="hover:text-foreground">Nam</Link></li>
            <li><Link to="/catalog/nu" className="hover:text-foreground">Nữ</Link></li>
            <li><Link to="/catalog/unisex" className="hover:text-foreground">Unisex</Link></li>
            <li><Link to="/catalog/phu-kien" className="hover:text-foreground">Phụ kiện</Link></li>
          </ul>
        </div>
        <div>
          <h4 className="text-sm font-semibold mb-3">Hỗ trợ</h4>
          <ul className="space-y-2 text-sm text-muted-foreground">
            <li><Link to="/contact" className="hover:text-foreground">Liên hệ</Link></li>
            <li><Link to="/contact" className="hover:text-foreground">Chính sách</Link></li>
            <li><Link to="/contact" className="hover:text-foreground">Bảo hành</Link></li>
          </ul>
        </div>
        <div>
          <h4 className="text-sm font-semibold mb-3">Nhận ưu đãi</h4>
          <form className="flex gap-2" onSubmit={(e)=>e.preventDefault()}>
            <input
              type="email"
              required
              placeholder="Email của bạn"
              className="h-10 flex-1 rounded-md border bg-background px-3 text-sm focus:outline-none focus:ring-2 focus:ring-ring"
            />
            <button className="h-10 rounded-md bg-primary px-4 text-sm text-primary-foreground hover:bg-primary/90">
              Đăng ký
            </button>
          </form>
          <p className="mt-2 text-xs text-muted-foreground">Bằng cách đăng ký, bạn đồng ý nhận email từ MODA.vn</p>
        </div>
      </div>
      <div className="border-t py-6 text-center text-xs text-muted-foreground">
        © {new Date().getFullYear()} MODA.vn • Xây dựng bằng Node.js + React • Tối ưu cho WebStorm
      </div>
    </footer>
  );
}
