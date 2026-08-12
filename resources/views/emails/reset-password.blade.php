<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
</head>
<body style="margin:0; padding:0; font-family: 'Plus Jakarta Sans', -apple-system, sans-serif; background: #FAF9F6;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background: #FAF9F6; padding: 40px 20px;">
        <tr>
            <td align="center">
                <table width="100%" max-width="600" cellpadding="0" cellspacing="0" style="max-width: 600px; background: white; border-radius: 18px; overflow: hidden; box-shadow: 0 8px 24px rgba(20,22,26,0.06);">
                    <!-- Header -->
                    <tr>
                        <td style="background: #14161A; padding: 30px 30px 20px; text-align: center; border-bottom: 3px solid #FF4405;">
                            <h1 style="font-family: 'Anton', 'Arial Narrow', sans-serif; font-size: 24px; color: white; margin: 0; letter-spacing: 1px;">
                                🏋️ FitForge
                            </h1>
                            <p style="color: rgba(255,255,255,0.6); font-size: 13px; margin: 6px 0 0; font-weight: 400;">
                                Password Reset Request
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Body -->
                    <tr>
                        <td style="padding: 35px 30px;">
                            <h2 style="font-size: 20px; color: #14161A; margin: 0 0 8px; font-weight: 700;">
                                Hello {{ $name }}!
                            </h2>
                            <p style="color: #2B2E34; font-size: 14px; line-height: 1.6; margin: 0 0 20px;">
                                We received a request to reset your password. Click the button below to set a new password.
                            </p>
                            
                            <!-- Reset Button - Opens in same tab -->
                            <div style="text-align: center; margin: 30px 0;">
                                <a href="{{ $resetLink }}" 
                                   target="_self"
                                   style="background: #FF4405; color: white; padding: 12px 35px; 
                                          text-decoration: none; border-radius: 8px; font-weight: 700; 
                                          font-size: 14px; display: inline-block; letter-spacing: 0.5px;">
                                    🔑 Reset Password
                                </a>
                            </div>
                            
                            <p style="color: #6B7280; font-size: 12px; line-height: 1.5; margin: 0 0 5px;">
                                ⏰ This link will expire in <strong>24 hours</strong>.
                            </p>
                            <p style="color: #6B7280; font-size: 12px; line-height: 1.5; margin: 0 0 20px;">
                                If you didn't request this, you can safely ignore this email.
                            </p>
                            
                            <hr style="border: none; border-top: 1px solid #E4E1D8; margin: 25px 0 20px;">
                            
                            <p style="color: #6B7280; font-size: 11px; margin: 0; text-align: center;">
                                This is an automated message. Please do not reply to this email.
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background: #EFEDE7; padding: 18px 30px; text-align: center;">
                            <p style="color: #6B7280; font-size: 11px; margin: 0;">
                                &copy; {{ date('Y') }} FitForge Athletic • All Rights Reserved
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>