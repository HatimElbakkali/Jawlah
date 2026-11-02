const form = document.getElementById("contactForm");
const submitBtn = document.getElementById("submitBtn");
const toast = document.getElementById("toast");
const toastMessage = document.getElementById("toastMessage");

let sendingInterval;
let toastTimeout;

form.addEventListener("submit", async (e) => {
  e.preventDefault();
  const name = form.name.value.trim();
  const email = form.email.value.trim();
  const phone = form.phone.value.trim();

  if (!name || !phone) {
    showToast("Please fill in all required fields (*).");
    return;
  }

  if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
    showToast("Please enter a valid email address.");
    return;
  }

  const formData = new FormData(form);

  submitBtn.disabled = true;
  let dots = 1;
  submitBtn.textContent = "Sending.";
  sendingInterval = setInterval(() => {
    dots++;
    if (dots > 3) {
      dots = 1;
    }
    submitBtn.textContent = "Sending" + ".".repeat(dots);
  }, 500);

  try {
    const response = await fetch("/public/contact", {
      method: "POST",
      body: formData,
    });

    const data = await response.json();

    if (data.success === true) {
      form.reset();
      showToast("Your message has been sent successfully! Our team will get back to you soon.", "success");
    } else {
      showToast(data.message || "Something went wrong.");
    }
  } catch (error) {
    showToast("Something went wrong. Please try again.");
  } finally {
    clearInterval(sendingInterval);
    submitBtn.disabled = false;
    submitBtn.textContent = "Send Message";
  }

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
});
