<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Email Verification OTP</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 20px; border-radius: 10px;">
        <h2 style="color: #007bff; text-align: center;">Email Verification</h2>
        
        <p>Hello!</p>
        
        <p>Thank you for registering. Your OTP code is:</p>
        
        <div style="background-color: #f8f9fa; border: 2px dashed #007bff; padding: 20px; text-align: center; font-size: 24px; font-weight: bold; letter-spacing: 4px; margin: 20px 0;">
            {{ $verification->otp }}
        </div>
        
        <p>This code expires in 60 minutes.</p>
        
        <p>Please enter this code to complete your registration.</p>
        
        <p style="font-size: 12px; color: #666;">If you didn't request this, please ignore this email.</p>
    </div>
</body>
</html>
