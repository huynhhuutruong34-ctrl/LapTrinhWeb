import "./global.css";

import { Toaster } from "@/components/ui/toaster";
import { createRoot } from "react-dom/client";
import { Toaster as Sonner } from "@/components/ui/sonner";
import { TooltipProvider } from "@/components/ui/tooltip";
import { QueryClient, QueryClientProvider } from "@tanstack/react-query";
import { BrowserRouter, Routes, Route } from "react-router-dom";
import Index from "./pages/Index";
import NotFound from "./pages/NotFound";
import Catalog from "./pages/Catalog";
import Layout from "@/components/layout/Layout";
import Product from "./pages/Product";
import Cart from "./pages/Cart";
import Checkout from "./pages/Checkout";
import OrderSuccess from "./pages/OrderSuccess";
import Login from "./pages/Login";
import Register from "./pages/Register";
import AdminDashboard from "./pages/admin/Dashboard";
import AdminProducts from "./pages/admin/Products";
import AdminOrders from "./pages/admin/Orders";
import Placeholder from "@/components/Placeholder";
import { CartProvider } from "@/components/cart/CartProvider";
import { UserProvider } from "@/components/auth/UserContext";

const queryClient = new QueryClient();

const App = () => (
  <QueryClientProvider client={queryClient}>
    <UserProvider>
      <CartProvider>
        <TooltipProvider>
          <Toaster />
          <Sonner />
          <BrowserRouter>
            <Layout>
              <Routes>
              <Route path="/" element={<Index />} />
              <Route path="/catalog" element={<Catalog />} />
              <Route path="/catalog/:category" element={<Catalog />} />
              <Route path="/product/:id" element={<Product />} />
              <Route path="/cart" element={<Cart />} />
              <Route path="/checkout" element={<Checkout />} />
              <Route path="/order-success/:id" element={<OrderSuccess />} />
              <Route path="/login" element={<Login />} />
              <Route path="/register" element={<Register />} />
              <Route path="/admin" element={<AdminDashboard />} />
              <Route path="/admin/products" element={<AdminProducts />} />
              <Route path="/admin/orders" element={<AdminOrders />} />
              <Route
                path="/contact"
                element={<Placeholder title="Liên hệ" description="Trang liên hệ sẽ được xây dựng tiếp theo theo yêu cầu của bạn." />}
              />
              {/* ADD ALL CUSTOM ROUTES ABOVE THE CATCH-ALL "*" ROUTE */}
              <Route path="*" element={<NotFound />} />
            </Routes>
            </Layout>
          </BrowserRouter>
        </TooltipProvider>
      </CartProvider>
    </UserProvider>
  </QueryClientProvider>
);

const container = document.getElementById("root");
if (!container) throw new Error("Root element not found");

declare global {
  interface Window {
    __MODA_REACT_ROOT__?: ReturnType<typeof createRoot>;
  }
}

if (!window.__MODA_REACT_ROOT__) {
  window.__MODA_REACT_ROOT__ = createRoot(container as Element);
}

window.__MODA_REACT_ROOT__!.render(<App />);

// HMR: unmount on module replacement to avoid duplicate roots
if (import.meta.hot) {
  import.meta.hot.accept();
  import.meta.hot.dispose(() => {
    try {
      window.__MODA_REACT_ROOT__?.unmount();
    } catch (e) {
      // ignore
    }
    // ensure next module will create a fresh root
    delete window.__MODA_REACT_ROOT__;
  });
}
