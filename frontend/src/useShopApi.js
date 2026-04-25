import { useEffect, useMemo, useState } from "react";
import { orderApi, productApi } from "./api";

export function useProducts(query, category) {
  const [products, setProducts] = useState([]);
  const [loading, setLoading] = useState(false);

  useEffect(() => {
    let mounted = true;
    setLoading(true);

    productApi
      .list({ q: query, category: category === "Tất cả" ? undefined : category })
      .then((result) => {
        if (mounted) {
          setProducts(result.data ?? []);
        }
      })
      .finally(() => {
        if (mounted) {
          setLoading(false);
        }
      });

    return () => {
      mounted = false;
    };
  }, [query, category]);

  return { products, loading };
}

export function useCheckout(token, cart) {
  const payload = useMemo(() => ({
    receiver_name: "Tuấn Anh",
    phone: "0988888888",
    address: "12 Duy Tân, Cầu Giấy, Hà Nội",
    items: cart.map((item) => ({ product_id: item.id, qty: item.qty })),
  }), [cart]);

  const placeOrder = () => orderApi.create(token, payload);

  return { placeOrder };
}
