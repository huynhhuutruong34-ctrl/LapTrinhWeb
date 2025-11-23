import { useLocation, Link } from "react-router-dom";
import { useEffect } from "react";

const NotFound = () => {
  const location = useLocation();

  useEffect(() => {
    console.error(
      "404 Error: User attempted to access non-existent route:",
      location.pathname,
    );
  }, [location.pathname]);

  return (
    <div className="min-h-[60vh] flex items-center justify-center">
      <div className="text-center">
        <h1 className="text-4xl font-bold mb-2">404</h1>
        <p className="text-muted-foreground mb-4">Không tìm thấy trang bạn yêu cầu</p>
        <Link to="/" className="rounded-md border px-4 py-2 text-sm hover:bg-accent">
          Về trang chủ
        </Link>
      </div>
    </div>
  );
};

export default NotFound;
