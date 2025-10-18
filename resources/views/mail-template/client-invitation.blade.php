<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invitation - Vivasvanna Exports</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        .header {
            background-color: #1e3d59;
            border: 1px solid #333333;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .content {
            padding: 30px 20px;
            color: #333333;
            line-height: 1.6;
            border: 1px solid #333333;
        }

        .content h2 {
            color: #1e3d59;
            font-size: 20px;
            margin-top: 0;
        }

        .btn {
            display: inline-block;
            margin: 20px 0;
            padding: 12px 25px;
            background-color: #ff6e40;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        .signature {
            margin-top: 20px;
        }

        .footer {
            background-color: #f0f0f0;
            color: #666666;
            text-align: center;
            padding: 15px;
            font-size: 12px;
            line-height: 1.4;
            border: 1px solid #333333;
            border-top: 0px;
        }

        a {
            color: #ff6e40;
            text-decoration: none;
        }

        img.signature-img {
            max-width: 100px;
            height: auto;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>Invitation</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <h2>Dear Sir,</h2>
            <p>Welcome to <strong>Vivasvanna Exports Pvt. Ltd. Dashboard</strong>.</p>
            <p>Please click the button below to complete your registration and access your account:</p>
            <div style="text-align: center;">
                <a href="{{ $invitation_link }}" class="btn">Accept Invitation</a>
            </div>
            <p>If the button above does not work, copy and paste this link into your browser:</p>
            <p><a href="{{ $invitation_link }}">Invitation Link</a></p>
            <!-- Signature -->
            <div class="signature">
                <p><strong>{{ $signature_name }}</strong>
                    <br>{{ $signature_number }}
                    <br>
                </p>
                <img src="https://portal.vivasvannaexports.com/images/logo-vis.png" alt="Signature" class="signature-img">
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Reg. Office:</strong> 20, World Business House, Near Parimal Garden Elise Bridge, Ahmedabad</p>
            <p><strong>Corporate Office:</strong> SWARRNIM HOUSE, 3rd Floor, Arihant School of Pharmacy SWARRNIM UNIVERSITY CAMPUS, Adalaj, S.G Highway, Ahmedabad</p>
            <p><a href="https://www.vivasvannaexports.com">www.vivasvannaexports.com</a> | <a href="https://www.swarrnim.com">www.swarrnim.com</a></p>
            <p><strong>Contact Support:</strong></p>
            <p>
                📞 <a href="tel:{{ $support_number[0] }}">{{ $support_number[1] }}</a> |
                📧 <a href="mailto:{{ $support_emailId }}">{{ $support_emailId }}</a>
            </p>
            <p>&copy; {{ date('Y') }} Vivasvanna Exports. All rights reserved.</p>
        </div>
    </div>
</body>

</html>