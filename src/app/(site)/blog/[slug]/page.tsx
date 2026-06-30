import { getPostData, getAllPostSlugs } from '@/lib/posts';
import { notFound } from 'next/navigation';
import { AnimateOnScroll } from '@/components/animate-on-scroll';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Badge } from '@/components/ui/badge';
import Image from 'next/image';

export async function generateStaticParams() {
  return getAllPostSlugs();
}

export async function generateMetadata({ params }: { params: { slug: string } }) {
  try {
    const postData = await getPostData(params.slug);
    return {
      title: `${postData.title} | CMFI Blog`,
      description: postData.excerpt,
    };
  } catch (error) {
    return {
      title: 'Post Not Found',
      description: 'This blog post could not be found.',
    };
  }
}

export default async function PostPage({ params }: { params: { slug: string } }) {
  let postData;
  try {
    postData = await getPostData(params.slug);
  } catch (error) {
    notFound();
  }

  return (
    <>
      <section className="relative h-[450px] flex items-center justify-center text-center text-white">
        <Image
          src={`https://picsum.photos/seed/${postData.slug}/1920/1080`}
          alt={postData.title}
          fill
          priority
          sizes="100vw"
          className="object-cover"
          data-ai-hint="abstract texture"
        />
        <div className="absolute inset-0 bg-black/60" />
        <div className="relative z-10 container mx-auto px-6">
          <AnimateOnScroll>
            <Badge variant="secondary" className="mb-4">
              Blog Post
            </Badge>
            <h1 className="font-headline text-4xl md:text-6xl font-bold tracking-tight">
              {postData.title}
            </h1>
            <div className="mt-6 flex items-center justify-center gap-4">
              <Avatar>
                <AvatarImage src={`/images/adminstrators/principal.jpeg`} alt={postData.author} />
                <AvatarFallback>{postData.author.charAt(0)}</AvatarFallback>
              </Avatar>
              <div>
                <p className="font-semibold">{postData.author}</p>
                <p className="text-sm text-white/80">
                  {new Date(postData.date).toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                  })}
                </p>
              </div>
            </div>
          </AnimateOnScroll>
        </div>
      </section>

      <section className="bg-background">
        <div className="container mx-auto px-6">
          <article className="prose dark:prose-invert lg:prose-xl max-w-4xl mx-auto">
            <div dangerouslySetInnerHTML={{ __html: postData.contentHtml }} />
          </article>
        </div>
      </section>
    </>
  );
}
