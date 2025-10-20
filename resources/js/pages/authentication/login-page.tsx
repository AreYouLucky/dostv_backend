import React from "react";
import GuestLayout from "@/layouts/guest-layout";
import type { PageWithLayout } from "@/types/page";

const Home: PageWithLayout = () => {
  return <div>Welcome to the Home Page!</div>;
};

Home.layout = (page) => (
  <GuestLayout
    header={'Home Page'}
  >
    {page}
  </GuestLayout>
);

export default Home;
