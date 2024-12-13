// BACKEND - Node.js
const express = require('express');
const nodemailer = require('nodemailer');
const bodyParser = require('body-parser');
const app = express();
const PORT = 3000;

app.use(bodyParser.json());

let verificationCodes = {}; // To store codes temporarily

const transporter = nodemailer.createTransport({
    service: 'gmail',
    auth: {
        user: 'your-email@gmail.com', // Replace with email
        pass: 'your-email-password' // Replace with email password
    }
});

app.post('/send-code', (req, res) => {
    const { email } = req.body;
    const code = Math.floor(Math.random() * 999) + 1; // Generate random code
    verificationCodes[email] = code;

    const mailOptions = {
        from: 'your-email@gmail.com',
        to: email,
        subject: 'Your Verification Code',
        text: `Your verification code is: ${code}`
    };

    transporter.sendMail(mailOptions, (error, info) => {
        if (error) {
            console.error(error);
            res.status(500).send('Error sending email.');
        } else {
            res.json(code);
        }
    });
});

app.listen(PORT, () => {
    console.log(`Server is running on http://localhost:${PORT}`);
});
