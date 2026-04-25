const API_URL = import.meta.env.VITE_API_URL ?? "http://127.0.0.1:8000/api";

export async function apiRequest(path, { token, method = "GET", body, params } = {}) {
  const url = new URL(`${API_URL}${path}`);

  if (params) {
    Object.entries(params).forEach(([key, value]) => {
      if (value !== undefined && value !== null && value !== "") {
        url.searchParams.set(key, value);
      }
    });
  }

  const response = await fetch(url, {
    method,
    headers: {
      "Content-Type": "application/json",
      ...(token ? { Authorization: `Bearer ${token}` } : {}),
    },
    body: body ? JSON.stringify(body) : undefined,
  });

  const payload = await response.json();

  if (!response.ok) {
    throw new Error(payload.message ?? "API request failed.");
  }

  return payload;
}

export const authApi = {
  register: (data) => apiRequest('/auth/register', { method: 'POST', body: data }),
  login: (data) => apiRequest('/auth/login', { method: 'POST', body: data }),
  me: (token) => apiRequest('/auth/me', { token }),
};

export const productApi = {
  list: ({ q, category, page = 1 } = {}) => apiRequest('/products', { params: { q, category, page } }),
  detail: (id) => apiRequest(`/products/${id}`),
};

export const orderApi = {
  create: (token, data) => apiRequest('/orders', { token, method: 'POST', body: data }),
  list: (token, page = 1) => apiRequest('/orders', { token, params: { page } }),
};
