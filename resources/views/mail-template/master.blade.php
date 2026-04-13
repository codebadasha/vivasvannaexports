<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Vivasvanna Exports Notification')</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            color: #333333;
            line-height: 1.2;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #1e3d59;
            color: #ffffff;
            padding: 20px;
            text-align: center;
            display: flex;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
        }
        .header img {
            width: 70px !important;
            max-width: 70px !important;
            margin-right: 20px;
        }
        .content {
            padding: 30px 20px;
            border: 1px solid #e0e0e0;
            line-height: 1.2;
        }
        .content h2 {
            color: #1e3d59;
            font-size: 20px;
            margin-top: 0;
        }
        .success-box {
            background-color: #e8f5e9;
            border-left: 5px solid #4caf50;
            padding: 20px 24px;
            margin: 24px 0;
            border-radius: 6px;
            font-size: 16px;
        }
        .btn {
            display: inline-block;
            margin: 14px 0;
            padding: 12px 25px;
            background-color: #ff6e40;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }
        .signature {
            margin-top: 32px;
            /* font-size: 15px; */
        }
        .footer {
            background-color: #f8f9fa;
            color: #555;
            text-align: center;
            padding: 15px;
            font-size: 12px;
            border-top: 1px solid #e0e0e0;
        }
        a {
            color: #ff6e40;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .support-contacts a {
            color: #1e3d59;
            font-weight: bold;
        }
        img.logo {
            max-width: 65px;
            height: auto;
            /* margin: 12px 0; */
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <img src="https://portal.vivasvannaexports.com/images/logo-vis.png" alt="Vivasvanna Exports Logo" class="logo">
            
            <div>
                <h1>@yield('email-title')</h1>
                @hasSection('subtitle')
                    <p style="margin:10px 0 0; font-size:16px; opacity:0.9;">
                        @yield('subtitle')
                    </p>
                @endif
            </div>
        </div>

        <!-- Content -->
        <div class="content">
            @yield('content')
            <!-- Signature -->
            <div class="signature">
                <p><strong>Best regards,</strong><br>
                <strong>Vivasvanna Support Team</strong><br>
                Vivasvanna Exports Pvt. Ltd.<br>
                +91-9979955809
                </p>
                <img src="https://portal.vivasvannaexports.com/images/logo-vis.png" alt="Vivasvanna Exports Logo" class="logo">
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Registered Office:</strong> 20, World Business House, Near Parimal Garden, Elise Bridge, Ahmedabad</p>
            <p><strong>Corporate Office:</strong> SWARRNIM HOUSE, 3rd Floor, Arihant School of Pharmacy, SWARRNIM UNIVERSITY CAMPUS, Adalaj, S.G. Highway, Ahmedabad</p>
            <p>
                <a href="https://www.vivasvannaexports.com">www.vivasvannaexports.com</a> &nbsp;|&nbsp;
                <a href="https://www.swarrnim.com">www.swarrnim.com</a>
            </p>
            <p class="support-contacts" style="margin-top: 16px;">
                <strong>Support:</strong><br>
                📞 <a href="tel:+919979955809">+91-9979955809</a><br>
                📧 <a href="mailto:info@vivasvannaexports.com">info@vivasvannaexports.com</a>
            </p>
            <p style="margin-top: 20px;">&copy; {{ date('Y') }} Vivasvanna Exports Pvt. Ltd. All rights reserved.</p>
        </div>
    </div>
</body>

</html>