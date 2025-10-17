import React from "react";

export type PageWithLayout = React.FC & {
  layout?: (page: React.ReactNode) => React.ReactNode;
};
