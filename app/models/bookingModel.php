<?php

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../services/bookingMailer.php';

class bookingModel
{
    private PDO $connect;
    private bookingMailer $mailer;

    public function __construct()
    {
        $db = new connectionDB();

        $this->connect = $db->getConnection();

        $this->mailer = new bookingMailer();
    }

    public function getInfoActivities($id)
    {
        $sqlState = $this->connect->prepare(
            "SELECT * FROM desert_activity WHERE id = ?"
        );

        $sqlState->execute([$id]);

        return $sqlState->fetch(PDO::FETCH_ASSOC);
    }

    public function getInfoPack($id)
    {
        $sqlState = $this->connect->prepare(
            "SELECT * FROM desert_activities_pack WHERE id = ?"
        );

        $sqlState->execute([$id]);

        return $sqlState->fetch(PDO::FETCH_ASSOC);
    }

    public function getBookingsByDate($type, $id, $date)
    {
        if ($type === 'activity') {

            $stmt = $this->connect->prepare(
                "SELECT
                    selected_time,
                    duration,
                    adults,
                    children,
                    infants
                 FROM bookings
                 WHERE activity_id = ?
                 AND reservation_date = ?"
            );
        } else {

            $stmt = $this->connect->prepare(
                "SELECT
                    selected_time,
                    duration,
                    adults,
                    children,
                    infants
                 FROM bookings
                 WHERE pack_id = ?
                 AND reservation_date = ?"
            );
        }

        $stmt->execute([
            $id,
            $date
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

private function generateCode(): string
{
    $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    $code = '';
    for ($i = 0; $i < 6; $i++) {
        $code .= $chars[random_int(0, strlen($chars) - 1)];
    }
    return 'JWL-' . $code;
}

public function createBooking($data)
{
    $sql = "
        INSERT INTO bookings (
            code,
            activity_id,
            pack_id,
            full_name,
            phone_number,
            email,
            reservation_date,
            adults,
            children,
            infants,
            duration,
            price_per_person,
            total_price,
            selected_time,
            created_at
        )
        VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW()
        )
    ";

    $stmt = $this->connect->prepare($sql);

    $code = null;
    $maxAttempts = 5;
    for ($attempt = 1; $attempt <= $maxAttempts; $attempt++) {
        $candidate = $this->generateCode();
        try {
            $stmt->execute([
                $candidate,
                $data['activity_id'],
                $data['pack_id'],
                $data['full_name'],
                $data['phone_number'],
                $data['email'],
                $data['reservation_date'],
                $data['adults'],
                $data['children'],
                $data['infants'],
                $data['duration'],
                $data['price_per_person'],
                $data['total_price'],
                $data['selected_time']
            ]);
            $code = $candidate;
            break;
        } catch (PDOException $e) {
            $isDuplicate = ($e->errorInfo[1] ?? null) == 1062;
            if (!$isDuplicate || $attempt === $maxAttempts) {
                throw $e;
            }
        }
    }

    $passengers = $data['adults'] + $data['children'] + $data['infants'];

    if (!empty($data['activity_id'])) {
        $activity = $this->getInfoActivities($data['activity_id']);
        $activityName = $activity['title'] ?? $activity['name'] ?? 'Desert Activity';
    } else {
        $pack = $this->getInfoPack($data['pack_id']);
        $activityName = $pack['title'] ?? $pack['name'] ?? 'Desert Pack';
    }

    $emailSend = $this->mailer->sendBookingEmail(
        $data['full_name'],
        $data['email'],
        $data['phone_number'],
        $activityName,
        $data['reservation_date'],
        $data['selected_time'],
        $data['duration'],
        $passengers,
        $data['price_per_person'],
        $data['total_price']
    );
    if (!$emailSend) {
        error_log("Booking saved, but email failed.");
    }

    return $code;
}
}