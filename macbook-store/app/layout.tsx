import type { Metadata } from "next";
import { Inter } from "next/font/google";
import "./globals.css";
import { ThemeProvider } from "@/components/theme-provider";

const inter = Inter({
  variable: "--font-sans",
  subsets: ["latin"],
  display: "swap",
});

export const metadata: Metadata = {
  title: "MacBook Store - Premium Apple Products",
  description: "Shop the latest MacBook Pro and MacBook Air with M4 chip",
};

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <html lang="en" className={`${inter.variable} h-full`} suppressHydrationWarning>
      <body className="min-h-full flex flex-col antialiased">
        <ThemeProvider
          attribute="class"
        defaultTheme="light"
       enableSystem
          disableTransitionOnChange
        >
          {children}
        </ThemeProvider>
      </body>
    </html>
  );
}
