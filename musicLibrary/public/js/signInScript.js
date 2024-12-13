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

//for logging in with guest user
const guestLogin = document.querySelector('.guest-login');
guestLogin.addEventListener('click', function(event) {
  event.preventDefault();
  createGuestUser();
})

const createGuestUser = () => {
  const namePool = {
    firstName: [
      "Melodic", "Rhythmic", "Harmonious", "Tuneful", "Symphonic",
      "Chordal", "Lyrical", "Crescendoing", "Resonant", "Acoustic",
      "Vibrato", "Polyphonic", "Pianissimo", "Forte", "Mezzo", 
      "Staccato", "Allegro", "Andante", "Operatic", "Serenading"
    ],
    secondName: [
      "Waffle", "Pickle", "Noodle", "Platypus", "Blimp",
      "Lobster", "Tofu", "Sock", "Pogo", "Doodle",
      "Giraffe", "Zucchini", "Sneeze", "Elbow", "Puddle",
      "Cactus", "Ferret", "Jellybean", "Otter", "Walrus"
    ]
  }
  const username = namePool.firstName[Math.floor(Math.random()*19)] + namePool.secondName[Math.floor(Math.random()*19)] + Math.floor(Math.random()*100)
  const usertype = "guest";

  const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  // Send the POST request to the backend
  fetch('/guest-login', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': csrfToken,
    },
    body: JSON.stringify({ username, usertype: 'guest' }),
  })
    .then(response => response.json())
    .then(data => {
      if (data.status === 'success') {
        console.log('Guest user logged in:', data.user);
        window.location.href = '/'; // Redirect to dashboard or appropriate page
      } else {
        console.error('Error logging in as guest:', data.message);
      }
    })
    .catch(error => console.error('Error:', error));
};
  
//for checking if input data is valid

/*
document.querySelector('#sign-in-btn').addEventListener('click', function(event) {
  event.preventDefault(); // Prevent the default form submission to handle it via JavaScript
  
  const form = event.target.closest('form');

  // Send an AJAX request (or use fetch for modern JavaScript)
  fetch(form.action, {
    method: 'POST',
    body: new FormData(form),
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      // Redirect to home page on success
      window.location.href = 'C:\\Users\\vesen\\Documents\\GitHub\\Web-Technologies\\musicLibrary\\resources\\views\\home.blade.php'; // Replace with your home route
    } else {
      alert('Login failed. Please try again.');
    }
  })
  .catch(error => console.error('Error:', error));
});
*/