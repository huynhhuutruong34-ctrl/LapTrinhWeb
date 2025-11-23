import "dotenv/config";
import express, { Request, Response } from "express";
import cors from "cors";
import path from "path";
import { handleDemo } from "./routes/demo";
import { handleCheckout } from "./routes/checkout";
import { handleHome } from "./routes/home";
import { handleRegister, handleLogin, handleLogout, handleMe, sessions } from "./routes/auth";
import { handleGetProducts, handleGetProduct, handleCreateProduct, handleUpdateProduct, handleDeleteProduct } from "./routes/products";
import { handleCreateOrder, handleGetOrders, handleGetOrder, handleUpdateOrder } from "./routes/orders";

export function createServer() {
  const app = express();

  // Middleware
  app.use(cors({ origin: true, credentials: true }));
  app.use(express.json());
  app.use(express.urlencoded({ extended: true }));

  // Simple cookie parser middleware
  app.use((req, res, next) => {
    const cookies: { [key: string]: string } = {};
    if (req.headers.cookie) {
      req.headers.cookie.split(";").forEach((cookie) => {
        const [name, value] = cookie.trim().split("=");
        cookies[name] = decodeURIComponent(value || "");
      });
    }
    (req as any).cookies = cookies;
    next();
  });

  // Cookie setter helper
  app.use((req, res, next) => {
    const setCookie = res.cookie;
    res.cookie = function (name: string, val: string, options?: any) {
      let cookieStr = `${name}=${encodeURIComponent(val)}`;
      if (options?.httpOnly) cookieStr += "; HttpOnly";
      if (options?.sameSite) cookieStr += `; SameSite=${options.sameSite}`;
      res.appendHeader("Set-Cookie", cookieStr);
      return res;
    };
    next();
  });

  // User session middleware
  app.use((req, res, next) => {
    const sessionId = (req as any).cookies?.sessionId;
    if (sessionId) {
      const user = sessions.get(sessionId);
      if (user) {
        (req as any).user = user;
      }
    }
    next();
  });

  // Serve static files (if any)
  app.use(express.static(path.join(process.cwd(), "public")));

  // Example API routes
  app.get("/api/ping", (_req, res) => {
    const ping = process.env.PING_MESSAGE ?? "ping";
    res.json({ message: ping });
  });

  app.get("/api/demo", handleDemo);
  app.post("/api/checkout", handleCheckout);

  // Auth routes
  app.post("/api/auth/register", handleRegister);
  app.post("/api/auth/login", handleLogin);
  app.post("/api/auth/logout", handleLogout);
  app.get("/api/auth/me", handleMe);

  // Products routes
  app.get("/api/products", handleGetProducts);
  app.get("/api/products/:id", handleGetProduct);
  app.post("/api/products", handleCreateProduct);
  app.put("/api/products/:id", handleUpdateProduct);
  app.delete("/api/products/:id", handleDeleteProduct);

  // Orders routes
  app.post("/api/orders", handleCreateOrder);
  app.get("/api/orders", handleGetOrders);
  app.get("/api/orders/:id", handleGetOrder);
  app.put("/api/orders/:id", handleUpdateOrder);

  // Server-rendered home page (simple HTML assembly)
  app.get("/", handleHome);
  app.get("/home", (_req, res) => res.redirect("/"));

  return app;
}
