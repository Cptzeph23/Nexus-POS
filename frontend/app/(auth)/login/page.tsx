import type { Metadata } from "next";

export const metadata: Metadata = { title: "Login - Nexus POS" };

export default function LoginPage() {
  return (
    <div style={{ padding: "32px", color: "#6b6b8a", fontFamily: "monospace" }}>
      <h1 style={{ color: "#a78bfa", marginBottom: "8px" }}>Login</h1>
      <p>Full implementation in Phase D.</p>
    </div>
  );
}