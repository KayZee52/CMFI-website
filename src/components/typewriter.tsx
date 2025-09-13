'use client';

import { useState, useEffect, useRef } from 'react';
import { cn } from '@/lib/utils';

type TypewriterProps = {
  phrases: string[];
  className?: string;
  typingSpeed?: number;
  deletingSpeed?: number;
  delayBetweenPhrases?: number;
};

export function Typewriter({
  phrases,
  className,
  typingSpeed = 100,
  deletingSpeed = 50,
  delayBetweenPhrases = 2000,
}: TypewriterProps) {
  const [text, setText] = useState('');
  const [phraseIndex, setPhraseIndex] = useState(0);
  const [isDeleting, setIsDeleting] = useState(false);
  const timeoutRef = useRef<NodeJS.Timeout | null>(null);
  const typingTimeoutRef = useRef<NodeJS.Timeout | null>(null);

  useEffect(() => {
    const handleTyping = () => {
      const currentPhrase = phrases[phraseIndex];
      
      if (isDeleting) {
        if (text.length > 0) {
          setText(prev => prev.substring(0, prev.length - 1));
          typingTimeoutRef.current = setTimeout(handleTyping, deletingSpeed);
        } else {
          setIsDeleting(false);
          setPhraseIndex(prev => (prev + 1) % phrases.length);
        }
      } else {
        if (text.length < currentPhrase.length) {
          setText(prev => currentPhrase.substring(0, prev.length + 1));
          typingTimeoutRef.current = setTimeout(handleTyping, typingSpeed);
        } else {
          timeoutRef.current = setTimeout(() => setIsDeleting(true), delayBetweenPhrases);
        }
      }
    };

    typingTimeoutRef.current = setTimeout(handleTyping, isDeleting ? deletingSpeed : typingSpeed);

    return () => {
      if (timeoutRef.current) clearTimeout(timeoutRef.current);
      if (typingTimeoutRef.current) clearTimeout(typingTimeoutRef.current);
    };
  }, [text, isDeleting, phraseIndex, phrases, typingSpeed, deletingSpeed, delayBetweenPhrases]);

  return (
    <span className={cn('relative', className)}>
      {text}
      <span className="animate-pulse">|</span>
    </span>
  );
}
