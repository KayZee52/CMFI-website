'use client';
import { Button } from "./ui/button";

const WhatsAppButton = () => {
    const whatsAppUrl = 'https://wa.me/1234567890'; // Replace with school's WhatsApp number

    return (
        <a 
            href={whatsAppUrl} 
            target="_blank" 
            rel="noopener noreferrer"
            className="fixed bottom-6 right-6 z-50"
        >
            <Button size="icon" className="bg-green-500 hover:bg-green-600 text-white rounded-full h-14 w-14 shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="lucide lucide-message-circle"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/></svg>
            </Button>
        </a>
    );
}

export default WhatsAppButton;
