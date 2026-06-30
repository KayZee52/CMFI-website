
import Link from 'next/link';
import { getSortedPostsData } from '@/lib/posts';
import { Card, CardHeader, CardTitle, CardDescription, CardContent } from '@/components/ui/card';
import { AnimateOnScroll } from '@/components/animate-on-scroll';
import { ArrowRight } from 'lucide-react';
import Image from 'next/image';

export const metadata = {
  title: 'Blog | CMFI Bilingual High School',
  description: 'News, articles, and updates from CMFI Bilingual High School.',
};

export default function BlogPage() {
  const allPosts = getSortedPostsData();

  return (
    <>
      <section className="relative h-[400px] flex items-center justify-center text-center text-white">
        <Image
          src="/images/heroimages/blog-hero.jpeg"
          alt="A person writing in a notebook, symbolizing the school blog"
          fill
          priority
          sizes="100vw"
          className="object-cover"
          data-ai-hint="writing notebook"
        />
        <div className="absolute inset-0 bg-black/60" />
        <div className="relative z-10 container mx-auto px-6">
          <AnimateOnScroll>
            <h1 className="font-headline text-4xl md:text-6xl font-bold tracking-tight">
              Our Blog
            </h1>
            <p className="mt-4 text-lg md:text-xl text-white/90 max-w-2xl mx-auto">
              Stay up to date with the latest news, events, and stories from the CMFI community.
            </p>
          </AnimateOnScroll>
        </div>
      </section>

      <section className="bg-background">
        <div className="container mx-auto px-6">
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            {allPosts.map((post, index) => (
              <AnimateOnScroll key={post.slug} delay={index * 100}>
                <Link href={`/blog/${post.slug}`} className="block h-full">
                  <Card className="h-full flex flex-col group hover:border-primary/50 hover:shadow-lg transition-all">
                    <CardHeader>
                      <CardTitle className="font-headline text-2xl group-hover:text-primary transition-colors">{post.title}</CardTitle>
                      <CardDescription>
                        {new Date(post.date).toLocaleDateString('en-US', {
                          year: 'numeric',
                          month: 'long',
                          day: 'numeric',
                        })}
                      </CardDescription>
                    </CardHeader>
                    <CardContent className="flex-grow">
                      <p className="text-muted-foreground">{post.excerpt}</p>
                    </CardContent>
                    <div className="p-6 pt-0 flex items-center text-primary font-semibold">
                      Read More
                      <ArrowRight className="ml-2 h-4 w-4 transform group-hover:translate-x-1 transition-transform" />
                    </div>
                  </Card>
                </Link>
              </AnimateOnScroll>
            ))}
          </div>
        </div>
      </section>
    </>
  );
}
