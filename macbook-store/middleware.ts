import { auth } from "@/lib/auth";
import { NextResponse } from "next/server";

export default auth((req) => {
  const { pathname } = req.nextUrl;
  const isLoggedIn = !!req.auth;

  // Protect /admin routes - require ADMIN role
  if (pathname.startsWith("/admin")) {
    if (!isLoggedIn) {
      return NextResponse.redirect(new URL("/auth/signin", req.url));
  }
    // @ts-ignore
    if (req.auth?.user?.role !== "ADMIN") {
      return NextResponse.redirect(new URL("/", req.url));
    }
  }

  // Protect /account routes - require authentication
  if (pathname.startsWith("/account")) {
    if (!isLoggedIn) {
      return NextResponse.redirect(new URL("/auth/signin", req.url));
    }
  }

  // Protect /checkout - require authentication
  if (pathname.startsWith("/checkout")) {
    if (!isLoggedIn) {
      return NextResponse.redirect(new URL("/auth/signin", req.url));
    }
  }

  return NextResponse.next();
});

export const config = {
  matcher: ["/admin/:path*", "/account/:path*", "/checkout/:path*"],
};
