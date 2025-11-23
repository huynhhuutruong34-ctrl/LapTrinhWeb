import { Link, useParams } from "react-router-dom";
import { Button } from "@/components/ui/button";
import { products } from "@/data/products";
import { categories, getCategoryName } from "@/data/categories";
import { useCart } from "@/components/cart/CartProvider";
import { useToast } from "@/hooks/use-toast";

export default function Catalog() {
  const { category } = useParams<{ category?: string }>();
  const selected = category ?? "tat-ca";
  const { addItem } = useCart();
  const { toast } = useToast();

  const filtered = selected === "tat-ca" ? products : products.filter((p) => p.category === selected);

  return (
    <div>
      <section className="container mx-auto px-4 py-10">
        <div className="flex items-end justify-between gap-4">
          <div>
            <h1 className="text-3xl font-bold tracking-tight">{getCategoryName(selected)}</h1>
            <p className="mt-1 text-muted-foreground">Khám phá bộ sưu tập mới nhất từ MODA.vn</p>
          </div>
          <div className="hidden md:flex items-center gap-2">
            {categories.map((c) => (
              <Button
                key={c.slug}
                variant={selected === c.slug ? "default" : "outline"}
                asChild
              >
                <Link to={c.slug === "tat-ca" ? "/catalog" : `/catalog/${c.slug}`}>{c.name}</Link>
              </Button>
            ))}
          </div>
        </div>

        <div className="mt-6 md:hidden flex flex-wrap gap-2">
          {categories.map((c) => (
            <Link
              key={c.slug}
              to={c.slug === "tat-ca" ? "/catalog" : `/catalog/${c.slug}`}
              className={`rounded-full border px-3 py-1 text-sm ${selected === c.slug ? "bg-primary text-primary-foreground" : "hover:bg-accent"}`}
            >
              {c.name}
            </Link>
          ))}
        </div>

        <div className="mt-8 grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4">
          {filtered.map((p) => (
            <article key={p.id} className="group overflow-hidden rounded-xl border bg-card">
              <div className="block">
                <div className="aspect-[4/5] overflow-hidden">
                  <img
                    src={p.images[0]}
                    alt={p.name}
                    className="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                    loading="lazy"
                  />
                </div>
                <div className="space-y-1 p-4">
                  <h3 className="font-medium">{p.name}</h3>
                  <p className="text-sm text-muted-foreground">Màu: {p.colors?.[0] ?? "—"}</p>
                  <div className="flex items-center justify-between pt-2">
                    <span className="font-semibold">{p.price.toLocaleString("vi-VN")}₫</span>
                    <div className="flex items-center gap-2">
                      <Button size="sm" onClick={() => { addItem(p, { quantity: 1, color: p.colors?.[0], size: p.sizes?.[0] }); toast({ title: 'Đã thêm vào giỏ', description: p.name }); }}>Thêm</Button>
                      <Link to={`/product/${p.id}`} className="text-sm text-muted-foreground">Xem</Link>
                    </div>
                  </div>
                </div>
              </div>
            </article>
          ))}
          {filtered.length === 0 && (
            <div className="col-span-full text-center text-muted-foreground">Chưa có sản phẩm cho danh mục này.</div>
          )}
        </div>
      </section>
    </div>
  );
}
