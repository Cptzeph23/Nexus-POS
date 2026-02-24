import type { Metadata } from "next";

export const metadata: Metadata = { title: "Orders - Nexus POS" };

export default function OrdersPage() {
  return (
    <div style={{ padding: "32px", color: "#6b6b8a", fontFamily: "monospace" }}>
      <h1 style={{ color: "#a78bfa", marginBottom: "8px" }}>Orders</h1>
      <p>Full implementation in Phase E.</p>
    </div>
  );
}