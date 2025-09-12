import { AnimateOnScroll } from '../animate-on-scroll';
import { newsData } from '@/lib/data';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '../ui/card';
import { Button } from '../ui/button';
import Link from 'next/link';
import { ArrowRight } from 'lucide-react';

const NewsPreviewSection = () => {
  const latestNews = newsData.slice(0, 3);

  return (
    <section id="news-preview" className="bg-card">
      <div className="container mx-auto px-6">
        <AnimateOnScroll className="text-center">
          <h2 className="font-headline text-3xl md:text-4xl font-bold">Latest News</h2>
          <p className="mt-4 max-w-2xl mx-auto text-lg text-muted-foreground">
            Stay informed with the latest happenings at CMFI.
          </p>
        </AnimateOnScroll>

        <div className="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8">
          {latestNews.map((item, index) => (
            <AnimateOnScroll key={index} delay={index * 100}>
              <Card className="flex flex-col h-full hover:shadow-lg transition-shadow duration-300 group">
                <CardHeader>
                  <CardTitle className="font-headline text-xl">{item.title}</CardTitle>
                  <CardDescription>{new Date(item.date).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}</CardDescription>
                </CardHeader>
                <CardContent className="flex-grow">
                  <p className="text-muted-foreground">{item.summary}</p>
                </CardContent>
                <CardFooter>
                  <Button asChild variant="link" className="px-0 group-hover:text-primary transition-colors">
                    <Link href="/contact#news">
                      Read More <ArrowRight className="ml-2 h-4 w-4" />
                    </Link>
                  </Button>
                </CardFooter>
              </Card>
            </AnimateOnScroll>
          ))}
        </div>

        <AnimateOnScroll className="text-center mt-12">
            <Button asChild size="lg" variant="outline">
                <Link href="/contact#news">See All Updates</Link>
            </Button>
        </AnimateOnScroll>
      </div>
    </section>
  );
};

export default NewsPreviewSection;
