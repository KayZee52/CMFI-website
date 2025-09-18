
'use client';

import { useState } from 'react';
import Image from 'next/image';
import { AnimateOnScroll } from '../animate-on-scroll';
import { Dialog, DialogContent } from '../ui/dialog';
import { cn } from '@/lib/utils';
import type { DriveMedia } from '@/lib/google-drive';
import { PlayCircle } from 'lucide-react';

const GallerySection = ({ media }: { media: DriveMedia[] }) => {
  const [selectedMedia, setSelectedMedia] = useState<DriveMedia | null>(null);

  const openModal = (item: DriveMedia) => {
    setSelectedMedia(item);
  };

  const isVideo = (item: DriveMedia) => item.mimeType.startsWith('video/');

  const getVideoSrc = (item: DriveMedia) => {
    return `https://drive.google.com/uc?export=view&id=${item.id}`;
  };

  const getHighQualityThumbnail = (thumbnailLink: string) => {
    // Request a larger, higher-quality thumbnail by replacing the size parameter.
    return thumbnailLink.replace(/=s\d+/, '=s1024');
  };

  if (!media || media.length === 0) {
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
          <h2 className="font-headline text-3xl md:text-4xl font-bold">Gallery</h2>
          <p className="mt-4 max-w-2xl mx-auto text-lg text-muted-foreground">
            A glimpse into the vibrant life at CMFI Bilingual High School.
          </p>
        </AnimateOnScroll>

        <AnimateOnScroll delay={200} className="mt-12">
          <div className="grid grid-cols-2 md:grid-cols-4 auto-rows-[250px] gap-4">
            {media.map((item, index) => {
              const colSpan = (index % 7 === 0 || index % 7 === 5) ? 'md:col-span-2' : '';
              const rowSpan = (index % 7 === 0 || index % 7 === 5) ? 'md:row-span-2' : '';
              
              return (
                <div
                  key={item.id}
                  onClick={() => openModal(item)}
                  className={cn(
                    'group relative overflow-hidden rounded-lg cursor-pointer',
                    colSpan,
                    rowSpan
                  )}
                >
                  <Image
                    src={getHighQualityThumbnail(item.thumbnailLink)}
                    alt={item.name}
                    fill
                    sizes="(max-width: 768px) 50vw, (max-width: 1200px) 25vw, 20vw"
                    className="object-cover w-full h-full group-hover:scale-105 transition-transform duration-300"
                  />
                  <div className="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-colors duration-300" />
                  {isVideo(item) && (
                    <div className="absolute inset-0 flex items-center justify-center">
                      <PlayCircle className="h-16 w-16 text-white/80 group-hover:text-white transition-colors" />
                    </div>
                  )}
                </div>
              );
            })}
          </div>
        </AnimateOnScroll>
      </div>

      <Dialog open={!!selectedMedia} onOpenChange={() => setSelectedMedia(null)}>
        <DialogContent className="max-w-4xl w-full p-2 h-auto max-h-[90vh]">
          {selectedMedia && (
            isVideo(selectedMedia) ? (
                <div className="relative aspect-video w-full h-full">
                    <video
                        src={getVideoSrc(selectedMedia)}
                        controls
                        autoPlay
                        className="w-full h-full rounded-md bg-black"
                    >
                        Your browser does not support the video tag.
                    </video>
                </div>
            ) : (
              <div className="relative aspect-video">
                <Image
                  src={getHighQualityThumbnail(selectedMedia.thumbnailLink)}
                  alt={selectedMedia.name}
                  fill
                  sizes="100vw"
                  className="object-contain rounded-md"
                />
              </div>
            )
          )}
        </DialogContent>
      </Dialog>
    </section>
  );
};

// Renaming to GalleryGrid to avoid conflict with async server component
const GalleryGrid = GallerySection;
export default GalleryGrid;
