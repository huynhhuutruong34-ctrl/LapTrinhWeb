import { RequestHandler } from "express";

// In-memory storage for demo (in production, use a real database)
interface StoredUser {
  id: number;
  email: string;
  name: string;
  password: string; // In production, use bcrypt
  role: "user" | "admin";
}

interface SessionUser {
  id: number;
  email: string;
  name: string;
  role: "user" | "admin";
}

// Demo users
const users: StoredUser[] = [
  {
    id: 1,
    email: "admin@test.com",
    name: "Admin User",
    password: "password123",
    role: "admin",
  },
  {
    id: 2,
    email: "user@test.com",
    name: "Test User",
    password: "password123",
    role: "user",
  },
];

let nextUserId = 3;
let sessions: Map<string, SessionUser> = new Map();

function generateSessionId() {
  return Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
}

export const handleRegister: RequestHandler = (req, res) => {
  const { name, email, password } = req.body;

  if (!name || !email || !password) {
    return res.status(400).json({ message: "Vui lòng cung cấp tên, email và mật khẩu" });
  }

  if (users.some((u) => u.email === email)) {
    return res.status(400).json({ message: "Email đã được đăng ký" });
  }

  const newUser: StoredUser = {
    id: nextUserId++,
    email,
    name,
    password, // In production, hash this
    role: "user",
  };

  users.push(newUser);

  const sessionId = generateSessionId();
  const sessionUser: SessionUser = {
    id: newUser.id,
    email: newUser.email,
    name: newUser.name,
    role: newUser.role,
  };
  sessions.set(sessionId, sessionUser);

  res.setHeader("Set-Cookie", `sessionId=${sessionId}; Path=/; HttpOnly`);
  res.json({ user: sessionUser });
};

export const handleLogin: RequestHandler = (req, res) => {
  const { email, password } = req.body;

  if (!email || !password) {
    return res.status(400).json({ message: "Vui lòng cung cấp email và mật khẩu" });
  }

  const user = users.find((u) => u.email === email && u.password === password);

  if (!user) {
    return res.status(401).json({ message: "Email hoặc mật khẩu không chính xác" });
  }

  const sessionId = generateSessionId();
  const sessionUser: SessionUser = {
    id: user.id,
    email: user.email,
    name: user.name,
    role: user.role,
  };
  sessions.set(sessionId, sessionUser);

  res.setHeader("Set-Cookie", `sessionId=${sessionId}; Path=/; HttpOnly`);
  res.json({ user: sessionUser });
};

export const handleLogout: RequestHandler = (req, res) => {
  const sessionId = (req as any).cookies?.sessionId;
  if (sessionId) {
    sessions.delete(sessionId);
  }
  res.setHeader("Set-Cookie", "sessionId=; Max-Age=0");
  res.json({ message: "Đã đăng xuất" });
};

export const handleMe: RequestHandler = (req, res) => {
  const sessionId = (req as any).cookies?.sessionId;

  if (!sessionId) {
    return res.status(401).json({ message: "Chưa đăng nhập" });
  }

  const user = sessions.get(sessionId);

  if (!user) {
    return res.status(401).json({ message: "Phiên hết hạn" });
  }

  res.json({ user });
};

export { users, sessions, SessionUser };
