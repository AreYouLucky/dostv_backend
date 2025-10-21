import { type ReactNode } from 'react';

interface GuestLayout {
    children: ReactNode;
}

function GuestLayout({children}:GuestLayout) {
  return (
    <div className='w-full min-h-screen'>
        {children}
    </div>
  )
}

export default GuestLayout