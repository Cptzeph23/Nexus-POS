import type { Metadata } from "next";

export const metadata: Metadata = { title: "Inventory - Nexus POS" };

export default function InventoryPage() {
  return (
    <div style={{ padding: "32px", color: "#6b6b8a", fontFamily: "monospace" }}>
      <h1 style={{ color: "#a78bfa", marginBottom: "8px" }}>Inventory</h1>
      <p>Full implementation in Phase G.</p>
    </div>
  );
}