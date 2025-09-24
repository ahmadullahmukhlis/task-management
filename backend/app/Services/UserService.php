<?php

namespace App\Services;

use App\Mail\OtpLoginMail;
use App\Models\UserVerification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class UserService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function verification($user, $request)
    {
        $otp = $this->generateUniqueOtp();

        $expiresAt = Carbon::now()->addHours(3);

        $verify = $user->verify()->create([
            'otp' => $otp,
            'expires_at' => $expiresAt,
            'status' => 'pending',
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            'device' => $this->getDevice($request->header('User-Agent')),
        ]);
        Mail::to($user->email)->queue(new OtpLoginMail($user, $otp));

        return $verify;
    }

    private function generateUniqueOtp()
    {
        do {
            $otp = random_int(100000, 9999999999);
            $exists = UserVerification::where('otp', $otp)
                ->where('expires_at', '>', Carbon::now())
                ->exists();
        } while ($exists);

        return $otp;
    }

    private function getDevice($userAgent)
    {
        if (stripos($userAgent, 'mobile') !== false) {
            return 'mobile';
        }

        return 'desktop';
    }
}
