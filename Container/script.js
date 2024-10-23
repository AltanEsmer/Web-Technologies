const logreBox = document.querySelector('.logreg-box')
const loginLink = document.querySelector('.login-link')
const registerLink = document.querySelector('.register-link')

// Dilara burdaydı

registerLink.addEventListener('click', () => {
  logreBox.classList.add('active');
});

loginLink.addEventListener('click', () => {
  logreBox.classList.remove('active');
});
