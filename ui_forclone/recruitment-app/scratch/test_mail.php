<?php

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    Mail::raw('This is a test email from CMFI Career Portal.', function ($message) {
        $message->to('kelvinzammie@gmail.com')
                ->subject('Test Email');
    });
    echo "Email sent successfully!\n";
} catch (\Exception $e) {
    echo "Failed to send email: " . $e->getMessage() . "\n";
}
