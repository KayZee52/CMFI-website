import type { SVGProps } from 'react';
import Image from 'next/image';

export const CMFILogo = (props: Omit<React.ComponentProps<typeof Image>, 'src' | 'alt'>) => (
  <Image
    src="/logo.png"
    alt="CMFI Bilingual High School Logo"
    width={50}
    height={50}
    {...props}
  />
);
