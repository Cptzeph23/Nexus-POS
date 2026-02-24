import type { Metadata } from "next";

export const metadata: Metadata = {
  title: "POS Terminal - Nexus POS",
};

export default function POSPage() {
  return (
    <div
      style={{
        display: "flex",
        alignItems: "center",
        justifyContent: "center",
        height: "100vh",
        flexDirection: "column",
        gap: "16px",
        background: "#07070f",
        color: "#a78bfa",
        fontFamily: "'IBM Plex Mono', monospace",
      }}
    >
      <div style={{ fontSize: "48px" }}>NEXUS</div>
      <div style={{ fontSize: "24px", fontWeight: 800, letterSpacing: "-0.5px" }}>
        Point of Sale
      </div>
      <div style={{ fontSize: "14px", color: "#6b6b8a" }}>
        Phase A - Structure OK
      </div>
      <div style={{ fontSize: "12px", color: "#3a3a55", marginTop: "8px" }}>
        Cashier interface loads here in Phase E
      </div>
    </div>
  );
}