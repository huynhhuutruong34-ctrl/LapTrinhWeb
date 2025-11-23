import { useEffect, useState } from "react";
import { AdminLayout } from "@/components/admin/AdminLayout";
import { Button } from "@/components/ui/button";
import { useToast } from "@/hooks/use-toast";

interface OrderItem {
  productId: number;
  quantity: number;
}

interface Order {
  id: string;
  customer: {
    name: string;
    email: string;
    phone: string;
    address: string;
    city: string;
  };
  items: OrderItem[];
  subtotal: number;
  shippingCost: number;
  discount: number;
  total: number;
  paymentMethod: "cod" | "card";
  status: "pending" | "confirmed" | "shipped" | "delivered" | "cancelled";
  createdAt: string;
}

export default function AdminOrders() {
  const [orders, setOrders] = useState<Order[]>([]);
  const [loading, setLoading] = useState(true);
  const [expandedOrderId, setExpandedOrderId] = useState<string | null>(null);
  const { toast } = useToast();

  useEffect(() => {
    fetchOrders();
  }, []);

  const fetchOrders = async () => {
    try {
      const res = await fetch("/api/orders", { credentials: "include" });
      if (!res.ok) throw new Error("Failed to fetch orders");
      const data = await res.json();
      setOrders(data);
    } catch (error) {
      toast({ title: "Lỗi", description: "Không thể tải danh sách đơn hàng" });
    } finally {
      setLoading(false);
    }
  };

  const handleUpdateStatus = async (orderId: string, newStatus: string) => {
    try {
      const res = await fetch(`/api/orders/${orderId}`, {
        method: "PUT",
        headers: { "Content-Type": "application/json" },
        credentials: "include",
        body: JSON.stringify({ status: newStatus }),
      });

      if (!res.ok) throw new Error("Failed to update order");

      toast({ title: "Cập nhật thành công" });
      fetchOrders();
    } catch (error) {
      toast({ title: "Lỗi", description: "Không thể cập nhật đơn hàng" });
    }
  };

  const getStatusLabel = (status: string) => {
    const labels: Record<string, string> = {
      pending: "Chờ xác nhận",
      confirmed: "Đã xác nhận",
      shipped: "Đang giao",
      delivered: "Đã giao",
      cancelled: "Đã hủy",
    };
    return labels[status] || status;
  };

  const getStatusColor = (status: string) => {
    const colors: Record<string, string> = {
      pending: "bg-yellow-100 text-yellow-800",
      confirmed: "bg-blue-100 text-blue-800",
      shipped: "bg-purple-100 text-purple-800",
      delivered: "bg-green-100 text-green-800",
      cancelled: "bg-red-100 text-red-800",
    };
    return colors[status] || "bg-gray-100 text-gray-800";
  };

  if (loading) {
    return (
      <AdminLayout>
        <div className="text-center py-12">Đang tải...</div>
      </AdminLayout>
    );
  }

  if (orders.length === 0) {
    return (
      <AdminLayout>
        <div className="text-center py-12 text-muted-foreground">
          Chưa có đơn hàng nào
        </div>
      </AdminLayout>
    );
  }

  return (
    <AdminLayout>
      <div className="space-y-6">
        <h2 className="text-xl font-semibold">Quản lý Đơn hàng</h2>

        <div className="space-y-3">
          {orders.map((order) => (
            <div key={order.id} className="rounded-lg border bg-card">
              <div
                className="p-4 cursor-pointer hover:bg-muted/50"
                onClick={() =>
                  setExpandedOrderId(
                    expandedOrderId === order.id ? null : order.id
                  )
                }
              >
                <div className="flex items-center justify-between">
                  <div>
                    <h3 className="font-semibold">{order.id}</h3>
                    <p className="text-sm text-muted-foreground">
                      {order.customer.name} • {order.customer.email}
                    </p>
                  </div>
                  <div className="text-right">
                    <p className="font-semibold">
                      {order.total.toLocaleString("vi-VN")}₫
                    </p>
                    <span
                      className={`inline-block px-2 py-1 rounded text-xs font-medium ${getStatusColor(
                        order.status
                      )}`}
                    >
                      {getStatusLabel(order.status)}
                    </span>
                  </div>
                </div>
              </div>

              {expandedOrderId === order.id && (
                <div className="border-t p-4 space-y-4">
                  <div className="grid grid-cols-2 gap-4">
                    <div>
                      <h4 className="font-medium mb-2">Thông tin giao hàng</h4>
                      <p className="text-sm text-muted-foreground">
                        {order.customer.address}, {order.customer.city}
                      </p>
                      <p className="text-sm text-muted-foreground">
                        {order.customer.phone}
                      </p>
                    </div>
                    <div>
                      <h4 className="font-medium mb-2">Chi tiết thanh toán</h4>
                      <p className="text-sm text-muted-foreground">
                        Phương thức: {order.paymentMethod === "cod" ? "COD" : "Thẻ"}
                      </p>
                      <p className="text-sm text-muted-foreground">
                        Tổng tiền: {order.total.toLocaleString("vi-VN")}₫
                      </p>
                    </div>
                  </div>

                  <div>
                    <h4 className="font-medium mb-2">Cập nhật trạng thái</h4>
                    <div className="flex gap-2 flex-wrap">
                      {[
                        "pending",
                        "confirmed",
                        "shipped",
                        "delivered",
                        "cancelled",
                      ].map((status) => (
                        <Button
                          key={status}
                          size="sm"
                          variant={
                            order.status === status ? "default" : "outline"
                          }
                          onClick={() =>
                            handleUpdateStatus(order.id, status)
                          }
                        >
                          {getStatusLabel(status)}
                        </Button>
                      ))}
                    </div>
                  </div>
                </div>
              )}
            </div>
          ))}
        </div>
      </div>
    </AdminLayout>
  );
}
