import type { Metadata } from "next";

export const metadata: Metadata = { title: "Dashboard - Nexus POS" };

export default function DashboardPage() {
  return (
    <div style={{ padding: "32px", color: "#6b6b8a", fontFamily: "monospace" }}>
      <h1 style={{ color: "#a78bfa", marginBottom: "8px" }}>Admin Dashboard</h1>
      <p>Full implementation in Phase I.</p>
    </div>
  );
}