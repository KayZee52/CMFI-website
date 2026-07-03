<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\RecruitmentSetting;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    /**
     * Send a notification via the configured gateway.
     */
    public function send($to, $message)
    {
        $gatewayUrl = RecruitmentSetting::where('key', 'gateway_url')->value('value');
        $apiKey = RecruitmentSetting::where('key', 'gateway_api_key')->value('value');
        $method = RecruitmentSetting::where('key', 'gateway_method')->value('value') ?? 'POST';

        if (!$gatewayUrl) {
            Log::warning("Notification gateway URL not configured.");
            return false;
        }

        try {
            $response = Http::withHeaders([
                'X-API-Key' => $apiKey,
                'Accept' => 'application/json',
            ]);

            if ($method === 'GET') {
                $response = $response->get($gatewayUrl, [
                    'to' => $to,
                    'message' => $message,
                ]);
            } else {
                $response = $response->post($gatewayUrl, [
                    'to' => $to,
                    'message' => $message,
                ]);
            }

            return $response->successful();
        } catch (\Exception $e) {
            Log::error("Notification failed: " . $e->getMessage());
            return false;
        }
    }
}
