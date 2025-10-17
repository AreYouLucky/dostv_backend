import { Head } from "@inertiajs/react";
import type { ReactNode } from "react";

interface GuestLayoutProps {
  children: ReactNode;
  header?: ReactNode;
  title?: string;
}

export default function GuestLayout({ children, title }: GuestLayoutProps) {
  return (
    <>
      <Head title={title} />
      <div className="w-full min-h-screen bg-gray-100">
        <main className="p-6">{children}</main>
      </div>
    </>
  );
}
