<?php if (!empty($allBookings)): ?>
    <?php foreach ($allBookings as $bk): ?>
        <tr data-id="<?= $bk['id'] ?>">
            <td><strong><?= htmlspecialchars($bk['id']) ?></strong></td>
            <td>
                <div class="customer-cell">
                    <div class="customer-meta">
                        <span class="customer-name"><?= htmlspecialchars($bk['full_name']) ?></span>
                        <span class="customer-email"><?= htmlspecialchars($bk['email']) ?></span>
                    </div>
                </div>
            </td>
            <td><span style="font-size:0.8rem; font-weight:600; color:var(--text-secondary); text-transform:capitalize;"><?= htmlspecialchars($bk['booking_type']) ?></span></td>
            <td><?= htmlspecialchars($bk['item_title']) ?></td>
            <td><?= htmlspecialchars($bk['reservation_date']) ?></td>
            <td><?= htmlspecialchars($bk['selected_time']) ?></td>
            <td><?= (int)$bk['adults'] ?></td>
            <td><?= (int)$bk['children'] ?></td>
            <td><?= (int)$bk['infants'] ?></td>
            <td><strong><?= number_format((float)$bk['total_price'], 2) ?> $</strong></td>
            <td>
                <select class="status-select <?= htmlspecialchars($bk['status'] ?? 'confirmed') ?>" data-booking-id="<?= $bk['id'] ?>">
                    <option value="confirmed" <?= ($bk['status'] ?? '') === 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
                    <option value="pending" <?= ($bk['status'] ?? '') === 'pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="cancelled" <?= ($bk['status'] ?? '') === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                    <option value="completed" <?= ($bk['status'] ?? '') === 'completed' ? 'selected' : '' ?>>Completed</option>
                </select>
            </td>
            <td>
                <div class="action-buttons">
                    <button class="btn-icon-action btn-delete-booking" data-id="<?= $bk['id'] ?>" title="Cancel/Delete">
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
        <td colspan="13" style="text-align: center; color: var(--text-muted);">No bookings found.</td>
    </tr>
<?php endif; ?>