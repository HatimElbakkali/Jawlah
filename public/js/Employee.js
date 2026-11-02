
document.addEventListener('DOMContentLoaded', () => {
    'use strict';

    const BASE = '/public/employee';
    const LOGIN_URL = '/employeeLogin';
    const DEFAULT_SECTION = '#bookings';
    async function request(url, { method = 'GET', body = null, signal } = {}) {
        const init = { method, signal, headers: { 'Accept': 'application/json' } };
        if (body !== null) {
            init.headers['Content-Type'] = 'application/json';
            init.body = JSON.stringify(body);
        }

        const res = await fetch(url, init);

        if (res.status === 401) {
            window.location.href = LOGIN_URL;
            throw new Error('SESSION_EXPIRED');
        }

        const text = await res.text();
        try {
            return JSON.parse(text);
        } catch (e) {
            console.error(`Server did not return JSON (status ${res.status}) for ${url}:\n`, text);
            throw new Error(`Server error (${res.status}) - check the console.`);
        }
    }

    function handleError(err, fallback) {
        if (err && (err.name === 'AbortError' || err.message === 'SESSION_EXPIRED')) return;
        console.error(err);
        showToast((err && err.message) || fallback, 'error');
    }

    function showToast(message, type = 'info') {
        let container = document.getElementById('toastContainer');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toastContainer';
            container.className = 'toast-container';
            document.body.appendChild(container);
        }

        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        toast.innerHTML = `
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="16" x2="12" y2="12"></line>
                <line x1="12" y1="8" x2="12.01" y2="8"></line>
            </svg>
            <span></span>
        `;
        toast.querySelector('span').textContent = message;
        container.appendChild(toast);

        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(50px)';
            setTimeout(() => toast.remove(), 300);
        }, 3500);
    }

    const navLinks = document.querySelectorAll('.sidebar-nav .nav-link');
    const sections = document.querySelectorAll('.content-section');
    const sidebar = document.querySelector('.sidebar');
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    function closeMobileSidebar() {
        if (sidebar) sidebar.classList.remove('open');
        if (sidebarOverlay) sidebarOverlay.classList.remove('open');
    }

    function switchSection(targetId) {
        if (!targetId) return;

        const sectionId = targetId.replace('#', '');
        const targetSection = document.getElementById(sectionId);

        if (!targetSection) {
            if (targetId !== DEFAULT_SECTION) switchSection(DEFAULT_SECTION);
            return;
        }

        sections.forEach(sec => sec.classList.remove('active'));
        targetSection.classList.add('active');

        navLinks.forEach(link => {
            const linkTarget = link.getAttribute('href').replace('#', '');
            link.classList.toggle('active', linkTarget === sectionId);
        });

        window.scrollTo({ top: 0, behavior: 'smooth' });
        closeMobileSidebar();
    }

    navLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const targetId = link.getAttribute('href');
            switchSection(targetId);
            history.pushState(null, null, targetId);
        });
    });

    switchSection(window.location.hash || DEFAULT_SECTION);

    window.addEventListener('popstate', () => {
        switchSection(window.location.hash || DEFAULT_SECTION);
    });

    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', () => {
            if (sidebar) sidebar.classList.toggle('open');
            if (sidebarOverlay) sidebarOverlay.classList.toggle('open');
        });
    }
    if (sidebarOverlay) sidebarOverlay.addEventListener('click', closeMobileSidebar);

    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('open');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeModal(modal) {
        if (modal) {
            modal.classList.remove('open');
            document.body.style.overflow = '';
        }
    }

    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) closeModal(overlay);
        });
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal-overlay').forEach(closeModal);
        }
    });

    const STATUS_CLASSES = ['confirmed', 'pending', 'cancelled', 'completed', 'read', 'unread', 'replied'];

    function syncStatusSelectClass(select) {
        if (!select) return;
        select.classList.remove(...STATUS_CLASSES);
        select.classList.add(select.value);
    }

    function initStatusSelects(root = document) {
        root.querySelectorAll('.status-select').forEach(select => {
            syncStatusSelectClass(select);
            select.dataset.prev = select.value;
        });
    }

    initStatusSelects();

    function refreshUnreadBadge() {
        const unread = document.querySelectorAll('#messagesTable .status-select[data-message-id]');
        let count = 0;
        unread.forEach(sel => { if (sel.value === 'unread') count++; });
        document.querySelectorAll('.nav-badge, .badge-count').forEach(el => { el.textContent = count; });
    }

    async function updateStatus(select) {
        const bookingId = select.getAttribute('data-booking-id');
        const messageId = select.getAttribute('data-message-id');
        const newStatus = select.value;

        syncStatusSelectClass(select);

        const isBooking = !!bookingId;
        const url = isBooking ? `${BASE}/booking/update-status` : `${BASE}/message/update-status`;
        const label = isBooking ? 'Booking' : 'Message';

        try {
            const data = await request(url, {
                method: 'POST',
                body: { id: isBooking ? bookingId : messageId, status: newStatus }
            });

            if (data.success) {
                select.dataset.prev = newStatus;
                showToast(`${label} status updated.`, 'success');
                if (!isBooking) refreshUnreadBadge();
            } else {
                throw new Error(data.message || `Failed to update ${label.toLowerCase()} status.`);
            }
        } catch (err) {
            select.value = select.dataset.prev || select.value;
            syncStatusSelectClass(select);
            handleError(err, `Network error updating ${label.toLowerCase()} status.`);
        }
    }

    document.addEventListener('change', (e) => {
        const select = e.target.closest ? e.target.closest('.status-select') : null;
        if (!select) return;
        if (!select.hasAttribute('data-booking-id') && !select.hasAttribute('data-message-id')) return;
        updateStatus(select);
    });

    // =====================================================================
    // Click delegation: modals, view message, delete booking, delete message
    // =====================================================================

    async function deleteItem({ btn, endpoint, confirmText, okText, failText }) {
        if (!confirm(confirmText)) return;

        try {
            const data = await request(`${BASE}/${endpoint}`, {
                method: 'POST',
                body: { id: btn.getAttribute('data-id') }
            });

            if (data.success) {
                showToast(okText, 'success');
                const tr = btn.closest('tr');
                if (tr) tr.remove();
                refreshUnreadBadge();
            } else {
                throw new Error(data.message || failText);
            }
        } catch (err) {
            handleError(err, 'Network error. Please try again.');
        }
    }

    async function viewMessage(btn) {
        const g = (name, fallback = '') => btn.getAttribute(name) || fallback;

        const set = (id, text) => {
            const el = document.getElementById(id);
            if (el) el.textContent = text;
        };

        set('viewMsgSender', g('data-sender', 'Customer'));
        set('viewMsgContact', `${g('data-email')} • ${g('data-phone')}`);
        set('viewMsgSubject', g('data-subject'));
        set('viewMsgDate', g('data-date'));
        set('viewMsgBody', g('data-body'));

        const id = g('data-id');
        const row = btn.closest('tr');
        const select = row ? row.querySelector('.status-select[data-message-id]') : null;

        if (id && select && select.value === 'unread') {
            try {
                const data = await request(`${BASE}/message/update-status`, {
                    method: 'POST',
                    body: { id, status: 'read' }
                });
                if (data.success) {
                    select.value = 'read';
                    select.dataset.prev = 'read';
                    syncStatusSelectClass(select);
                    refreshUnreadBadge();
                }
            } catch (err) {
                handleError(err, 'Could not mark the message as read.');
            }
        }
    }

    document.addEventListener('click', (e) => {
        if (!e.target.closest) return;

        const closeBtn = e.target.closest('[data-modal-close]');
        if (closeBtn) {
            closeModal(closeBtn.closest('.modal-overlay'));
            return;
        }

        const viewBtn = e.target.closest('.btn-view-message');
        if (viewBtn) {
            viewMessage(viewBtn);
        }

        const opener = e.target.closest('[data-modal-target]');
        if (opener) {
            e.preventDefault();
            openModal(opener.getAttribute('data-modal-target'));
            return;
        }

        const delBooking = e.target.closest('.btn-delete-booking');
        if (delBooking) {
            deleteItem({
                btn: delBooking,
                endpoint: 'booking/delete',
                confirmText: 'Are you sure you want to delete this booking?',
                okText: 'Booking deleted.',
                failText: 'Failed to delete booking.'
            });
            return;
        }

        const delMessage = e.target.closest('.btn-delete-message');
        if (delMessage) {
            deleteItem({
                btn: delMessage,
                endpoint: 'message/delete',
                confirmText: 'Are you sure you want to delete this message?',
                okText: 'Message deleted.',
                failText: 'Failed to delete message.'
            });
        }
    });

    const bookingSearchInput = document.getElementById('bookingSearchInput');
    const bookingStatusFilter = document.getElementById('bookingStatusFilter');
    const bookingTypeFilter = document.getElementById('bookingTypeFilter');
    const bookingDateFilter = document.getElementById('bookingDateFilter');
    const bookingsTableBody = document.querySelector('#bookingsTable tbody');

    let bookingSearchTimer = null;
    let bookingAbortCtrl = null;

    async function loadBookings() {
        if (!bookingsTableBody) return;

        if (bookingAbortCtrl) bookingAbortCtrl.abort();
        bookingAbortCtrl = new AbortController();

        const params = new URLSearchParams({
            q: bookingSearchInput ? bookingSearchInput.value.trim() : '',
            type: bookingTypeFilter ? bookingTypeFilter.value : 'all',
            status: bookingStatusFilter ? bookingStatusFilter.value : 'all',
            date: bookingDateFilter ? bookingDateFilter.value : ''
        });

        try {
            const data = await request(`${BASE}/bookings/search?${params.toString()}`, {
                signal: bookingAbortCtrl.signal
            });

            if (data.success) {
                bookingsTableBody.innerHTML = data.html;
                initStatusSelects(bookingsTableBody);
            } else {
                showToast(data.message || 'Failed to search bookings.', 'error');
            }
        } catch (err) {
            handleError(err, 'Network error searching bookings.');
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

        const query = messageSearchInput ? messageSearchInput.value.toLowerCase().trim() : '';
        const statusVal = messageStatusFilter ? messageStatusFilter.value.toLowerCase() : 'all';

        messagesTableBody.querySelectorAll('tr').forEach(row => {
            const senderName = row.querySelector('.customer-name')?.textContent.toLowerCase() || '';
            const email = row.children[2]?.textContent.toLowerCase() || '';
            const subject = row.children[4]?.textContent.toLowerCase() || '';
            const body = row.querySelector('.message-body-preview')?.textContent.toLowerCase() || '';
            const statusSelect = row.querySelector('.status-select');
            const rowStatus = statusSelect ? statusSelect.value.toLowerCase() : '';

            const matchesSearch = !query || senderName.includes(query) || email.includes(query)
                || subject.includes(query) || body.includes(query);
            const matchesStatus = statusVal === 'all' || rowStatus === statusVal;

            row.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
        });
    }

    if (messageSearchInput) messageSearchInput.addEventListener('input', filterMessagesDOM);
    if (messageStatusFilter) messageStatusFilter.addEventListener('change', filterMessagesDOM);
    // re-apply the filter when a status changes (e.g. unread -> read while filtering "unread")
    document.addEventListener('change', (e) => {
        if (e.target.closest && e.target.closest('#messagesTable .status-select')) filterMessagesDOM();
    });

    const availabilitySearchInput = document.getElementById('availabilitySearchInput');
    const availabilityTypeFilter = document.getElementById('availabilityTypeFilter');
    const availabilityStatusFilter = document.getElementById('availabilityStatusFilter');
    const availabilityDateFilter = document.getElementById('availabilityDateFilter');
    const availabilityTableBody = document.querySelector('#availabilityTable tbody');

    function filterAvailabilityDOM() {
        if (!availabilityTableBody) return;

        const query = availabilitySearchInput ? availabilitySearchInput.value.toLowerCase().trim() : '';
        const typeVal = availabilityTypeFilter ? availabilityTypeFilter.value.toLowerCase() : 'all';
        const statusVal = availabilityStatusFilter ? availabilityStatusFilter.value.toLowerCase() : 'all';
        const dateVal = availabilityDateFilter ? availabilityDateFilter.value : '';

        availabilityTableBody.querySelectorAll('tr').forEach(row => {
            const rowDate = row.children[0]?.textContent.trim() || '';
            const rowType = row.children[1]?.textContent.toLowerCase().trim() || '';
            const rowTitle = row.children[2]?.textContent.toLowerCase() || '';
            const rowTime = row.children[3]?.textContent.toLowerCase() || '';
            const pill = row.querySelector('.status-pill');
            const isAvail = pill ? pill.textContent.trim().toLowerCase() === 'available' : false;

            const matchesSearch = !query || rowTitle.includes(query) || rowTime.includes(query);
            const matchesType = typeVal === 'all' || rowType.includes(typeVal);
            const matchesStatus = statusVal === 'all'
                || (statusVal === 'available' && isAvail)
                || (statusVal === 'not_available' && !isAvail);
            const matchesDate = !dateVal || rowDate.includes(dateVal);

            row.style.display = (matchesSearch && matchesType && matchesStatus && matchesDate) ? '' : 'none';
        });
    }

    if (availabilitySearchInput) availabilitySearchInput.addEventListener('input', filterAvailabilityDOM);
    if (availabilityTypeFilter) availabilityTypeFilter.addEventListener('change', filterAvailabilityDOM);
    if (availabilityStatusFilter) availabilityStatusFilter.addEventListener('change', filterAvailabilityDOM);
    if (availabilityDateFilter) availabilityDateFilter.addEventListener('change', filterAvailabilityDOM);
});