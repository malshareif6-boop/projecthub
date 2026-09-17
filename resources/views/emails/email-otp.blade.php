<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body style="margin:0;padding:0;background:#F3F4F6;font-family:Segoe UI,Arial,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#F3F4F6;padding:32px 16px;">
        <tr>
            <td align="center">
                <table width="560" cellpadding="0" cellspacing="0"
                    style="background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 1px 3px rgba(0,0,0,.08);">
                    <tr>
                        <td style="background:#4F46E5;padding:24px 32px;">
                            <span
                                style="display:inline-block;width:36px;height:36px;background:#fff;border-radius:8px;color:#4F46E5;font-weight:700;font-size:13px;line-height:36px;text-align:center;margin-right:10px;">PH</span>
                            <span
                                style="color:#fff;font-size:18px;font-weight:600;vertical-align:middle;">ProjectHub</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:32px;text-align:center;">
                            <h1 style="margin:0 0 12px;font-size:22px;color:#111827;">Verify your email</h1>
                            <p style="margin:0 0 24px;font-size:15px;color:#4B5563;">
                                Hello {{ $user->name }}, use this code to verify your account:
                            </p>
                            <div
                                style="display:inline-block;background:#F3F4F6;border-radius:12px;padding:16px 32px;letter-spacing:8px;font-size:32px;font-weight:700;color:#111827;">
                                {{ $otp }}
                            </div>
                            <p style="margin:24px 0 0;font-size:13px;color:#9CA3AF;">
                                This code expires in 15 minutes.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td
                            style="padding:16px 32px;background:#F9FAFB;border-top:1px solid #E5E7EB;text-align:center;">
                            <p style="margin:0;font-size:12px;color:#9CA3AF;">© {{ date('Y') }} ProjectHub</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
