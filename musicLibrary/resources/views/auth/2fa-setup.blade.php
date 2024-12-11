<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2FA Setup - Music Library</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('css/signinStyle.css') }}">
    <style>
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 80px);
        }
        
        .setup-content {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 2px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 40px rgba(8, 7, 16, 0.6);
            padding: 30px;
            border-radius: 10px;
            max-width: 500px;
            width: 100%;
        }

        .setup-content h2 {
            color: #fff;
            text-align: center;
            margin-bottom: 20px;
        }

        .qr-container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            text-align: center;
        }

        .input-box {
            position: relative;
            margin: 30px 0;
        }

        .input-box input {
            width: 100%;
            height: 50px;
            background: transparent;
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 40px;
            font-size: 16px;
            color: #fff;
            padding: 20px 45px 20px 20px;
            outline: none;
        }

        .input-box label {
            position: absolute;
            top: 50%;
            left: 20px;
            transform: translateY(-50%);
            font-size: 16px;
            color: #fff;
            pointer-events: none;
            transition: 0.5s;
        }

        .input-box input:focus~label,
        .input-box input:valid~label {
            top: -5px;
            left: 15px;
            font-size: 14px;
            background: rgba(255, 255, 255, 0.1);
            padding: 0 6px;
            border-radius: 5px;
        }

        .btn {
            width: 100%;
            height: 45px;
            background: #fff;
            border: none;
            outline: none;
            border-radius: 40px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            font-size: 16px;
            color: #333;
            font-weight: 600;
            margin-top: 20px;
        }

        .instructions {
            color: #fff;
            margin: 20px 0;
            text-align: center;
            font-size: 14px;
            line-height: 1.6;
        }
    </style>
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
        <div class="setup-content">
            <h2>Set up Two-Factor Authentication</h2>
            
            <div class="instructions">
                <p>1. Install an authenticator app like Google Authenticator on your phone</p>
                <p>2. Scan the QR code below with your authenticator app</p>
                <p>3. Enter the verification code shown in your app</p>
            </div>

            <div class="qr-container">
                {!! $qrCodeUrl !!}
            </div>

            <form method="POST" action="{{ route('2fa.enable') }}">
                @csrf
                <div class="input-box">
                    <input type="text" name="one_time_password" id="one_time_password" required>
                    <label>Verification Code</label>
                </div>

                @error('one_time_password')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                @enderror

                <button type="submit" class="btn">Enable 2FA</button>
            </form>
        </div>
    </div>
</body>
</html>