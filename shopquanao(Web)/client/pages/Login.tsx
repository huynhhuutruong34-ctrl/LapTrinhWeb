import { useState } from "react";
import { Link, useNavigate } from "react-router-dom";
import { useUser } from "@/components/auth/UserContext";
import { Button } from "@/components/ui/button";
import { useToast } from "@/hooks/use-toast";

export default function LoginPage() {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [loading, setLoading] = useState(false);
  const { login } = useUser();
  const navigate = useNavigate();
  const { toast } = useToast();

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);

    try {
      await login(email, password);
      toast({
        title: "Đăng nhập thành công",
        description: "Chào mừng bạn quay lại!",
      });
      navigate("/");
    } catch (error) {
      toast({
        title: "Lỗi",
        description: error instanceof Error ? error.message : "Đăng nhập thất bại",
      });
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="container mx-auto px-4 py-12">
      <div className="mx-auto max-w-md">
        <div className="rounded-lg border bg-card p-8">
          <h1 className="text-2xl font-bold">Đăng nhập</h1>
          <p className="mt-1 text-sm text-muted-foreground">
            Đăng nhập vào tài khoản LaptopXpress của bạn
          </p>

          <form onSubmit={handleSubmit} className="mt-6 space-y-4">
            <div>
              <label className="block text-sm font-medium">Email</label>
              <input
                type="email"
                value={email}
                onChange={(e) => setEmail(e.target.value)}
                required
                className="mt-1 w-full rounded-md border bg-background px-3 py-2"
                placeholder="your@email.com"
              />
            </div>

            <div>
              <label className="block text-sm font-medium">Mật khẩu</label>
              <input
                type="password"
                value={password}
                onChange={(e) => setPassword(e.target.value)}
                required
                className="mt-1 w-full rounded-md border bg-background px-3 py-2"
                placeholder="••••••••"
              />
            </div>

            <Button type="submit" size="lg" className="w-full" disabled={loading}>
              {loading ? "Đang đăng nhập..." : "Đăng nhập"}
            </Button>
          </form>

          <div className="mt-4 text-center">
            <p className="text-sm text-muted-foreground">
              Chưa có tài khoản?{" "}
              <Link to="/register" className="text-primary hover:underline">
                Đăng ký ngay
              </Link>
            </p>
          </div>

          <div className="mt-6 border-t pt-4">
            <p className="text-xs text-muted-foreground">
              Tài khoản demo: admin@test.com / password123
            </p>
          </div>
        </div>
      </div>
    </div>
  );
}
