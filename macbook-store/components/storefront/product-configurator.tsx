"use client";

import { useState } from "react";
import { Button } from "@/components/ui/button";
import { ShoppingBag } from "lucide-react";
import { useCartStore } from "@/lib/cart-store";

type Variant = {
  id: string;
  chip: string;
  ram: number;
  storage: number;
  color: string;
  priceDelta: number;
  sku: string;
  stock: number;
};

type ProductConfiguratorProps = {
  basePrice: number;
  variants: Variant[];
  productName: string;
  productImage?: string;
};

export function ProductConfigurator({
  basePrice,
  variants,
  productName,
  productImage,
}: ProductConfiguratorProps) {
  const addItem = useCartStore((state) => state.addItem);
  // Extract unique options
  const chips = [...new Set(variants.map((v) => v.chip))];
  const rams = [...new Set(variants.map((v) => v.ram))].sort((a, b) => a - b);
  const storages = [...new Set(variants.map((v) => v.storage))].sort((a, b) => a - b);
  const colors = [...new Set(variants.map((v) => v.color))];

  // Selected options
  const [selectedChip, setSelectedChip] = useState(chips[0]);
  const [selectedRam, setSelectedRam] = useState(rams[0]);
  const [selectedStorage, setSelectedStorage] = useState(storages[0]);
  const [selectedColor, setSelectedColor] = useState(colors[0]);

  // Find matching variant
  const selectedVariant = variants.find(
    (v) =>
      v.chip === selectedChip &&
      v.ram === selectedRam &&
      v.storage === selectedStorage &&
      v.color === selectedColor
  );

  const totalPrice = basePrice + (selectedVariant?.priceDelta || 0);
  const inStock = (selectedVariant?.stock || 0) > 0;

  const handleAddToCart = () => {
    if (!selectedVariant || !inStock) return;

    addItem({
      variantId: selectedVariant.id,
      quantity: 1,
      snapshot: {
     productName,
      variantSku: selectedVariant.sku,
        chip: selectedVariant.chip,
        ram: selectedVariant.ram,
        storage: selectedVariant.storage,
        color: selectedVariant.color,
        price: totalPrice,
        image: productImage,
      },
    });
  };

  return (
    <div className="space-y-8">
      {/* Chip Selection */}
      <div>
        <h3 className="text-lg font-semibold mb-4">Chip</h3>
    <div className="grid grid-cols-2 gap-3">
          {chips.map((chip) => (
            <button
         key={chip}
              onClick={() => setSelectedChip(chip)}
              className={`p-4 rounded-xl border-2 transition-all ${
            selectedChip === chip
            ? "border-[var(--accent)] ring-2 ring-[var(--accent)]/20"
                : "border-[var(--border)] hover:border-[var(--accent)]/50"
              }`}
            >
              <div className="font-semibold">{chip}</div>
            </button>
          ))}
     </div>
      </div>

      {/* RAM Selection */}
      <div>
        <h3 className="text-lg font-semibold mb-4">Memory</h3>
        <div className="grid grid-cols-3 gap-3">
          {rams.map((ram) => (
            <button
              key={ram}
              onClick={() => setSelectedRam(ram)}
            className={`p-4 rounded-xl border-2 transition-all ${
                selectedRam === ram
                  ? "border-[var(--accent)] ring-2 ring-[var(--accent)]/20"
                  : "border-[var(--border)] hover:border-[var(--accent)]/50"
           }`}
            >
              <div className="font-semibold">{ram}GB</div>
            </button>
          ))}
        </div>
      </div>

      {/* Storage Selection */}
      <div>
        <h3 className="text-lg font-semibold mb-4">Storage</h3>
        <div className="grid grid-cols-3 gap-3">
          {storages.map((storage) => (
            <button
          key={storage}
              onClick={() => setSelectedStorage(storage)}
              className={`p-4 rounded-xl border-2 transition-all ${
              selectedStorage === storage
                  ? "border-[var(--accent)] ring-2 ring-[var(--accent)]/20"
                  : "border-[var(--border)] hover:border-[var(--accent)]/50"
              }`}
            >
              <div className="font-semibold">{storage}GB</div>
          </button>
      ))}
        </div>
      </div>

      {/* Color Selection */}
      <div>
        <h3 className="text-lg font-semibold mb-4">Color</h3>
        <div className="grid grid-cols-2 gap-3">
          {colors.map((color) => (
            <button
           key={color}
              onClick={() => setSelectedColor(color)}
              className={`p-4 rounded-xl border-2 transition-all ${
                selectedColor === color
                  ? "border-[var(--accent)] ring-2 ring-[var(--accent)]/20"
            : "border-[var(--border)] hover:border-[var(--accent)]/50"
              }`}
            >
            <div className="font-semibold">{color}</div>
            </button>
          ))}
        </div>
      </div>

      {/* Price & Add to Cart */}
      <div className="sticky bottom-0 bg-[var(--surface)] border-t border-[var(--border)] p-6 -mx-6 -mb-6 rounded-b-3xl">
        <div className="flex items-center justify-between mb-4">
          <div>
            <div className="text-sm text-[var(--muted)]">Total</div>
            <div className="text-3xl font-bold">
          ${(totalPrice / 100).toLocaleString()}
            </div>
          </div>
          {!inStock && (
            <div className="text-sm text-red-500 font-medium">Out of stock</div>
      )}
        </div>
        <Button
          className="w-full rounded-full py-6 text-base"
          disabled={!inStock}
      onClick={handleAddToCart}
        >
          <ShoppingBag className="mr-2 h-5 w-5" />
          Add to Bag
        </Button>
        {selectedVariant && (
          <div className="mt-3 text-xs text-[var(--muted)] text-center">
          SKU: {selectedVariant.sku}
          </div>
        )}
      </div>
    </div>
  );
}
