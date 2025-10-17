import GuestLayout from "@/layouts/guest-layout";

export default function LoginPage() {
  return (
    <div>Login</div>
  );
}

LoginPage.layout = (page: React.ReactNode) => (
  <GuestLayout
    header={
      <h2 className="text-xl font-semibold leading-tight text-gray-800">
        Authentication Page
      </h2>
    }
  >
    {page}
  </GuestLayout>
);
