import { AnimateOnScroll } from '../animate-on-scroll';
import { newsData } from '@/lib/data';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '../ui/card';
import { Button } from '../ui/button';
import Link from 'next/link';
import { ArrowRight } from 'lucide-react';

const NewsSection = () => {
  return (
    <section id="news" className="bg-card">
      <div className="container mx-auto px-6">
        <AnimateOnScroll className="text-center">
          <h2 className="font-headline text-3xl md:text-4xl font-bold">News & Updates</h2>
          <p className="mt-4 max-w-2xl mx-auto text-lg text-muted-foreground">
            Stay informed with the latest happenings, announcements, and events.
          </p>
        </AnimateOnScroll>

        <div className="mt-16 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          {newsData.map((item, index) => (
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
      </div>
    </section>
  );
};

export default NewsSection;
