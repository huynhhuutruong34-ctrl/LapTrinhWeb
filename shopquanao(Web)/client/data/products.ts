export type Product = {
  id: number;
  slug: string;
  name: string;
  price: number;
  category: string;
  images: string[];
  colors?: string[];
  sizes?: string[];
  specs?: Record<string, string>;
  description?: string;
};

export const products: Product[] = [
  {
    id: 1,
    slug: "ao-thun-nam-co-ban",
    name: "Áo Thun Nam Cơ Bản",
    price: 150000,
    category: "nam",
    images: [
      "https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?q=80&w=1600&auto=format&fit=crop",
      "https://images.unsplash.com/photo-1556821552-9f6db235933a?q=80&w=1600&auto=format&fit=crop",
      "https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?q=80&w=1600&auto=format&fit=crop",
    ],
    colors: ["Trắng", "Đen", "Xám"],
    sizes: ["XS", "S", "M", "L", "XL", "2XL"],
    description:
      "Áo thun nam cao cấp, thoải mái mặc cả ngày. Chất liệu cotton 100%, mềm mại và thấm hút mồ hôi tốt.",
  },
  {
    id: 2,
    slug: "ao-so-mi-nam-trang",
    name: "Áo Sơ Mi Nam Trắng",
    price: 350000,
    category: "nam",
    images: [
      "https://images.unsplash.com/photo-1556821552-9f6db235933a?q=80&w=1600&auto=format&fit=crop",
      "https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?q=80&w=1600&auto=format&fit=crop",
      "https://images.unsplash.com/photo-1556821552-9f6db235933a?q=80&w=1600&auto=format&fit=crop",
    ],
    colors: ["Trắng", "Xanh"],
    sizes: ["S", "M", "L", "XL"],
    description: "Áo sơ mi nam đẹp, phù hợp cho công sở. Chất vải cao cấp, bền bỉ và dễ bảo quản.",
  },
  {
    id: 3,
    slug: "quan-jean-nam-xanh",
    name: "Quần Jean Nam Xanh",
    price: 450000,
    category: "quan",
    images: [
      "https://images.unsplash.com/photo-1542272604-787c62d465d1?q=80&w=1600&auto=format&fit=crop",
      "https://images.unsplash.com/photo-1516417344260-16bac56c4f5a?q=80&w=1600&auto=format&fit=crop",
      "https://images.unsplash.com/photo-1542272604-787c62d465d1?q=80&w=1600&auto=format&fit=crop",
    ],
    colors: ["Xanh đậm", "Xanh nhạt"],
    sizes: ["28", "29", "30", "31", "32", "33", "34"],
    description: "Quần jean nam chất lượng cao, bền và đẹp. Thiết kế hiện đại, thoải mái cho mọi hoạt động.",
  },
  {
    id: 4,
    slug: "ao-day-nu-hong",
    name: "Áo Dây Nữ Hồng",
    price: 200000,
    category: "nu",
    images: [
      "https://images.unsplash.com/photo-1551028719-00167b16ebc5?q=80&w=1600&auto=format&fit=crop",
      "https://images.unsplash.com/photo-1506629082632-401017062ee9?q=80&w=1600&auto=format&fit=crop",
      "https://images.unsplash.com/photo-1551028719-00167b16ebc5?q=80&w=1600&auto=format&fit=crop",
    ],
    colors: ["Hồng", "Trắng", "Đen"],
    sizes: ["XS", "S", "M", "L", "XL"],
    description: "Áo dây nữ mềm mại, thích hợp cho mùa hè. Chất liệu thoáng mát, màu sắc tươi sáng.",
  },
  {
    id: 5,
    slug: "quan-shorts-nu-trang",
    name: "Quần Shorts Nữ Trắng",
    price: 280000,
    category: "nu",
    images: [
      "https://images.unsplash.com/photo-1506629082632-401017062ee9?q=80&w=1600&auto=format&fit=crop",
      "https://images.unsplash.com/photo-1551028719-00167b16ebc5?q=80&w=1600&auto=format&fit=crop",
      "https://images.unsplash.com/photo-1506629082632-401017062ee9?q=80&w=1600&auto=format&fit=crop",
    ],
    colors: ["Trắng", "Đen", "Xanh"],
    sizes: ["XS", "S", "M", "L", "XL"],
    description: "Quần shorts nữ form vừa vặn, thoáng mát. Thiết kế hiện đại, dễ phối đồ.",
  },
  {
    id: 6,
    slug: "vay-lien-nu-den",
    name: "Váy Liền Nữ Đen",
    price: 550000,
    category: "nu",
    images: [
      "https://images.unsplash.com/photo-1589411954174-786cb883fdf4?q=80&w=1600&auto=format&fit=crop",
      "https://images.unsplash.com/photo-1551028719-00167b16ebc5?q=80&w=1600&auto=format&fit=crop",
      "https://images.unsplash.com/photo-1589411954174-786cb883fdf4?q=80&w=1600&auto=format&fit=crop",
    ],
    colors: ["Đen", "Đỏ", "Xanh"],
    sizes: ["XS", "S", "M", "L", "XL"],
    description: "Váy liền nữ thanh lịch, dễ phối đồ. Chất liệu cao cấp, phù hợp cho nhiều dịp.",
  },
];
