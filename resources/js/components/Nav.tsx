import React from 'react';
import { Link, usePage } from '@inertiajs/react';

export default function Nav() {
  const { auth } = usePage().props as any;
  return (
    <nav className='bg-white shadow-md border-b py-2'>
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex justify-between h-16">
          <div className="flex items-center">
            <Link href="/" className='text-2xl font-black text-indigo-600'>
              MyApp
            </Link>
          </div>
        </div>
      </div>
    </nav>
  )
}
