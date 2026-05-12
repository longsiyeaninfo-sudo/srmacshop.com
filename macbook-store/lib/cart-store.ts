import { create } from "zustand";
import { persist } from "zustand/middleware";

export type CartItem = {
  variantId: string;
  quantity: number;
  snapshot: {
    productName: string;
    variantSku: string;
    chip: string;
    ram: number;
    storage: number;
    color: string;
    price: number;
    image?: string;
  };
};

type CartStore = {
  items: CartItem[];
  addItem: (item: CartItem) => void;
  removeItem: (variantId: string) => void;
  updateQuantity: (variantId: string, quantity: number) => void;
  clear: () => void;
  subtotal: () => number;
  itemCount: () => number;
};

export const useCartStore = create<CartStore>()(
  persist(
    (set, get) => ({
      items: [],

      addItem: (item) => {
        set((state) => {
          const existingItem = state.items.find(
       (i) => i.variantId === item.variantId
          );

          if (existingItem) {
            return {
              items: state.items.map((i) =>
                i.variantId === item.variantId
                  ? { ...i, quantity: i.quantity + item.quantity }
          : i
          ),
            };
        }

          return { items: [...state.items, item] };
    });
      },

      removeItem: (variantId) => {
        set((state) => ({
          items: state.items.filter((i) => i.variantId !== variantId),
        }));
      },

      updateQuantity: (variantId, quantity) => {
        if (quantity <= 0) {
          get().removeItem(variantId);
          return;
        }

        set((state) => ({
          items: state.items.map((i) =>
         i.variantId === variantId ? { ...i, quantity } : i
          ),
      }));
      },

      clear: () => {
     set({ items: [] });
      },

      subtotal: () => {
        return get().items.reduce(
          (sum, item) => sum + item.snapshot.price * item.quantity,
          0
      );
      },

      itemCount: () => {
        return get().items.reduce((sum, item) => sum + item.quantity, 0);
      },
    }),
    {
      name: "cart-storage",
    }
  )
);
