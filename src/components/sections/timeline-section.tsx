import { timelineData } from '@/lib/data';
import { AnimateOnScroll } from '../animate-on-scroll';
import { Card, CardContent, CardHeader, CardTitle } from '../ui/card';

const TimelineSection = () => {
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
