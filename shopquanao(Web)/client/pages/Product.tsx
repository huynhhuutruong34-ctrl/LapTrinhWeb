import { useState } from "react";
import { useParams, Link } from "react-router-dom";
import { products } from "@/data/products";
import { useCart } from "@/components/cart/CartProvider";
import { Button } from "@/components/ui/button";

export default function ProductPage() {
  const { id } = useParams();
  const pid = Number(id);
  const product = products.find((p) => p.id === pid);
  const { addItem } = useCart();

  const [mainIndex, setMainIndex] = useState(0);
  const [color, setColor] = useState<string | undefined>(product?.colors?.[0]);
  const [size, setSize] = useState<string | undefined>(product?.sizes?.[0]);
  const [quantity, setQuantity] = useState(1);

  if (!product) {
    return (
      <div className="container mx-auto px-4 py-24 text-center">
        <h2 className="text-2xl font-semibold">Sản phẩm không tồn tại</h2>
        <p className="mt-2 text-muted-foreground">Sản phẩm bạn tìm kiếm không có trong hệ thống.</p>
        <div className="mt-4">
          <Link to="/catalog" className="rounded-md border px-4 py-2">Quay về danh mục</Link>
        </div>
      </div>
    );
  }

  const handleAdd = () => {
    addItem(product, { quantity, color, size });
  };

  return (
    <div className="container mx-auto px-4 py-12">
      <div className="grid gap-8 md:grid-cols-2">
        <div>
          <div className="rounded-2xl border overflow-hidden">
            <img src={product.images[mainIndex]} alt={product.name} className="w-full h-[560px] object-cover" />
          </div>
          <div className="mt-4 grid grid-cols-4 gap-3">
            {product.images.map((src, i) => (
              <button
                key={src}
                onClick={() => setMainIndex(i)}
                className={`overflow-hidden rounded-md border ${i === mainIndex ? "ring-2 ring-primary" : ""}`}
              >
                <img src={src} alt={`${product.name} ${i}`} className="h-20 w-full object-cover" />
              </button>
            ))}
          </div>
        </div>
        <div>
          <h1 className="text-2xl font-bold">{product.name}</h1>
          <p className="mt-2 text-muted-foreground">{product.description}</p>
          <div className="mt-4 flex items-baseline gap-4">
            <span className="text-2xl font-extrabold">{product.price.toLocaleString("vi-VN")}₫</span>
            <span className="text-sm text-muted-foreground">Miễn phí giao hàng cho đơn hàng trên 499.000₫</span>
          </div>

          <div className="mt-6 space-y-4">
            {product.colors && (
              <div>
                <h4 className="text-sm font-medium">Màu sắc</h4>
                <div className="mt-2 flex items-center gap-2">
                  {product.colors.map((c) => (
                    <button
                      key={c}
                      onClick={() => setColor(c)}
                      className={`rounded-full px-3 py-1 text-sm border ${color === c ? "bg-primary text-primary-foreground" : "text-muted-foreground"}`}
                    >
                      {c}
                    </button>
                  ))}
                </div>
              </div>
            )}

            {product.sizes && (
              <div>
                <h4 className="text-sm font-medium">Kích cỡ</h4>
                <div className="mt-2 flex items-center gap-2">
                  {product.sizes.map((s) => (
                    <button
                      key={s}
                      onClick={() => setSize(s)}
                      className={`rounded-md px-3 py-1 text-sm border ${size === s ? "bg-primary text-primary-foreground" : "text-muted-foreground"}`}
                    >
                      {s}
                    </button>
                  ))}
                </div>
              </div>
            )}

            <div className="flex items-center gap-4">
              <div className="flex items-center gap-2">
                <button onClick={() => setQuantity((q) => Math.max(1, q - 1))} className="rounded-md border px-3 py-1">-</button>
                <div className="w-12 text-center">{quantity}</div>
                <button onClick={() => setQuantity((q) => q + 1)} className="rounded-md border px-3 py-1">+</button>
              </div>

              <Button size="lg" onClick={handleAdd}>Thêm vào giỏ</Button>
            </div>
          </div>

          <div className="mt-8">
            <h4 className="text-sm font-semibold">Chi tiết</h4>
            <p className="mt-2 text-sm text-muted-foreground">{product.description}</p>
          </div>
        </div>
      </div>

      <section className="mt-12">
        <h3 className="text-lg font-semibold">Sản phẩm liên quan</h3>
        <div className="mt-4 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
          {products.filter((p) => p.id !== product.id).slice(0, 4).map((p) => (
            <Link key={p.id} to={`/product/${p.id}`} className="rounded-xl border bg-card overflow-hidden">
              <img src={p.images[0]} alt={p.name} className="h-40 w-full object-cover" />
              <div className="p-3">
                <div className="text-sm font-medium">{p.name}</div>
                <div className="mt-1 text-sm text-muted-foreground">{p.price.toLocaleString("vi-VN")}₫</div>
              </div>
            </Link>
          ))}
        </div>
      </section>
    </div>
  );
}
