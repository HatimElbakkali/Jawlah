<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JAWLAH Employee Panel</title>
    <link rel="shortcut icon" href="/public/assets/Logo/favicon.ico" />
    <link rel="icon" type="image/png" sizes="16x16" href="/public/assets/Logo/favicon-16.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="/public/assets/Logo/favicon-32.png" />
    <link rel="icon" type="image/png" sizes="48x48" href="/public/assets/Logo/favicon-48.png" />
    <link rel="icon" type="image/png" sizes="64x64" href="/public/assets/Logo/favicon-64.png" />
    <link rel="icon" type="image/png" sizes="128x128" href="/public/assets/Logo/favicon-128.png" />
    <link rel="apple-touch-icon" sizes="180x180" href="/public/assets/Logo/apple-touch-icon.png" />
    <link rel="stylesheet" href="/public/css/admin.css">
    <meta name="theme-color" content="#231709">
    <link rel="preload" href="/public/assets/Fonts/Andalus.woff2" as="font" type="font/woff2" crossorigin />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Amiri+Quran&display=swap"
        rel="stylesheet">
</head>

<body>

    <div class="app-container">
        <div id="sidebarOverlay" class="modal-overlay" style="background: rgba(0,0,0,0.5); z-index: 190;"></div>
        <aside class="sidebar">
            <div>
                <a href="#bookings" class="sidebar-brand">
                    <img style="width: 60%;" src="/public/assets/Logo/Jawlah.webp" alt="JAWLAH Logo">
                </a>
                <nav class="sidebar-nav">

                    <a href="#bookings" class="nav-link active">
                        <div class="nav-link-content">
                            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            <span>Bookings</span>
                        </div>
                    </a>

                    <a href="#availability" class="nav-link">
                        <div class="nav-link-content">
                            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                            <span>Availability</span>
                        </div>
                    </a>

                    <a href="#messages" class="nav-link">
                        <div class="nav-link-content">
                            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                </path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                            <span>Messages</span>
                        </div>
                        <span class="nav-badge"><?= (int) $unreadCount ?></span>
                    </a>

                </nav>
            </div>

            <div class="sidebar-footer">
                <a href="/public/employee/logout" class="btn-logout">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    <span>Logout</span>
                </a>
            </div>

        </aside>

        <div class="main-wrapper">

            <header class="top-navbar">
                <button class="mobile-menu-btn" aria-label="Toggle Mobile Menu">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </button>

                <div class="navbar-actions">
                    <button class="icon-btn-badge" aria-label="Notifications">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                        </svg>
                        <span class="badge-count"><?= (int) $unreadCount ?></span>
                    </button>

                    <div class="topbar-user">
                        <span class="topbar-username"><?= htmlspecialchars($employeeName) ?></span>
                    </div>
                </div>
            </header>

            <main class="content-area">

                <!-- ================= BOOKINGS ================= -->
                <section id="bookings" class="content-section active">
                    <div class="page-header">
                        <div class="header-title-group">
                            <h2>Bookings</h2>
                            <p>Manage all customer bookings</p>
                        </div>
                    </div>

                    <div class="glass-card-all filter-bar">
                        <div class="filter-group" style="min-width: 220px;">
                            <input type="text" id="bookingSearchInput" class="filter-input"
                                placeholder="Search customer, email, phone..." style="width: 100%;">
                        </div>

                        <select id="bookingTypeFilter" class="filter-select">
                            <option value="all">All Booking Types</option>
                            <option value="activity">Activity</option>
                            <option value="pack">Pack</option>
                        </select>

                        <select id="bookingStatusFilter" class="filter-select">
                            <option value="all">All Statuses</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="pending">Pending</option>
                            <option value="cancelled">Cancelled</option>
                            <option value="completed">Completed</option>
                        </select>

                        <input type="date" id="bookingDateFilter" class="filter-input">
                    </div>

                    <div class="glass-card-all">
                        <div class="table-responsive">
                            <table class="custom-table" id="bookingsTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>CODE</th>
                                        <th>Customer</th>
                                        <th>Type</th>
                                        <th>Activity / Pack</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Adults</th>
                                        <th>Children</th>
                                        <th>Infants</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php require __DIR__ . '/partial/employeeBookingrows.php'; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </section>

                <!-- ================= AVAILABILITY ================= -->
                <section id="availability" class="content-section">

                    <div class="page-header">
                        <div class="header-title-group">
                            <h2>Availability</h2>
                            <p>Calculated capacity & slot availability from reservations</p>
                        </div>
                    </div>

                    <div class="glass-card-all filter-bar">
                        <div class="filter-group" style="min-width: 200px;">
                            <input type="text" id="availabilitySearchInput" class="filter-input"
                                placeholder="Search excursion..." style="width: 100%;">
                        </div>

                        <select class="filter-select" id="availabilityTypeFilter">
                            <option value="all">All Types</option>
                            <option value="activity">Activity</option>
                            <option value="pack">Pack</option>
                        </select>

                        <select class="filter-select" id="availabilityStatusFilter">
                            <option value="all">All Statuses</option>
                            <option value="available">Available</option>
                            <option value="not_available">Not Available</option>
                        </select>

                        <input type="date" id="availabilityDateFilter" class="filter-input">
                    </div>

                    <div class="glass-card-all">
                        <div class="table-responsive">
                            <table class="custom-table" id="availabilityTable">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Activity / Pack Name</th>
                                        <th>Time</th>
                                        <th>Duration</th>
                                        <th>Capacity</th>
                                        <th>Reserved</th>
                                        <th>Remaining</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($availabilityData)): ?>
                                        <?php foreach ($availabilityData as $av): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($av['date']) ?></td>
                                                <td><span style="font-size:0.8rem; font-weight:600; color:var(--text-secondary); text-transform:capitalize;"><?= htmlspecialchars($av['type']) ?></span></td>
                                                <td><strong><?= htmlspecialchars($av['item_title']) ?></strong></td>
                                                <td><?= htmlspecialchars($av['selected_time']) ?></td>
                                                <td><?= htmlspecialchars($av['duration']) ?></td>
                                                <td><?= htmlspecialchars($av['capacity']) ?></td>
                                                <td><?= htmlspecialchars($av['reserved']) ?></td>
                                                <td><strong><?= htmlspecialchars($av['remaining']) ?></strong></td>
                                                <td>
                                                    <span class="status-pill <?= $av['status'] === 'available' ? 'confirmed' : 'cancelled' ?>">
                                                        <?= $av['status'] === 'available' ? 'Available' : 'Not Available' ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="9" style="text-align: center; color: var(--text-muted);">No booked time slots to display.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </section>

                <section id="messages" class="content-section">

                    <div class="page-header">
                        <div class="header-title-group">
                            <h2>Messages</h2>
                            <p>Manage customer contact messages</p>
                        </div>
                    </div>

                    <div class="glass-card-all filter-bar">
                        <div class="filter-group" style="min-width: 220px;">
                            <input type="text" id="messageSearchInput" class="filter-input"
                                placeholder="Search sender, email, subject, message..." style="width: 100%;">
                        </div>

                        <select id="messageStatusFilter" class="filter-select">
                            <option value="all">All Statuses</option>
                            <option value="unread">Unread</option>
                            <option value="read">Read</option>
                            <option value="replied">Replied</option>
                        </select>
                    </div>

                    <div class="glass-card-all">
                        <div class="table-responsive">
                            <table class="custom-table" id="messagesTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Sender</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Subject</th>
                                        <th>Message</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($allMessages)): ?>
                                        <?php foreach ($allMessages as $msg): ?>
                                            <tr data-id="<?= (int) $msg['id'] ?>">
                                                <td><strong><?= htmlspecialchars($msg['id']) ?></strong></td>
                                                <td>
                                                    <div class="customer-cell">
                                                        <span class="customer-name"><?= htmlspecialchars($msg['name']) ?></span>
                                                    </div>
                                                </td>
                                                <td><?= htmlspecialchars($msg['email']) ?></td>
                                                <td><?= htmlspecialchars($msg['phone']) ?></td>
                                                <td><strong><?= htmlspecialchars($msg['subject']) ?></strong></td>
                                                <td>
                                                    <div class="message-body-preview">
                                                        <?= htmlspecialchars(mb_strimwidth($msg['message'], 0, 80, '...')) ?>
                                                    </div>
                                                </td>
                                                <td><?= htmlspecialchars($msg['created_at']) ?></td>
                                                <td>
                                                    <select class="status-select <?= htmlspecialchars($msg['status']) ?>" data-message-id="<?= (int) $msg['id'] ?>">
                                                        <option value="unread" <?= $msg['status'] === 'unread' ? 'selected' : '' ?>>Unread</option>
                                                        <option value="read" <?= $msg['status'] === 'read' ? 'selected' : '' ?>>Read</option>
                                                        <option value="replied" <?= $msg['status'] === 'replied' ? 'selected' : '' ?>>Replied</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <div class="action-buttons">
                                                        <button class="btn-icon-action btn-view-message" data-modal-target="viewMessageModal"
                                                            data-id="<?= (int) $msg['id'] ?>"
                                                            data-sender="<?= htmlspecialchars($msg['name']) ?>"
                                                            data-email="<?= htmlspecialchars($msg['email']) ?>"
                                                            data-phone="<?= htmlspecialchars($msg['phone']) ?>"
                                                            data-subject="<?= htmlspecialchars($msg['subject']) ?>"
                                                            data-date="<?= htmlspecialchars($msg['created_at']) ?>"
                                                            data-body="<?= htmlspecialchars($msg['message']) ?>"
                                                            title="View Message">
                                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                                <circle cx="12" cy="12" r="3"></circle>
                                                            </svg>
                                                        </button>
                                                        <button class="btn-icon-action delete btn-delete-message" data-id="<?= (int) $msg['id'] ?>" title="Delete Message">
                                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="9" style="text-align: center; color: var(--text-muted);">No messages found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </section>

            </main>

        </div>

    </div>

    <div id="viewMessageModal" class="modal-overlay">
        <div class="modal-card">
            <div class="modal-header">
                <h3 class="modal-title">Message Details</h3>
                <button class="modal-close-btn" data-modal-close>&times;</button>
            </div>
            <div class="modal-body">
                <div style="display:flex; align-items:center; gap:1rem; margin-bottom:1.5rem; padding:1rem; background:rgba(245,242,232,0.8); border-radius:14px;">
                    <div>
                        <h4 id="viewMsgSender" style="font-size:1.1rem; color:var(--text-primary);">Customer</h4>
                        <span id="viewMsgContact" style="font-size:0.85rem; color:var(--text-secondary);">email • phone</span>
                    </div>
                </div>

                <div style="margin-bottom: 1.25rem;">
                    <span style="font-size:0.75rem; color:var(--text-muted); text-transform:uppercase; font-weight:700;">Subject</span>
                    <p id="viewMsgSubject" style="font-weight:700; color:var(--text-primary); font-size:1.1rem; margin-top:0.25rem;">Subject</p>
                </div>

                <div style="margin-bottom: 1.25rem;">
                    <span style="font-size:0.75rem; color:var(--text-muted); text-transform:uppercase; font-weight:700;">Date</span>
                    <p id="viewMsgDate" style="font-weight:600; color:var(--text-secondary); font-size:0.9rem; margin-top:0.25rem;">Date</p>
                </div>

                <div style="margin-bottom: 1.25rem;">
                    <span style="font-size:0.75rem; color:var(--text-muted); text-transform:uppercase; font-weight:700;">Message Content</span>
                    <div id="viewMsgBody" class="glass-card" style="margin-top:0.5rem; padding:1.25rem; background:rgba(255,255,255,0.4); line-height:1.6; font-size:0.925rem; color:var(--text-primary); border-radius:14px;">
                    </div>
                </div>
            </div>
            <div class="modal-footer-actions">
                <button class="btn-secondary" data-modal-close>Close</button>
            </div>
        </div>
    </div>

    <script src="/public/js/employee.js"></script>
</body>

</html>