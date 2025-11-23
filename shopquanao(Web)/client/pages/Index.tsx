import { Link } from "react-router-dom";
import { Button } from "@/components/ui/button";
import { categories } from "@/data/categories";
import { useCart } from "@/components/cart/CartProvider";
import { useToast } from "@/hooks/use-toast";

const featured = [
  {
    id: 1,
    name: "Áo Thun Nam Cơ Bản",
    price: 150000,
    image:
      "https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?q=80&w=1440&auto=format&fit=crop",
    tag: "Nam",
  },
  {
    id: 2,
    name: "Áo Sơ Mi Nam Trắng",
    price: 350000,
    image:
      "https://images.unsplash.com/photo-1556821552-9f6db235933a?q=80&w=1440&auto=format&fit=crop",
    tag: "Nam",
  },
  {
    id: 4,
    name: "Áo Dây Nữ Hồng",
    price: 200000,
    image:
      "https://images.unsplash.com/photo-1551028719-00167b16ebc5?q=80&w=1440&auto=format&fit=crop",
    tag: "Nữ",
  },
];

export default function Index() {
  const { addItem } = useCart();
  const { toast } = useToast();

  return (
    <div>
      {/* Hero */}
      <section className="relative overflow-hidden border-b bg-gradient-to-b from-background to-muted">
        <div className="container mx-auto grid gap-8 px-4 py-20 md:grid-cols-2 md:gap-12 md:py-28">
          <div className="order-2 md:order-1">
            <p className="mb-3 inline-flex items-center gap-2 rounded-full border px-3 py-1 text-xs text-muted-foreground">
              <span className="inline-block size-2 rounded-full bg-primary" /> Thời Trang Quần Áo 2025 - Hàng Chính Hãng
            </p>
            <h1 className="text-4xl font-extrabold leading-tight tracking-tight md:text-5xl">
              Quần áo cao cấp cho mọi phong cách
            </h1>
            <p className="mt-3 max-w-prose text-muted-foreground">
              MODA.vn cung cấp các mẫu thời trang hàng đầu từ các thương hiệu uy tín với giá cạnh tranh, chất lượng đảm bảo, giao hàng nhanh chóng.
            </p>
            <div className="mt-6 flex flex-wrap items-center gap-3">
              <Button asChild size="lg">
                <Link to="/catalog">Mua ngay</Link>
              </Button>
              <Button asChild size="lg" variant="outline">
                <Link to="/catalog">Xem bộ sưu tập</Link>
              </Button>
            </div>
            <div className="mt-8 flex flex-wrap items-center gap-6 text-sm text-muted-foreground">
              <div className="flex items-center gap-2">
                <span className="inline-block size-2 rounded-full bg-emerald-500" /> Giao hàng 1-2 ngày
              </div>
              <div className="flex items-center gap-2">
                <span className="inline-block size-2 rounded-full bg-rose-500" /> Chất lư���ng đảm bảo
              </div>
              <div className="flex items-center gap-2">
                <span className="inline-block size-2 rounded-full bg-sky-500" /> Hỗ trợ 24/7
              </div>
            </div>
          </div>
          <div className="order-1 md:order-2">
            <div className="grid grid-cols-3 gap-3 md:gap-4">
              <div className="col-span-2 row-span-2 overflow-hidden rounded-2xl">
                <img
                  src="https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?q=80&w=1600&auto=format&fit=crop"
                  alt="Áo thun nam cao cấp"
                  className="h-full w-full object-cover"
                  loading="lazy"
                />
              </div>
              <div className="overflow-hidden rounded-2xl">
                <img
                  src="https://images.unsplash.com/photo-1556821552-9f6db235933a?q=80&w=800&auto=format&fit=crop"
                  alt="Áo sơ mi nam"
                  className="h-full w-full object-cover"
                  loading="lazy"
                />
              </div>
              <div className="overflow-hidden rounded-2xl">
                <img
                  src="https://images.unsplash.com/photo-1551028719-00167b16ebc5?q=80&w=800&auto=format&fit=crop"
                  alt="Áo dây nữ"
                  className="h-full w-full object-cover"
                  loading="lazy"
                />
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Featured categories */}
      <section className="container mx-auto px-4 py-12">
        <div className="flex flex-wrap items-center gap-3">
          <span className="text-sm text-muted-foreground">Danh mục nổi bật:</span>
          {categories.filter((c) => c.slug !== "tat-ca").map((c) => (
            <Link
              key={c.slug}
              to={`/catalog/${c.slug}`}
              className="rounded-full border px-4 py-1.5 text-sm hover:bg-accent"
            >
              {c.name}
            </Link>
          ))}
        </div>
      </section>

      {/* Featured products */}
      <section className="container mx-auto px-4 pb-16">
        <div className="flex items-end justify-between">
          <div>
            <h2 className="text-2xl font-bold tracking-tight">Sản phẩm nổi bật</h2>
            <p className="text-muted-foreground">Những mẫu thời trang được yêu thích nhất</p>
          </div>
          <Button asChild variant="outline">
            <Link to="/catalog">Xem tất cả</Link>
          </Button>
        </div>
        <div className="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
          {featured.map((p) => (
            <article key={p.id} className="group overflow-hidden rounded-2xl border bg-card">
              <div className="aspect-[4/5] overflow-hidden">
                <img
                  src={p.image}
                  alt={p.name}
                  className="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                  loading="lazy"
                />
              </div>
              <div className="p-4">
                <div className="flex items-center justify-between">
                  <h3 className="font-medium">{p.name}</h3>
                  <span className="rounded-full bg-secondary px-2 py-0.5 text-xs text-secondary-foreground">
                    {p.tag}
                  </span>
                </div>
                <div className="mt-2 flex items-center justify-between">
                  <span className="font-semibold">{p.price.toLocaleString("vi-VN")}₫</span>
                  <Button size="sm" onClick={() => { addItem({ id: p.id, slug: p.name.toLowerCase().replace(/\s+/g,'-'), name: p.name, price: p.price, category: 'tat-ca', images: [p.image] }, { quantity: 1 }); toast({ title: 'Đã thêm vào giỏ', description: p.name }); }}>
                    Thêm vào giỏ
                  </Button>
                </div>
              </div>
            </article>
          ))}
        </div>
      </section>

      {/* Perks */}
      <section className="border-t bg-muted/40">
        <div className="container mx-auto grid gap-8 px-4 py-12 md:grid-cols-3">
          <div>
            <h3 className="font-semibold">Hàng chính hãng 100%</h3>
            <p className="text-sm text-muted-foreground">Toàn bộ sản phẩm từ các nhà cung cấp uy tín</p>
          </div>
          <div>
            <h3 className="font-semibold">Chất lượng đảm bảo</h3>
            <p className="text-sm text-muted-foreground">Hỗ trợ đổi/trả hàng trong 30 ngày nếu không hài lòng</p>
          </div>
          <div>
            <h3 className="font-semibold">Thanh toán linh hoạt</h3>
            <p className="text-sm text-muted-foreground">Hỗ trợ COD, thẻ, chuyển khoản, trả góp 0%</p>
          </div>
        </div>
      </section>
    </div>
  );
}
