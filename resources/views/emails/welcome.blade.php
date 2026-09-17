<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
</head>
<body style="margin:0;padding:0;background:#F3F4F6;font-family:Segoe UI,Arial,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#F3F4F6;padding:32px 16px;">
        <tr>
            <td align="center">
                <table width="560" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 1px 3px rgba(0,0,0,.08);">
                    {{-- Header --}}
                    <tr>
                        <td style="background:#4F46E5;padding:24px 32px;">
                            <span style="display:inline-block;width:36px;height:36px;background:#fff;border-radius:8px;color:#4F46E5;font-weight:700;font-size:13px;line-height:36px;text-align:center;margin-right:10px;">PH</span>
                            <span style="color:#fff;font-size:18px;font-weight:600;vertical-align:middle;">ProjectHub</span>
                        </td>
                    </tr>
                    {{-- Body --}}
                    <tr>
                        <td style="padding:32px;">
                            <h1 style="margin:0 0 12px;font-size:22px;color:#111827;">Welcome, {{ $user->name }}!</h1>
                            <p style="margin:0 0 16px;font-size:15px;line-height:1.6;color:#4B5563;">
                                Your ProjectHub account is ready. Create your graduation project, invite teammates, and track progress with your supervisor.
                            </p>
                            <a href="{{ url('/dashboard') }}"
                               style="display:inline-block;background:#4F46E5;color:#fff;text-decoration:none;padding:12px 24px;border-radius:8px;font-size:14px;font-weight:600;">
                                Go to Dashboard
                            </a>
                        </td>
                    </tr>
                    {{-- Footer --}}
                    <tr>
                        <td style="padding:16px 32px;background:#F9FAFB;border-top:1px solid #E5E7EB;text-align:center;">
                            <p style="margin:0;font-size:12px;color:#9CA3AF;">© {{ date('Y') }} ProjectHub — Graduation Project Management</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
