
'use client';

import { useState, useCallback } from 'react';
import Image from 'next/image';
import { AnimateOnScroll } from '../animate-on-scroll';
import { Dialog, DialogContent, DialogDescription, DialogTitle } from '../ui/dialog';
import { cn } from '@/lib/utils';
import type { DriveMedia } from '@/lib/google-drive';
import { PlayCircle, ChevronLeft, ChevronRight, Download } from 'lucide-react';
import { Button } from '../ui/button';

const GallerySection = ({ media }: { media: DriveMedia[] }) => {
  const [selectedMediaIndex, setSelectedMediaIndex] = useState<number | null>(null);
  const [touchStart, setTouchStart] = useState<number | null>(null);
  const minSwipeDistance = 50;

  const openModal = (index: number) => {
    setSelectedMediaIndex(index);
  };

  const closeModal = () => {
    setSelectedMediaIndex(null);
  };
  
  const goToNext = useCallback(() => {
    if (selectedMediaIndex === null) return;
    setSelectedMediaIndex((prevIndex) => (prevIndex! + 1) % media.length);
  }, [selectedMediaIndex, media.length]);
  
  const goToPrevious = useCallback(() => {
    if (selectedMediaIndex === null) return;
    setSelectedMediaIndex((prevIndex) => (prevIndex! - 1 + media.length) % media.length);
  }, [selectedMediaIndex, media.length]);

  const onTouchStart = (e: React.TouchEvent) => {
    setTouchStart(e.targetTouches[0].clientX);
  };

  const onTouchMove = (e: React.TouchEvent) => {
    if (touchStart === null) return;
    const currentTouch = e.targetTouches[0].clientX;
    const distance = touchStart - currentTouch;

    if (distance > minSwipeDistance) {
      goToNext();
      setTouchStart(null);
    } else if (distance < -minSwipeDistance) {
      goToPrevious();
      setTouchStart(null);
    }
  };


  const selectedMedia = selectedMediaIndex !== null ? media[selectedMediaIndex] : null;

  const isVideo = (item: DriveMedia) => item.mimeType.startsWith('video/');

  const getStreamSrc = (item: DriveMedia) => {
    return `https://drive.google.com/uc?export=view&id=${item.id}`;
  };

  const getDownloadSrc = (item: DriveMedia) => {
    return `https://drive.google.com/uc?export=download&id=${item.id}`;
  };

  const getHighQualityThumbnail = (thumbnailLink: string) => {
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
                  onClick={() => openModal(index)}
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

      <Dialog open={!!selectedMedia} onOpenChange={closeModal}>
        <DialogContent 
          className="max-w-6xl w-full p-2 h-auto max-h-[90vh] bg-transparent border-0 shadow-none flex items-center justify-center"
          onTouchStart={onTouchStart}
          onTouchMove={onTouchMove}
        >
          {selectedMedia && (
            <>
              <DialogTitle className="sr-only">Gallery Viewer</DialogTitle>
              <DialogDescription className="sr-only">
                Viewing {isVideo(selectedMedia) ? 'video' : 'image'} titled {selectedMedia.name}. Use arrow buttons to navigate.
              </DialogDescription>
              <div className="relative w-full h-full max-w-full max-h-full">
                {isVideo(selectedMedia) ? (
                  <div className="relative aspect-video w-full h-full max-h-[90vh] flex items-center justify-center">
                      <video
                          src={getStreamSrc(selectedMedia)}
                          controls
                          autoPlay
                          className="w-auto h-auto max-w-full max-h-full rounded-md bg-black"
                      >
                          Your browser does not support the video tag.
                      </video>
                  </div>
                ) : (
                  <div className="relative aspect-video w-full h-full max-h-[90vh]">
                    <Image
                      src={getHighQualityThumbnail(selectedMedia.thumbnailLink)}
                      alt={selectedMedia.name}
                      fill
                      sizes="100vw"
                      className="object-contain rounded-md"
                    />
                  </div>
                )}
                 <div className="absolute bottom-4 right-4 z-20">
                  <Button asChild size="icon" className="bg-black/50 hover:bg-black/80 text-white rounded-full">
                    <a href={getDownloadSrc(selectedMedia)} download={selectedMedia.name} target="_blank" rel="noopener noreferrer">
                      <Download className="h-5 w-5" />
                      <span className="sr-only">Download</span>
                    </a>
                  </Button>
                </div>
              </div>
            </>
          )}

          <Button onClick={goToPrevious} size="icon" className="absolute left-4 top-1/2 -translate-y-1/2 z-20 bg-black/50 hover:bg-black/80 text-white rounded-full">
            <ChevronLeft className="h-6 w-6" />
            <span className="sr-only">Previous</span>
          </Button>
          <Button onClick={goToNext} size="icon" className="absolute right-4 top-1/2 -translate-y-1/2 z-20 bg-black/50 hover:bg-black/80 text-white rounded-full">
            <ChevronRight className="h-6 w-6" />
            <span className="sr-only">Next</span>
          </Button>

        </DialogContent>
      </Dialog>
    </section>
  );
};

// Renaming to GalleryGrid to avoid conflict with async server component
const GalleryGrid = GallerySection;
export default GalleryGrid;
