import { RequestHandler } from "express";
import { products } from "../../client/data/products";

export const handleHome: RequestHandler = (_req, res) => {
  try {
    const productsHtml = products
      .map(
        (p) => `
      <div class="card">
        <img src="${p.images[0]}" alt="${p.name}" />
        <div class="card-body">
          <div class="name">${p.name}</div>
          <div class="price">${p.price.toLocaleString("vi-VN")}₫</div>
        </div>
      </div>`,
      )
      .join("\n");

    const html = `<!doctype html>
<html lang="vi">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>MODA.vn - Trang chủ</title>
    <style>
      body{font-family:Inter,system-ui,Arial,Helvetica,sans-serif;margin:0;padding:0;background:#f7f7f8;color:#111}
      .container{max-width:1100px;margin:32px auto;padding:0 16px}
      .grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:16px}
      .card{background:#fff;border-radius:10px;overflow:hidden;border:1px solid #e6e6e9}
      .card img{width:100%;height:260px;object-fit:cover}
      .card-body{padding:12px}
      .price{font-weight:700;color:#111}
      header{background:#fff;border-bottom:1px solid #eee;padding:12px 0}
      .brand{font-weight:800;font-size:20px;color:#111}
      .nav{margin-top:6px}
      .nav a{margin-right:12px;color:#6b6b6b;text-decoration:none}
      footer{padding:24px 0;text-align:center;color:#777}
    </style>
  </head>
  <body>
    <header>
      <div class="container">
        <div class="brand">MODA.vn</div>
        <nav class="nav">
          <a href="/">Trang chủ</a>
          <a href="/catalog">Danh mục</a>
          <a href="/cart">Giỏ hàng</a>
          <a href="/contact">Liên hệ</a>
        </nav>
      </div>
    </header>

    <main class="container">
      <h1>MODA.vn - Trang chủ</h1>
      <section>
        <h2>Sản phẩm nổi bật</h2>
        <div class="grid">
          ${productsHtml}
        </div>
      </section>
    </main>

    <footer>
      © MODA.vn • ${new Date().getFullYear()}
    </footer>
  </body>
</html>`;

    res.status(200).contentType("html").send(html);
  } catch (err) {
    console.error("Error rendering home view", err);
    res.status(500).send("Server error");
  }
};
