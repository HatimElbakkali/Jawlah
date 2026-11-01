<?php


require_once __DIR__ . '/../../config/config.php';

class employeeModel
{
    public const BOOKING_STATUSES = ['confirmed', 'pending', 'cancelled', 'completed'];
    public const MESSAGE_STATUSES = ['unread', 'read', 'replied'];

    private PDO $connect;

    public function __construct()
    {
        $db = new connectionDB();
        $this->connect = $db->getConnection();
    }
    public function searchBookings(string $q = '', string $type = 'all', string $status = 'all', string $date = ''): array
    {
        $sql = "SELECT
                    b.*,
                    CASE
                        WHEN b.activity_id IS NOT NULL THEN 'activity'
                        ELSE 'pack'
                    END AS booking_type,
                    COALESCE(da.title, dp.title, 'Unknown Excursion') AS item_title
                FROM bookings b
                LEFT JOIN desert_activity da ON b.activity_id = da.id
                LEFT JOIN desert_activities_pack dp ON b.pack_id = dp.id
                WHERE 1 = 1";

        $params = [];

        $q = trim($q);
        if ($q !== '') {
            $like = '%' . addcslashes($q, '%_\\') . '%';
            $sql .= " AND (
                        b.code LIKE :q1
                        OR b.full_name LIKE :q2
                        OR b.email LIKE :q3
                        OR b.phone_number LIKE :q4
                        OR COALESCE(da.title, dp.title, '') LIKE :q5
                    )";
            foreach (['q1', 'q2', 'q3', 'q4', 'q5'] as $key) {
                $params[$key] = $like;
            }
        }

        if ($type === 'activity') {
            $sql .= " AND b.activity_id IS NOT NULL";
        } elseif ($type === 'pack') {
            $sql .= " AND b.activity_id IS NULL";
        }

        if (in_array($status, self::BOOKING_STATUSES, true)) {
            $sql .= " AND b.status = :status";
            $params['status'] = $status;
        }

        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            $sql .= " AND b.reservation_date = :date";
            $params['date'] = $date;
        }

        $sql .= " ORDER BY b.id ASC";

        $stmt = $this->connect->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateBookingStatus(int $id, string $status): bool
    {
        if (!in_array($status, self::BOOKING_STATUSES, true)) {
            throw new InvalidArgumentException('Invalid booking status.');
        }

        $stmt = $this->connect->prepare("UPDATE bookings SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }

    public function deleteBooking(int $id): bool
    {
        $stmt = $this->connect->prepare("DELETE FROM bookings WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getAllMessages(): array
    {
        $stmt = $this->connect->query("SELECT * FROM contact ORDER BY id ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countUnreadMessages(): int
    {
        $stmt = $this->connect->query("SELECT COUNT(*) FROM contact WHERE status = 'unread'");
        return (int) $stmt->fetchColumn();
    }

    public function updateMessageStatus(int $id, string $status): bool
    {
        if (!in_array($status, self::MESSAGE_STATUSES, true)) {
            throw new InvalidArgumentException('Invalid message status.');
        }

        $stmt = $this->connect->prepare("UPDATE contact SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }

    public function deleteMessage(int $id): bool
    {
        $stmt = $this->connect->prepare("DELETE FROM contact WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getAvailabilityCalculated(): array
    {
        $sql = "SELECT
                    b.reservation_date,
                    b.selected_time,
                    b.duration,
                    b.activity_id,
                    b.pack_id,
                    CASE
                        WHEN b.activity_id IS NOT NULL AND b.activity_id != '' THEN 'Activity'
                        ELSE 'Pack'
                    END AS item_type,
                    COALESCE(da.title, dp.title, 'Desert Excursion') AS item_title,
                    COALESCE(da.capacity, dp.capacity, 20) AS total_capacity,
                    COALESCE(da.status, dp.status, 'available') AS item_status,
                    SUM(b.adults + b.children + b.infants) AS total_reserved
                FROM bookings b
                LEFT JOIN desert_activity da ON b.activity_id = da.id
                LEFT JOIN desert_activities_pack dp ON b.pack_id = dp.id
                WHERE b.status != 'cancelled'
                GROUP BY b.reservation_date, b.selected_time, b.duration, b.activity_id, b.pack_id, item_type, item_title, total_capacity, item_status
                ORDER BY b.reservation_date DESC, b.selected_time ASC";

        $stmt = $this->connect->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $result = [];
        foreach ($rows as $row) {
            $capacity   = (int) $row['total_capacity'];
            $reserved   = (int) $row['total_reserved'];
            $remaining  = max(0, $capacity - $reserved);
            $itemStatus = $row['item_status'] ?? 'available';

            $status = ($itemStatus === 'not_available' || $remaining <= 0) ? 'not_available' : 'available';

            $result[] = [
                'date'          => $row['reservation_date'],
                'type'          => $row['item_type'],
                'item_title'    => $row['item_title'],
                'selected_time' => $row['selected_time'],
                'duration'      => $row['duration'] ?: '30 min',
                'capacity'      => $capacity,
                'reserved'      => $reserved,
                'remaining'     => $remaining,
                'status'        => $status
            ];
        }

        return $result;
    }
}