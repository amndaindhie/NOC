<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>NOC System - Email Verification OTP</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f8; color: #333;">
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
        <tr>
            <td align="center" style="padding: 40px 20px;">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="600" style="background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); overflow: hidden;">
                    
                    <!-- Header -->
                    <tr>
                        <td align="center" style="background-color: #1e4356; padding: 20px;">
                            <h1 style="margin: 0; font-size: 22px; color: #ffffff;">NOC System - Email Verification</h1>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding: 30px;">
                            <p style="margin: 0 0 15px;">Hello,</p>
                            <p style="margin: 0 0 15px;">
                                Thank you for registering with <strong>NOC System</strong>.  
                                To verify your email address, please use the One-Time Password (OTP) below:
                            </p>

                            <div style="background-color: #f9fbff; border: 2px dashed #68a4c4; border-radius: 8px; padding: 20px; text-align: center; font-size: 26px; font-weight: bold; letter-spacing: 6px; color: #1e4356; margin: 25px 0;">
                                {{ $verification->otp }}
                            </div>

                            <p style="margin: 0 0 15px;">This code is valid for <strong>60 minutes</strong>. Please enter it on the verification page to complete your registration.</p>
                            <p style="margin: 0 0 15px; font-size: 13px; color: #666;">If you did not request this, you can safely ignore this email.</p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="background-color: #f4f6f8; padding: 15px; font-size: 12px; color: #888;">
                            &copy; {{ date('Y') }} NOC System. All rights reserved.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
