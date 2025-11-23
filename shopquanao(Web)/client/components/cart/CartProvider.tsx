import React, { createContext, useContext, useEffect, useState } from "react";
import type { Product } from "@/data/products";

export type CartItem = {
  product: Product;
  quantity: number;
  color?: string;
  size?: string;
};

type CartContextValue = {
  items: CartItem[];
  addItem: (product: Product, opts?: { quantity?: number; color?: string; size?: string }) => void;
  removeItem: (index: number) => void;
  updateQuantity: (index: number, quantity: number) => void;
  clear: () => void;
  totalItems: number;
  subtotal: number;

  // coupons & shipping
  couponCode?: string | null;
  applyCoupon: (code: string) => boolean;
  removeCoupon: () => void;
  discount: number;
  shippingCity?: string | null;
  setShippingCity: (city: string | null) => void;
  shippingCost: number;
  total: number;
};

const CartContext = createContext<CartContextValue | undefined>(undefined);

const STORAGE_KEY = "moda_cart_v1";

export const CartProvider = ({ children }: { children: React.ReactNode }) => {
  const [items, setItems] = useState<CartItem[]>(() => {
    try {
      const raw = localStorage.getItem(STORAGE_KEY);
      return raw ? (JSON.parse(raw) as CartItem[]) : [];
    } catch {
      return [];
    }
  });

  useEffect(() => {
    try {
      localStorage.setItem(STORAGE_KEY, JSON.stringify(items));
    } catch {}
  }, [items]);

  const addItem = (product: Product, opts?: { quantity?: number; color?: string; size?: string }) => {
    const quantity = opts?.quantity ?? 1;
    // Try to merge with same product+variant
    const idx = items.findIndex(
      (it) => it.product.id === product.id && it.color === opts?.color && it.size === opts?.size,
    );
    if (idx > -1) {
      const copy = [...items];
      copy[idx].quantity += quantity;
      setItems(copy);
    } else {
      setItems([...items, { product, quantity, color: opts?.color, size: opts?.size }]);
    }
  };

  const removeItem = (index: number) => {
    const copy = [...items];
    copy.splice(index, 1);
    setItems(copy);
  };

  const updateQuantity = (index: number, quantity: number) => {
    if (quantity <= 0) return removeItem(index);
    const copy = [...items];
    copy[index].quantity = quantity;
    setItems(copy);
  };

  const clear = () => {
    setItems([]);
    setCouponCode(null);
    setDiscount(0);
    setShippingCity(null);
  };

  const totalItems = items.reduce((s, it) => s + it.quantity, 0);
  const subtotal = items.reduce((s, it) => s + it.quantity * it.product.price, 0);

  // coupons & shipping implementation
  const [couponCode, setCouponCode] = useState<string | null>(null);
  const [discount, setDiscount] = useState<number>(0);
  const [shippingCity, setShippingCity] = useState<string | null>(null);

  const applyCoupon = (code: string) => {
    // simple demo: SAVE10 gives 10% off, FREESHIP gives free shipping
    const normalized = code.trim().toUpperCase();
    if (normalized === "SAVE10") {
      setCouponCode(normalized);
      setDiscount(Math.round(subtotal * 0.1));
      return true;
    }
    if (normalized === "FREESHIP") {
      setCouponCode(normalized);
      setDiscount(0);
      return true;
    }
    return false;
  };

  const removeCoupon = () => {
    setCouponCode(null);
    setDiscount(0);
  };

  const shippingCost = shippingCity && shippingCity.toLowerCase().includes("hồ chí minh") ? 0 : 30000;

  const total = Math.max(0, subtotal - discount + shippingCost);

  return (
    <CartContext.Provider
      value={{
        items,
        addItem,
        removeItem,
        updateQuantity,
        clear,
        totalItems,
        subtotal,
        couponCode,
        applyCoupon,
        removeCoupon,
        discount,
        shippingCity,
        setShippingCity: (c: string | null) => setShippingCity(c),
        shippingCost,
        total,
      }}
    >
      {children}
    </CartContext.Provider>
  );
};

export const useCart = () => {
  const ctx = useContext(CartContext);
  if (!ctx) throw new Error("useCart must be used within CartProvider");
  return ctx;
};
