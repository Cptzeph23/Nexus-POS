import axios, {
  type AxiosInstance,
  type AxiosResponse,
  type InternalAxiosRequestConfig,
} from "axios";
import type {
  SyncBatchRequest,
  SyncBatchResponse,
  Transaction,
  LocalProduct,
  Customer,
  DailySummary,
  Branch,
  Terminal,
  User,
} from "@/types";

export class NetworkError extends Error {
  constructor(message = "No network connection") {
    super(message);
    this.name = "NetworkError";
  }
}

export class ApiError extends Error {
  constructor(
    public status: number,
    public code: string,
    message: string,
  ) {
    super(message);
    this.name = "ApiError";
  }
}

export interface PaginatedResponse<T> {
  data:  T[];
  meta: {
    total:        number;
    perPage:      number;
    currentPage:  number;
    lastPage:     number;
  };
}

function createApiClient(): AxiosInstance {
  const client = axios.create({
    baseURL:        process.env.NEXT_PUBLIC_API_URL ?? "http://localhost:8000/api/v1",
    timeout:        10_000,
    headers: {
      "Content-Type": "application/json",
      "Accept":       "application/json",
      "X-App-Version": process.env.NEXT_PUBLIC_APP_VERSION ?? "1.0.0",
    },
  });

  client.interceptors.request.use(
    (config: InternalAxiosRequestConfig) => {
      if (typeof window !== "undefined" && !navigator.onLine) {
        throw new NetworkError();
      }

      const token = getStoredToken();
      if (token) {
        config.headers.Authorization = `Bearer ${token}`;
      }

      const terminalId = getStoredTerminalId();
      const branchId   = getStoredBranchId();
      if (terminalId) config.headers["X-Terminal-ID"] = terminalId;
      if (branchId)   config.headers["X-Branch-ID"]   = branchId;

      return config;
    },
    (error) => Promise.reject(error),
  );

  client.interceptors.response.use(
    (response: AxiosResponse) => response,
    async (error) => {
      if (!error.response) {
        throw new NetworkError(error.message);
      }

      const { status, data } = error.response;

      if (status === 401) {
        clearStoredSession();
        if (typeof window !== "undefined") {
          window.location.href = "/login";
        }
      }

      throw new ApiError(
        status,
        data?.code ?? "UNKNOWN",
        data?.message ?? `Request failed with status ${status}`,
      );
    },
  );

  return client;
}

function getStoredToken(): string | null {
  if (typeof window === "undefined") return null;
  return localStorage.getItem("nexus_token");
}

function getStoredTerminalId(): string | null {
  if (typeof window === "undefined") return null;
  return localStorage.getItem("nexus_terminal_id");
}

function getStoredBranchId(): string | null {
  if (typeof window === "undefined") return null;
  return localStorage.getItem("nexus_branch_id");
}

export function setStoredSession(token: string, terminalId: string, branchId: string): void {
  localStorage.setItem("nexus_token",       token);
  localStorage.setItem("nexus_terminal_id", terminalId);
  localStorage.setItem("nexus_branch_id",   branchId);
}

export function clearStoredSession(): void {
  ["nexus_token", "nexus_terminal_id", "nexus_branch_id", "nexus_session_id"].forEach(
    (key) => localStorage.removeItem(key),
  );
}

const http = createApiClient();

export const api = {
  auth: {
    registerTerminal: (deviceId: string, branchCode: string, secret: string) =>
      http.post<{ terminalId: string; token: string; branch: Branch }>(
        "/auth/terminal",
        { deviceId, branchCode, secret },
      ),

    cashierLogin: (pin: string, terminalId: string) =>
      http.post<{ token: string; cashier: User; sessionId: string }>(
        "/auth/cashier/login",
        { pin, terminalId },
      ),

    cashierLogout: (sessionId: string) =>
      http.post("/auth/cashier/logout", { sessionId }),
  },

  products: {
    list: (params?: { page?: number; category?: string; updatedAfter?: string }) =>
      http.get<PaginatedResponse<LocalProduct>>("/products", { params }),

    getById: (id: string) =>
      http.get<LocalProduct>(`/products/${id}`),

    getByBarcode: (barcode: string) =>
      http.get<LocalProduct>(`/products/barcode/${encodeURIComponent(barcode)}`),

    search: (query: string) =>
      http.get<LocalProduct[]>("/products/search", { params: { q: query } }),
  },

  sync: {
    batch: (payload: SyncBatchRequest) =>
      http.post<SyncBatchResponse>("/sync/batch", payload),

    status: () =>
      http.get<{ pending: number; lastSync: string | null }>("/sync/status"),
  },

  transactions: {
    list: (params?: { branchId?: string; date?: string; page?: number }) =>
      http.get<PaginatedResponse<Transaction>>("/transactions", { params }),

    getById: (id: string) =>
      http.get<Transaction>(`/transactions/${id}`),

    refund: (id: string, items: unknown[], reason: string) =>
      http.post<Transaction>(`/transactions/${id}/refund`, { items, reason }),
  },

  customers: {
    search: (query: string) =>
      http.get<Customer[]>("/customers/search", { params: { q: query } }),

    getById: (id: string) =>
      http.get<Customer>(`/customers/${id}`),

    create: (data: Partial<Customer>) =>
      http.post<Customer>("/customers", data),

    redeemPoints: (id: string, points: number) =>
      http.post<{ discount: number; remainingPoints: number }>(
        `/customers/${id}/loyalty/redeem`,
        { points },
      ),
  },

  inventory: {
    levels: (branchId: string) =>
      http.get<{ productId: string; quantity: number; reorderPoint: number }[]>(
        `/inventory/${branchId}`,
      ),

    transfer: (fromBranch: string, toBranch: string, productId: string, qty: number) =>
      http.post("/inventory/transfer", { fromBranch, toBranch, productId, qty }),
  },

  reports: {
    daily: (branchId: string, date: string) =>
      http.get<DailySummary>("/reports/daily", { params: { branchId, date } }),

    branches: (from: string, to: string) =>
      http.get("/reports/branches", { params: { from, to } }),
  },

  admin: {
    branches: {
      list: () => http.get<Branch[]>("/admin/branches"),
      create: (data: Partial<Branch>) => http.post<Branch>("/admin/branches", data),
      update: (id: string, data: Partial<Branch>) => http.put<Branch>(`/admin/branches/${id}`, data),
    },
    users: {
      list: (branchId?: string) => http.get<User[]>("/admin/users", { params: { branchId } }),
      create: (data: Partial<User>) => http.post<User>("/admin/users", data),
    },
    terminals: {
      list: (branchId?: string) => http.get<Terminal[]>("/admin/terminals", { params: { branchId } }),
    },
  },
};

export { http };