<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OTPService
{
    protected $apiKey;
    protected $senderId;
    protected $templateId;

public function __construct()
{
    $this->apiKey = env('MSG91_API_KEY');
    $this->senderId = env('MSG91_SENDER_ID');
    $this->templateId = env('MSG91_TEMPLATE_ID');
}

    public function sendOTP($phone, $otp)
    {
        try {
            // Clean phone number
            $phone = $this->formatPhoneNumber($phone);
            
            Log::info('📱 OTP Sending Started', [
                'phone' => $phone,
                'otp' => $otp
            ]);

            // Send SMS via MSG91
            $result = $this->sendSMS($phone, $otp);
            
            if ($result['success']) {
                Log::info('✅ OTP SMS sent successfully');
                return $result;
            }

            Log::warning('⚠️ SMS sending failed: ' . ($result['message'] ?? 'Unknown error'));
            
            return ['success' => false, 'message' => $result['message'] ?? 'SMS failed'];

        } catch (\Exception $e) {
            Log::error('❌ OTP Error: ' . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Send SMS via MSG91
     */
private function sendSMS($phone, $otp)
{
    try {

        $message = "Dear customer, use this One Time Password {$otp} to log in to your ASCOXTECHNOSOFT profile registration. This OTP will be valid for the next 5 mins. - ASCOXTECHNOSOFT";

        $response = Http::get(env('SMS_API_URL'), [
            'ApiKey'             => env('SMS_API_KEY'),
            'ClientId'           => env('SMS_CLIENT_ID'),
            'SenderId'           => env('SMS_SENDER_ID'),
            'MobileNumbers'      => $phone,
            'Message'            => $message,
            'TemplateId'         => env('SMS_TEMPLATE_ID'),
            'PrincipalEntityId'  => env('SMS_PRINCIPAL_ENTITY_ID')
        ]);

        \Log::info('SMS Response', [
            'response' => $response->body()
        ]);

        return [
            'success' => $response->successful(),
            'message' => $response->body()
        ];

    } catch (\Exception $e) {

        \Log::error('SMS Error : '.$e->getMessage());

        return [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }
}

    /**
     * Format phone number
     */
    private function formatPhoneNumber($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        $phone = ltrim($phone, '0');
        return $phone;
    }
}

