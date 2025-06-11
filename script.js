const container = document.querySelector(".container");
const formTitle = document.getElementById("formTitle");
const loginForm = document.getElementById("loginForm");
const registerForm = document.getElementById("registerForm");
const toggleBtn = document.getElementById("toggleBtn");

toggleBtn.addEventListener("click", () => {
  container.classList.toggle("active");

  if (container.classList.contains("active")) {
    formTitle.innerText = "Register";
    loginForm.style.display = "none";
    registerForm.style.display = "block";
    toggleBtn.innerText = "Login";
  } else {
    formTitle.innerText = "Login";
    loginForm.style.display = "block";
    registerForm.style.display = "none";
    toggleBtn.innerText = "Register";
  }
});
