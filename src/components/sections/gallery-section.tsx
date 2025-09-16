'use client';

import { useState } from 'react';
import Image from 'next/image';
import { AnimateOnScroll } from '../animate-on-scroll';
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle } from '../ui/dialog';
import { cn } from '@/lib/utils';
import type { DriveImage } from '@/lib/google-drive';

const GallerySection = ({ images }: { images: DriveImage[] }) => {
  const [selectedImage, setSelectedImage] = useState<DriveImage | null>(null);

  const openModal = (image: DriveImage) => {
    setSelectedImage(image);
  };

  if (!images || images.length === 0) {
    return (
       <section id="gallery" className="bg-card">
        <div className="container mx-auto px-6 text-center">
            <AnimateOnScroll>
                <h2 className="font-headline text-3xl md:text-4xl font-bold">Image Gallery</h2>
                <p className="mt-4 max-w-2xl mx-auto text-lg text-muted-foreground">
                    The gallery is currently empty or could not be loaded. Please check back later.
                </p>
            </AnimateOnScroll>
        </div>
       </section>
    )
  }

  return (
    <section id="gallery" className="bg-card">
      <div className="container mx-auto px-6">
        <AnimateOnScroll className="text-center">
          <h2 className="font-headline text-3xl md:text-4xl font-bold">Image Gallery</h2>
          <p className="mt-4 max-w-2xl mx-auto text-lg text-muted-foreground">
            A glimpse into the vibrant life at CMFI Bilingual High School.
          </p>
        </AnimateOnScroll>

        <AnimateOnScroll delay={200} className="mt-12">
          <div className="grid grid-cols-2 md:grid-cols-4 auto-rows-[250px] gap-4">
            {images.map((image, index) => {
              const colSpan = (index % 7 === 0 || index % 7 === 5) ? 'md:col-span-2' : '';
              const rowSpan = (index % 7 === 0 || index % 7 === 5) ? 'md:row-span-2' : '';
              
              return (
                <div
                  key={image.id}
                  onClick={() => openModal(image)}
                  className={cn(
                    'group relative overflow-hidden rounded-lg cursor-pointer',
                    colSpan,
                    rowSpan
                  )}
                >
                  <Image
                    src={image.thumbnailLink.replace('=s220', '=s1024')} // Request a larger thumbnail
                    alt={image.name}
                    fill
                    sizes="(max-width: 768px) 50vw, (max-width: 1200px) 25vw, 20vw"
                    className="object-cover w-full h-full group-hover:scale-105 transition-transform duration-300"
                  />
                  <div className="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-colors duration-300" />
                </div>
              );
            })}
          </div>
        </AnimateOnScroll>
      </div>

      <Dialog open={!!selectedImage} onOpenChange={() => setSelectedImage(null)}>
        <DialogContent className="max-w-3xl p-2">
          {selectedImage && (
            <>
              <DialogHeader className="sr-only">
                <DialogTitle>Image Viewer</DialogTitle>
                <DialogDescription>{`Enlarged view of image: ${selectedImage.name}`}</DialogDescription>
              </DialogHeader>
              <div className="relative aspect-video">
                <Image
                  src={selectedImage.thumbnailLink.replace('=s220', '=w1920-h1080')}
                  alt={selectedImage.name}
                  fill
                  sizes="100vw"
                  className="object-contain rounded-md"
                />
              </div>
            </>
          )}
        </DialogContent>
      </Dialog>
    </section>
  );
};


// Renaming to GalleryGrid to avoid conflict with async server component
const GalleryGrid = GallerySection;
export default GalleryGrid;
