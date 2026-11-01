<?php

require_once __DIR__ . '/../../config/config.php';

class adminModel
{
    private PDO $connect;

    public function __construct()
    {
        $db = new connectionDB();
        $this->connect = $db->getConnection();
    }

    public function totalBookings(): array
    {
        $stmt = $this->connect->query("SELECT COUNT(*) as totalBookings FROM `bookings`");
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res ?: ['totalBookings' => 0];
    }

    public function totalRevenue(): array
    {
        $stmt = $this->connect->query("SELECT COALESCE(SUM(total_price), 0) as totalPrice FROM `bookings`");
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res ?: ['totalPrice' => 0];
    }

    public function totalDesertActivities(): array
    {
        $stmt = $this->connect->query("SELECT COUNT(*) as totalDesertActivities FROM `desert_activity`");
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res ?: ['totalDesertActivities' => 0];
    }

    public function totalDesertPack(): array
    {
        $stmt = $this->connect->query("SELECT COUNT(*) as totalDesertPack FROM `desert_activities_pack`");
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res ?: ['totalDesertPack' => 0];
    }

    public function totalMessages(): array
    {
        $stmt = $this->connect->query("SELECT COUNT(*) as totalMessages FROM `contact`");
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res ?: ['totalMessages' => 0];
    }

    public function recentBookings(int $limit = 5): array
    {
        $sql = "SELECT
                    b.*,
                    CASE WHEN b.activity_id IS NOT NULL THEN 'activity'
                        ELSE 'pack'
                    END as booking_type,
                    COALESCE(da.title, dp.title, 'Unknown Excursion') as activity_nom
                FROM bookings b
                LEFT JOIN desert_activity da ON b.activity_id = da.id
                LEFT JOIN desert_activities_pack dp ON b.pack_id = dp.id
                ORDER BY b.id ASC
                LIMIT :limit";

        $stmt = $this->connect->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllBookings(): array
    {
        return $this->searchBookings();
    }


    public function searchBookings(string $q = '', string $type = 'all', string $status = 'all', string $date = ''): array
    {
        $sql = "SELECT
                    b.*,
                    CASE
                        WHEN b.activity_id IS NOT NULL THEN 'activity'
                        ELSE 'pack'
                    END as booking_type,
                    COALESCE(da.title, dp.title, 'Unknown Excursion') as item_title
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

        if (in_array($status, ['confirmed', 'pending', 'cancelled', 'completed'], true)) {
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
        $stmt = $this->connect->prepare("UPDATE bookings SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }

    public function deleteBooking(int $id): bool
    {
        $stmt = $this->connect->prepare("DELETE FROM bookings WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getAllActivities(): array
    {
        $stmt = $this->connect->query("SELECT * FROM desert_activity ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getActivityById(string $id): ?array
    {
        $stmt = $this->connect->prepare("SELECT * FROM desert_activity WHERE id = ?");
        $stmt->execute([$id]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res ?: null;
    }

    public function createActivity(array $data): bool
    {
        $uuid = $data['id'] ?? sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );

        $icon = !empty($data['icon_title']) ? $data['icon_title'] : (!empty($data['icon']) ? $data['icon'] : '/public/assets/Icons/camel.png');
        $image = !empty($data['image']) ? $data['image'] : '/public/assets/Images/Camel.webp';
        $status = in_array($data['status'] ?? '', ['available', 'not_available'], true) ? $data['status'] : 'available';

        $sql = "INSERT INTO desert_activity
                (id, title, icon_title, description, location, age_restriction, accompanied, price, capacity, image, status, created_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

        $stmt = $this->connect->prepare($sql);
        return $stmt->execute([
            $uuid,
            $data['title'] ?? '',
            $icon,
            $data['description'] ?? '',
            $data['location'] ?? '',
            $data['age_restriction'] ?? '',
            $data['accompanied'] ?? '',
            (float) ($data['price'] ?? 0),
            (int) ($data['capacity'] ?? 20),
            $image,
            $status
        ]);
    }

    public function updateActivity(string $id, array $data): bool
    {
        $current = $this->getActivityById($id);
        if (!$current) {
            return false;
        }

        $icon = isset($data['icon_title']) ? $data['icon_title'] : (isset($data['icon']) ? $data['icon'] : $current['icon_title']);
        $image = isset($data['image']) ? $data['image'] : $current['image'];
        $status = in_array($data['status'] ?? '', ['available', 'not_available'], true) ? $data['status'] : ($current['status'] ?? 'available');

        $sql = "UPDATE desert_activity
                SET title = ?, icon_title = ?, description = ?, location = ?, age_restriction = ?, accompanied = ?, price = ?, capacity = ?, image = ?, status = ?
                WHERE id = ?";

        $stmt = $this->connect->prepare($sql);
        return $stmt->execute([
            $data['title'] ?? $current['title'],
            $icon,
            $data['description'] ?? $current['description'],
            $data['location'] ?? $current['location'],
            $data['age_restriction'] ?? $current['age_restriction'],
            $data['accompanied'] ?? $current['accompanied'],
            (float) ($data['price'] ?? $current['price']),
            (int) ($data['capacity'] ?? $current['capacity']),
            $image,
            $status,
            $id
        ]);
    }

    public function updateActivityStatus(string $id, string $status): bool
    {
        $validStatus = in_array($status, ['available', 'not_available'], true) ? $status : 'available';
        $stmt = $this->connect->prepare("UPDATE desert_activity SET status = ? WHERE id = ?");
        return $stmt->execute([$validStatus, $id]);
    }

    public function deleteActivity(string $id): bool
    {
        $stmt = $this->connect->prepare("DELETE FROM desert_activity WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getAllPacks(): array
    {
        $stmt = $this->connect->query("SELECT * FROM desert_activities_pack ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPackById(string $id): ?array
    {
        $stmt = $this->connect->prepare("SELECT * FROM desert_activities_pack WHERE id = ?");
        $stmt->execute([$id]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res ?: null;
    }

    public function createPack(array $data): bool
    {
        $uuid = $data['id'] ?? sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );

        $image = !empty($data['image']) ? $data['image'] : '/public/assets/Images/pack.webp';
        $status = in_array($data['status'] ?? '', ['available', 'not_available'], true) ? $data['status'] : 'available';

        $sql = "INSERT INTO desert_activities_pack
                (id, title, description, location, age_restriction, accompanied, price, capacity, image, status, created_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

        $stmt = $this->connect->prepare($sql);
        return $stmt->execute([
            $uuid,
            $data['title'] ?? '',
            $data['description'] ?? '',
            $data['location'] ?? '',
            $data['age_restriction'] ?? '',
            $data['accompanied'] ?? '',
            (float) ($data['price'] ?? 0),
            (int) ($data['capacity'] ?? 15),
            $image,
            $status
        ]);
    }

    public function updatePack(string $id, array $data): bool
    {
        $current = $this->getPackById($id);
        if (!$current) {
            return false;
        }

        $image = isset($data['image']) ? $data['image'] : $current['image'];
        $status = in_array($data['status'] ?? '', ['available', 'not_available'], true) ? $data['status'] : ($current['status'] ?? 'available');

        $sql = "UPDATE desert_activities_pack
                SET title = ?, description = ?, location = ?, age_restriction = ?, accompanied = ?, price = ?, capacity = ?, image = ?, status = ?
                WHERE id = ?";

        $stmt = $this->connect->prepare($sql);
        return $stmt->execute([
            $data['title'] ?? $current['title'],
            $data['description'] ?? $current['description'],
            $data['location'] ?? $current['location'],
            $data['age_restriction'] ?? $current['age_restriction'],
            $data['accompanied'] ?? $current['accompanied'],
            (float) ($data['price'] ?? $current['price']),
            (int) ($data['capacity'] ?? $current['capacity']),
            $image,
            $status,
            $id
        ]);
    }

    public function updatePackStatus(string $id, string $status): bool
    {
        $validStatus = in_array($status, ['available', 'not_available'], true) ? $status : 'available';
        $stmt = $this->connect->prepare("UPDATE desert_activities_pack SET status = ? WHERE id = ?");
        return $stmt->execute([$validStatus, $id]);
    }

    public function deletePack(string $id): bool
    {
        $stmt = $this->connect->prepare("DELETE FROM desert_activities_pack WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getAllMessages(): array
    {
        $stmt = $this->connect->query("SELECT * FROM contact ORDER BY id ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateMessageStatus(int $id, string $status): bool
    {
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
                    END as item_type,
                    COALESCE(da.title, dp.title, 'Desert Excursion') as item_title,
                    COALESCE(da.capacity, dp.capacity, 20) as total_capacity,
                    COALESCE(da.status, dp.status, 'available') as item_status,
                    SUM(b.adults + b.children + b.infants) as total_reserved
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
            $capacity = (int) $row['total_capacity'];
            $reserved = (int) $row['total_reserved'];
            $remaining = max(0, $capacity - $reserved);
            $itemStatus = $row['item_status'] ?? 'available';

            $status = ($itemStatus === 'not_available' || $remaining <= 0) ? 'not_available' : 'available';

            $result[] = [
                'date' => $row['reservation_date'],
                'type' => $row['item_type'],
                'item_title' => $row['item_title'],
                'selected_time' => $row['selected_time'],
                'duration' => $row['duration'] ?: '30 min',
                'capacity' => $capacity,
                'reserved' => $reserved,
                'remaining' => $remaining,
                'status' => $status
            ];
        }

        return $result;
    }

}