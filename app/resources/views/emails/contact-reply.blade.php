<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balasan Pesan - Unceasing Cantica Bandung</title>
</head>
<body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; background-color: #f3f4f6;">
    <table role="presentation" style="width: 100%; border-collapse: collapse; background-color: #f3f4f6; padding: 20px;">
        <tr>
            <td align="center">
                <table role="presentation" style="max-width: 600px; width: 100%; border-collapse: collapse; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%); padding: 30px 40px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 24px; font-weight: bold;">Unceasing Cantica Bandung</h1>
                            <p style="margin: 10px 0 0 0; color: #e0f2fe; font-size: 14px;">Balasan Pesan Kontak</p>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px;">
                            <p style="margin: 0 0 20px 0; color: #1e293b; font-size: 16px; line-height: 1.6;">
                                Halo <strong>{{ $contactMessage->name }}</strong>,
                            </p>
                            
                            <p style="margin: 0 0 20px 0; color: #1e293b; font-size: 16px; line-height: 1.6;">
                                Terima kasih telah menghubungi kami. Berikut adalah balasan untuk pesan Anda:
                            </p>
                            
                            <!-- Original Message -->
                            <div style="background-color: #f8fafc; border-left: 4px solid #0ea5e9; padding: 20px; margin: 20px 0; border-radius: 4px;">
                                <p style="margin: 0 0 10px 0; color: #64748b; font-size: 14px; font-weight: 600; text-transform: uppercase;">Pesan Asli Anda:</p>
                                <p style="margin: 0 0 10px 0; color: #1e293b; font-size: 14px; line-height: 1.6;">
                                    <strong>Subjek:</strong> {{ $contactMessage->subject }}
                                </p>
                                <p style="margin: 0; color: #475569; font-size: 14px; line-height: 1.6; white-space: pre-wrap;">{{ $contactMessage->message }}</p>
                            </div>
                            
                            <!-- Reply Message -->
                            <div style="background-color: #eff6ff; border-left: 4px solid #3b82f6; padding: 20px; margin: 20px 0; border-radius: 4px;">
                                <p style="margin: 0 0 10px 0; color: #1e40af; font-size: 14px; font-weight: 600; text-transform: uppercase;">Balasan dari {{ $adminName }}:</p>
                                <p style="margin: 0; color: #1e293b; font-size: 15px; line-height: 1.8; white-space: pre-wrap;">{{ $replyMessage }}</p>
                            </div>
                            
                            <p style="margin: 30px 0 0 0; color: #64748b; font-size: 14px; line-height: 1.6;">
                                Jika Anda memiliki pertanyaan lebih lanjut, jangan ragu untuk menghubungi kami kembali.
                            </p>
                            
                            <p style="margin: 20px 0 0 0; color: #1e293b; font-size: 16px; line-height: 1.6;">
                                Salam,<br>
                                <strong>{{ $adminName }}</strong><br>
                                <span style="color: #64748b; font-size: 14px;">Unceasing Cantica Bandung</span>
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8fafc; padding: 30px 40px; text-align: center; border-top: 1px solid #e2e8f0;">
                            <p style="margin: 0 0 10px 0; color: #64748b; font-size: 12px;">
                                Email ini dikirim sebagai balasan untuk pesan yang Anda kirim melalui form kontak di website kami.
                            </p>
                            <p style="margin: 0; color: #94a3b8; font-size: 11px;">
                                © {{ date('Y') }} Unceasing Cantica Bandung. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

