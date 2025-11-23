import { Link, NavLink } from "react-router-dom";
import { useState } from "react";
import { Button } from "@/components/ui/button";
import { cn } from "@/lib/utils";
import { useCart } from "@/components/cart/CartProvider";
import { useUser } from "@/components/auth/UserContext";

const navItems = [
  { to: "/", label: "Trang chủ" },
  { to: "/catalog", label: "Danh mục" },
  { to: "/cart", label: "Giỏ hàng" },
  { to: "/contact", label: "Liên hệ" },
];

export function Header() {
  const [open, setOpen] = useState(false);
  const [userMenuOpen, setUserMenuOpen] = useState(false);
  const { totalItems } = useCart();
  const { user, logout } = useUser();

  return (
    <header className="sticky top-0 z-50 w-full border-b bg-background/60 backdrop-blur supports-[backdrop-filter]:bg-background/60">
      <div className="container mx-auto flex h-16 items-center justify-between px-4">
        <div className="flex items-center gap-6">
          <Link to="/" className="font-extrabold tracking-tight text-xl">
            <span className="text-primary">MODA</span>
            <span className="ml-1 text-muted-foreground">.vn</span>
          </Link>
          <nav className="hidden md:flex items-center gap-1">
            {navItems.map((item) => (
              <NavLink
                key={item.to}
                to={item.to}
                className={({ isActive }) =>
                  cn(
                    "px-3 py-2 text-sm font-medium rounded-md transition-colors",
                    isActive
                      ? "bg-secondary text-secondary-foreground"
                      : "text-muted-foreground hover:text-foreground hover:bg-accent",
                  )
                }
                end={item.to === "/"}
              >
                {item.label}
              </NavLink>
            ))}
          </nav>
        </div>

        <div className="hidden md:flex items-center gap-2">
          <div className="relative">
            <input
              className="h-10 w-64 rounded-md border bg-background px-3 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-ring"
              placeholder="Tìm kiếm sản phẩm..."
              aria-label="Tìm kiếm"
            />
            <svg
              aria-hidden
              viewBox="0 0 24 24"
              className="pointer-events-none absolute right-3 top-1/2 size-5 -translate-y-1/2 text-muted-foreground"
            >
              <path
                d="M10 4a6 6 0 1 1 0 12A6 6 0 0 1 10 4Zm10.707 15.293-4.387-4.387"
                stroke="currentColor"
                strokeWidth="2"
                fill="none"
                strokeLinecap="round"
              />
            </svg>
          </div>

          <div className="relative">
            <Button asChild variant="outline">
              <Link to="/cart" className="inline-flex items-center gap-2 px-3 py-2">
                <svg viewBox="0 0 24 24" className="h-4 w-4" fill="none" stroke="currentColor">
                  <path d="M3 3h2l.4 2M7 13h10l4-8H5.4" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" />
                </svg>
                Giỏ hàng
                {totalItems > 0 && (
                  <span className="ml-2 inline-flex h-5 w-5 items-center justify-center rounded-full bg-primary text-primary-foreground text-xs">
                    {totalItems}
                  </span>
                )}
              </Link>
            </Button>
          </div>

          {user ? (
            <div className="relative">
              <button
                onClick={() => setUserMenuOpen(!userMenuOpen)}
                className="inline-flex items-center gap-2 rounded-md border px-3 py-2 text-sm hover:bg-accent"
              >
                <svg viewBox="0 0 24 24" className="h-4 w-4" fill="currentColor">
                  <path d="M12 12a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm0 1c-4.418 0-8 1.79-8 4v2h16v-2c0-2.21-3.582-4-8-4z" />
                </svg>
                {user.name}
              </button>
              {userMenuOpen && (
                <div className="absolute right-0 mt-2 w-48 rounded-md border bg-card shadow-lg">
                  <div className="p-2">
                    <div className="px-3 py-2 text-sm text-muted-foreground">
                      {user.email}
                    </div>
                    {user.role === "admin" && (
                      <>
                        <Button asChild variant="ghost" className="w-full justify-start">
                          <Link to="/admin" onClick={() => setUserMenuOpen(false)}>
                            Quản lý Admin
                          </Link>
                        </Button>
                      </>
                    )}
                    <button
                      onClick={() => {
                        logout();
                        setUserMenuOpen(false);
                      }}
                      className="w-full rounded-md px-3 py-2 text-sm text-destructive hover:bg-accent text-left"
                    >
                      Đăng xuất
                    </button>
                  </div>
                </div>
              )}
            </div>
          ) : (
            <div className="flex items-center gap-2">
              <Button asChild variant="outline">
                <Link to="/login">Đăng nhập</Link>
              </Button>
              <Button asChild>
                <Link to="/register">Đăng ký</Link>
              </Button>
            </div>
          )}
        </div>

        <button
          className="md:hidden inline-flex h-10 w-10 items-center justify-center rounded-md border hover:bg-accent"
          aria-label="Mở menu"
          onClick={() => setOpen((v) => !v)}
        >
          <svg viewBox="0 0 24 24" className="size-6" aria-hidden>
            <path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" strokeWidth="2" />
          </svg>
        </button>
      </div>

      {open && (
        <div className="md:hidden border-t bg-background">
          <nav className="container mx-auto flex flex-col p-2">
            {navItems.map((item) => (
              <Link
                key={item.to}
                to={item.to}
                onClick={() => setOpen(false)}
                className="rounded-md px-3 py-2 text-sm text-foreground hover:bg-accent"
              >
                {item.label}
              </Link>
            ))}
            <Link
              to="/cart"
              onClick={() => setOpen(false)}
              className="mt-2 rounded-md border px-3 py-2 text-sm"
            >
              Mở giỏ hàng
            </Link>
            {user ? (
              <>
                <div className="mt-4 border-t pt-2">
                  <div className="px-3 py-2 text-sm font-medium">{user.name}</div>
                  {user.role === "admin" && (
                    <Link
                      to="/admin"
                      onClick={() => setOpen(false)}
                      className="rounded-md px-3 py-2 text-sm text-foreground hover:bg-accent block"
                    >
                      Quản lý Admin
                    </Link>
                  )}
                  <button
                    onClick={() => {
                      logout();
                      setOpen(false);
                    }}
                    className="w-full rounded-md px-3 py-2 text-sm text-destructive hover:bg-accent text-left"
                  >
                    Đăng xuất
                  </button>
                </div>
              </>
            ) : (
              <div className="mt-4 border-t pt-2 flex flex-col gap-2">
                <Button asChild className="w-full" variant="outline">
                  <Link to="/login" onClick={() => setOpen(false)}>Đăng nhập</Link>
                </Button>
                <Button asChild className="w-full">
                  <Link to="/register" onClick={() => setOpen(false)}>Đăng ký</Link>
                </Button>
              </div>
            )}
          </nav>
        </div>
      )}
    </header>
  );
}
