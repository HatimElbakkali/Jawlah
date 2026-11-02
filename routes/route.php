<?php

require_once __DIR__ . '/../app/controllers/tourController.php';
require_once __DIR__ . '/../app/controllers/contactController.php';
require_once __DIR__ . '/../app/controllers/bookingController.php';
require_once __DIR__ . '/../app/controllers/adminController.php';
require_once __DIR__ . '/../app/controllers/employeecontroller.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (str_starts_with($uri, '/public')) {
    $uri = substr($uri, 7);
}

if ($uri === '') {
    $uri = '/';
}

switch ($uri) {

    case '/':
    case '/home.php':
        require __DIR__ . '/../app/views/home/home.php';
        break;

    case '/tour':
        $TourController = new tourController();
        $TourController->showDesertActivity();
        break;

    case '/booking':
        $bookingController = new bookingController();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $bookingController->storeBooking();
        } elseif (isset($_GET['action']) && $_GET['action'] === 'availability') {
            $bookingController->getAvailability();
        } else {
            $bookingController->showInfoTours();
        }
        break;

    case '/booking/availability':
        $bookingController = new bookingController();
        $bookingController->getAvailability();
        break;

    case '/about':
        require __DIR__ . '/../app/views/about/about-us.php';
        break;

    case '/contact':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $contactController = new contactController();
            $contactController->send();
        } else {
            require __DIR__ . '/../app/views/contact/contact-us.php';
        }
        break;


    case '/admin':
        $adminController = new adminController();
        $adminController->dashBoard();
        break;

    case '/admin/login':
        $adminController = new adminController();
        $adminController->login();
        break;

    case '/admin/logout':
        $adminController = new adminController();
        $adminController->logout();
        break;

    case '/admin/activity/create':
        $adminController = new adminController();
        $adminController->createActivity();
        break;

    case '/admin/activity/update':
        $adminController = new adminController();
        $adminController->updateActivity();
        break;

    case '/admin/activity/delete':
        $adminController = new adminController();
        $adminController->deleteActivity();
        break;

    case '/admin/activity/update-status':
        $adminController = new adminController();
        $adminController->updateActivityStatus();
        break;

    case '/admin/pack/create':
        $adminController = new adminController();
        $adminController->createPack();
        break;

    case '/admin/pack/update':
        $adminController = new adminController();
        $adminController->updatePack();
        break;

    case '/admin/pack/delete':
        $adminController = new adminController();
        $adminController->deletePack();
        break;

    case '/admin/pack/update-status':
        $adminController = new adminController();
        $adminController->updatePackStatus();
        break;

    case '/admin/booking/update-status':
        $adminController = new adminController();
        $adminController->updateBookingStatus();
        break;

    case '/admin/booking/delete':
        $adminController = new adminController();
        $adminController->deleteBooking();
        break;

    case '/admin/bookings/search':
        $adminController = new adminController();
        $adminController->searchBookings();
        break;

    case '/admin/message/update-status':
        $adminController = new adminController();
        $adminController->updateMessageStatus();
        break;

    case '/admin/message/delete':
        $adminController = new adminController();
        $adminController->deleteMessage();
        break;


    case '/employee':
        $employeeController = new employeeController();
        $employeeController->dashBoard();
        break;

    case '/employeeLogin':
        $employeeController = new employeeController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $employeeController->login();
        } else {
            $employeeController->showLogin();
        }
        break;

    case '/employee/logout':
        $employeeController = new employeeController();
        $employeeController->logout();
        break;

    case '/employee/bookings/search':
        $employeeController = new employeeController();
        $employeeController->searchBookings();
        break;

    case '/employee/booking/update-status':
        $employeeController = new employeeController();
        $employeeController->updateBookingStatus();
        break;

    case '/employee/booking/delete':
        $employeeController = new employeeController();
        $employeeController->deleteBooking();
        break;

    case '/employee/message/update-status':
        $employeeController = new employeeController();
        $employeeController->updateMessageStatus();
        break;

    case '/employee/message/delete':
        $employeeController = new employeeController();
        $employeeController->deleteMessage();
        break;


    case '/adminLogin':
        require __DIR__ . '/../authentication/AdminLogin.php';
        break;

    default:
        http_response_code(404);
        echo "Page not found";
        break;
}