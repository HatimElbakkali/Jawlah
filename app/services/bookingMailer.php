<?php

use PHPMailer\PHPMailer\PHPMailer;
require_once __DIR__ . '/../../config/config.php';


class bookingMailer
{
    public function sendBookingEmail(
        string $name,
        string $email,
        string $phone,
        string $activityName,
        string $reservationDate,
        string $reservationTime,
        string $duration,
        int $passengers,
        float $pricePerPerson,
        float $totalPrice,
        string $bookingReference = ''
    ): bool {
        $mail = new PHPMailer(true);

        try {
            if (trim($bookingReference) === '') {
                throw new InvalidArgumentException('Booking reference is required.');
            }

            $e = fn($v) => htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');

            $safeRef      = $e($bookingReference);
            $safeName     = $e($name);
            $safeEmail    = $e($email);
            $safePhone    = $e($phone);
            $safeActivity = $e($activityName);
            $safeDate     = $e($reservationDate);
            $safeTime     = $e($reservationTime);
            $safeDuration = $e($duration);
            $priceFmt     = number_format($pricePerPerson, 2);
            $totalFmt     = number_format($totalPrice, 2);

            $mail->isSMTP();

            $mail->Host = MailConfig::get('SMTP_HOST');

            $mail->SMTPAuth = filter_var(
                MailConfig::get('SMTP_AUTH'),
                FILTER_VALIDATE_BOOLEAN
            );

            $mail->Username = MailConfig::get('SMTP_USER');

            $mail->Password = preg_replace(
                '/\s+/',
                '',
                MailConfig::get('SMTP_PASS')
            );

            $mail->SMTPSecure =
                MailConfig::get('SMTP_SECURE') === 'ssl'
                ? PHPMailer::ENCRYPTION_SMTPS
                : PHPMailer::ENCRYPTION_STARTTLS;

            $mail->Port = (int) MailConfig::get('SMTP_PORT');

            $mail->CharSet = 'UTF-8';

            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                ]
            ];

            $mail->setFrom(
                MailConfig::get('FROM_EMAIL'),
                MailConfig::get('FROM_NAME')
            );

            $mail->addAddress($email, $name);

            $mail->isHTML(true);
            $mail->Subject = 'Booking Confirmed - JAWLAH';

            $mail->Body = "
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Booking Confirmed - JAWLAH</title>
</head>
<body style='margin:0; padding:0; background-color:#b2ae8a; font-family:Arial, Helvetica, sans-serif;'>
    <div style='width:100%; padding:40px 0;'>
        <div style='max-width:650px; margin:0 auto; background:#fff;'>
            <div style='background:#231709; padding:30px 35px; text-align:center;'>
                <h1 style='margin:0; color:#9e8a45; font-size:30px; letter-spacing:2px;'>
                    JAWLAH
                </h1>
                <p style='margin:8px 0 0; color:#fff; font-size:13px;'>
                    Booking Confirmation
                </p>
            </div>
            <div style='padding:35px;'>
                <div style='text-align:center; margin-bottom:35px;'>
                    <div style='width:60px; height:60px; line-height:60px; margin:0 auto 18px; background:#231709; color:#fff; border-radius:50%; font-size:30px;'>
                        &#10003;
                    </div>
                    <h2 style='margin:0 0 10px; color:#000; font-size:24px;'>
                        Payment &amp; Booking Confirmed!
                    </h2>
                    <p style='margin:0; color:#555; font-size:14px; line-height:1.6;'>
                        Shukran! Your desert experience is confirmed.
                    </p>
                    <p style='margin:6px 0 0; color:#555; font-size:14px;'>
                        Booking Reference: <strong style='color:#231709;'>{$safeRef}</strong>
                    </p>
                </div>
                <div style='border:1px solid #ddd; margin-bottom:25px;'>
                    <div style='background:#f5f5f5; padding:14px 18px; border-bottom:1px solid #ddd;'>
                        <strong style='color:#000; font-size:15px;'>Customer Information</strong>
                    </div>
                    <div style='padding:20px;'>
                        <p style='margin:0 0 14px; color:#000;'><strong>Name:</strong> <span style='color:#555;'>{$safeName}</span></p>
                        <p style='margin:0 0 14px; color:#000;'><strong>Email:</strong> <span style='color:#555;'>{$safeEmail}</span></p>
                        <p style='margin:0; color:#000;'><strong>Phone:</strong> <span style='color:#555;'>{$safePhone}</span></p>
                    </div>
                </div>
                <div style='border:1px solid #ddd; margin-bottom:25px;'>
                    <div style='background:#f5f5f5; padding:14px 18px; border-bottom:1px solid #ddd;'>
                        <strong style='color:#000; font-size:15px;'>Booking Details</strong>
                    </div>
                    <div style='padding:20px;'>
                        <p style='margin:0 0 14px; color:#000;'><strong>Activity:</strong> <span style='color:#555;'>{$safeActivity}</span></p>
                        <p style='margin:0 0 14px; color:#000;'><strong>Date:</strong> <span style='color:#555;'>{$safeDate}</span></p>
                        <p style='margin:0 0 14px; color:#000;'><strong>Time:</strong> <span style='color:#555;'>{$safeTime}</span></p>
                        <p style='margin:0 0 14px; color:#000;'><strong>Duration:</strong> <span style='color:#555;'>{$safeDuration}</span></p>
                        <p style='margin:0; color:#000;'><strong>Passengers:</strong> <span style='color:#555;'>{$passengers}</span></p>
                    </div>
                </div>
                <div style='border:1px solid #ddd; margin-bottom:25px;'>
                    <div style='background:#231709; padding:14px 18px;'>
                        <strong style='color:#9e8a45; font-size:16px;'>Payment Receipt</strong>
                    </div>
                    <div style='padding:20px;'>
                        <table style='width:100%; border-collapse:collapse;'>
                            <tr>
                                <td style='padding:10px 0; color:#555; border-bottom:1px solid #eee;'>Price per person</td>
                                <td style='padding:10px 0; color:#000; text-align:right; border-bottom:1px solid #eee;'>\${$priceFmt}</td>
                            </tr>
                            <tr>
                                <td style='padding:10px 0; color:#555; border-bottom:1px solid #eee;'>Passengers</td>
                                <td style='padding:10px 0; color:#000; text-align:right; border-bottom:1px solid #eee;'>{$passengers}</td>
                            </tr>
                            <tr>
                                <td style='padding:18px 0 5px; color:#000; font-size:17px;'><strong>Total Paid</strong></td>
                                <td style='padding:18px 0 5px; color:#9e8a45; font-size:20px; text-align:right;'><strong>\${$totalFmt}</strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div style='padding:18px; border-left:4px solid #9e8a45; background:#f8f8f8; color:#555; font-size:13px; line-height:1.7;'>
                    Please keep this email as your booking confirmation and payment receipt.<br><br>
                    We recommend arriving at least <strong>15 minutes before</strong> your scheduled experience.
                </div>
            </div>
            <div style='background:#231709; padding:25px 35px; text-align:center;'>
                <p style='margin:0 0 8px; color:#9e8a45; font-size:14px; font-weight:bold;'>JAWLAH</p>
                <p style='margin:0; color:#fff; opacity:0.7; font-size:11px;'>Your desert experience starts here.</p>
                <p style='margin:8px 0 0; color:#fff; opacity:0.5; font-size:11px;'>&copy; " . date('Y') . " JAWLAH. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>
";

            $mail->AltBody = "
JAWLAH - Booking Confirmation
Booking Reference: {$bookingReference}

Name: {$name}
Email: {$email}
Phone: {$phone}
Activity: {$activityName}
Date: {$reservationDate}
Time: {$reservationTime}
Duration: {$duration}
Passengers: {$passengers}
Total Paid: \${$totalFmt}
";

            return $mail->send();
        } catch (\Throwable $ex) {
            error_log("PHPMailer Booking Error: " . $mail->ErrorInfo . " | " . $ex->getMessage());
            return false;
        }
    }
}