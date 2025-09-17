
'use client';
import { Button } from "./ui/button";

const WhatsAppButton = () => {
    const whatsAppUrl = 'https://wa.me/231770732334';

    const WhatsAppIcon = () => (
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91S17.5 2 12.04 2zM12.04 20.12c-1.48 0-2.93-.39-4.2-1.12L7.3 18.72l-3.26.86.88-3.18c-.81-1.32-1.24-2.85-1.24-4.47 0-4.54 3.69-8.23 8.24-8.23 4.54 0 8.23 3.69 8.23 8.23s-3.69 8.23-8.23 8.23zm4.5-6.02c-.25-.12-1.47-.72-1.7-.81-.23-.09-.39-.12-.56.12-.17.25-.64.81-.79.98-.15.17-.29.19-.54.06-.25-.12-1.06-.39-2.02-1.25-.75-.66-1.25-1.48-1.4-1.73-.14-.25-.01-.39.11-.5.11-.11.25-.29.37-.43.13-.15.17-.25.25-.41.09-.17.04-.31-.02-.43s-.56-1.34-.76-1.84c-.2-.48-.41-.42-.56-.43h-.48c-.17 0-.44.06-.67.31-.23.25-.87.85-.87 2.07 0 1.22.89 2.4 1.01 2.56.12.17 1.76 2.67 4.27 3.77 2.51 1.1 2.51.74 2.96.7.45-.05 1.47-.6 1.68-1.18.21-.58.21-1.08.14-1.18-.05-.1-.17-.16-.25-.2z"/>
        </svg>
    )

    return (
        <a 
            href={whatsAppUrl} 
            target="_blank" 
            rel="noopener noreferrer"
            aria-label="Chat on WhatsApp"
            className="fixed bottom-6 right-6 z-50 group"
        >
            <Button size="icon" className="bg-green-500 hover:bg-green-600 text-white rounded-full h-14 w-14 shadow-lg transition-transform group-hover:scale-110">
                <WhatsAppIcon />
            </Button>
            <span className="sr-only">Chat on WhatsApp</span>
        </a>
    );
}

export default WhatsAppButton;
