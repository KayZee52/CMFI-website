'use client';

import { useState } from 'react';
import { timelineData } from '@/lib/data';
import { AnimateOnScroll } from '../animate-on-scroll';
import { Card, CardContent, CardHeader, CardTitle } from '../ui/card';
import { Button } from '../ui/button';
import { generateSummary } from '@/lib/actions';
import { Wand2, Loader2, AlertTriangle } from 'lucide-react';
import { Alert, AlertDescription, AlertTitle } from "@/components/ui/alert"

type SummaryState = {
  [key: string]: {
    summary?: string | null;
    isLoading: boolean;
    error?: string | null;
  };
};

const TimelineSection = () => {
  const [summaries, setSummaries] = useState<SummaryState>({});

  const handleSummarize = async (year: string, text: string) => {
    setSummaries(prev => ({ ...prev, [year]: { isLoading: true } }));
    const result = await generateSummary(text);
    setSummaries(prev => ({
      ...prev,
      [year]: {
        summary: result.summary,
        isLoading: false,
        error: result.error,
      },
    }));
  };

  return (
    <section id="timeline" className="bg-background">
      <div className="container mx-auto px-6">
        <AnimateOnScroll className="text-center">
          <h2 className="font-headline text-3xl md:text-4xl font-bold">Our Journey Through Time</h2>
          <p className="mt-4 max-w-2xl mx-auto text-lg text-muted-foreground">
            From our humble beginnings to becoming a beacon of education, discover the key milestones that have shaped CMFI.
          </p>
        </AnimateOnScroll>
        
        <div className="relative mt-16">
          <div className="absolute left-1/2 top-0 bottom-0 w-0.5 bg-border -translate-x-1/2 hidden md:block" />
          
          {timelineData.map((item, index) => {
            const isLeft = index % 2 === 0;
            const summaryState = summaries[item.year];

            return (
              <div key={item.year} className={`relative flex items-center md:justify-center mb-12`}>
                <div className={`w-full md:w-5/12 ${isLeft ? 'md:pr-8 md:text-right' : 'md:pl-8 md:order-2'}`}>
                  <AnimateOnScroll>
                    <Card className="hover:shadow-xl transition-shadow duration-300">
                      <CardHeader>
                        <p className="text-primary font-bold">{item.year}</p>
                        <CardTitle className="font-headline text-xl">{item.title}</CardTitle>
                      </CardHeader>
                      <CardContent>
                        <p className="text-muted-foreground">{item.description}</p>
                        {item.longDescription && (
                          <div className="mt-4">
                            {summaryState?.summary ? (
                              <div className="p-4 bg-primary/5 rounded-md text-left">
                                <h4 className="font-bold text-sm mb-2 flex items-center">
                                  <Wand2 className="h-4 w-4 mr-2" /> AI Summary
                                </h4>
                                <p className="text-sm text-muted-foreground">{summaryState.summary}</p>
                              </div>
                            ) : (
                              <Button 
                                variant="outline" 
                                size="sm" 
                                className="mt-2"
                                disabled={summaryState?.isLoading}
                                onClick={() => handleSummarize(item.year, item.longDescription!)}
                              >
                                {summaryState?.isLoading ? (
                                  <Loader2 className="mr-2 h-4 w-4 animate-spin" />
                                ) : (
                                  <Wand2 className="mr-2 h-4 w-4" />
                                )}
                                Summarize with AI
                              </Button>
                            )}
                            {summaryState?.error && (
                              <Alert variant="destructive" className="mt-2 text-left">
                                <AlertTriangle className="h-4 w-4" />
                                <AlertTitle>Error</AlertTitle>
                                <AlertDescription>{summaryState.error}</AlertDescription>
                              </Alert>
                            )}
                          </div>
                        )}
                      </CardContent>
                    </Card>
                  </AnimateOnScroll>
                </div>
                <div className="absolute left-1/2 -translate-x-1/2 h-4 w-4 rounded-full bg-primary border-4 border-card hidden md:block"></div>
              </div>
            );
          })}
        </div>
      </div>
    </section>
  );
};

export default TimelineSection;
