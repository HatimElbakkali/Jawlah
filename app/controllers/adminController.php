<?php

require_once __DIR__ . '/../models/adminModel.php';

class adminController
{
    private adminModel $adminModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->adminModel = new adminModel();
    }

    private function requireAuth(): void
    {
        if (empty($_SESSION['admin_logged_in'])) {
            header('Location: /public/login');
            exit;
        }
    }

    public function dashBoard(): void
    {
        $this->requireAuth();

        $totalBookings = $this->adminModel->totalBookings();
        $totalRevenue = $this->adminModel->totalRevenue();
        $totalDeserActivities = $this->adminModel->totalDesertActivities();
        $totalDesertPack = $this->adminModel->totalDesertPack();
        $totalMessages = $this->adminModel->totalMessages();

        $recentBookings = $this->adminModel->recentBookings(5);
        $allBookings = $this->adminModel->getAllBookings();
        $allActivities = $this->adminModel->getAllActivities();
        $allPacks = $this->adminModel->getAllPacks();
        $allMessages = $this->adminModel->getAllMessages();
        $availabilityData = $this->adminModel->getAvailabilityCalculated();

        require_once __DIR__ . "/../views/admin/admin.php";
    }

    public function login(): void
    {
        header('Content-Type: application/json');

        try {
            $input = json_decode(file_get_contents('php://input'), true);
            $username = trim($input['username'] ?? $_POST['username'] ?? '');
            $password = trim($input['password'] ?? $_POST['password'] ?? '');

            if (empty($username) || empty($password)) {
                throw new Exception('Please enter both username and password.');
            }

            if ($username === 'hatim' && $password === 'hatimelbakkali12345') {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_user'] = $username;

                echo json_encode([
                    'success' => true,
                    'message' => 'Login successful.',
                    'redirect' => '/public/admin'
                ]);
                exit;
            } else {
                throw new Exception('Invalid username or password.');
            }
        } catch (Throwable $e) {
            http_response_code(401);
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
            exit;
        }
    }

    public function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = [];
        session_destroy();
        header('Location: /public/login');
        exit;
    }

    private function handleFileUpload(array $fileInfo, string $subfolder): ?string
    {
        if (empty($fileInfo['name']) || ($fileInfo['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            return null;
        }

        $allowedExts = ['jpg', 'jpeg', 'png', 'webp', 'svg'];
        $fileExt = strtolower(pathinfo($fileInfo['name'], PATHINFO_EXTENSION));

        if (!in_array($fileExt, $allowedExts, true)) {
            throw new Exception("Invalid file type (.$fileExt). Allowed formats: " . implode(', ', $allowedExts));
        }

        $uploadDir = __DIR__ . '/../../public/assets/uploads/' . trim($subfolder, '/') . '/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $sanitizedBase = preg_replace('/[^a-zA-Z0-9_-]/', '', pathinfo($fileInfo['name'], PATHINFO_FILENAME));
        if (empty($sanitizedBase)) {
            $sanitizedBase = 'asset';
        }
        $uniqueFilename = $sanitizedBase . '_' . uniqid() . '.' . $fileExt;
        $targetPath = $uploadDir . $uniqueFilename;

        if (!move_uploaded_file($fileInfo['tmp_name'], $targetPath)) {
            throw new Exception('Failed to move uploaded file.');
        }

        return '/public/assets/uploads/' . trim($subfolder, '/') . '/' . $uniqueFilename;
    }

    public function createActivity(): void
    {
        $this->requireAuth();
        header('Content-Type: application/json');

        try {
            $input = $_POST;
            if (empty($input)) {
                $input = json_decode(file_get_contents('php://input'), true) ?? [];
            }

            if (empty($input['title']) || empty($input['price'])) {
                throw new Exception('Title and price are required.');
            }

            if (!empty($_FILES['image_file']['name'])) {
                $uploadedImage = $this->handleFileUpload($_FILES['image_file'], 'images');
                if ($uploadedImage) {
                    $input['image'] = $uploadedImage;
                }
            } elseif (!empty($_FILES['image']['name'])) {
                $uploadedImage = $this->handleFileUpload($_FILES['image'], 'images');
                if ($uploadedImage) {
                    $input['image'] = $uploadedImage;
                }
            }

            if (!empty($_FILES['icon_file']['name'])) {
                $uploadedIcon = $this->handleFileUpload($_FILES['icon_file'], 'icons');
                if ($uploadedIcon) {
                    $input['icon_title'] = $uploadedIcon;
                }
            } elseif (!empty($_FILES['icon_title']['name'])) {
                $uploadedIcon = $this->handleFileUpload($_FILES['icon_title'], 'icons');
                if ($uploadedIcon) {
                    $input['icon_title'] = $uploadedIcon;
                }
            }

            $success = $this->adminModel->createActivity($input);
            echo json_encode([
                'success' => $success,
                'message' => $success ? 'Activity added successfully.' : 'Failed to create activity.'
            ]);
        } catch (Throwable $e) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }

    public function updateActivity(): void
    {
        $this->requireAuth();
        header('Content-Type: application/json');

        try {
            $input = $_POST;
            if (empty($input)) {
                $input = json_decode(file_get_contents('php://input'), true) ?? [];
            }

            $id = $input['id'] ?? null;
            if (!$id) {
                throw new Exception('Activity ID is missing.');
            }

            if (!empty($_FILES['image_file']['name'])) {
                $uploadedImage = $this->handleFileUpload($_FILES['image_file'], 'images');
                if ($uploadedImage) {
                    $input['image'] = $uploadedImage;
                }
            } elseif (!empty($_FILES['image']['name'])) {
                $uploadedImage = $this->handleFileUpload($_FILES['image'], 'images');
                if ($uploadedImage) {
                    $input['image'] = $uploadedImage;
                }
            }

            if (!empty($_FILES['icon_file']['name'])) {
                $uploadedIcon = $this->handleFileUpload($_FILES['icon_file'], 'icons');
                if ($uploadedIcon) {
                    $input['icon_title'] = $uploadedIcon;
                }
            } elseif (!empty($_FILES['icon_title']['name'])) {
                $uploadedIcon = $this->handleFileUpload($_FILES['icon_title'], 'icons');
                if ($uploadedIcon) {
                    $input['icon_title'] = $uploadedIcon;
                }
            }

            $success = $this->adminModel->updateActivity($id, $input);
            echo json_encode([
                'success' => $success,
                'message' => $success ? 'Activity updated successfully.' : 'Failed to update activity.'
            ]);
        } catch (Throwable $e) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }

    public function deleteActivity(): void
    {
        $this->requireAuth();
        header('Content-Type: application/json');

        try {
            $input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
            $id = $input['id'] ?? null;

            if (!$id) {
                throw new Exception('Activity ID is missing.');
            }

            $success = $this->adminModel->deleteActivity($id);
            echo json_encode([
                'success' => $success,
                'message' => $success ? 'Activity deleted successfully.' : 'Failed to delete activity.'
            ]);
        } catch (Throwable $e) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }

    public function updateActivityStatus(): void
    {
        $this->requireAuth();
        header('Content-Type: application/json');

        try {
            $input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
            $id = $input['id'] ?? null;
            $status = trim($input['status'] ?? '');

            if (!$id || !$status) {
                throw new Exception('Activity ID and status are required.');
            }

            $success = $this->adminModel->updateActivityStatus($id, $status);
            echo json_encode([
                'success' => $success,
                'message' => $success ? 'Activity status updated.' : 'Failed to update activity status.'
            ]);
        } catch (Throwable $e) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }

    public function createPack(): void
    {
        $this->requireAuth();
        header('Content-Type: application/json');

        try {
            $input = $_POST;
            if (empty($input)) {
                $input = json_decode(file_get_contents('php://input'), true) ?? [];
            }

            if (empty($input['title']) || empty($input['price'])) {
                throw new Exception('Title and price are required.');
            }

            if (!empty($_FILES['image_file']['name'])) {
                $uploadedImage = $this->handleFileUpload($_FILES['image_file'], 'images');
                if ($uploadedImage) {
                    $input['image'] = $uploadedImage;
                }
            } elseif (!empty($_FILES['image']['name'])) {
                $uploadedImage = $this->handleFileUpload($_FILES['image'], 'images');
                if ($uploadedImage) {
                    $input['image'] = $uploadedImage;
                }
            }

            $success = $this->adminModel->createPack($input);
            echo json_encode([
                'success' => $success,
                'message' => $success ? 'Pack added successfully.' : 'Failed to create pack.'
            ]);
        } catch (Throwable $e) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }

    public function updatePack(): void
    {
        $this->requireAuth();
        header('Content-Type: application/json');

        try {
            $input = $_POST;
            if (empty($input)) {
                $input = json_decode(file_get_contents('php://input'), true) ?? [];
            }

            $id = $input['id'] ?? null;
            if (!$id) {
                throw new Exception('Pack ID is missing.');
            }

            if (!empty($_FILES['image_file']['name'])) {
                $uploadedImage = $this->handleFileUpload($_FILES['image_file'], 'images');
                if ($uploadedImage) {
                    $input['image'] = $uploadedImage;
                }
            } elseif (!empty($_FILES['image']['name'])) {
                $uploadedImage = $this->handleFileUpload($_FILES['image'], 'images');
                if ($uploadedImage) {
                    $input['image'] = $uploadedImage;
                }
            }

            $success = $this->adminModel->updatePack($id, $input);
            echo json_encode([
                'success' => $success,
                'message' => $success ? 'Pack updated successfully.' : 'Failed to update pack.'
            ]);
        } catch (Throwable $e) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }

    public function updatePackStatus(): void
    {
        $this->requireAuth();
        header('Content-Type: application/json');

        try {
            $input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
            $id = $input['id'] ?? null;
            $status = trim($input['status'] ?? '');

            if (!$id || !$status) {
                throw new Exception('Pack ID and status are required.');
            }

            $success = $this->adminModel->updatePackStatus($id, $status);
            echo json_encode([
                'success' => $success,
                'message' => $success ? 'Pack status updated.' : 'Failed to update pack status.'
            ]);
        } catch (Throwable $e) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }

    public function deletePack(): void
    {
        $this->requireAuth();
        header('Content-Type: application/json');

        try {
            $input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
            $id = $input['id'] ?? null;

            if (!$id) {
                throw new Exception('Pack ID is missing.');
            }

            $success = $this->adminModel->deletePack($id);
            echo json_encode([
                'success' => $success,
                'message' => $success ? 'Pack deleted successfully.' : 'Failed to delete pack.'
            ]);
        } catch (Throwable $e) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }

    public function searchBookings(): void
    {
        $this->requireAuth();
        header('Content-Type: application/json');

        try {
            $q = trim($_GET['q'] ?? '');
            $type = $_GET['type'] ?? 'all';
            $status = $_GET['status'] ?? 'all';
            $date = $_GET['date'] ?? '';

            $allBookings = $this->adminModel->searchBookings($q, $type, $status, $date);

            ob_start();
            require __DIR__ . '/../views/admin/partial/bookingRows.php';
            $html = ob_get_clean();

            echo json_encode([
                'success' => true,
                'count' => count($allBookings),
                'html' => $html
            ]);
        } catch (Throwable $e) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }

    public function updateBookingStatus(): void
    {
        $this->requireAuth();
        header('Content-Type: application/json');

        try {
            $input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
            $id = (int) ($input['id'] ?? 0);
            $status = trim($input['status'] ?? '');

            if (!$id || !$status) {
                throw new Exception('Invalid parameters.');
            }

            $success = $this->adminModel->updateBookingStatus($id, $status);
            echo json_encode([
                'success' => $success,
                'message' => $success ? 'Booking status updated.' : 'Failed to update booking status.'
            ]);
        } catch (Throwable $e) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }

    public function deleteBooking(): void
    {
        $this->requireAuth();
        header('Content-Type: application/json');

        try {
            $input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
            $id = (int) ($input['id'] ?? 0);

            if (!$id) {
                throw new Exception('Booking ID is missing.');
            }

            $success = $this->adminModel->deleteBooking($id);
            echo json_encode([
                'success' => $success,
                'message' => $success ? 'Booking deleted.' : 'Failed to delete booking.'
            ]);
        } catch (Throwable $e) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }

    public function updateMessageStatus(): void
    {
        $this->requireAuth();
        header('Content-Type: application/json');

        try {
            $input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
            $id = (int) ($input['id'] ?? 0);
            $status = trim($input['status'] ?? 'read');

            if (!$id) {
                throw new Exception('Message ID is missing.');
            }

            $success = $this->adminModel->updateMessageStatus($id, $status);
            echo json_encode([
                'success' => $success,
                'message' => $success ? 'Message status updated.' : 'Failed to update status.'
            ]);
        } catch (Throwable $e) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }

    public function deleteMessage(): void
    {
        $this->requireAuth();
        header('Content-Type: application/json');

        try {
            $input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
            $id = (int) ($input['id'] ?? 0);

            if (!$id) {
                throw new Exception('Message ID is missing.');
            }

            $success = $this->adminModel->deleteMessage($id);
            echo json_encode([
                'success' => $success,
                'message' => $success ? 'Message deleted.' : 'Failed to delete message.'
            ]);
        } catch (Throwable $e) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }
}