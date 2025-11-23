export interface Product {
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
}
