import { RequestHandler } from "express";
import { Product } from "../types/product";

let products: Product[] = [
  {
    id: 1,
    slug: "asus-rog-zephyrus",
    name: "ASUS ROG Zephyrus G14",
    price: 35990000,
    category: "gaming",
    images: [
      "https://images.unsplash.com/photo-1588872657840-790ff3bde4c0?q=80&w=1600&auto=format&fit=crop",
      "https://images.unsplash.com/photo-1587829191301-cd57bc803db2?q=80&w=1600&auto=format&fit=crop",
    ],
    colors: ["Xám", "Đen"],
    sizes: ["14 inch"],
    specs: {
      CPU: "Intel Core i9-13900H",
      RAM: "16GB DDR5",
      GPU: "NVIDIA RTX 4080",
      "Màn hình": "14 inch QHD+ 165Hz",
      "Lưu trữ": "512GB SSD NVMe",
    },
    description: "Laptop gaming compact và mạnh mẽ với RTX 4080, lý tưởng cho các game thủ yêu thích portability.",
  },
  {
    id: 2,
    slug: "macbook-pro-m3-max",
    name: "MacBook Pro 16 M3 Max",
    price: 63990000,
    category: "workstation",
    images: [
      "https://images.unsplash.com/photo-1517336714731-489689fd1ca8?q=80&w=1600&auto=format&fit=crop",
    ],
    colors: ["Bạc", "Đen"],
    sizes: ["16 inch"],
    specs: {
      CPU: "Apple M3 Max",
      RAM: "36GB Unified",
      GPU: "18-core GPU",
      "Màn hình": "16 inch Liquid Retina XDR",
      "Lưu trữ": "512GB SSD",
    },
    description: "MacBook Pro 16 inch M3 Max - Tuyệt vời cho sáng tạo nội dung và phát triển phần mềm.",
  },
  {
    id: 3,
    slug: "dell-xps-13-plus",
    name: "Dell XPS 13 Plus",
    price: 24990000,
    category: "ultrabook",
    images: [
      "https://images.unsplash.com/photo-1597872200969-2b65d56bd16b?q=80&w=1600&auto=format&fit=crop",
    ],
    colors: ["Bạc", "Đen"],
    sizes: ["13.4 inch"],
    specs: {
      CPU: "Intel Core i7-1360P",
      RAM: "16GB LPDDR5",
      GPU: "Intel Iris Xe",
      "Màn hình": "13.4 inch OLED",
      "Lưu trữ": "512GB SSD",
    },
    description: "Dell XPS 13 Plus với thiết kế tối giản, OLED display, và hiệu năng mạnh.",
  },
  {
    id: 4,
    slug: "lenovo-thinkpad-x1-carbon",
    name: "Lenovo ThinkPad X1 Carbon",
    price: 28990000,
    category: "van-phong",
    images: [
      "https://images.unsplash.com/photo-1515612141207-8c18d41659af?q=80&w=1600&auto=format&fit=crop",
    ],
    colors: ["Đen"],
    sizes: ["14 inch"],
    specs: {
      CPU: "Intel Core i7-1365U",
      RAM: "16GB LPDDR5",
      GPU: "Intel Iris Xe",
      "Màn hình": "14 inch 2.8K OLED",
      "Lưu trữ": "512GB SSD",
    },
    description: "ThinkPad X1 Carbon Gen 12 - Laptop doanh nhân hàng đầu với độ bền cao.",
  },
  {
    id: 5,
    slug: "hp-pavilion-15",
    name: "HP Pavilion 15 Plus",
    price: 13990000,
    category: "van-phong",
    images: [
      "https://images.unsplash.com/photo-1516387938669-c8343971ccea?q=80&w=1600&auto=format&fit=crop",
    ],
    colors: ["Bạc", "Xám"],
    sizes: ["15.6 inch"],
    specs: {
      CPU: "AMD Ryzen 5 7530U",
      RAM: "8GB DDR5",
      GPU: "Radeon Graphics",
      "Màn hình": "15.6 inch FHD",
      "Lưu trữ": "256GB SSD",
    },
    description: "HP Pavilion 15 Plus - Laptop giá tốt với hiệu năng đủ dùng cho học tập, văn phòng.",
  },
  {
    id: 6,
    slug: "msi-stealth-15",
    name: "MSI Stealth 15",
    price: 32990000,
    category: "gaming",
    images: [
      "https://images.unsplash.com/photo-1588872657840-790ff3bde4c0?q=80&w=1600&auto=format&fit=crop",
    ],
    colors: ["Đen"],
    sizes: ["15.6 inch"],
    specs: {
      CPU: "Intel Core i9-13900H",
      RAM: "16GB DDR5",
      GPU: "NVIDIA RTX 4070",
      "Màn hình": "15.6 inch FHD 144Hz",
      "Lưu trữ": "512GB SSD",
    },
    description: "MSI Stealth 15 - Laptop gaming mỏng nhẹ với thiết kế tối giản nhưng hiệu năng mạnh mẽ.",
  },
];

let nextId = 7;

export const handleGetProducts: RequestHandler = (req, res) => {
  res.json(products);
};

export const handleGetProduct: RequestHandler = (req, res) => {
  const id = Number(req.params.id);
  const product = products.find((p) => p.id === id);

  if (!product) {
    return res.status(404).json({ message: "Sản phẩm không tìm thấy" });
  }

  res.json(product);
};

export const handleCreateProduct: RequestHandler = (req, res) => {
  const { name, price, category, images, colors, sizes, specs, description } = req.body;

  if (!name || !price || !category) {
    return res.status(400).json({ message: "Vui lòng cung cấp tên, giá và danh mục" });
  }

  const newProduct: Product = {
    id: nextId++,
    slug: name.toLowerCase().replace(/\s+/g, "-"),
    name,
    price,
    category,
    images: images || [],
    colors: colors || [],
    sizes: sizes || [],
    specs: specs || {},
    description: description || "",
  };

  products.push(newProduct);
  res.status(201).json(newProduct);
};

export const handleUpdateProduct: RequestHandler = (req, res) => {
  const id = Number(req.params.id);
  const { name, price, category, images, colors, sizes, specs, description } = req.body;

  const product = products.find((p) => p.id === id);

  if (!product) {
    return res.status(404).json({ message: "Sản phẩm không tìm thấy" });
  }

  if (name) product.name = name;
  if (price) product.price = price;
  if (category) product.category = category;
  if (images) product.images = images;
  if (colors) product.colors = colors;
  if (sizes) product.sizes = sizes;
  if (specs) product.specs = specs;
  if (description) product.description = description;

  res.json(product);
};

export const handleDeleteProduct: RequestHandler = (req, res) => {
  const id = Number(req.params.id);
  const index = products.findIndex((p) => p.id === id);

  if (index === -1) {
    return res.status(404).json({ message: "Sản phẩm không tìm thấy" });
  }

  products.splice(index, 1);
  res.json({ message: "Đã xóa sản phẩm" });
};

export { products };
