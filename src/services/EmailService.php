<?php

namespace Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Models\SettingsModel;

class EmailService
{
    private PHPMailer $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);
        
        // Ayarları veritabanından al
        $settingsModel = new SettingsModel();
        $mailSettings = $settingsModel->getMailSettings();
        
        // SMTP ayarları - önce veritabanı, sonra .env fallback
        $this->mailer->isSMTP();
        $this->mailer->Host       = $mailSettings['host'] ?? ($_ENV['MAIL_HOST'] ?? '');
        $this->mailer->SMTPAuth   = true;
        $this->mailer->Username   = $mailSettings['username'] ?? ($_ENV['MAIL_USERNAME'] ?? '');
        $this->mailer->Password   = $mailSettings['password'] ?? ($_ENV['MAIL_PASSWORD'] ?? '');
        $this->mailer->SMTPSecure = $mailSettings['encryption'] ?? ($_ENV['MAIL_ENCRYPTION'] ?? 'tls');
        $this->mailer->Port       = $mailSettings['port'] ?? ($_ENV['MAIL_PORT'] ?? 587);
        $this->mailer->CharSet    = 'UTF-8';
        
        // Gönderen bilgileri
        $this->mailer->setFrom(
            $mailSettings['from_address'] ?? ($_ENV['MAIL_FROM_ADDRESS'] ?? 'noreply@aybu.edu.tr'),
            $mailSettings['from_name'] ?? ($_ENV['MAIL_FROM_NAME'] ?? 'AYBÜ Askıda Kampüs')
        );
    }

    public function sendContactEmail(string $toEmail, string $fromName, string $fromEmail, string $subject, string $message): bool
    {
        try {
            $this->mailer->addAddress($toEmail);
            $this->mailer->addReplyTo($fromEmail, $fromName);
            $this->mailer->isHTML(true);
            $this->mailer->Subject = '[Askıda Kampüs İletişim] ' . $subject;
            $this->mailer->Body    = $this->getContactTemplate($fromName, $fromEmail, $subject, $message);
            $this->mailer->AltBody = "Gönderen: $fromName <$fromEmail>\nKonu: $subject\n\n$message";
            $this->mailer->send();
            return true;
        } catch (\Throwable $e) {
            error_log('İletişim formu email hatası: ' . $this->mailer->ErrorInfo);
            return false;
        }
    }

    private function getContactTemplate(string $fromName, string $fromEmail, string $subject, string $message): string
    {
        $safeFromName  = htmlspecialchars($fromName,  ENT_QUOTES, 'UTF-8');
        $safeFromEmail = htmlspecialchars($fromEmail, ENT_QUOTES, 'UTF-8');
        $safeSubject   = htmlspecialchars($subject,   ENT_QUOTES, 'UTF-8');
        $safeMessage   = nl2br(htmlspecialchars($message, ENT_QUOTES, 'UTF-8'));
        $date          = date('d.m.Y H:i');

        return <<<HTML
<!DOCTYPE html>
<html lang="tr">
<head><meta charset="UTF-8"><title>İletişim Formu</title></head>
<body style="margin:0;padding:0;font-family:Arial,sans-serif;background:#f3f4f6;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f3f4f6;padding:40px 0;">
  <tr><td align="center">
    <table width="600" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:8px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.08);">
      <tr>
        <td style="background:linear-gradient(135deg,#003a6e 0%,#00A3B4 100%);padding:36px 32px;text-align:center;">
          <h1 style="color:#fff;margin:0;font-size:22px;font-weight:700;">Askıda Kampüs</h1>
          <p style="color:rgba(255,255,255,0.8);margin:6px 0 0;font-size:13px;">Yeni İletişim Formu Mesajı</p>
        </td>
      </tr>
      <tr>
        <td style="padding:32px;">
          <table width="100%" cellpadding="0" cellspacing="0" style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;margin-bottom:24px;">
            <tr>
              <td style="padding:16px 20px;border-bottom:1px solid #e2e8f0;">
                <span style="font-size:11px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:0.5px;">Gönderen</span>
                <p style="margin:4px 0 0;font-size:15px;font-weight:600;color:#1f2937;">$safeFromName</p>
                <a href="mailto:$safeFromEmail" style="font-size:13px;color:#00A3B4;text-decoration:none;">$safeFromEmail</a>
              </td>
            </tr>
            <tr>
              <td style="padding:16px 20px;border-bottom:1px solid #e2e8f0;">
                <span style="font-size:11px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:0.5px;">Konu</span>
                <p style="margin:4px 0 0;font-size:15px;font-weight:600;color:#1f2937;">$safeSubject</p>
              </td>
            </tr>
            <tr>
              <td style="padding:16px 20px;">
                <span style="font-size:11px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:0.5px;">Gönderim Tarihi</span>
                <p style="margin:4px 0 0;font-size:14px;color:#374151;">$date</p>
              </td>
            </tr>
          </table>

          <div style="margin-bottom:8px;">
            <span style="font-size:11px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:0.5px;">Mesaj</span>
          </div>
          <div style="background:#fff;border:1px solid #e2e8f0;border-left:4px solid #00A3B4;border-radius:0 8px 8px 0;padding:20px 24px;font-size:15px;color:#374151;line-height:1.8;">
            $safeMessage
          </div>

          <div style="margin-top:28px;padding:16px 20px;background:#e0f7fa;border-radius:8px;border:1px solid #b2ebf2;">
            <p style="margin:0;font-size:13px;color:#007a7a;">
              Bu mesajı yanıtlamak için
              <a href="mailto:$safeFromEmail" style="color:#005f6b;font-weight:700;">$safeFromEmail</a>
              adresine e-posta gönderebilirsiniz.
            </p>
          </div>
        </td>
      </tr>
      <tr>
        <td style="background:#f9fafb;padding:24px;text-align:center;border-top:1px solid #e5e7eb;">
          <p style="color:#9ca3af;font-size:12px;margin:0;">
            © {$date[6]}{$date[7]}{$date[8]}{$date[9]} Ankara Yıldırım Beyazıt Üniversitesi<br>
            Askıda Kampüs Sistemi — İletişim Formu
          </p>
        </td>
      </tr>
    </table>
  </td></tr>
</table>
</body>
</html>
HTML;
    }

    public function sendPasswordResetEmail(string $email, string $token): bool
    {
        try {
            $resetUrl = url("sifre-sifirla?token=$token&email=" . urlencode($email));
            
            $this->mailer->addAddress($email);
            $this->mailer->isHTML(true);
            $this->mailer->Subject = 'Şifre Sıfırlama - Askıda Kampüs';
            
            $this->mailer->Body = $this->getPasswordResetTemplate($resetUrl);
            $this->mailer->AltBody = "Şifrenizi sıfırlamak için şu linke tıklayın: $resetUrl\n\nBu link 1 saat geçerlidir.";
            
            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            error_log("Email gönderme hatası: " . $this->mailer->ErrorInfo);
            return false;
        }
    }

    public function sendDonationThankYouEmail(string $email, string $donorName, array $donationDetails): bool
    {
        try {
            // Subject'i veritabanından al
            $settingsModel = new SettingsModel();
            $subject = $settingsModel->get('email_donation_subject', 'Bağışınız İçin Teşekkür Ederiz - AYBÜ Askıda Kampüs');
            $greeting = $settingsModel->get('email_donation_greeting', 'Sayın {{donor_name}},');
            
            // Placeholder'ları değiştir
            $subject = str_replace('{{donor_name}}', $donorName, $subject);
            $greetingText = str_replace('{{donor_name}}', $donorName, $greeting);
            
            $this->mailer->addAddress($email);
            $this->mailer->isHTML(true);
            $this->mailer->Subject = $subject;
            
            $this->mailer->Body = $this->getDonationThankYouTemplate($donorName, $donationDetails);
            $this->mailer->AltBody = "$greetingText\n\nAnkara Yıldırım Beyazıt Üniversitesi İktisadi İşletmeler Müdürlüğü olarak değerli bağışınız için teşekkür ederiz.";
            
            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            error_log("Email gönderme hatası: " . $this->mailer->ErrorInfo);
            return false;
        }
    }

    private function getPasswordResetTemplate(string $resetUrl): string
    {
        return <<<HTML
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Şifre Sıfırlama</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f3f4f6;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f3f4f6; padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #00A3B4 0%, #007A8A 100%); padding: 40px 30px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 28px;">Askıda Kampüs</h1>
                            <p style="color: rgba(255,255,255,0.9); margin: 10px 0 0 0; font-size: 14px;">Şifre Sıfırlama</p>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <p style="color: #374151; font-size: 16px; line-height: 24px; margin: 0 0 20px 0;">
                                Merhaba,
                            </p>
                            <p style="color: #374151; font-size: 16px; line-height: 24px; margin: 0 0 20px 0;">
                                Şifrenizi sıfırlamak için bir talepte bulundunuz. Aşağıdaki butona tıklayarak yeni şifrenizi oluşturabilirsiniz.
                            </p>
                            
                            <!-- Button -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin: 30px 0;">
                                <tr>
                                    <td align="center">
                                        <a href="$resetUrl" style="display: inline-block; padding: 14px 40px; background-color: #00A3B4; color: #ffffff; text-decoration: none; border-radius: 6px; font-size: 16px; font-weight: bold;">
                                            Şifremi Sıfırla
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            
                            <p style="color: #6b7280; font-size: 14px; line-height: 20px; margin: 20px 0 0 0;">
                                Bu link <strong>1 saat</strong> geçerlidir. Eğer şifre sıfırlama talebinde bulunmadıysanız, bu e-postayı görmezden gelebilirsiniz.
                            </p>
                            
                            <p style="color: #9ca3af; font-size: 12px; line-height: 18px; margin: 20px 0 0 0; padding-top: 20px; border-top: 1px solid #e5e7eb;">
                                Buton çalışmıyorsa, aşağıdaki linki tarayıcınıza kopyalayın:<br>
                                <a href="$resetUrl" style="color: #00A3B4; word-break: break-all;">$resetUrl</a>
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f9fafb; padding: 30px; text-align: center; border-top: 1px solid #e5e7eb;">
                            <p style="color: #6b7280; font-size: 12px; margin: 0;">
                                © 2026 Ankara Yıldırım Beyazıt Üniversitesi<br>
                                Askıda Kampüs Sistemi
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
HTML;
    }

    private function getDonationThankYouTemplate(string $donorName, array $details): string
    {
        // Template'leri veritabanından al
        $settingsModel = new SettingsModel();
        $subject = $settingsModel->get('email_donation_subject', 'Bağışınız İçin Teşekkür Ederiz - AYBÜ Askıda Kampüs');
        $greeting = $settingsModel->get('email_donation_greeting', 'Sayın {{donor_name}},');
        $body = $settingsModel->get('email_donation_body', 'Ankara Yıldırım Beyazıt Üniversitesi İktisadi İşletmeler Müdürlüğü olarak, Askıda Kampüs projemize yapmış olduğunuz değerli bağış için en içten teşekkürlerimizi sunarız.');
        $footerText = $settingsModel->get('email_donation_footer_text', 'Bağışınız onaylandıktan sonra, belirlediğiniz ürünler işletme stoğuna eklenecek ve öğrencilerimiz tarafından rezerve edilebilecektir.');
        $signature = $settingsModel->get('email_donation_signature', 'Ankara Yıldırım Beyazıt Üniversitesi\nİktisadi İşletmeler Müdürlüğü\nAskıda Kampüs Projesi');
        
        // Değerleri hazırla
        $venueName = e($details['venue_name'] ?? '');
        $totalAmount = number_format($details['total_amount'] ?? 0, 2, ',', '.');
        $donationDate = format_date($details['created_at'] ?? date('Y-m-d H:i:s'));
        
        // Placeholder'ları değiştir
        $placeholders = [
            '{{donor_name}}' => $donorName,
            '{{venue_name}}' => $venueName,
            '{{total_amount}}' => $totalAmount,
            '{{donation_date}}' => $donationDate,
        ];
        
        $greeting = str_replace(array_keys($placeholders), array_values($placeholders), $greeting);
        $body = str_replace(array_keys($placeholders), array_values($placeholders), $body);
        $footerText = str_replace(array_keys($placeholders), array_values($placeholders), $footerText);
        
        // HTML'e dönüştür (satır sonlarını <br> yap)
        $bodyHtml = nl2br(e($body));
        $footerTextHtml = nl2br(e($footerText));
        $signatureHtml = nl2br(e($signature));
        
        $itemsHtml = '';
        if (!empty($details['items'])) {
            foreach ($details['items'] as $item) {
                $itemName = e($item['product_name']);
                $quantity = e($item['quantity']);
                $price = number_format($item['price'] * $item['quantity'], 2, ',', '.');
                $itemsHtml .= "<tr><td style='padding: 8px 0; color: #374151;'>$itemName × $quantity</td><td style='padding: 8px 0; color: #374151; text-align: right;'>₺$price</td></tr>";
            }
        }
        
        return <<<HTML
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bağış Teşekkürü</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f3f4f6;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f3f4f6; padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #00A3B4 0%, #007A8A 100%); padding: 40px 30px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 28px;">Ankara Yıldırım Beyazıt Üniversitesi</h1>
                            <p style="color: rgba(255,255,255,0.95); margin: 8px 0 0 0; font-size: 15px;">İktisadi İşletmeler Müdürlüğü</p>
                            <p style="color: rgba(255,255,255,0.9); margin: 12px 0 0 0; font-size: 14px;">Askıda Kampüs Sistemi</p>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <p style="color: #374151; font-size: 16px; line-height: 24px; margin: 0 0 20px 0;">
                                <strong>$greeting</strong>
                            </p>
                            <div style="color: #374151; font-size: 16px; line-height: 24px; margin: 0 0 30px 0;">
                                $bodyHtml
                            </div>
                            
                            <!-- Donation Details -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f9fafb; border-radius: 8px; padding: 20px; margin: 20px 0;">
                                <tr>
                                    <td>
                                        <h3 style="color: #00A3B4; margin: 0 0 15px 0; font-size: 16px;">Bağış Detayları</h3>
                                        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 10px;">
                                            <tr>
                                                <td style="padding: 6px 0; color: #6b7280; font-size: 14px;">İşletme:</td>
                                                <td style="padding: 6px 0; color: #374151; font-size: 14px; text-align: right; font-weight: 600;">$venueName</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 6px 0; color: #6b7280; font-size: 14px;">Tarih:</td>
                                                <td style="padding: 6px 0; color: #374151; font-size: 14px; text-align: right;">$donationDate</td>
                                            </tr>
                                        </table>
                                        
                                        <div style="border-top: 1px solid #e5e7eb; margin: 15px 0;"></div>
                                        
                                        <h4 style="color: #374151; margin: 0 0 10px 0; font-size: 14px;">Bağışlanan Ürünler:</h4>
                                        <table width="100%" cellpadding="0" cellspacing="0" style="font-size: 14px;">
                                            $itemsHtml
                                            <tr style="border-top: 2px solid #00A3B4;">
                                                <td style="padding: 12px 0 0 0; color: #374151; font-weight: bold;">Toplam Tutar:</td>
                                                <td style="padding: 12px 0 0 0; color: #00A3B4; font-weight: bold; text-align: right; font-size: 18px;">₺$totalAmount</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            
                            <div style="color: #374151; font-size: 16px; line-height: 24px; margin: 30px 0 20px 0;">
                                $footerTextHtml
                            </div>
                            
                            <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
                                <p style="color: #6b7280; font-size: 14px; line-height: 20px; margin: 0;">
                                    <strong style="color: #374151;">$signatureHtml</strong>
                                </p>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f9fafb; padding: 30px; text-align: center; border-top: 1px solid #e5e7eb;">
                            <p style="color: #6b7280; font-size: 12px; margin: 0 0 10px 0;">
                                © 2026 Ankara Yıldırım Beyazıt Üniversitesi<br>
                                İktisadi İşletmeler Müdürlüğü
                            </p>
                            <p style="color: #9ca3af; font-size: 11px; margin: 0;">
                                Esenboğa Külliyesi, Esenboğa/ANKARA<br>
                                Tel: +90 312 906 10 00 | E-posta: basin@aybu.edu.tr
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
HTML;
    }
}

