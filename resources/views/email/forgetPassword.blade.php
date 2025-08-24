<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - POS</title>
</head>

<body style="margin:0; padding:0; background-color:#f4f4f4; font-family: Arial, sans-serif;">
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td align="center" style="padding: 40px 0;">
                <table border="0" cellpadding="0" cellspacing="0" width="600"
                    style="background:#ffffff; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.1); overflow:hidden;">

                    <!-- Header -->
                    <tr>
                        <td align="center" bgcolor="#0d6efd" style="padding:20px;">
                            <h2 style="color:#ffffff; margin:0; font-size:24px;">🔑 Reset Your Password</h2>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:30px; color:#333333; font-size:16px; line-height:1.6;">
                            <p>Hello,</p>
                            <p>We received a request to reset your password for your <strong>POS account</strong>.</p>
                            <p>Click the button below to reset your password:</p>

                            <!-- Button -->
                            <p style="text-align:center; margin:30px 0;">
                                <a href="{{ route('reset.password.get', $token) }}"
                                    style="background-color:#0d6efd; color:#ffffff; padding:12px 24px; 
                                          text-decoration:none; border-radius:5px; font-weight:bold;">
                                    Reset Password
                                </a>
                            </p>

                            <p>If you didn’t request a password reset, you can safely ignore this email.</p>
                            <p style="margin-top:30px;">Thanks,<br><strong>POS Team</strong></p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" bgcolor="#f4f4f4" style="padding:15px; font-size:12px; color:#888888;">
                            &copy; {{ date('Y') }} POS System. All rights reserved.
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>

</html>
