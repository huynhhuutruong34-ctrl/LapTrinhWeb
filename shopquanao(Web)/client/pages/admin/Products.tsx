import { useEffect, useState } from "react";
import { AdminLayout } from "@/components/admin/AdminLayout";
import { Button } from "@/components/ui/button";
import { useToast } from "@/hooks/use-toast";
import { Product } from "@/data/products";

export default function AdminProducts() {
  const [products, setProducts] = useState<Product[]>([]);
  const [loading, setLoading] = useState(true);
  const [editingId, setEditingId] = useState<number | null>(null);
  const [showForm, setShowForm] = useState(false);
  const [formData, setFormData] = useState<Partial<Product>>({});
  const { toast } = useToast();

  useEffect(() => {
    fetchProducts();
  }, []);

  const fetchProducts = async () => {
    try {
      const res = await fetch("/api/products");
      const data = await res.json();
      setProducts(data);
    } catch (error) {
      toast({ title: "Lỗi", description: "Không thể tải danh sách sản phẩm" });
    } finally {
      setLoading(false);
    }
  };

  const handleEdit = (product: Product) => {
    setEditingId(product.id);
    setFormData(product);
    setShowForm(true);
  };

  const handleAdd = () => {
    setEditingId(null);
    setFormData({
      name: "",
      price: 0,
      category: "van-phong",
      images: [],
      colors: [],
      sizes: [],
      specs: {},
      description: "",
    });
    setShowForm(true);
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();

    try {
      const method = editingId ? "PUT" : "POST";
      const url = editingId ? `/api/products/${editingId}` : "/api/products";

      const res = await fetch(url, {
        method,
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(formData),
      });

      if (!res.ok) throw new Error("Lỗi máy chủ");

      toast({
        title: editingId ? "Cập nhật thành công" : "Thêm thành công",
        description: formData.name,
      });

      setShowForm(false);
      setEditingId(null);
      fetchProducts();
    } catch (error) {
      toast({ title: "Lỗi", description: "Không thể lưu sản phẩm" });
    }
  };

  const handleDelete = async (id: number) => {
    if (!confirm("Xác nhận xóa sản phẩm này?")) return;

    try {
      const res = await fetch(`/api/products/${id}`, { method: "DELETE" });
      if (!res.ok) throw new Error("Lỗi máy chủ");

      toast({ title: "Đã xóa sản phẩm" });
      fetchProducts();
    } catch (error) {
      toast({ title: "Lỗi", description: "Không thể xóa sản phẩm" });
    }
  };

  if (loading) {
    return (
      <AdminLayout>
        <div className="text-center py-12">Đang tải...</div>
      </AdminLayout>
    );
  }

  return (
    <AdminLayout>
      <div className="space-y-6">
        <div className="flex items-center justify-between">
          <h2 className="text-xl font-semibold">Quản lý Sản phẩm</h2>
          <Button onClick={handleAdd}>Thêm sản phẩm</Button>
        </div>

        {showForm && (
          <div className="rounded-lg border bg-card p-6">
            <h3 className="font-semibold mb-4">
              {editingId ? "Chỉnh sửa" : "Thêm"} Sản phẩm
            </h3>
            <form onSubmit={handleSubmit} className="space-y-4 max-w-2xl">
              <div>
                <label className="block text-sm font-medium">Tên sản phẩm</label>
                <input
                  type="text"
                  value={formData.name || ""}
                  onChange={(e) => setFormData({ ...formData, name: e.target.value })}
                  required
                  className="mt-1 w-full rounded-md border bg-background px-3 py-2"
                />
              </div>

              <div className="grid grid-cols-2 gap-4">
                <div>
                  <label className="block text-sm font-medium">Giá (₫)</label>
                  <input
                    type="number"
                    value={formData.price || 0}
                    onChange={(e) => setFormData({ ...formData, price: Number(e.target.value) })}
                    required
                    className="mt-1 w-full rounded-md border bg-background px-3 py-2"
                  />
                </div>

                <div>
                  <label className="block text-sm font-medium">Danh mục</label>
                  <select
                    value={formData.category || "van-phong"}
                    onChange={(e) => setFormData({ ...formData, category: e.target.value })}
                    className="mt-1 w-full rounded-md border bg-background px-3 py-2"
                  >
                    <option value="gaming">Gaming</option>
                    <option value="van-phong">Văn phòng</option>
                    <option value="ultrabook">Ultrabook</option>
                    <option value="workstation">Workstation</option>
                  </select>
                </div>
              </div>

              <div>
                <label className="block text-sm font-medium">Mô tả</label>
                <textarea
                  value={formData.description || ""}
                  onChange={(e) => setFormData({ ...formData, description: e.target.value })}
                  className="mt-1 w-full rounded-md border bg-background px-3 py-2 h-24"
                />
              </div>

              <div className="flex gap-2">
                <Button type="submit">Lưu</Button>
                <Button
                  type="button"
                  variant="outline"
                  onClick={() => setShowForm(false)}
                >
                  Hủy
                </Button>
              </div>
            </form>
          </div>
        )}

        <div className="rounded-lg border overflow-hidden">
          <table className="w-full">
            <thead className="border-b bg-muted/50">
              <tr>
                <th className="text-left p-4">Tên</th>
                <th className="text-left p-4">Giá</th>
                <th className="text-left p-4">Danh mục</th>
                <th className="text-left p-4">Hành động</th>
              </tr>
            </thead>
            <tbody>
              {products.map((product) => (
                <tr key={product.id} className="border-b hover:bg-muted/30">
                  <td className="p-4">{product.name}</td>
                  <td className="p-4">{product.price.toLocaleString("vi-VN")}₫</td>
                  <td className="p-4">{product.category}</td>
                  <td className="p-4 space-x-2">
                    <Button
                      size="sm"
                      variant="outline"
                      onClick={() => handleEdit(product)}
                    >
                      Sửa
                    </Button>
                    <Button
                      size="sm"
                      variant="destructive"
                      onClick={() => handleDelete(product.id)}
                    >
                      Xóa
                    </Button>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
    </AdminLayout>
  );
}
