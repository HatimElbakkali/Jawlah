<?php


require_once __DIR__ . '/../models/employeemodel.php';

class employeeController
{
    private const USERS = [
        'employee' => 'CHANGE_ME_123',
    ];

    private employeeModel $employeeModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->employeeModel = new employeeModel();
    }
    
    private function requireAuth(bool $json = false): void
    {
        if (!empty($_SESSION['employee_logged_in'])) {
            return;
        }

        if ($json) {
            http_response_code(401);
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Session expired. Please log in again.'
            ]);
        } else {
            header('Location: /public/employee/login');
        }
        exit;
    }

    private function requirePost(): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
            http_response_code(405);
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
            exit;
        }
    }

    private function jsonInput(): array
    {
        $input = json_decode(file_get_contents('php://input'), true);
        return is_array($input) ? $input : $_POST;
    }

    private function respond(array $payload, int $code = 200): void
    {
        http_response_code($code);
        echo json_encode($payload);
        exit;
    }

    public function showLogin(): void
    {
        if (!empty($_SESSION['employee_logged_in'])) {
            header('Location: /public/employee');
            exit;
        }

        require __DIR__ . '/../views/EmployeeDashboard/employeeLogin.php';
    }

    public function login(): void
    {
        $this->requirePost();
        header('Content-Type: application/json');

        try {
            $input    = $this->jsonInput();
            $username = trim($input['username'] ?? '');
            $password = trim($input['password'] ?? '');

            if ($username === '' || $password === '') {
                throw new InvalidArgumentException('Please enter both username and password.');
            }

            $expected = self::USERS[$username] ?? null;

            if ($expected === null || !hash_equals($expected, $password)) {
                $this->respond(['success' => false, 'message' => 'Invalid username or password.'], 401);
            }

            session_regenerate_id(true);
            $_SESSION['employee_logged_in'] = true;
            $_SESSION['employee_user']      = $username;

            $this->respond([
                'success'  => true,
                'message'  => 'Login successful.',
                'redirect' => '/public/employee'
            ]);
        } catch (Throwable $e) {
            $this->respond(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function logout(): void
    {
        unset($_SESSION['employee_logged_in'], $_SESSION['employee_user']);
        session_regenerate_id(true);

        header('Location: /public/employee/login');
        exit;
    }

    public function dashBoard(): void
    {
        $this->requireAuth();

        $employeeName     = $_SESSION['employee_user'] ?? 'Employee';
        $allBookings      = $this->employeeModel->searchBookings();
        $allMessages      = $this->employeeModel->getAllMessages();
        $availabilityData = $this->employeeModel->getAvailabilityCalculated();
        $unreadCount      = $this->employeeModel->countUnreadMessages();

        require __DIR__ . '/../views/EmployeeDashboard/employee.php';
    }

    public function searchBookings(): void
    {
        $this->requireAuth(true);
        header('Content-Type: application/json');

        $obLevel = ob_get_level();

        try {
            $q      = trim($_GET['q'] ?? '');
            $type   = $_GET['type'] ?? 'all';
            $status = $_GET['status'] ?? 'all';
            $date   = $_GET['date'] ?? '';

            $allBookings = $this->employeeModel->searchBookings($q, $type, $status, $date);

            $viewPath = __DIR__ . '/../views/EmployeeDashboard/partial/employeebookingrows.php';
            if (!is_file($viewPath)) {
                throw new RuntimeException('View not found: ' . $viewPath);
            }

            ob_start();
            require $viewPath;
            $html = ob_get_clean();

            $this->respond([
                'success' => true,
                'count'   => count($allBookings),
                'html'    => $html
            ]);
        } catch (Throwable $e) {
            while (ob_get_level() > $obLevel) {
                ob_end_clean();
            }
            $this->respond(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function updateBookingStatus(): void
    {
        $this->requireAuth(true);
        $this->requirePost();
        header('Content-Type: application/json');

        try {
            $input  = $this->jsonInput();
            $id     = (int) ($input['id'] ?? 0);
            $status = trim($input['status'] ?? '');

            if ($id <= 0) {
                throw new InvalidArgumentException('Booking ID is missing.');
            }

            $ok = $this->employeeModel->updateBookingStatus($id, $status);
            $this->respond([
                'success' => $ok,
                'message' => $ok ? 'Booking status updated.' : 'Failed to update booking status.'
            ]);
        } catch (Throwable $e) {
            $this->respond(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function deleteBooking(): void
    {
        $this->requireAuth(true);
        $this->requirePost();
        header('Content-Type: application/json');

        try {
            $id = (int) ($this->jsonInput()['id'] ?? 0);
            if ($id <= 0) {
                throw new InvalidArgumentException('Booking ID is missing.');
            }

            $ok = $this->employeeModel->deleteBooking($id);
            $this->respond([
                'success' => $ok,
                'message' => $ok ? 'Booking deleted.' : 'Failed to delete booking.'
            ]);
        } catch (Throwable $e) {
            $this->respond(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function updateMessageStatus(): void
    {
        $this->requireAuth(true);
        $this->requirePost();
        header('Content-Type: application/json');

        try {
            $input  = $this->jsonInput();
            $id     = (int) ($input['id'] ?? 0);
            $status = trim($input['status'] ?? 'read');

            if ($id <= 0) {
                throw new InvalidArgumentException('Message ID is missing.');
            }

            $ok = $this->employeeModel->updateMessageStatus($id, $status);
            $this->respond([
                'success' => $ok,
                'message' => $ok ? 'Message status updated.' : 'Failed to update message status.'
            ]);
        } catch (Throwable $e) {
            $this->respond(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function deleteMessage(): void
    {
        $this->requireAuth(true);
        $this->requirePost();
        header('Content-Type: application/json');

        try {
            $id = (int) ($this->jsonInput()['id'] ?? 0);
            if ($id <= 0) {
                throw new InvalidArgumentException('Message ID is missing.');
            }

            $ok = $this->employeeModel->deleteMessage($id);
            $this->respond([
                'success' => $ok,
                'message' => $ok ? 'Message deleted.' : 'Failed to delete message.'
            ]);
        } catch (Throwable $e) {
            $this->respond(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }
}