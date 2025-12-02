<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join True Form Elite</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 20px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
            color: #333;
        }
        .message {
            font-size: 16px;
            margin-bottom: 20px;
            color: #555;
        }
        .offer-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 8px;
            padding: 25px;
            text-align: center;
            margin: 30px 0;
        }
        .offer-box h2 {
            color: #ffffff;
            margin: 0 0 10px 0;
            font-size: 24px;
        }
        .offer-box p {
            color: #f0e6ff;
            margin: 0;
            font-size: 15px;
        }
        .cta-button {
            display: inline-block;
            background-color: #ffffff;
            color: #667eea;
            text-decoration: none;
            padding: 15px 40px;
            border-radius: 8px;
            font-weight: bold;
            font-size: 16px;
            margin: 30px 0;
            transition: all 0.3s;
        }
        .cta-button:hover {
            background-color: #f0e6ff;
        }
        .link-box {
            background-color: #f8f9fa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            word-break: break-all;
        }
        .link-box p {
            margin: 0 0 10px 0;
            font-size: 14px;
            color: #666;
        }
        .link-box a {
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
        }
        .features {
            margin: 30px 0;
        }
        .feature {
            margin-bottom: 15px;
            padding-left: 30px;
            position: relative;
        }
        .feature:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #667eea;
            font-weight: bold;
            font-size: 20px;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 30px;
            text-align: center;
            color: #999;
            font-size: 14px;
        }
        .signature {
            margin-top: 30px;
            font-style: italic;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🌟 True Form Elite</h1>
        </div>

        <div class="content">
            <p class="greeting">Hey!</p>

            <p class="message">
                I've been using True Form Elite to track my wellness journey, and it's been incredible. I thought you might be interested!
            </p>

            <div class="offer-box">
                <h2>Get 15% Off Your First Month</h2>
                <p>Special discount just for you!</p>
            </div>

            <p class="message">
                Use my referral link to get started:
            </p>

            <div style="text-align: center;">
                <a href="{{ $referralLink }}" class="cta-button">
                    Join True Form Elite
                </a>
            </div>

            <div class="link-box">
                <p><strong>Or copy this link:</strong></p>
                <a href="{{ $referralLink }}">{{ $referralLink }}</a>
            </div>

            <p class="message">
                It's a 360-day transformation program that helps you track:
            </p>

            <div class="features">
                <div class="feature">Energy levels and vitality</div>
                <div class="feature">Mental focus and clarity</div>
                <div class="feature">Sleep quality</div>
                <div class="feature">Gut health</div>
                <div class="feature">Skin glow</div>
                <div class="feature">Overall Mito-Age Score</div>
            </div>

            <p class="message">
                If you're serious about improving your health, I think you'll love it.
            </p>

            <p class="message">
                Let me know if you have any questions!
            </p>

            <p class="signature">
                {{ $referrer->name }}
            </p>
        </div>

        <div class="footer">
            <p>
                This email was sent by {{ $referrer->name }} through the True Form Elite referral program.
            </p>
            <p style="margin-top: 10px;">
                © {{ date('Y') }} True Form Elite. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
