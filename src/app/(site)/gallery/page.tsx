import GalleryGrid from '@/components/sections/gallery-section';
import { getGalleryImages } from '@/lib/google-drive';

export const revalidate = 3600; // Revalidate every hour

export default async function GalleryPage() {
  const media = await getGalleryImages();

  return <GalleryGrid media={media} />;
}
