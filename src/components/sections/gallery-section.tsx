'use client';

import { useState } from 'react';
import Image from 'next/image';
import { AnimateOnScroll } from '../animate-on-scroll';
import { galleryData } from '@/lib/data';
import { PlaceHolderImages } from '@/lib/placeholder-images';
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle } from '../ui/dialog';
import { cn } from '@/lib/utils';

const GallerySection = () => {
  const [selectedImage, setSelectedImage] = useState<{ url: string; hint: string } | null>(null);

  const getImage = (id: string) => {
    return PlaceHolderImages.find((img) => img.id === `gallery-${id}`);
  };

  const galleryImages = galleryData.map(item => ({
      ...item,
      imageUrl: getImage(item.id)?.imageUrl
  })).filter(item => item.imageUrl);


  const openModal = (image: {imageUrl?: string, hint: string}) => {
    if (image.imageUrl) {
        setSelectedImage({ url: image.imageUrl, hint: image.hint });
    }
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
                {galleryImages.map((image, index) => {
                    const colSpan = (index === 0 || index === 5) ? 'md:col-span-2' : '';
                    const rowSpan = (index === 0 || index === 5) ? 'md:row-span-2' : '';
                    if (!image.imageUrl) return null;
                    return (
                        <div 
                            key={image.id}
                            onClick={() => openModal(image)}
                            className={cn('group relative overflow-hidden rounded-lg cursor-pointer', colSpan, rowSpan)}
                        >
                            <Image
                                src={image.imageUrl}
                                alt={image.hint}
                                data-ai-hint={image.hint}
                                fill
                                sizes="(max-width: 768px) 50vw, (max-width: 1200px) 25vw, 20vw"
                                className="object-cover w-full h-full group-hover:scale-105 transition-transform duration-300"
                            />
                            <div className="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-colors duration-300" />
                        </div>
                    )
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
                <DialogDescription>{`Enlarged view of image: ${selectedImage.hint}`}</DialogDescription>
              </DialogHeader>
              <div className="relative aspect-video">
                <Image
                  src={selectedImage.url}
                  alt={selectedImage.hint}
                  fill
                  sizes="100vw"
                  data-ai-hint={selectedImage.hint}
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

export default GallerySection;
