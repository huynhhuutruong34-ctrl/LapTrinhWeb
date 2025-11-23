import { useState } from "react";
import { Link, useNavigate } from "react-router-dom";
import { useUser } from "@/components/auth/UserContext";
import { Button } from "@/components/ui/button";
import { useToast } from "@/hooks/use-toast";

export default function RegisterPage() {
  const [name, setName] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [confirmPassword, setConfirmPassword] = useState("");
  const [loading, setLoading] = useState(false);
  const { register } = useUser();
  const navigate = useNavigate();
  const { toast } = useToast();

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();

    if (password !== confirmPassword) {
      toast({
        title: "Lỗi",
        description: "Mật khẩu không trùng khớp",
      });
      return;
    }

    if (password.length < 6) {
      toast({
        title: "Lỗi",
        description: "Mật khẩu phải có ít nhất 6 ký tự",
      });
      return;
    }

    setLoading(true);

    try {
      await register(name, email, password);
      toast({
        title: "Đăng ký thành công",
        description: "Tài khoản của bạn đã được tạo!",
      });
      navigate("/");
    } catch (error) {
      toast({
        title: "Lỗi",
        description: error instanceof Error ? error.message : "Đăng ký thất bại",
      });
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="container mx-auto px-4 py-12">
      <div className="mx-auto max-w-md">
        <div className="rounded-lg border bg-card p-8">
          <h1 className="text-2xl font-bold">Đăng ký</h1>
          <p className="mt-1 text-sm text-muted-foreground">
            Tạo tài khoản LaptopXpress mới
          </p>

          <form onSubmit={handleSubmit} className="mt-6 space-y-4">
            <div>
              <label className="block text-sm font-medium">Họ & Tên</label>
              <input
                type="text"
                value={name}
                onChange={(e) => setName(e.target.value)}
                required
                className="mt-1 w-full rounded-md border bg-background px-3 py-2"
                placeholder="Nguyễn Văn A"
              />
            </div>

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

            <div>
              <label className="block text-sm font-medium">Xác nhận mật khẩu</label>
              <input
                type="password"
                value={confirmPassword}
                onChange={(e) => setConfirmPassword(e.target.value)}
                required
                className="mt-1 w-full rounded-md border bg-background px-3 py-2"
                placeholder="••••••••"
              />
            </div>

            <Button type="submit" size="lg" className="w-full" disabled={loading}>
              {loading ? "Đang đăng ký..." : "Đăng ký"}
            </Button>
          </form>

          <div className="mt-4 text-center">
            <p className="text-sm text-muted-foreground">
              Đã có tài khoản?{" "}
              <Link to="/login" className="text-primary hover:underline">
                Đăng nhập ngay
              </Link>
            </p>
          </div>
        </div>
      </div>
    </div>
  );
}
