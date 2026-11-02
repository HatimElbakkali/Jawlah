document.addEventListener("DOMContentLoaded", () => {
  const state = {
    adults: 0,
    children: 0,
    infants: 0,
    selectedDate: null,
    selectedDateFull: null,
    selectedTime: null,
    duration: null,
    pricePerPerson: 0,
    existingBookings: [],
    capacity: 30,
    currentStep: 2,
  };

  const toast = document.getElementById("toast");
  const toastMessage = document.getElementById("toastMessage");
  let toastTimeout;

  function showToast(message, type = "error") {
    clearTimeout(toastTimeout);
    toastMessage.textContent = message;
    toast.classList.remove("toast--success", "toast--error");
    toast.classList.add(`toast--${type}`);
    toast.classList.add("show");

    toastTimeout = setTimeout(() => {
      toast.classList.remove("show");
    }, 3500);
  }

  const elements = {
    stepNodes: document.querySelectorAll(".step-item"),

    screenDate: document.getElementById("screen-date"),
    screenDuration: document.getElementById("screen-duration"),
    screenTime: document.getElementById("screen-time"),
    screenParticipants: document.getElementById("screen-participants"),
    screenReview: document.getElementById("screen-review"),

    calMonthTitle: document.getElementById("cal-month-title"),
    calGrid: document.getElementById("calendar-days-grid"),
    calPrevBtn: document.getElementById("cal-prev"),
    calNextBtn: document.getElementById("cal-next"),
    datePicker: document.getElementById("date-picker"),

    durationCards: document.querySelectorAll(".duration-select-card"),

    timeSlotBtns: document.querySelectorAll(".time-slot-btn"),
    metaDateDisplay: document.getElementById("meta-date-display"),
    metaDurationDisplay: document.getElementById("meta-duration-display"),
    metaCapacityDisplay: document.getElementById("meta-capacity-display"),

    adultsCount: document.getElementById("adults-count"),
    adultsInc: document.getElementById("adults-inc"),
    adultsDec: document.getElementById("adults-dec"),

    childrenCount: document.getElementById("children-count"),
    childrenInc: document.getElementById("children-inc"),
    childrenDec: document.getElementById("children-dec"),

    infantsCount: document.getElementById("infants-count"),
    infantsInc: document.getElementById("infants-inc"),
    infantsDec: document.getElementById("infants-dec"),

    revDateVal: document.getElementById("rev-date-val"),
    revDurationVal: document.getElementById("rev-duration-val"),
    revTimeVal: document.getElementById("rev-time-val"),
    revParticipantsVal: document.getElementById("rev-participants-val"),
    revTotalVal: document.getElementById("rev-total-val"),

    payRadios: document.querySelectorAll('input[name="payment-type"]'),
    payTabOptions: document.querySelectorAll(".pay-tab-option"),
    payTabPanels: document.querySelectorAll(".pay-tab-panel"),

    adultPriceDetail: document.getElementById("adult-price-detail"),
    adultTotalDetail: document.getElementById("adult-total-detail"),
    childPriceDetail: document.getElementById("child-price-detail"),
    childTotalDetail: document.getElementById("child-total-detail"),

    btnNextDate: document.getElementById("btn-next-date"),
    btnNextDuration: document.getElementById("btn-next-duration"),
    btnBackDuration: document.getElementById("btn-back-duration"),

    btnNextTime: document.getElementById("btn-next-time"),
    btnBackTime: document.getElementById("btn-back-time"),

    btnNextParticipants: document.getElementById("btn-next-participants"),
    btnBackParticipants: document.getElementById("btn-back-participants"),

    btnConfirmBooking: document.getElementById("btn-confirm-booking"),
    btnBackReview: document.getElementById("btn-back-review"),

    modalConfirm: document.getElementById("modal-confirm"),
    btnCloseModal: document.getElementById("btn-close-modal"),
    modalDateVal: document.getElementById("modal-date-val"),
    modalTimeVal: document.getElementById("modal-time-val"),
    modalPriceVal: document.getElementById("modal-price-val"),
    modalPayMethod: document.getElementById("modal-pay-method"),
    modalRefCode: document.getElementById("modal-ref-code"),
    formName: document.getElementById("form-name"),
    formEmail: document.getElementById("form-email"),
    formPhone: document.getElementById("form-phone"),
  };

  const monthNames = [
    "January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
  ];

  function toDateInputValue(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, "0");
    const day = String(date.getDate()).padStart(2, "0");
    return `${year}-${month}-${day}`;
  }

  function parseDateInput(value) {
    const [year, month, day] = value.split("-").map(Number);
    return new Date(year, month - 1, day);
  }

  function formatDate(date) {
    return date.toLocaleDateString("en-GB", {
      day: "2-digit",
      month: "long",
      year: "numeric",
    });
  }

  function timeToMinutes(timeStr) {
    if (!timeStr) return 0;
    const parts = timeStr.trim().split(" ");
    const [hoursStr, minutesStr] = parts[0].split(":");
    let hours = parseInt(hoursStr, 10);
    const minutes = parseInt(minutesStr, 10);

    if (parts[1] === "PM" && hours !== 12) hours += 12;
    if (parts[1] === "AM" && hours === 12) hours = 0;

    return hours * 60 + minutes;
  }

  async function fetchAvailability() {
    if (!state.selectedDate) return;

    const params = new URLSearchParams(window.location.search);
    const type = params.get("type");
    const id = params.get("id");

    if (!type || !id) return;

    try {
      const response = await fetch(
        `/public/booking/availability?type=${encodeURIComponent(type)}&id=${encodeURIComponent(id)}&date=${encodeURIComponent(state.selectedDate)}`
      );

      if (!response.ok) return;

      const data = await response.json();

      if (data.success) {
        if (data.capacity) {
          state.capacity = Number(data.capacity);
          if (elements.metaCapacityDisplay) {
            elements.metaCapacityDisplay.textContent = state.capacity;
          }
        }
        state.existingBookings = data.bookings || [];
        updateTimeSlotsAvailability();
      }
    } catch (err) {
    }
  }

  function updateTimeSlotsAvailability() {
    if (!elements.datePicker.value) return;

    const selectedDate = parseDateInput(elements.datePicker.value);
    selectedDate.setHours(0, 0, 0, 0);

    const today = new Date();
    today.setHours(0, 0, 0, 0);

    const isToday = selectedDate.getTime() === today.getTime();
    const now = new Date();
    const currentMinutesNow = now.getHours() * 60 + now.getMinutes();

    const durationMinutes = parseInt(state.duration, 10) || 30;
    const userParticipants = state.adults + state.children + state.infants;
    const capacity = state.capacity || 30;

    elements.timeSlotBtns.forEach((button) => {
      const slotStart = timeToMinutes(button.dataset.time);
      const isPast = isToday && slotStart < currentMinutesNow;

      button.classList.remove("available", "limited", "fully-booked", "past");

      if (isPast) {
        button.disabled = true;
        button.classList.add("past");
        if (state.selectedTime === button.dataset.time) {
          state.selectedTime = null;
          button.classList.remove("selected");
        }
        return;
      }

      let maxOccupied = 0;
      for (let t = slotStart; t < slotStart + durationMinutes; t += 30) {
        let windowOccupied = 0;

        (state.existingBookings || []).forEach((b) => {
          const bStart = timeToMinutes(b.selected_time);
          const bDur = parseInt(b.duration, 10) || 30;
          const bEnd = bStart + bDur;

          if (bStart < t + 30 && bEnd > t) {
            windowOccupied +=
              (parseInt(b.adults, 10) || 0) +
              (parseInt(b.children, 10) || 0) +
              (parseInt(b.infants, 10) || 0);
          }
        });

        if (windowOccupied > maxOccupied) {
          maxOccupied = windowOccupied;
        }
      }

      const usedPercentage = (maxOccupied / capacity) * 100;
      const isExceeded = (maxOccupied + userParticipants) > capacity;
      const remainingSpots = Math.max(0, capacity - maxOccupied);

      button.setAttribute("title", `${remainingSpots} / ${capacity} places available`);

      if (usedPercentage >= 100 || isExceeded) {
        button.disabled = true;
        button.classList.add("fully-booked");
        if (state.selectedTime === button.dataset.time) {
          state.selectedTime = null;
          button.classList.remove("selected");
        }
      } else if (usedPercentage >= 70) {
        button.disabled = false;
        button.classList.add("limited");
      } else {
        button.disabled = false;
        button.classList.add("available");
      }

      if (state.selectedTime === button.dataset.time && elements.metaCapacityDisplay) {
        elements.metaCapacityDisplay.textContent = `${remainingSpots} / ${capacity} remaining`;
      }
    });

    if (!state.selectedTime && elements.metaCapacityDisplay) {
      elements.metaCapacityDisplay.textContent = `${capacity}`;
    }
  }

  function setSelectedDate(value) {
    if (!value) return;

    const selectedDate = parseDateInput(value);

    state.selectedDate = value;
    state.selectedDateFull = formatDate(selectedDate);

    state.calYear = selectedDate.getFullYear();
    state.calMonth = selectedDate.getMonth();

    elements.datePicker.value = value;
    elements.metaDateDisplay.textContent = state.selectedDateFull;

    renderCalendar(state.calYear, state.calMonth);
    fetchAvailability();
  }

  function renderCalendar(year, monthIndex) {
    elements.calMonthTitle.textContent = `${monthNames[monthIndex]} ${year}`;
    elements.calGrid.innerHTML = "";

    const today = new Date();
    today.setHours(0, 0, 0, 0);

    const selectedValue = elements.datePicker.value;
    const firstDayIndex = new Date(year, monthIndex, 1).getDay();
    const daysInMonth = new Date(year, monthIndex + 1, 0).getDate();

    for (let i = 0; i < firstDayIndex; i++) {
      const emptyCell = document.createElement("div");
      emptyCell.className = "cal-day empty";
      elements.calGrid.appendChild(emptyCell);
    }

    for (let day = 1; day <= daysInMonth; day++) {
      const dayCell = document.createElement("div");
      const cellDate = new Date(year, monthIndex, day);
      const cellValue = toDateInputValue(cellDate);

      dayCell.className = "cal-day";
      dayCell.textContent = day;
      dayCell.dataset.date = cellValue;

      if (cellDate < today) {
        dayCell.classList.add("disabled");
      }

      if (cellValue === selectedValue) {
        dayCell.classList.add("selected");
      }

      dayCell.addEventListener("click", () => {
        if (cellDate < today) return;

        document.querySelectorAll(".cal-day").forEach((cell) => {
          cell.classList.remove("selected");
        });

        dayCell.classList.add("selected");
        setSelectedDate(cellValue);
      });

      elements.calGrid.appendChild(dayCell);
    }
  }

  function updateReviewPage() {
    elements.revDateVal.textContent = state.selectedDateFull || "Not selected";
    elements.revDurationVal.textContent = state.duration || "Not selected";
    elements.revTimeVal.textContent = state.selectedTime || "Not selected";

    let participantsText = `${state.adults} Adult`;

    if (state.adults !== 1) {
      participantsText = `${state.adults} Adults`;
    }

    if (state.children > 0) {
      participantsText += `, ${state.children} Child`;
    }

    if (state.infants > 0) {
      participantsText += `, ${state.infants} Infant`;
    }

    const childPrice = state.pricePerPerson / 2;
    const totalPrice =
      state.adults * state.pricePerPerson + state.children * childPrice;

    elements.adultPriceDetail.textContent = `${state.adults} Adults × $${state.pricePerPerson}`;
    elements.adultTotalDetail.textContent = `$${state.adults * state.pricePerPerson}`;
    elements.childPriceDetail.textContent = `${state.children} Child × $${childPrice}`;
    elements.childTotalDetail.textContent = `$${state.children * childPrice}`;

    elements.revParticipantsVal.textContent = participantsText;
    elements.revTotalVal.textContent = `$${totalPrice}`;
  }

  function updateStepView(targetStep) {
    if (targetStep < 2 || targetStep > 6) return;

    state.currentStep = targetStep;

    elements.stepNodes.forEach((node) => {
      const nodeStep = Number(node.dataset.step);
      node.classList.remove("active", "completed");

      if (nodeStep < state.currentStep) {
        node.classList.add("completed");
      } else if (nodeStep === state.currentStep) {
        node.classList.add("active");
      }
    });

    document.querySelectorAll(".step-connector").forEach((connector, index) => {
      connector.classList.toggle("completed", index < state.currentStep - 1);
    });

    [
      elements.screenDate,
      elements.screenDuration,
      elements.screenTime,
      elements.screenParticipants,
      elements.screenReview,
    ].forEach((screen) => {
      screen?.classList.remove("active");
    });

    if (targetStep === 2) elements.screenDate?.classList.add("active");
    if (targetStep === 3) elements.screenDuration?.classList.add("active");
    if (targetStep === 4) {
      elements.screenTime?.classList.add("active");
      updateTimeSlotsAvailability();
    }
    if (targetStep === 5) elements.screenParticipants?.classList.add("active");

    if (targetStep === 6) {
      elements.screenReview?.classList.add("active");
      updateReviewPage();
    }

    window.scrollTo({
      top: 0,
      behavior: "smooth",
    });
  }

  function setupEventListeners() {
    elements.btnNextDate.addEventListener("click", () => {
      updateStepView(3);
    });

    elements.datePicker.addEventListener("change", () => {
      if (elements.datePicker.value) {
        setSelectedDate(elements.datePicker.value);
      }
    });

    elements.calPrevBtn.addEventListener("click", () => {
      state.calMonth--;

      if (state.calMonth < 0) {
        state.calMonth = 11;
        state.calYear--;
      }

      renderCalendar(state.calYear, state.calMonth);
    });

    elements.calNextBtn.addEventListener("click", () => {
      state.calMonth++;

      if (state.calMonth > 11) {
        state.calMonth = 0;
        state.calYear++;
      }

      renderCalendar(state.calYear, state.calMonth);
    });

    elements.durationCards.forEach((card) => {
      card.addEventListener("click", () => {
        elements.durationCards.forEach((item) => {
          item.classList.remove("selected");
        });

        card.classList.add("selected");

        state.duration = card.dataset.duration;
        state.pricePerPerson = Number(card.dataset.price);

        elements.metaDurationDisplay.textContent = state.duration;
        updateTimeSlotsAvailability();
      });
    });

    elements.btnNextDuration.addEventListener("click", () => {
      const selectedDuration = document.querySelector(
        ".duration-select-card.selected",
      );

      if (!selectedDuration) {
        showToast("Please select a duration first.");
        return;
      }

      updateStepView(4);
    });

    elements.btnBackDuration.addEventListener("click", () => {
      updateStepView(2);
    });

    elements.timeSlotBtns.forEach((button) => {
      button.addEventListener("click", () => {
        if (button.disabled) return;

        elements.timeSlotBtns.forEach((item) => {
          item.classList.remove("selected");
        });

        button.classList.add("selected");
        state.selectedTime = button.dataset.time;
        updateTimeSlotsAvailability();
      });
    });

    elements.btnNextTime.addEventListener("click", () => {
      if (!state.selectedTime) {
        showToast("Please select an available time first.");
        return;
      }

      updateStepView(5);
    });

    elements.btnBackTime.addEventListener("click", () => {
      updateStepView(3);
    });

    elements.btnNextParticipants.addEventListener("click", () => {
      if (state.adults < 1) {
        showToast("At least one adult is required for a booking.");
        return;
      }

      updateStepView(6);
    });

    elements.btnBackParticipants.addEventListener("click", () => {
      updateStepView(4);
    });

    elements.adultsInc.addEventListener("click", () => {
      state.adults++;
      elements.adultsCount.textContent = state.adults;
      updateTimeSlotsAvailability();
      updateReviewPage();
    });

    elements.adultsDec.addEventListener("click", () => {
      if (state.adults > 0) {
        state.adults--;
        elements.adultsCount.textContent = state.adults;
        updateTimeSlotsAvailability();
        updateReviewPage();
      }
    });

    elements.childrenInc.addEventListener("click", () => {
      state.children++;
      elements.childrenCount.textContent = state.children;
      updateTimeSlotsAvailability();
      updateReviewPage();
    });

    elements.childrenDec.addEventListener("click", () => {
      if (state.children > 0) {
        state.children--;
        elements.childrenCount.textContent = state.children;
        updateTimeSlotsAvailability();
        updateReviewPage();
      }
    });

    elements.infantsInc?.addEventListener("click", () => {
      state.infants++;
      elements.infantsCount.textContent = state.infants;
      updateTimeSlotsAvailability();
      updateReviewPage();
    });

    elements.infantsDec?.addEventListener("click", () => {
      if (state.infants > 0) {
        state.infants--;
        elements.infantsCount.textContent = state.infants;
        updateTimeSlotsAvailability();
        updateReviewPage();
      }
    });

    elements.btnBackReview.addEventListener("click", () => {
      updateStepView(5);
    });

    elements.btnConfirmBooking.addEventListener("click", async () => {
      const name = elements.formName.value.trim();
      const email = elements.formEmail.value.trim();
      const phone = elements.formPhone.value.trim();

      if (!name || !phone || !email) {
        showToast("Please fill in all required fields (*).");
        return;
      }

      if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        showToast("Please enter a valid email address.");
        return;
      }

      if (!state.selectedTime) {
        showToast("Not enough capacity available.");
        return;
      }

      const params = new URLSearchParams(window.location.search);
      const type = params.get("type");
      const id = params.get("id");
      const bookingData = {
        idTour: id,
        type: type,
        date: state.selectedDate,
        time: state.selectedTime,
        duration: state.duration,
        adults: state.adults,
        children: state.children,
        infants: state.infants,
        full_name: name,
        email: email,
        phone: phone,
      };

      try {
        elements.btnConfirmBooking.disabled = true;
        elements.btnConfirmBooking.textContent = "Processing...";

        const response = await fetch("/public/booking", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(bookingData),
        });

        const result = await response.json();

        if (!response.ok || !result.success) {
          throw new Error(result.message || "Booking failed");
        }

        const childPrice = state.pricePerPerson / 2;
        const totalPrice =
          state.adults * state.pricePerPerson + state.children * childPrice;

        elements.modalDateVal.textContent = state.selectedDateFull;
        elements.modalTimeVal.textContent = `${state.selectedTime} (${state.duration})`;

        elements.modalPriceVal.textContent = `$${totalPrice}`;
        if (elements.modalPayMethod) {
          elements.modalPayMethod.textContent = "Credit Card";
        }

        if (elements.modalRefCode && result.code) {
          elements.modalRefCode.textContent = result.code;
        }

        elements.modalConfirm.classList.add("active");
      } catch (error) {
        showToast(error.message || "Something went wrong. Please try again.");
      } finally {
        elements.btnConfirmBooking.disabled = false;
        elements.btnConfirmBooking.textContent = "Confirm Booking";
      }
    });


    elements.btnCloseModal.addEventListener("click", () => {
      elements.modalConfirm.classList.remove("active");
      updateStepView(2);
    });
  }

  function init() {
    const today = new Date();
    const todayValue = toDateInputValue(today);

    elements.datePicker.min = todayValue;
    elements.datePicker.value = todayValue;

    const selectedDuration = document.querySelector(
      ".duration-select-card.selected",
    );

    if (selectedDuration) {
      state.duration = selectedDuration.dataset.duration;
      state.pricePerPerson = Number(selectedDuration.dataset.price);
      elements.metaDurationDisplay.textContent = state.duration;
    }

    if (elements.metaCapacityDisplay) {
      const capVal = elements.metaCapacityDisplay.dataset.capacity || elements.metaCapacityDisplay.textContent;
      if (capVal) {
        state.capacity = parseInt(capVal, 10);
      }
    }

    setSelectedDate(todayValue);
    setInterval(updateTimeSlotsAvailability, 60000);

    updateStepView(2);
    setupEventListeners();
  }

  init();
});