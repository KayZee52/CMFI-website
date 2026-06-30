
'use client';

import { Suspense } from 'react';
import { useSearchParams } from 'next/navigation';
import Link from 'next/link';
import { AnimateOnScroll } from '@/components/animate-on-scroll';
import { searchData } from '@/lib/data';
import { Card, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { ArrowRight, Search as SearchIcon } from 'lucide-react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { useRouter } from 'next/navigation';

type SearchResult = {
    title: string;
    href: string;
    summary: string;
};

const SearchResults = () => {
    const searchParams = useSearchParams();
    const query = searchParams.get('q');
    const router = useRouter();

    const handleSearch = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();
        const formData = new FormData(event.currentTarget);
        const newQuery = formData.get('q') as string;
        if (newQuery) {
            router.push(`/search?q=${encodeURIComponent(newQuery)}`);
        }
    };

    let results: SearchResult[] = [];
    if (query) {
        const lowerCaseQuery = query.toLowerCase();
        results = searchData.filter(item => 
            item.title.toLowerCase().includes(lowerCaseQuery) ||
            item.summary.toLowerCase().includes(lowerCaseQuery) ||
            item.keywords.some(keyword => keyword.toLowerCase().includes(lowerCaseQuery))
        );
    }

    return (
        <div className="container mx-auto px-6 py-12 md:py-20">
            <AnimateOnScroll>
                <div className="max-w-2xl mx-auto">
                     <form onSubmit={handleSearch} className="relative mb-8">
                        <SearchIcon className="absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-muted-foreground" />
                        <Input
                            type="search"
                            name="q"
                            defaultValue={query || ''}
                            placeholder="What are you looking for?"
                            className="w-full pl-10 h-12 text-lg"
                        />
                         <Button type="submit" className="absolute right-1 top-1/2 -translate-y-1/2 h-10">Search</Button>
                    </form>

                    <h1 className="font-headline text-3xl md:text-4xl font-bold mb-2">
                        Search Results
                    </h1>
                     <p className="text-muted-foreground mb-8">
                        {query ? `Found ${results.length} results for "${query}"` : 'Please enter a search term to begin.'}
                    </p>
                </div>
            </AnimateOnScroll>
            
            <AnimateOnScroll delay={200}>
                <div className="max-w-2xl mx-auto space-y-6">
                    {results.length > 0 ? (
                        results.map((result, index) => (
                            <Link href={result.href} key={index} className="block">
                                <Card className="hover:shadow-lg hover:border-primary/50 transition-all group">
                                    <CardHeader>
                                        <CardTitle className="font-headline text-xl flex items-center justify-between">
                                            <span>{result.title}</span>
                                            <ArrowRight className="h-5 w-5 text-muted-foreground group-hover:text-primary group-hover:translate-x-1 transition-transform" />
                                        </CardTitle>
                                        <CardDescription className="pt-2">{result.summary}</CardDescription>
                                    </CardHeader>
                                </Card>
                            </Link>
                        ))
                    ) : query ? (
                         <div className="text-center py-12">
                            <p className="text-lg text-muted-foreground">No results found. Try a different search term.</p>
                        </div>
                    ) : null}
                </div>
            </AnimateOnScroll>
        </div>
    );
};


const SearchPage = () => {
    return (
        <Suspense fallback={<div>Loading...</div>}>
            <SearchResults />
        </Suspense>
    );
}

export default SearchPage;