<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt lại mật khẩu</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f5f7fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f5f7fa; padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="560" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.06);">
                    {{-- Header --}}
                    <tr>
                        <td style="background: linear-gradient(135deg, #059669, #34d399); padding: 32px 40px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 24px; font-weight: 700; letter-spacing: -0.5px;">MBTI-CRS</h1>
                            <p style="margin: 8px 0 0; color: rgba(255,255,255,0.9); font-size: 13px;">Hệ thống đánh giá tính cách & Gợi ý nghề nghiệp</p>
                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="padding: 40px;">
                            <h2 style="margin: 0 0 8px; color: #1a1a2e; font-size: 20px; font-weight: 700;">Đặt lại mật khẩu</h2>
                            <p style="margin: 0 0 24px; color: #888; font-size: 14px; line-height: 1.6;">
                                Xin chào <strong style="color: #1a1a2e;">{{ $hoTen }}</strong>,
                            </p>
                            <p style="margin: 0 0 24px; color: #555; font-size: 14px; line-height: 1.7;">
                                Chúng tôi nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn. Nhấn vào nút bên dưới để tạo mật khẩu mới:
                            </p>

                            {{-- CTA Button --}}
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" style="padding: 8px 0 32px;">
                                        <a href="{{ $resetUrl }}" style="display: inline-block; padding: 14px 36px; background: linear-gradient(135deg, #059669, #34d399); color: #ffffff; text-decoration: none; border-radius: 8px; font-size: 14px; font-weight: 600; letter-spacing: 0.3px;">
                                            Đặt lại mật khẩu
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 0 0 16px; color: #888; font-size: 13px; line-height: 1.6;">
                                Link này sẽ hết hạn sau <strong>60 phút</strong>. Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này.
                            </p>

                            {{-- Divider --}}
                            <hr style="border: none; border-top: 1px solid #e8ecf1; margin: 24px 0;">

                            <p style="margin: 0; color: #aaa; font-size: 12px; line-height: 1.6;">
                                Nếu nút không hoạt động, hãy sao chép và dán link sau vào trình duyệt:<br>
                                <a href="{{ $resetUrl }}" style="color: #059669; word-break: break-all; font-size: 11px;">{{ $resetUrl }}</a>
                            </p>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="background: #f9fafb; padding: 20px 40px; text-align: center; border-top: 1px solid #e8ecf1;">
                            <p style="margin: 0; color: #aaa; font-size: 11px;">
                                © {{ date('Y') }} MBTI-CRS. Đây là email tự động, vui lòng không trả lời.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
