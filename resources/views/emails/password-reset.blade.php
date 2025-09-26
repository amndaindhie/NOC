<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Password Reset - NOC System</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      line-height: 1.7;
      color: #444;
      background-color: #f4f6f9;
      margin: 0;
      padding: 20px;
    }
    .container {
      max-width: 650px;
      margin: auto;
      background: #fff;
      border-radius: 14px;
      overflow: hidden;
      box-shadow: 0 6px 18px rgba(0,0,0,0.08);
    }
    .header {
      background: linear-gradient(135deg, #436a80, #1e4356);
      color: white;
      padding: 40px 30px;
      text-align: center;
    }
    .header h1 {
      margin: 0;
      font-size: 26px;
      font-weight: 700;
      letter-spacing: 0.5px;
    }
    .header p {
      margin: 8px 0 0;
      font-size: 15px;
      opacity: 0.85;
    }
    .content {
      padding: 35px 30px;
    }
    .content h2 {
      color: #004085;
      margin-bottom: 18px;
      font-size: 22px;
      font-weight: 600;
    }
    .button {
      display: inline-block;
      background: linear-gradient(135deg, #28a745, #20c997);
      color: white !important;
      padding: 14px 35px;
      border-radius: 30px;
      font-weight: 600;
      text-decoration: none;
      letter-spacing: 0.3px;
      box-shadow: 0 5px 18px rgba(40, 167, 69, 0.35);
      transition: all 0.3s ease;
    }
    .button:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 22px rgba(40, 167, 69, 0.5);
    }
    .highlight {
      background-color: #eef5ff;
      border-left: 5px solid #1e4356;
      padding: 16px 18px;
      margin: 22px 0;
      border-radius: 8px;
      font-size: 15px;
    }
    .warning {
      background: #fff8e1;
      border: 1px solid #ffe08a;
      padding: 16px 18px;
      border-radius: 8px;
      margin: 25px 0;
      font-size: 14px;
      color: #7a5600;
    }
    .link-box {
      word-break: break-all;
      background-color: #f1f3f5;
      padding: 12px;
      border-radius: 6px;
      font-family: monospace;
      font-size: 13px;
      margin-top: 15px;
    }
    .footer {
      background: #f8f9fa;
      text-align: center;
      padding: 20px;
      font-size: 13px;
      color: #6c757d;
      border-top: 1px solid #e9ecef;
    }
    .footer p {
      margin: 6px 0;
    }
  </style>
</head>
<body>
  <div class="container">

    <!-- Header -->
    <div class="header">
      <h1>🔒 NOC System</h1>
      <p>Network Operation Center</p>
    </div>

    <!-- Content -->
    <div class="content">
      <h2>Reset Your Password</h2>
      <p>Hello,</p>
      <p>You are receiving this email because we received a password reset request for your account on <strong>NOC System</strong>.</p>

      <div class="highlight">
        <p><strong>📌 Request Details:</strong></p>
        <p>📧 Email: {{ $email }}</p>
        <p>⏰ Time: {{ now()->format('M d, Y, H:i') }}</p>
      </div>

      <p>If you made this request, please click the button below to reset your password:</p>
      <p style="text-align: center; margin: 25px 0;">
        <a href="{{ $url }}" class="button">🔑 Reset My Password</a>
      </p>

      <div class="warning">
        <strong>⚠️ Security Notice:</strong><br>
        • This link will expire in 60 minutes<br>
        • Do not share this link with anyone<br>
        • If you did not request a password reset, please ignore this email
      </div>

      <p>If the button above does not work, copy and paste the link below into your browser:</p>
      <div class="link-box">
        {{ $url }}
      </div>

      <p style="margin-top: 25px;">Thank you,<br>
      <strong>The NOC System Team</strong></p>
    </div>

    <!-- Footer -->
    <div class="footer">
      <p>© {{ date('Y') }} NOC System - Network Operation Center</p>
      <p>This email was sent automatically. Please do not reply.</p>
    </div>
  </div>
</body>
</html>
