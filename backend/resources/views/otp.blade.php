<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>OTP</title>
    <style>
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #365a5d;
            color: white !important;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            margin: 15px 0;
        }

        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: #f4f7ff;
            font-size: 14px;
        }

        .container {
            max-width: 680px;
            margin: 0 auto;
            padding: 45px 30px 60px;
            background: #f4f7ff;
            background-image: url({{ $message->embed(public_path('email/email-bg.png')) }});
            background-image: url(https://archisketch-resources.s3.ap-northeast-2.amazonaws.com/vrstyler/1661497957196_595865/email-template-background-banner);
            background-repeat: no-repeat;
            background-size: 800px 452px;
            background-position: top center;
            font-size: 14px;
            color: #434343;
        }

        .content-box {
            margin: 70px 0 0;
            padding: 60px 30px;
            background: #ffffff;
            border-radius: 30px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .inner-content {
            width: 100%;
            max-width: 489px;
            margin: 0 auto;
            text-align: center;
        }

        .otp-code {
            margin: 40px 0 0;
            font-size: 20px;
            font-weight: 600;
            letter-spacing: 25px;
            color: #365a5d;
        }

        .help-text {
            max-width: 400px;
            margin: 90px auto 0;
            text-align: center;
            font-weight: 500;
            color: #8c8c8c;
        }

        footer {
            width: 100%;
            max-width: 490px;
            margin: 20px auto 0;
            text-align: center;
            border-top: 1px solid #e6ebf1;
            padding-top: 20px;
        }
    </style>
    <style>
        /* Font faces remain the same as in your original code */
        @font-face {
            font-family: 'Poppins';
            font-style: normal;
            font-weight: 300;
            font-display: swap;
            src: url(https://fonts.gstatic.com/s/poppins/v23/pxiByp8kv8JHgFVrLDz8Z11lFc-K.woff2) format('woff2');
            unicode-range: U+0900-097F, U+1CD0-1CF9, U+200C-200D, U+20A8, U+20B9, U+20F0, U+25CC, U+A830-A839, U+A8E0-A8FF, U+11B00-11B09;
        }

        /* Include all other @font-face rules from your original code */
    </style>
</head>

<body>
    <div class="container">
        <header>
            <table style="width: 100%;">
                <tbody>
                    <tr style="height: 0;">
                        <td>
                            <img alt="" src="{{ $message->embed(public_path('email/facebook.png')) }}"
                                height="30px" />
                        </td>
                        <td style="text-align: right;">
                            <span style="font-size: 16px; line-height: 30px; color: #ffffff;">
                                {{ now()->format('Y-m-d') }}
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </header>

        <main>
            <div class="content-box">
                <div class="inner-content">
                    <h1 style="margin: 0; font-size: 24px; font-weight: 500; color: #1f1f1f;">
                        OTP Verification
                    </h1>
                    <p style="margin: 17px 0 0; font-size: 16px; font-weight: 500;">
                        Hello {{ $user->first_name }} {{ $user->last_name }}
                    </p>
                    <p style="margin: 17px 0 0; font-weight: 500; letter-spacing: 0.56px; line-height: 1.6;">
                        Thank you for choosing {{ config('app.name') }} Team. Use the following OTP
                        to complete the procedure to activate your account. OTP is
                        valid for
                        <span style="font-weight: 600; color: #1f1f1f;">3 hours</span>.
                        Do not share this code with others.
                    </p>
                    <p class="otp-code">
                        {{ $otp }}
                    </p>
                    <a href="{{ env('WEBSITE_URL') }}/verification?token={{ urlencode(Illuminate\Support\Facades\Crypt::encryptString($user->email)) }}"
                        class="button">
                        Verify Your Account
                    </a>
                </div>
            </div>

            <p class="help-text">
                Need help? Ask at
                <a href="mailto:ahmadullahmukhlis2019@gmail.com" style="color: #499fb6; text-decoration: none;">
                    ahmadullahmukhlis2019@gmail.com
                </a>
                or visit our
                <a href="{{ env('WEBSITE_URL') }}" target="_blank" style="color: #499fb6; text-decoration: none;">
                    {{ config('app.name') }}
                </a>
            </p>
        </main>

        <footer
            style="width: 100%; max-width: 490px; margin: 20px auto 0; text-align: center; border-top: 1px solid #e6ebf1; padding-top: 20px;">
            <p style="margin: 40px 0 0; font-size: 16px; font-weight: 600; color: #434343;">
                {{ config('app.name') }}
            </p>
            <p style="margin: 8px 0 0; color: #434343;">
                Address 540, City, State.
            </p>
            <div style="margin: 16px 0 0;">
                <a href="" target="_blank" style="display: inline-block;">
                    <img width="36px" alt="Facebook"
                        src="{{ $message->embed(public_path('email/facebook.png')) }}" />
                </a>
                <a href="" target="_blank" style="display: inline-block; margin-left: 8px;">
                    <img width="36px" alt="Instagram"
                        src="{{ $message->embed(public_path('email/instegram.png')) }}" />
                </a>
                <a href="" target="_blank" style="display: inline-block; margin-left: 8px;">
                    <img width="36px" alt="Twitter" src="{{ $message->embed(public_path('email/twiter.png')) }}" />
                </a>
                <a href="" target="_blank" style="display: inline-block; margin-left: 8px;">
                    <img width="36px" alt="Youtube" src="{{ $message->embed(public_path('email/youtub.png')) }}" />
                </a>
            </div>
            <p style="margin: 16px 0 0; color: #434343;">
                Copyright © 2022 Company. All rights reserved.
            </p>
        </footer>
    </div>
</body>

</html>
