'use client';
import { type FC, type ReactNode, useId } from 'react';
import { AnimateOnScroll } from './animate-on-scroll';

function polarToCartesian(centerX: number, centerY: number, radius: number, angleInDegrees: number) {
  const angleInRadians = ((angleInDegrees - 90) * Math.PI) / 180.0;
  return {
    x: centerX + radius * Math.cos(angleInRadians),
    y: centerY + radius * Math.sin(angleInRadians),
  };
}

function describeArc(x: number, y: number, radius: number, startAngle: number, endAngle: number) {
  const start = polarToCartesian(x, y, radius, endAngle);
  const end = polarToCartesian(x, y, radius, startAngle);
  const largeArcFlag = endAngle - startAngle <= 180 ? '0' : '1';
  const d = ['M', start.x, start.y, 'A', radius, radius, 0, largeArcFlag, 0, end.x, end.y].join(' ');
  return d;
}

type ArcProps = {
  rotate: number;
  angle: number;
  skew: number;
  text: string;
  value: string;
  Icon: ReactNode;
  color: string;
  animationDelay: number;
};

export const Arc: FC<ArcProps> = ({ rotate, angle, skew, text, value, Icon, color, animationDelay }) => {
  const id = useId();
  const radius = 95;
  const innerRadius = 55;
  
  const textAngle = -rotate - angle / 2;

  return (
    <div
      className="absolute inset-0 origin-center transition-transform duration-500"
      style={{ transform: `rotate(${rotate}deg)` }}
    >
      <AnimateOnScroll
        delay={animationDelay}
        className="transition-all duration-700 origin-center"
        style={{ transform: 'scale(0.9)', animationFillMode: 'forwards' }}
      >
        <div className="absolute inset-0">
          <svg viewBox="0 0 200 200" className="w-full h-full">
            <defs>
                <path id={id} d={describeArc(100, 100, radius, 0, angle)} />
            </defs>
            <path
              d={describeArc(100, 100, radius, 0, angle) + ` L ${polarToCartesian(100, 100, innerRadius, angle).x} ${polarToCartesian(100, 100, innerRadius, angle).y} ` + describeArc(100, 100, innerRadius, angle, 0) + ' Z'}
              fill={color}
              stroke="hsl(var(--background))"
              strokeWidth="2"
            />
          </svg>
        </div>
        <div
          className="absolute inset-0 flex flex-col items-center justify-start text-primary text-center pt-3 animate-counter-revolve"
          style={{ transform: `rotate(${textAngle}deg) ` }}
        >
            <div className="h-6 w-6">{Icon}</div>
            <p className="font-headline text-3xl font-bold mt-1">{value}</p>
            <p className="text-xs max-w-[80px] leading-tight mt-1">{text}</p>
        </div>
      </AnimateOnScroll>
    </div>
  );
};
