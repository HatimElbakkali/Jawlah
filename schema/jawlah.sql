-- JAWLAH Database Schema
-- Clean version for GitHub

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

SET NAMES utf8mb4;

-- --------------------------------------------------------
-- Database: jawlah
-- --------------------------------------------------------

-- ========================================================
-- BOOKINGS
-- ========================================================

CREATE TABLE `bookings` (
    `id` int(11) NOT NULL,
    `code` varchar(10)
    `activity_id` char(36) DEFAULT NULL,
    `pack_id` char(36) DEFAULT NULL,
    `full_name` varchar(150) NOT NULL,
    `phone_number` varchar(20) NOT NULL,
    `email` varchar(150) NOT NULL,
    `reservation_date` date NOT NULL,
    `adults` int(11) NOT NULL DEFAULT 0,
    `children` int(11) NOT NULL DEFAULT 0,
    `infants` int(11) NOT NULL DEFAULT 0,
    `duration` varchar(50) DEFAULT NULL,
    `selected_time` varchar(20) NOT NULL,
    `price_per_person` decimal(10,2) NOT NULL,
    `total_price` decimal(10,2) NOT NULL,
    `created_at` datetime DEFAULT current_timestamp(),
    `status` enum(
        'confirmed',
        'pending',
        'cancelled',
        'completed'
    ) NOT NULL DEFAULT 'confirmed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- ========================================================
-- CONTACT
-- ========================================================

CREATE TABLE `contact` (
    `id` int(10) UNSIGNED NOT NULL,
    `name` varchar(100) NOT NULL,
    `email` varchar(255) NOT NULL,
    `phone` varchar(30) DEFAULT NULL,
    `subject` varchar(255) NOT NULL,
    `message` text NOT NULL,
    `status` enum(
        'unread',
        'read',
        'replied'
    ) NOT NULL DEFAULT 'unread',
    `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- ========================================================
-- DESERT ACTIVITIES PACK
-- ========================================================

CREATE TABLE `desert_activities_pack` (
    `id` char(36) NOT NULL DEFAULT uuid(),
    `title` varchar(255) NOT NULL,
    `image` varchar(255) NOT NULL,
    `description` text NOT NULL,
    `location` varchar(255) NOT NULL,
    `age_restriction` varchar(100) NOT NULL,
    `accompanied` varchar(255) NOT NULL,
    `price` decimal(10,2) NOT NULL,
    `created_at` datetime DEFAULT current_timestamp(),
    `capacity` int(11) NOT NULL,
    `status` enum(
        'available',
        'not_available'
    ) NOT NULL DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Demo Pack

INSERT INTO `desert_activities_pack`
(
    `id`,
    `title`,
    `image`,
    `description`,
    `location`,
    `age_restriction`,
    `accompanied`,
    `price`,
    `created_at`,
    `capacity`,
    `status`
)
VALUES
(
    'b5590e10-939f-11f1-991b-4c77cb9a64c8',
    'The Desert Trilogy',
    '/public/assets/Images/pack.webp',
    'Enjoy a complete desert experience that blends relaxation and adventure in one journey. Start with a peaceful Camel Riding tour across the golden dunes, guided by an expert who introduces you to the beauty of the desert. Then enjoy an exciting Quad Bike ride, where you can drive yourself or ride with a professional driver for a safe and thrilling experience. Finish your adventure with Sandboarding, sliding down the dunes and enjoying pure fun in the heart of the desert.',
    'Merzouga, Morocco',
    'Suitable for adults only',
    'Self-drive or professional driver, accompanied by a guide',
    60.00,
    '2026-08-09 04:09:17',
    10,
    'available'
);


-- ========================================================
-- DESERT ACTIVITY
-- ========================================================

CREATE TABLE `desert_activity` (
    `id` char(36) NOT NULL,
    `image` varchar(255) DEFAULT NULL,
    `title` varchar(255) DEFAULT NULL,
    `icon_title` varchar(255) DEFAULT NULL,
    `description` text DEFAULT NULL,
    `location` varchar(255) DEFAULT NULL,
    `age_restriction` varchar(50) DEFAULT NULL,
    `accompanied` varchar(50) DEFAULT NULL,
    `price` decimal(10,2) DEFAULT NULL,
    `created_at` datetime DEFAULT current_timestamp(),
    `capacity` int(11) DEFAULT NULL,
    `status` enum(
        'available',
        'not_available'
    ) NOT NULL DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Demo Activities

INSERT INTO `desert_activity`
(
    `id`,
    `image`,
    `title`,
    `icon_title`,
    `description`,
    `location`,
    `age_restriction`,
    `accompanied`,
    `price`,
    `created_at`,
    `capacity`,
    `status`
)
VALUES

(
    'b063825c-9387-11f1-991b-4c77cb9a64c8',
    '/public/assets/Images/Camel-Riding.webp',
    'Camel Riding',
    '/public/assets/Icons/camel.png',
    'Enjoy a peaceful ride through the golden dunes and experience authentic desert life.',
    'Merzouga, Morocco',
    'all ages',
    'Accompanied by a guide',
    20.00,
    '2026-08-09 01:17:21',
    30,
    'available'
),

(
    'b0638ff2-9387-11f1-991b-4c77cb9a64c8',
    '/public/assets/Images/Quad bike.webp',
    'Quad Bike',
    '/public/assets/Icons/Quad bike.png',
    'Feel the adrenaline as you explore the desert on powerful quad bikes.',
    'Merzouga, Morocco',
    'adults only',
    'Self-drive or professional driver',
    25.00,
    '2026-08-09 01:17:21',
    25,
    'available'
),

(
    'b0639097-9387-11f1-991b-4c77cb9a64c8',
    '/public/assets/Images/Sandbording.webp',
    'Sandboarding',
    '/public/assets/Icons/Sandbording.png',
    'Slide down the dunes and enjoy a fun, thrilling desert activity.',
    'Merzouga, Morocco',
    'adults only',
    'Accompanied by a guide',
    10.00,
    '2026-08-09 01:17:21',
    50,
    'available'
),

(
    'b06390d2-9387-11f1-991b-4c77cb9a64c8',
    '/public/assets/Images/car 4.webp',
    'Car 4x4 Desert',
    '/public/assets/Icons/Car 4 4 desert.png',
    'Feel the adrenaline as you conquer the desert dunes in a powerful 4x4 vehicle.',
    'Merzouga, Morocco',
    'all ages',
    'Self-drive or professional driver',
    40.00,
    '2026-08-09 01:17:21',
    10,
    'available'
);


-- ========================================================
-- PRIMARY KEYS & INDEXES
-- ========================================================

ALTER TABLE `bookings`
    ADD PRIMARY KEY (`id`),
    ADD KEY `activity_id` (`activity_id`),
    ADD KEY `pack_id` (`pack_id`);

ALTER TABLE `contact`
    ADD PRIMARY KEY (`id`);

ALTER TABLE `desert_activities_pack`
    ADD PRIMARY KEY (`id`);

ALTER TABLE `desert_activity`
    ADD PRIMARY KEY (`id`);


-- ========================================================
-- AUTO INCREMENT
-- ========================================================

ALTER TABLE `bookings`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `contact`
    MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;


-- ========================================================
-- FOREIGN KEYS
-- ========================================================

ALTER TABLE `bookings`
    ADD CONSTRAINT `bookings_activity_fk`
        FOREIGN KEY (`activity_id`)
        REFERENCES `desert_activity` (`id`),

    ADD CONSTRAINT `bookings_pack_fk`
        FOREIGN KEY (`pack_id`)
        REFERENCES `desert_activities_pack` (`id`);


COMMIT;