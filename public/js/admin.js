document.addEventListener('DOMContentLoaded', () => {
    'use strict';

    const navLinks = document.querySelectorAll('.sidebar-nav .nav-link');
    const sections = document.querySelectorAll('.content-section');
    const sidebar = document.querySelector('.sidebar');
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    function switchSection(targetId) {
        if (!targetId) return;

        const sectionId = targetId.replace('#', '');
        const targetSection = document.getElementById(sectionId);

        if (targetSection) {
            sections.forEach(sec => sec.classList.remove('active'));
            targetSection.classList.add('active');

            navLinks.forEach(link => {
                const linkTarget = link.getAttribute('href').replace('#', '');
                if (linkTarget === sectionId) {
                    link.classList.add('active');
                } else {
                    link.classList.remove('active');
                }
            });

            window.scrollTo({ top: 0, behavior: 'smooth' });
            closeMobileSidebar();
        }
    }

    navLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const targetId = link.getAttribute('href');
            switchSection(targetId);
            history.pushState(null, null, targetId);
        });
    });

    const initialHash = window.location.hash || '#dashboard';
    switchSection(initialHash);

    window.addEventListener('popstate', () => {
        const hash = window.location.hash || '#dashboard';
        switchSection(hash);
    });

    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', () => {
            if (sidebar) sidebar.classList.toggle('open');
            if (sidebarOverlay) sidebarOverlay.classList.toggle('open');
        });
    }

    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', closeMobileSidebar);
    }

    function closeMobileSidebar() {
        if (sidebar) sidebar.classList.remove('open');
        if (sidebarOverlay) sidebarOverlay.classList.remove('open');
    }

    const modalCloses = document.querySelectorAll('[data-modal-close]');
    const modalOverlays = document.querySelectorAll('.modal-overlay');

    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('open');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeModal(modalElement) {
        if (modalElement) {
            modalElement.classList.remove('open');
            document.body.style.overflow = '';
        }
    }

    document.querySelectorAll('[data-modal-target]').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const targetId = btn.getAttribute('data-modal-target');
            openModal(targetId);
        });
    });

    modalCloses.forEach(btn => {
        btn.addEventListener('click', () => {
            closeModal(btn.closest('.modal-overlay'));
        });
    });

    modalOverlays.forEach(overlay => {
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) closeModal(overlay);
        });
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            modalOverlays.forEach(overlay => closeModal(overlay));
        }
    });

    function syncStatusSelectClass(select) {
        if (!select) return;
        const val = select.value;
        select.classList.remove('confirmed', 'pending', 'cancelled', 'completed', 'available', 'not_available', 'read', 'unread', 'replied');
        select.classList.add(val);
    }

    document.querySelectorAll('.status-select').forEach(syncStatusSelectClass);

    document.addEventListener('change', (e) => {
        const select = e.target.closest ? e.target.closest('.status-select') : null;
        if (!select) return;

        syncStatusSelectClass(select);

        const bookingId = select.getAttribute('data-booking-id');
        const messageId = select.getAttribute('data-message-id');
        const itemId = select.getAttribute('data-id');
        const itemType = select.getAttribute('data-type');
        const newStatus = select.value;

        if (bookingId) {
            fetch('/public/admin/booking/update-status', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: bookingId, status: newStatus })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    showToast('Booking status updated.', 'success');
                } else {
                    showToast(data.message || 'Failed to update booking status.', 'error');
                }
            })
            .catch(() => showToast('Network error updating booking status.', 'error'));
        } else if (messageId) {
            fetch('/public/admin/message/update-status', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: messageId, status: newStatus })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    showToast('Message status updated.', 'success');
                } else {
                    showToast(data.message || 'Failed to update message status.', 'error');
                }
            })
            .catch(() => showToast('Network error updating message status.', 'error'));
        } else if (itemId && itemType) {
            const endpoint = (itemType === 'pack')
                ? '/public/admin/pack/update-status'
                : '/public/admin/activity/update-status';
            const card = select.closest('.item-card');

            fetch(endpoint, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: itemId, status: newStatus })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    showToast(`${itemType === 'pack' ? 'Pack' : 'Activity'} status updated.`, 'success');
                    if (card) {
                        if (newStatus === 'not_available') {
                            card.classList.add('is-unavailable');
                        } else {
                            card.classList.remove('is-unavailable');
                        }
                        const editBtn = card.querySelector(itemType === 'pack' ? '.btn-edit-pack' : '.btn-edit-activity');
                        if (editBtn) editBtn.setAttribute('data-status', newStatus);
                    }
                } else {
                    showToast(data.message || 'Failed to update status.', 'error');
                }
            })
            .catch(() => showToast('Network error updating status.', 'error'));
        }
    });

    document.querySelectorAll('.btn-view-message').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.getAttribute('data-id');
            const sender = btn.getAttribute('data-sender') || 'Customer';
            const email = btn.getAttribute('data-email') || '';
            const phone = btn.getAttribute('data-phone') || '';
            const subject = btn.getAttribute('data-subject') || '';
            const date = btn.getAttribute('data-date') || '';
            const body = btn.getAttribute('data-body') || '';

            const viewMsgSender = document.getElementById('viewMsgSender');
            const viewMsgContact = document.getElementById('viewMsgContact');
            const viewMsgSubject = document.getElementById('viewMsgSubject');
            const viewMsgDate = document.getElementById('viewMsgDate');
            const viewMsgBody = document.getElementById('viewMsgBody');

            if (viewMsgSender) viewMsgSender.textContent = sender;
            if (viewMsgContact) viewMsgContact.textContent = `${email} • ${phone}`;
            if (viewMsgSubject) viewMsgSubject.textContent = subject;
            if (viewMsgDate) viewMsgDate.textContent = date;
            if (viewMsgBody) viewMsgBody.textContent = body;

            if (id) {
                fetch('/public/admin/message/update-status', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: id, status: 'read' })
                });
            }
        });
    });

    const addActivityForm = document.getElementById('addActivityForm');
    if (addActivityForm) {
        addActivityForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(addActivityForm);

            fetch('/public/admin/activity/create', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(resData => {
                if (resData.success) {
                    showToast('Activity added successfully!', 'success');
                    closeModal(addActivityForm.closest('.modal-overlay'));
                    setTimeout(() => window.location.reload(), 600);
                } else {
                    showToast(resData.message || 'Failed to add activity.', 'error');
                }
            })
            .catch(() => showToast('Network error adding activity.', 'error'));
        });
    }

    document.querySelectorAll('.btn-edit-activity').forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('editActivityId').value = btn.getAttribute('data-id');
            document.getElementById('editActivityTitle').value = btn.getAttribute('data-title');
            document.getElementById('editActivityPrice').value = btn.getAttribute('data-price');
            document.getElementById('editActivityCapacity').value = btn.getAttribute('data-capacity');
            document.getElementById('editActivityDescription').value = btn.getAttribute('data-description');
            document.getElementById('editActivityLocation').value = btn.getAttribute('data-location');
            document.getElementById('editActivityAge').value = btn.getAttribute('data-age');
            document.getElementById('editActivityAccompanied').value = btn.getAttribute('data-accompanied');
            const statusSelect = document.getElementById('editActivityStatus');
            if (statusSelect) statusSelect.value = btn.getAttribute('data-status') || 'available';
            openModal('editActivityModal');
        });
    });

    const editActivityForm = document.getElementById('editActivityForm');
    if (editActivityForm) {
        editActivityForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(editActivityForm);

            fetch('/public/admin/activity/update', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(resData => {
                if (resData.success) {
                    showToast('Activity updated successfully!', 'success');
                    closeModal(editActivityForm.closest('.modal-overlay'));
                    setTimeout(() => window.location.reload(), 600);
                } else {
                    showToast(resData.message || 'Failed to update activity.', 'error');
                }
            })
            .catch(() => showToast('Network error updating activity.', 'error'));
        });
    }

    document.querySelectorAll('.btn-delete-activity').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.getAttribute('data-id');
            if (confirm('Are you sure you want to delete this activity?')) {
                fetch('/public/admin/activity/delete', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: id })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        showToast('Activity deleted.', 'success');
                        setTimeout(() => window.location.reload(), 500);
                    } else {
                        showToast(data.message || 'Failed to delete activity.', 'error');
                    }
                });
            }
        });
    });

    const addPackForm = document.getElementById('addPackForm');
    if (addPackForm) {
        addPackForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(addPackForm);

            fetch('/public/admin/pack/create', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(resData => {
                if (resData.success) {
                    showToast('Pack added successfully!', 'success');
                    closeModal(addPackForm.closest('.modal-overlay'));
                    setTimeout(() => window.location.reload(), 600);
                } else {
                    showToast(resData.message || 'Failed to add pack.', 'error');
                }
            })
            .catch(() => showToast('Network error adding pack.', 'error'));
        });
    }

    document.querySelectorAll('.btn-edit-pack').forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('editPackId').value = btn.getAttribute('data-id');
            document.getElementById('editPackTitle').value = btn.getAttribute('data-title');
            document.getElementById('editPackPrice').value = btn.getAttribute('data-price');
            document.getElementById('editPackCapacity').value = btn.getAttribute('data-capacity');
            document.getElementById('editPackDescription').value = btn.getAttribute('data-description');
            document.getElementById('editPackLocation').value = btn.getAttribute('data-location');
            document.getElementById('editPackAge').value = btn.getAttribute('data-age');
            document.getElementById('editPackAccompanied').value = btn.getAttribute('data-accompanied');
            const statusSelect = document.getElementById('editPackStatus');
            if (statusSelect) statusSelect.value = btn.getAttribute('data-status') || 'available';
            openModal('editPackModal');
        });
    });

    const editPackForm = document.getElementById('editPackForm');
    if (editPackForm) {
        editPackForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(editPackForm);

            fetch('/public/admin/pack/update', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(resData => {
                if (resData.success) {
                    showToast('Pack updated successfully!', 'success');
                    closeModal(editPackForm.closest('.modal-overlay'));
                    setTimeout(() => window.location.reload(), 600);
                } else {
                    showToast(resData.message || 'Failed to update pack.', 'error');
                }
            })
            .catch(() => showToast('Network error updating pack.', 'error'));
        });
    }

    document.querySelectorAll('.btn-delete-pack').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.getAttribute('data-id');
            if (confirm('Are you sure you want to delete this pack?')) {
                fetch('/public/admin/pack/delete', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: id })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        showToast('Pack deleted.', 'success');
                        setTimeout(() => window.location.reload(), 500);
                    } else {
                        showToast(data.message || 'Failed to delete pack.', 'error');
                    }
                });
            }
        });
    });

    document.addEventListener('click', (e) => {
        const btn = e.target.closest ? e.target.closest('.btn-delete-booking') : null;
        if (!btn) return;

        const id = btn.getAttribute('data-id');
        if (confirm('Are you sure you want to delete this booking?')) {
            fetch('/public/admin/booking/delete', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: id })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    showToast('Booking deleted.', 'success');
                    const tr = btn.closest('tr');
                    if (tr) tr.remove();
                } else {
                    showToast(data.message || 'Failed to delete booking.', 'error');
                }
            })
            .catch(() => showToast('Network error deleting booking.', 'error'));
        }
    });

    document.querySelectorAll('.btn-delete-message').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.getAttribute('data-id');
            if (confirm('Are you sure you want to delete this message?')) {
                fetch('/public/admin/message/delete', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: id })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        showToast('Message deleted.', 'success');
                        const tr = btn.closest('tr');
                        if (tr) tr.remove();
                    } else {
                        showToast(data.message || 'Failed to delete message.', 'error');
                    }
                });
            }
        });
    });

    const bookingSearchInput = document.getElementById('bookingSearchInput');
    const bookingStatusFilter = document.getElementById('bookingStatusFilter');
    const bookingTypeFilter = document.getElementById('bookingTypeFilter');
    const bookingDateFilter = document.getElementById('bookingDateFilter');
    const bookingsTableBody = document.querySelector('#bookingsTable tbody');

    let bookingSearchTimer = null;
    let bookingSearchSeq = 0;

    async function loadBookings() {
        if (!bookingsTableBody) return;

        const seq = ++bookingSearchSeq;
        const params = new URLSearchParams({
            q: bookingSearchInput ? bookingSearchInput.value.trim() : '',
            type: bookingTypeFilter ? bookingTypeFilter.value : 'all',
            status: bookingStatusFilter ? bookingStatusFilter.value : 'all',
            date: bookingDateFilter ? bookingDateFilter.value : ''
        });

        try {
            const res = await fetch('/public/admin/bookings/search?' + params.toString());
            const data = await res.json();

            if (seq !== bookingSearchSeq) return;

            if (data.success) {
                bookingsTableBody.innerHTML = data.html;
                bookingsTableBody.querySelectorAll('.status-select').forEach(syncStatusSelectClass);
            } else {
                showToast(data.message || 'Failed to search bookings.', 'error');
            }
        } catch (err) {
            showToast('Network error searching bookings.', 'error');
        }
    }

    if (bookingSearchInput) {
        bookingSearchInput.addEventListener('input', () => {
            clearTimeout(bookingSearchTimer);
            bookingSearchTimer = setTimeout(loadBookings, 300);
        });
    }
    if (bookingStatusFilter) bookingStatusFilter.addEventListener('change', loadBookings);
    if (bookingTypeFilter) bookingTypeFilter.addEventListener('change', loadBookings);
    if (bookingDateFilter) bookingDateFilter.addEventListener('change', loadBookings);

    const messageSearchInput = document.getElementById('messageSearchInput');
    const messageStatusFilter = document.getElementById('messageStatusFilter');
    const messagesTableBody = document.querySelector('#messagesTable tbody');

    function filterMessagesDOM() {
        if (!messagesTableBody) return;
        const rows = messagesTableBody.querySelectorAll('tr');
        const query = messageSearchInput ? messageSearchInput.value.toLowerCase().trim() : '';
        const statusVal = messageStatusFilter ? messageStatusFilter.value.toLowerCase() : 'all';

        rows.forEach(row => {
            const senderName = row.querySelector('.customer-name')?.textContent.toLowerCase() || '';
            const email = row.children[2]?.textContent.toLowerCase() || '';
            const subject = row.children[4]?.textContent.toLowerCase() || '';
            const body = row.querySelector('.message-body-preview')?.textContent.toLowerCase() || '';
            const statusSelect = row.querySelector('.status-select');
            const rowStatus = statusSelect ? statusSelect.value.toLowerCase() : '';

            const matchesSearch = !query || senderName.includes(query) || email.includes(query) || subject.includes(query) || body.includes(query);
            const matchesStatus = statusVal === 'all' || rowStatus === statusVal;

            if (matchesSearch && matchesStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    if (messageSearchInput) messageSearchInput.addEventListener('input', filterMessagesDOM);
    if (messageStatusFilter) messageStatusFilter.addEventListener('change', filterMessagesDOM);

    const activitySearchInput = document.getElementById('activitySearchInput');
    const activitiesGrid = document.getElementById('activitiesGrid');

    if (activitySearchInput && activitiesGrid) {
        activitySearchInput.addEventListener('input', () => {
            const query = activitySearchInput.value.toLowerCase().trim();
            const cards = activitiesGrid.querySelectorAll('.item-card');

            cards.forEach(card => {
                const title = card.querySelector('.card-item-title')?.textContent.toLowerCase() || '';
                if (!query || title.includes(query)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }

    const availabilitySearchInput = document.getElementById('availabilitySearchInput');
    const availabilityTypeFilter = document.getElementById('availabilityTypeFilter');
    const availabilityStatusFilter = document.getElementById('availabilityStatusFilter');
    const availabilityDateFilter = document.getElementById('availabilityDateFilter');
    const availabilityTableBody = document.querySelector('#availabilityTable tbody');

    function filterAvailabilityDOM() {
        if (!availabilityTableBody) return;
        const rows = availabilityTableBody.querySelectorAll('tr');
        const query = availabilitySearchInput ? availabilitySearchInput.value.toLowerCase().trim() : '';
        const typeVal = availabilityTypeFilter ? availabilityTypeFilter.value.toLowerCase() : 'all';
        const statusVal = availabilityStatusFilter ? availabilityStatusFilter.value.toLowerCase() : 'all';
        const dateVal = availabilityDateFilter ? availabilityDateFilter.value : '';

        rows.forEach(row => {
            const rowDate = row.children[0]?.textContent.trim() || '';
            const rowType = row.children[1]?.textContent.toLowerCase().trim() || '';
            const rowTitle = row.children[2]?.textContent.toLowerCase() || '';
            const rowTime = row.children[3]?.textContent.toLowerCase() || '';
            const statusPill = row.querySelector('.status-pill');
            const rowStatusText = statusPill ? statusPill.textContent.trim().toLowerCase() : '';
            const isAvail = rowStatusText === 'available';

            const matchesSearch = !query || rowTitle.includes(query) || rowTime.includes(query);
            const matchesType = typeVal === 'all' || rowType.includes(typeVal);
            const matchesStatus = statusVal === 'all' || (statusVal === 'available' && isAvail) || (statusVal === 'not_available' && !isAvail);
            const matchesDate = !dateVal || rowDate.includes(dateVal);

            if (matchesSearch && matchesType && matchesStatus && matchesDate) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    if (availabilitySearchInput) availabilitySearchInput.addEventListener('input', filterAvailabilityDOM);
    if (availabilityTypeFilter) availabilityTypeFilter.addEventListener('change', filterAvailabilityDOM);
    if (availabilityStatusFilter) availabilityStatusFilter.addEventListener('change', filterAvailabilityDOM);
    if (availabilityDateFilter) availabilityDateFilter.addEventListener('change', filterAvailabilityDOM);

    function showToast(message, type = 'info') {
        let toastContainer = document.getElementById('toastContainer');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.id = 'toastContainer';
            toastContainer.className = 'toast-container';
            document.body.appendChild(toastContainer);
        }

        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        toast.innerHTML = `
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="16" x2="12" y2="12"></line>
                <line x1="12" y1="8" x2="12.01" y2="8"></line>
            </svg>
            <span>${escapeHTML(message)}</span>
        `;

        toastContainer.appendChild(toast);

        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(50px)';
            setTimeout(() => toast.remove(), 300);
        }, 3500);
    }

    function escapeHTML(str) {
        return (str || '').replace(/[&<>'"]/g,
            tag => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                "'": '&#39;',
                '"': '&quot;'
            }[tag] || tag)
        );
    }
});