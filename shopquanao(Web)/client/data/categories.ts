export type Category = {
  slug: string;
  name: string;
};

export const categories: Category[] = [
  { slug: "tat-ca", name: "Tất cả" },
  { slug: "nam", name: "Áo nam" },
  { slug: "nu", name: "Áo nữ" },
  { slug: "quan", name: "Quần áo" },
];

export const getCategoryName = (slug?: string) => {
  if (!slug || slug === "tat-ca") return "Tất cả sản phẩm";
  return categories.find((c) => c.slug === slug)?.name ?? "Tất cả";
};
