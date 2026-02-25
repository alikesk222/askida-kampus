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

