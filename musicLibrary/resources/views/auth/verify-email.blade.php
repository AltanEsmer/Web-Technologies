<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email - Music Library</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('css/signinStyle.css') }}">
</head>
<body>
    <header class="header">
        <nav class="navbar">
            <a href="{{ route('home') }}">
                <div class="logo-image-wrapper">
                    <img src="{{ asset('images/MusicLibraryLogo.png') }}" alt="Logo" class="about-image">
                </div>
            </a>
        </nav>
    </header>

    <div class="background"></div>
    <div class="container">
        <div class="verification-content">
            <div class="verification-left">
                <h2>Verify Your Email Address</h2>
                <div class="verification-text">
                    <p>Before proceeding, please check your email for a verification link.</p>
                    <p>If you did not receive the email, click below to request another.</p>
                </div>
            </div>
            
            <div class="verification-right">
                @if (session('resent'))
                    <div class="alert alert-success">
                        A fresh verification link has been sent to your email address.
                    </div>
                @endif

                <form method="POST" action="{{ route('verification.send') }}" class="verification-form">
                    @csrf
                    <button type="submit" class="btn">
                        Resend Verification Email
                    </button>
                </form>

                <div class="verification-links">
                    <a href="{{ route('signin') }}" class="signin-link">Already verified? Sign In</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>