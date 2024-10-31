const logreBox = document.querySelector('.logreg-box');
const loginLink = document.querySelector('.login-link');
const registerLink = document.querySelector('.register-link');

//for rememberMe function
const rmCheck = document.getElementById("checker");
const emailInput = document.getElementById("mail");
const signInBtn = document.getElementById("sign-in-btn");

if (localStorage.checkbox && localStorage.checkbox !== "") {
rmCheck.setAttribute("checked", "checked");
emailInput.value = localStorage.username;
} else {
rmCheck.removeAttribute("checked");
emailInput.value = "";
}

function lsRememberMe() {
if (rmCheck.checked && emailInput.value !== "") {
  localStorage.username = emailInput.value;
  localStorage.checkbox = rmCheck.value;
} else {
  localStorage.username = "";
  localStorage.checkbox = "";
}
}

//for sign in/up page shift
registerLink.addEventListener('click', () => {
  logreBox.classList.add('active');
});

loginLink.addEventListener('click', () => {
  logreBox.classList.remove('active');
});

//for checking if input data is valid
