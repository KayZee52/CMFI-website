'use client';

import { useState } from 'react';
import Image from 'next/image';
import { AnimateOnScroll } from '../animate-on-scroll';
import { galleryData } from '@/lib/data';
import { PlaceHolderImages } from '@/lib/placeholder-images';
import { Card, CardContent } from '../ui/card';
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle } from '../ui/dialog';
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs"

const GallerySection = () => {
  const [selectedImage, setSelectedImage] = useState<{ url: string, hint: string } | null>(null);

  const getImage = (id: string) => {
    return PlaceHolderImages.find((img) => img.id === `gallery-${id}`);
  };

  const eventTypes = [...new Set(galleryData.map(item => item.event))];

  return (
    <section id="gallery" className="bg-card">
      <div className="container mx-auto px-6">
        <AnimateOnScroll className="text-center">
          <h2 className="font-headline text-3xl md:text-4xl font-bold">Gallery</h2>
          <p className="mt-4 max-w-2xl mx-auto text-lg text-muted-foreground">
            Explore moments from our vibrant school life.
          </p>
        </AnimateOnScroll>

        <AnimateOnScroll delay={200} className="mt-12">
          <Tabs defaultValue={eventTypes[0]} className="w-full">
            <TabsList className="grid w-full grid-cols-2 md:grid-cols-4 mx-auto max-w-2xl">
              {eventTypes.map(event => (
                <TabsTrigger key={event} value={event}>{event}</TabsTrigger>
              ))}
            </TabsList>
            {eventTypes.map(event => (
              <TabsContent key={event} value={event}>
                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-8">
                  {galleryData.filter(item => item.event === event).map((item, index) => {
                    const img = getImage(item.id);
                    if (!img) return null;
                    return (
                      <AnimateOnScroll key={item.id} delay={index * 100}>
                        <Card 
                          className="overflow-hidden cursor-pointer group"
                          onClick={() => setSelectedImage({ url: img.imageUrl, hint: item.hint })}
                        >
                          <CardContent className="p-0">
                            <div className="aspect-w-3 aspect-h-2">
                              <Image
                                src={img.imageUrl}
                                alt={`${item.event} - ${item.id}`}
                                width={600}
                                height={400}
                                data-ai-hint={item.hint}
                                className="object-cover w-full h-full group-hover:scale-105 transition-transform duration-300"
                              />
                            </div>
                          </CardContent>
                        </Card>
                      </AnimateOnScroll>
                    );
                  })}
                </div>
              </TabsContent>
            ))}
          </Tabs>
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
