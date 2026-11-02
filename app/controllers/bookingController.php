<?php
require_once __DIR__ . "/../models/bookingModel.php";
require_once __DIR__ . "/../services/bookingMailer.php";

class bookingController
{
    private bookingModel $bookingModel;

    public function __construct()
    {
        $this->bookingModel = new bookingModel();
    }

    public function showInfoTours()
    {
        $id = $_GET['id'] ?? null;
        $type = $_GET['type'] ?? null;

        if ($type === "activity") {
            $showInfoActivities = $this->bookingModel->getInfoActivities($id) ?? null;
        } elseif ($type === "pack") {
            $showInfoPack = $this->bookingModel->getInfoPack($id) ?? null;
        }

        $bookingInfo = $type === 'pack' ? ($showInfoPack ?? null) : ($showInfoActivities ?? null);
        if (!$bookingInfo || ($bookingInfo['status'] ?? 'available') !== 'available') {
            header('Location: /public/tour');
            exit;
        }

        require_once __DIR__ . '/../views/booking/booking.php';
    }

    public function getAvailability()
    {
        header('Content-Type: application/json');

        try {
            $type = $_GET['type'] ?? null;
            $id = $_GET['id'] ?? null;
            $rawDate = $_GET['date'] ?? null;

            if (!$type || !$id || !$rawDate) {
                throw new Exception("Missing required parameters: type, id, date.");
            }

            $date = date('Y-m-d', strtotime($rawDate));

            if ($type === 'pack') {
                $item = $this->bookingModel->getInfoPack($id);
            } else {
                $item = $this->bookingModel->getInfoActivities($id);
            }

            if (!$item || ($item['status'] ?? 'available') !== 'available') {
                throw new Exception("Item is currently unavailable.");
            }

            $capacity = (int) ($item['capacity'] ?? 30);
            $bookings = $this->bookingModel->getBookingsByDate($type, $id, $date);

            echo json_encode([
                "success" => true,
                "capacity" => $capacity,
                "bookings" => $bookings
            ]);

        } catch (Throwable $e) {
            http_response_code(400);
            echo json_encode([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
        exit;
    }

    public function storeBooking()
    {
        header('Content-Type: application/json');

        try {
            $data = json_decode(file_get_contents("php://input"), true);

            if (!$data) {
                throw new Exception("Invalid booking data.");
            }

            $type = $data['type'] ?? null;
            $id = $data['idTour'] ?? $data['id'] ?? null;
            $rawDate = $data['date'] ?? null;
            $selectedTime = $data['time'] ?? $data['selected_time'] ?? null;
            $duration = $data['duration'] ?? '30 min';
            $adults = (int) ($data['adults'] ?? 1);
            $children = (int) ($data['children'] ?? 0);
            $infants = (int) ($data['infants'] ?? 0);
            $fullName = trim($data['full_name'] ?? '');
            $email = trim($data['email'] ?? '');
            $phone = trim($data['phone'] ?? $data['phone_number'] ?? '');

            if (!$type || !$id || !$rawDate || !$selectedTime || !$fullName || !$email || !$phone) {
                throw new Exception("All required booking fields must be filled out.");
            }

            $reservationDate = date('Y-m-d', strtotime($rawDate));

            if ($type === 'pack') {
                $item = $this->bookingModel->getInfoPack($id);
            } else {
                $item = $this->bookingModel->getInfoActivities($id);
            }

            if (!$item || ($item['status'] ?? 'available') !== 'available') {
                throw new Exception("Selected activity or pack is currently not available for booking.");
            }

            $capacity = (int) ($item['capacity'] ?? 30);
            $basePrice = (float) ($item['price'] ?? 0);

            $durationMinutes = (int) filter_var($duration, FILTER_SANITIZE_NUMBER_INT);
            if ($durationMinutes <= 0) $durationMinutes = 30;

            $pricePerPerson = ($durationMinutes === 60 && $type !== 'pack') ? $basePrice * 2 : $basePrice;
            $childPrice = $pricePerPerson / 2;
            $totalPrice = ($adults * $pricePerPerson) + ($children * $childPrice);

            $newParticipants = $adults + $children + $infants;
            if ($newParticipants <= 0) {
                throw new Exception("At least one participant is required.");
            }

            $existingBookings = $this->bookingModel->getBookingsByDate($type, $id, $reservationDate);
            $newStart = $this->parseTimeToMinutes($selectedTime);
            for ($t = $newStart; $t < $newStart + $durationMinutes; $t += 30) {
                $occupied = 0;
                foreach ($existingBookings as $b) {
                    $bStart = $this->parseTimeToMinutes($b['selected_time'] ?? '');
                    $bDur = (int) filter_var($b['duration'] ?? '30 min', FILTER_SANITIZE_NUMBER_INT);
                    if ($bDur <= 0) $bDur = 30;
                    $bEnd = $bStart + $bDur;

                    if ($bStart < $t + 30 && $bEnd > $t) {
                        $occupied += ((int)$b['adults'] + (int)$b['children'] + (int)$b['infants']);
                    }
                }

                if ($occupied + $newParticipants > $capacity) {
                    echo json_encode([
                        "success" => false,
                        "message" => "This time slot is no longer available."
                    ]);
                    exit;
                }
            }

            $activityId = ($type === 'activity') ? $id : null;
            $packId = ($type === 'pack') ? $id : null;

            $code = $this->bookingModel->createBooking([
                'activity_id' => $activityId,
                'pack_id' => $packId,
                'full_name' => $fullName,
                'phone_number' => $phone,
                'email' => $email,
                'reservation_date' => $reservationDate,
                'adults' => $adults,
                'children' => $children,
                'infants' => $infants,
                'duration' => $duration,
                'price_per_person' => $pricePerPerson,
                'total_price' => $totalPrice,
                'selected_time' => $selectedTime
            ]);

            if (!$code) {
                throw new Exception("Failed to record booking. Please try again.");
            }

            try {
                $itemName = $item['name']
                    ?? $item['title']
                    ?? $item['activity_name']
                    ?? $item['pack_name']
                    ?? 'Activity';

                $mailer = new bookingMailer();
                $mailer->sendBookingEmail(
                    $fullName,
                    $email,
                    $phone,
                    (string) $itemName,
                    $reservationDate,
                    (string) $selectedTime,
                    (string) $duration,
                    $newParticipants,
                    (float) $pricePerPerson,
                    (float) $totalPrice,
                    (string) $code
                );
            } catch (Throwable $mailError) {
                error_log('Booking email failed: ' . $mailError->getMessage());
            }

            echo json_encode([
                "success" => true,
                "message" => "Booking confirmed successfully!",
                "code" => $code
            ]);
        } catch (Throwable $e) {
            http_response_code(400);
            echo json_encode([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
        exit;
    }

    private function parseTimeToMinutes(string $timeStr): int
    {
        $timestamp = strtotime($timeStr);
        if ($timestamp === false) {
            return 0;
        }
        return ((int) date('H', $timestamp)) * 60 + ((int) date('i', $timestamp));
    }
}