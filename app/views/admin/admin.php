
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JAWLAH Admin Control Panel - Tour Management</title>
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
                <a href="#dashboard" class="sidebar-brand">
                    <img style="width: 60%;" src="/public/assets/Logo/Jawlah.webp" alt="JAWLAH Logo">
                </a>
                <nav class="sidebar-nav">
                    <a href="#dashboard" class="nav-link active">
                        <div class="nav-link-content">
                            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <rect x="3" y="3" width="7" height="7" rx="2"></rect>
                                <rect x="14" y="3" width="7" height="7" rx="2"></rect>
                                <rect x="14" y="14" width="7" height="7" rx="2"></rect>
                                <rect x="3" y="14" width="7" height="7" rx="2"></rect>
                            </svg>
                            <span>Dashboard</span>
                        </div>
                    </a>

                    <a href="#bookings" class="nav-link">
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

                    <a href="#activities" class="nav-link">
                        <div class="nav-link-content">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <path d="m16.24 7.76-1.804 5.411a2 2 0 0 1-1.265 1.265L7.76 16.24l1.804-5.411a2 2 0 0 1 1.265-1.265z" />
                            </svg>
                            <span>Activities</span>
                        </div>
                    </a>

                    <a href="#packs" class="nav-link">
                        <div class="nav-link-content">
                            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <polyline points="20 12 20 22 4 22 4 12"></polyline>
                                <rect x="2" y="7" width="20" height="5"></rect>
                                <line x1="12" y1="22" x2="12" y2="7"></line>
                                <path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"></path>
                                <path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"></path>
                            </svg>
                            <span>Packs</span>
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
                        <span class="nav-badge"><?= count($allMessages) ?></span>
                    </a>

                </nav>
            </div>

            <div class="sidebar-footer">
                <a href="/public/admin/logout" class="btn-logout">
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
                        <span class="badge-count"><?= count($allMessages) ?></span>
                    </button>

                    <div class="topbar-user">
                        <img src="/public/assets/Images/HatimElbakkali.jpg"
                            alt="Admin Avatar" class="topbar-avatar">
                        <span class="topbar-username">Admin</span>
                    </div>
                </div>
            </header>

            <main class="content-area">

                <section id="dashboard" class="content-section active">

                    <div class="page-header">
                        <div class="header-title-group">
                            <h2>Welcome back, Hatim</h2>
                            <p>Here's what's happening with JAWLAH today.</p>
                        </div>
                    </div>

                    <div class="stats-grid">

                        <div class="glass-card stat-card">
                            <div class="stat-header">
                                <div class="stat-icon">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                </div>
                            </div>
                            <div class="stat-title">Total Bookings</div>
                            <div class="stat-value"><?= htmlspecialchars($totalBookings['totalBookings']) ?></div>
                        </div>

                        <div class="glass-card stat-card">
                            <div class="stat-header">
                                <div class="stat-icon">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2">
                                        <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                                        <line x1="2" y1="10" x2="22" y2="10"></line>
                                    </svg>
                                </div>
                            </div>

                            <div class="stat-title">Total Revenue</div>
                            <div class="stat-value"><?= number_format((float)($totalRevenue['totalPrice']), 2) ?><span
                                    style="font-size:1.5rem; font-weight:600; color:var(--gold);">$</span></div>
                        </div>

                        <div class="glass-card stat-card">
                            <div class="stat-header">
                                <div class="stat-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10" />
                                        <path d="m16.24 7.76-1.804 5.411a2 2 0 0 1-1.265 1.265L7.76 16.24l1.804-5.411a2 2 0 0 1 1.265-1.265z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="stat-title">Desert Activities</div>
                            <div class="stat-value"><?= htmlspecialchars($totalDeserActivities['totalDesertActivities']) ?></div>
                        </div>

                        <div class="glass-card stat-card">
                            <div class="stat-header">
                                <div class="stat-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z" />
                                        <path d="m3.3 7 8.7 5 8.7-5" />
                                        <path d="M12 22V12" />
                                    </svg>
                                </div>
                            </div>
                            <div class="stat-title">Desert Pack</div>
                            <div class="stat-value"><?= htmlspecialchars($totalDesertPack['totalDesertPack']) ?></div>
                        </div>
                    </div>

                    <div class="glass-card-all">
                        <div class="chart-card-header">
                            <h3 class="chart-title">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <line x1="8" y1="6" x2="21" y2="6"></line>
                                    <line x1="8" y1="12" x2="21" y2="12"></line>
                                    <line x1="8" y1="18" x2="21" y2="18"></line>
                                    <line x1="3" y1="6" x2="3.01" y2="6"></line>
                                    <line x1="3" y1="12" x2="3.01" y2="12"></line>
                                    <line x1="3" y1="18" x2="3.01" y2="18"></line>
                                </svg>
                                Recent Bookings
                            </h3>

                            <a href="#bookings" class="btn-secondary"
                                style="padding: 0.4rem 0.85rem; font-size: 0.8rem;">View All Bookings</a>
                        </div>

                        <div class="table-responsive">
                            <table class="custom-table">
                                <thead>
                                    <tr>
                                        <th>Customer</th>
                                        <th>Activity / Pack</th>
                                        <th>Date</th>
                                        <th>Guests</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($recentBookings)): ?>
                                        <?php foreach ($recentBookings as $recentBooking) : ?>
                                            <tr>
                                                <td>
                                                    <div class="customer-cell">
                                                        <div class="customer-meta">
                                                            <span class="customer-name"><?= htmlspecialchars($recentBooking['full_name']) ?></span>
                                                            <span class="customer-email"><?= htmlspecialchars($recentBooking['email']) ?></span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><?= htmlspecialchars($recentBooking['activity_nom']) ?></td>
                                                <td><?= htmlspecialchars($recentBooking['reservation_date']) ?></td>
                                                <td><?= (int)$recentBooking['adults'] + (int)$recentBooking['children'] + (int)$recentBooking['infants'] ?></td>
                                                <td><strong><?= number_format((float)$recentBooking['total_price'], 2) ?> $</strong></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" style="text-align: center; color: var(--text-muted);">No recent bookings found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                <section id="bookings" class="content-section">
                    <div class="page-header">
                        <div class="header-title-group">
                            <h2>Bookings</h2>
                            <p>Manage all customer bookings</p>
                        </div>
                    </div>

                    <div class="glass-card-all filter-bar">
                        <div class="filter-group" style="min-width: 220px;">
                            <input type="text" id="bookingSearchInput" class="filter-input"
                                placeholder="Search code, customer, email, phone..." style="width: 100%;">
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
                                    <?php require __DIR__ . '/partial/bookingRows.php'; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </section>

                <section id="activities" class="content-section">

                    <div class="page-header">
                        <div class="header-title-group">
                            <h2>Activities</h2>
                            <p>Manage all excursion activities</p>
                        </div>
                        <div class="header-actions">
                            <button class="btn-primary" data-modal-target="addActivityModal">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                Add Activity
                            </button>
                        </div>
                    </div>

                    <div class="glass-card-all filter-bar">
                        <div class="filter-group">
                            <input type="text" id="activitySearchInput" class="filter-input"
                                placeholder="Search activities..." style="width: 100%;">
                        </div>
                    </div>

                    <div class="cards-grid" id="activitiesGrid">
                        <?php if (!empty($allActivities)): ?>
                            <?php foreach ($allActivities as $act): ?>
                                <div class="glass-card-all item-card <?= ($act['status'] === 'not_available') ? 'is-unavailable' : '' ?>" data-id="<?= htmlspecialchars($act['id']) ?>">
                                    <div class="card-media">
                                        <img src="<?= htmlspecialchars($act['image'] ?: '/public/assets/Images/Camel.webp') ?>"
                                            alt="<?= htmlspecialchars($act['title']) ?>">
                                        <select class="status-select card-status-badge card-status-select <?= ($act['status'] === 'not_available') ? 'not_available' : 'available' ?>"
                                            data-id="<?= htmlspecialchars($act['id']) ?>"
                                            data-type="activity"
                                            title="Toggle Availability">
                                            <option value="available" <?= ($act['status'] ?? 'available') === 'available' ? 'selected' : '' ?>>Available</option>
                                            <option value="not_available" <?= ($act['status'] ?? '') === 'not_available' ? 'selected' : '' ?>>Not Available</option>
                                        </select>
                                    </div>
                                    <div class="card-content">
                                        <div style="display:flex; align-items:center; justify-content:space-between; gap:0.5rem; margin-bottom:0.4rem;">
                                            <h3 class="card-item-title" style="margin-bottom:0;"><?= htmlspecialchars($act['title']) ?></h3>
                                            <?php if (!empty($act['icon_title'])): ?>
                                                <img src="<?= htmlspecialchars($act['icon_title']) ?>" alt="Icon" class="card-title-icon" style="width:24px; height:24px; object-fit:contain; flex-shrink:0;">
                                            <?php endif; ?>
                                        </div>
                                        <div class="card-price-tag"><?= number_format((float)$act['price'], 2) ?> $ <span style="font-size:0.8rem; font-weight:400; color:var(--text-secondary);">/ Person</span></div>
                                        <p class="card-description"><?= htmlspecialchars($act['description']) ?></p>

                                        <div class="card-meta-list">
                                            <div class="card-meta-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-round-icon lucide-users-round">
                                                    <path d="M18 21a8 8 0 0 0-16 0" />
                                                    <circle cx="10" cy="8" r="5" />
                                                    <path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3" />
                                                </svg>
                                                <span>Capacity: <?= htmlspecialchars($act['capacity']) ?> Persons</span>
                                            </div>
                                            <div class="card-meta-item">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                                    <circle cx="12" cy="10" r="3"></circle>
                                                </svg>
                                                <span>Location: <?= htmlspecialchars($act['location']) ?></span>
                                            </div>
                                            <div class="card-meta-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-round-check-icon lucide-user-round-check">
                                                    <path d="M2 21a8 8 0 0 1 13.292-6" />
                                                    <circle cx="10" cy="8" r="5" />
                                                    <path d="m16 19 2 2 4-4" />
                                                </svg>
                                                <span>Age Restriction: <?= htmlspecialchars($act['age_restriction']) ?></span>
                                            </div>
                                            <div class="card-meta-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-icon lucide-user">
                                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                                    <circle cx="12" cy="7" r="4" />
                                                </svg>
                                                <span>Accompanied: <?= htmlspecialchars($act['accompanied']) ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer-actions">
                                        <button class="btn-card-action btn-edit btn-edit-activity"
                                            data-id="<?= htmlspecialchars($act['id']) ?>"
                                            data-title="<?= htmlspecialchars($act['title']) ?>"
                                            data-price="<?= htmlspecialchars($act['price']) ?>"
                                            data-capacity="<?= htmlspecialchars($act['capacity']) ?>"
                                            data-image="<?= htmlspecialchars($act['image'] ?? '') ?>"
                                            data-icon="<?= htmlspecialchars($act['icon_title'] ?? '') ?>"
                                            data-description="<?= htmlspecialchars($act['description']) ?>"
                                            data-location="<?= htmlspecialchars($act['location']) ?>"
                                            data-age="<?= htmlspecialchars($act['age_restriction']) ?>"
                                            data-accompanied="<?= htmlspecialchars($act['accompanied']) ?>"
                                            data-status="<?= htmlspecialchars($act['status'] ?? 'available') ?>"
                                            title="Edit Activity">
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                            </svg>
                                            <span>Edit</span>
                                        </button>
                                        <button class="btn-card-action btn-delete btn-delete-activity" data-id="<?= htmlspecialchars($act['id']) ?>" title="Delete Activity">
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                            </svg>
                                            <span>Delete</span>
                                        </button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p style="color:var(--text-muted);">No activities found in database.</p>
                        <?php endif; ?>
                    </div>

                </section>

                <section id="packs" class="content-section">

                    <div class="page-header">
                        <div class="header-title-group">
                            <h2>Packs</h2>
                            <p>Manage all activity package offerings</p>
                        </div>
                        <div class="header-actions">
                            <button class="btn-primary" data-modal-target="addPackModal">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                Add Pack
                            </button>
                        </div>
                    </div>

                    <div class="cards-grid" id="packsGrid">
                        <?php if (!empty($allPacks)): ?>
                            <?php foreach ($allPacks as $pk): ?>
                                <div class="glass-card-all item-card <?= ($pk['status'] === 'not_available') ? 'is-unavailable' : '' ?>" data-id="<?= htmlspecialchars($pk['id']) ?>">
                                    <div class="card-media">
                                        <img src="<?= htmlspecialchars($pk['image'] ?: '/public/assets/Images/pack.webp') ?>"
                                            alt="<?= htmlspecialchars($pk['title']) ?>">
                                        <select class="status-select card-status-badge card-status-select <?= ($pk['status'] === 'not_available') ? 'not_available' : 'available' ?>"
                                            data-id="<?= htmlspecialchars($pk['id']) ?>"
                                            data-type="pack"
                                            title="Toggle Availability">
                                            <option value="available" <?= ($pk['status'] ?? 'available') === 'available' ? 'selected' : '' ?>>Available</option>
                                            <option value="not_available" <?= ($pk['status'] ?? '') === 'not_available' ? 'selected' : '' ?>>Not Available</option>
                                        </select>
                                    </div>
                                    <div class="card-content">
                                        <h3 class="card-item-title"><?= htmlspecialchars($pk['title']) ?></h3>
                                        <div class="card-price-tag"><?= number_format((float)$pk['price'], 2) ?> $ <span style="font-size:0.8rem; font-weight:400; color:var(--text-secondary);">/ Person</span></div>
                                        <p class="card-description"><?= htmlspecialchars($pk['description']) ?></p>

                                        <div class="card-meta-list">
                                            <div class="card-meta-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-round-icon lucide-users-round">
                                                    <path d="M18 21a8 8 0 0 0-16 0" />
                                                    <circle cx="10" cy="8" r="5" />
                                                    <path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3" />
                                                </svg>
                                                <span>Capacity: <?= htmlspecialchars($pk['capacity']) ?> Persons</span>
                                            </div>
                                            <div class="card-meta-item">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                                    <circle cx="12" cy="10" r="3"></circle>
                                                </svg>
                                                <span>Location: <?= htmlspecialchars($pk['location']) ?></span>
                                            </div>
                                            <div class="card-meta-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-round-check-icon lucide-user-round-check">
                                                    <path d="M2 21a8 8 0 0 1 13.292-6" />
                                                    <circle cx="10" cy="8" r="5" />
                                                    <path d="m16 19 2 2 4-4" />
                                                </svg>
                                                <span>Age Restriction: <?= htmlspecialchars($pk['age_restriction']) ?></span>
                                            </div>
                                            <div class="card-meta-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-icon lucide-user">
                                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                                    <circle cx="12" cy="7" r="4" />
                                                </svg>
                                                <span>Accompanied: <?= htmlspecialchars($pk['accompanied']) ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer-actions">
                                        <button class="btn-card-action btn-edit btn-edit-pack"
                                            data-id="<?= htmlspecialchars($pk['id']) ?>"
                                            data-title="<?= htmlspecialchars($pk['title']) ?>"
                                            data-price="<?= htmlspecialchars($pk['price']) ?>"
                                            data-capacity="<?= htmlspecialchars($pk['capacity']) ?>"
                                            data-image="<?= htmlspecialchars($pk['image'] ?? '') ?>"
                                            data-description="<?= htmlspecialchars($pk['description']) ?>"
                                            data-location="<?= htmlspecialchars($pk['location']) ?>"
                                            data-age="<?= htmlspecialchars($pk['age_restriction']) ?>"
                                            data-accompanied="<?= htmlspecialchars($pk['accompanied']) ?>"
                                            data-status="<?= htmlspecialchars($pk['status'] ?? 'available') ?>"
                                            title="Edit Pack">
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                            </svg>
                                            <span>Edit</span>
                                        </button>
                                        <button class="btn-card-action btn-delete btn-delete-pack" data-id="<?= htmlspecialchars($pk['id']) ?>" title="Delete Pack">
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                            </svg>
                                            <span>Delete</span>
                                        </button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p style="color:var(--text-muted);">No packs found in database.</p>
                        <?php endif; ?>
                    </div>

                </section>

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
                                            <tr data-id="<?= $msg['id'] ?>">
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
                                                    <select class="status-select <?= htmlspecialchars($msg['status']) ?>" data-message-id="<?= $msg['id'] ?>">
                                                        <option value="unread" <?= $msg['status'] === 'unread' ? 'selected' : '' ?>>Unread</option>
                                                        <option value="read" <?= $msg['status'] === 'read' ? 'selected' : '' ?>>Read</option>
                                                        <option value="replied" <?= $msg['status'] === 'replied' ? 'selected' : '' ?>>Replied</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <div class="action-buttons">
                                                        <button class="btn-icon-action btn-view-message" data-modal-target="viewMessageModal"
                                                            data-id="<?= $msg['id'] ?>"
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
                                                        <button class="btn-icon-action delete btn-delete-message" data-id="<?= $msg['id'] ?>" title="Delete Message">
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

    <div id="addActivityModal" class="modal-overlay">
        <div class="modal-card">
            <div class="modal-header">
                <h3 class="modal-title">Add Activity</h3>
                <button class="modal-close-btn" data-modal-close>&times;</button>
            </div>
            <form id="addActivityForm" enctype="multipart/form-data">
                <div class="modal-form-grid">
                    <div class="full-width">
                        <label class="form-label">Activity Title</label>
                        <input type="text" name="title" class="filter-input" placeholder="e.g. Camel Riding" required style="width: 100%;">
                    </div>
                    <div>
                        <label class="form-label">Price ($)</label>
                        <input type="number" step="0.01" name="price" class="filter-input" placeholder="300" required style="width: 100%;">
                    </div>
                    <div>
                        <label class="form-label">Capacity</label>
                        <input type="number" name="capacity" class="filter-input" placeholder="20" required style="width: 100%;">
                    </div>
                    <div>
                        <label class="form-label">Activity Image (Upload from PC)</label>
                        <input type="file" name="image_file" accept="image/png, image/jpeg, image/webp, image/svg+xml" class="filter-input" style="width: 100%;">
                    </div>
                    <div>
                        <label class="form-label">Activity Icon (Upload from PC)</label>
                        <input type="file" name="icon_file" accept="image/png, image/jpeg, image/webp, image/svg+xml" class="filter-input" style="width: 100%;">
                    </div>
                    <div class="full-width">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="filter-input" placeholder="Activity description..." rows="3" style="width: 100%; resize: vertical;"></textarea>
                    </div>
                    <div>
                        <label class="form-label">Location</label>
                        <input type="text" name="location" class="filter-input" placeholder="e.g. Merzouga" required style="width: 100%;">
                    </div>
                    <div>
                        <label class="form-label">Age Restriction</label>
                        <input type="text" name="age_restriction" class="filter-input" placeholder="e.g. 5+ Years" required style="width: 100%;">
                    </div>
                    <div>
                        <label class="form-label">Accompanied</label>
                        <input type="text" name="accompanied" class="filter-input" placeholder="e.g. Yes (Guide)" required style="width: 100%;">
                    </div>
                    <div>
                        <label class="form-label">Status</label>
                        <select name="status" class="filter-input" style="width: 100%;">
                            <option value="available">Available</option>
                            <option value="not_available">Not Available</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer-actions">
                    <button type="button" class="btn-secondary" data-modal-close>Cancel</button>
                    <button type="submit" class="btn-primary">Save Activity</button>
                </div>
            </form>
        </div>
    </div>

    <div id="editActivityModal" class="modal-overlay">
        <div class="modal-card">
            <div class="modal-header">
                <h3 class="modal-title">Edit Activity</h3>
                <button class="modal-close-btn" data-modal-close>&times;</button>
            </div>
            <form id="editActivityForm" enctype="multipart/form-data">
                <input type="hidden" id="editActivityId" name="id">
                <div class="modal-form-grid">
                    <div class="full-width">
                        <label class="form-label">Activity Title</label>
                        <input type="text" id="editActivityTitle" name="title" class="filter-input" required style="width: 100%;">
                    </div>
                    <div>
                        <label class="form-label">Price ($)</label>
                        <input type="number" step="0.01" id="editActivityPrice" name="price" class="filter-input" required style="width: 100%;">
                    </div>
                    <div>
                        <label class="form-label">Capacity</label>
                        <input type="number" id="editActivityCapacity" name="capacity" class="filter-input" required style="width: 100%;">
                    </div>
                    <div>
                        <label class="form-label">Change Image (Upload from PC)</label>
                        <input type="file" name="image_file" accept="image/png, image/jpeg, image/webp, image/svg+xml" class="filter-input" style="width: 100%;">
                    </div>
                    <div>
                        <label class="form-label">Change Icon (Upload from PC)</label>
                        <input type="file" name="icon_file" accept="image/png, image/jpeg, image/webp, image/svg+xml" class="filter-input" style="width: 100%;">
                    </div>
                    <div class="full-width">
                        <label class="form-label">Description</label>
                        <textarea id="editActivityDescription" name="description" class="filter-input" rows="3" style="width: 100%; resize: vertical;"></textarea>
                    </div>
                    <div>
                        <label class="form-label">Location</label>
                        <input type="text" id="editActivityLocation" name="location" class="filter-input" required style="width: 100%;">
                    </div>
                    <div>
                        <label class="form-label">Age Restriction</label>
                        <input type="text" id="editActivityAge" name="age_restriction" class="filter-input" required style="width: 100%;">
                    </div>
                    <div>
                        <label class="form-label">Accompanied</label>
                        <input type="text" id="editActivityAccompanied" name="accompanied" class="filter-input" required style="width: 100%;">
                    </div>
                    <div>
                        <label class="form-label">Status</label>
                        <select id="editActivityStatus" name="status" class="filter-input" style="width: 100%;">
                            <option value="available">Available</option>
                            <option value="not_available">Not Available</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer-actions">
                    <button type="button" class="btn-secondary" data-modal-close>Cancel</button>
                    <button type="submit" class="btn-primary">Update Activity</button>
                </div>
            </form>
        </div>
    </div>

    <div id="addPackModal" class="modal-overlay">
        <div class="modal-card">
            <div class="modal-header">
                <h3 class="modal-title">Add Pack</h3>
                <button class="modal-close-btn" data-modal-close>&times;</button>
            </div>
            <form id="addPackForm" enctype="multipart/form-data">
                <div class="modal-form-grid">
                    <div class="full-width">
                        <label class="form-label">Pack Title</label>
                        <input type="text" name="title" class="filter-input" placeholder="e.g. Desert Adventure Pack" required style="width: 100%;">
                    </div>
                    <div>
                        <label class="form-label">Price ($)</label>
                        <input type="number" step="0.01" name="price" class="filter-input" placeholder="1800" required style="width: 100%;">
                    </div>
                    <div>
                        <label class="form-label">Capacity</label>
                        <input type="number" name="capacity" class="filter-input" placeholder="15" required style="width: 100%;">
                    </div>
                    <div class="full-width">
                        <label class="form-label">Pack Image (Upload from PC)</label>
                        <input type="file" name="image_file" accept="image/png, image/jpeg, image/webp, image/svg+xml" class="filter-input" style="width: 100%;">
                    </div>
                    <div class="full-width">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="filter-input" placeholder="Pack description..." rows="3" style="width: 100%; resize: vertical;"></textarea>
                    </div>
                    <div>
                        <label class="form-label">Location</label>
                        <input type="text" name="location" class="filter-input" placeholder="e.g. Merzouga Camp" required style="width: 100%;">
                    </div>
                    <div>
                        <label class="form-label">Age Restriction</label>
                        <input type="text" name="age_restriction" class="filter-input" placeholder="e.g. 12+ Years" required style="width: 100%;">
                    </div>
                    <div>
                        <label class="form-label">Accompanied</label>
                        <input type="text" name="accompanied" class="filter-input" placeholder="e.g. Dedicated Guide" required style="width: 100%;">
                    </div>
                    <div>
                        <label class="form-label">Status</label>
                        <select name="status" class="filter-input" style="width: 100%;">
                            <option value="available">Available</option>
                            <option value="not_available">Not Available</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer-actions">
                    <button type="button" class="btn-secondary" data-modal-close>Cancel</button>
                    <button type="submit" class="btn-primary">Save Pack</button>
                </div>
            </form>
        </div>
    </div>

    <div id="editPackModal" class="modal-overlay">
        <div class="modal-card">
            <div class="modal-header">
                <h3 class="modal-title">Edit Pack</h3>
                <button class="modal-close-btn" data-modal-close>&times;</button>
            </div>
            <form id="editPackForm" enctype="multipart/form-data">
                <input type="hidden" id="editPackId" name="id">
                <div class="modal-form-grid">
                    <div class="full-width">
                        <label class="form-label">Pack Title</label>
                        <input type="text" id="editPackTitle" name="title" class="filter-input" required style="width: 100%;">
                    </div>
                    <div>
                        <label class="form-label">Price $</label>
                        <input type="number" step="0.01" id="editPackPrice" name="price" class="filter-input" required style="width: 100%;">
                    </div>
                    <div>
                        <label class="form-label">Capacity</label>
                        <input type="number" id="editPackCapacity" name="capacity" class="filter-input" required style="width: 100%;">
                    </div>
                    <div class="full-width">
                        <label class="form-label">Change Pack Image (Upload from PC)</label>
                        <input type="file" name="image_file" accept="image/png, image/jpeg, image/webp, image/svg+xml" class="filter-input" style="width: 100%;">
                    </div>
                    <div class="full-width">
                        <label class="form-label">Description</label>
                        <textarea id="editPackDescription" name="description" class="filter-input" rows="3" style="width: 100%; resize: vertical;"></textarea>
                    </div>
                    <div>
                        <label class="form-label">Location</label>
                        <input type="text" id="editPackLocation" name="location" class="filter-input" required style="width: 100%;">
                    </div>
                    <div>
                        <label class="form-label">Age Restriction</label>
                        <input type="text" id="editPackAge" name="age_restriction" class="filter-input" required style="width: 100%;">
                    </div>
                    <div>
                        <label class="form-label">Accompanied</label>
                        <input type="text" id="editPackAccompanied" name="accompanied" class="filter-input" required style="width: 100%;">
                    </div>
                    <div>
                        <label class="form-label">Status</label>
                        <select id="editPackStatus" name="status" class="filter-input" style="width: 100%;">
                            <option value="available">Available</option>
                            <option value="not_available">Not Available</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer-actions">
                    <button type="button" class="btn-secondary" data-modal-close>Cancel</button>
                    <button type="submit" class="btn-primary">Update Pack</button>
                </div>
            </form>
        </div>
    </div>

    <script src="/public/js/admin.js"></script>
</body>

</html>