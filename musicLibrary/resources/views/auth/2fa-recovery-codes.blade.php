<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2FA Recovery Codes - Music Library</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('css/signinStyle.css') }}">
    <style>
        body {
            background-color: #9FC5C5;
            margin: 0;
            min-height: 100vh;
        }

        .setup-content {
            background: rgba(45, 98, 98, 0.95);
            border-radius: 20px;
            padding: 30px;
            max-width: 450px;
            width: 100%;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.2);
        }

        .recovery-codes {
            margin: 25px 0;
        }

        .recovery-code {
            font-family: 'Courier New', monospace;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            padding: 12px 20px;
            margin: 8px 0;
            border-radius: 8px;
            font-size: 16px;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            text-align: center;
        }

        .recovery-code:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateX(5px);
        }

        .warning {
            background: rgba(255, 87, 87, 0.1);
            padding: 15px 20px;
            border-radius: 12px;
            margin: 20px 0;
            border-left: 4px solid #ff5757;
        }

        .warning p {
            margin: 5px 0;
            color: #fff;
            font-size: 14px;
        }

        .warning p:first-child {
            color: #ff5757;
            font-weight: bold;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        h2 {
            color: #fff;
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: 600;
        }

        .btn {
            width: 100%;
            padding: 12px;
            background: #fff;
            color: #2d6262;
            border: none;
            border-radius: 40px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            text-decoration: none;
            display: block;
            margin-top: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn:hover {
            background: #f0f0f0;
            transform: translateY(-2px);
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 80px);
            padding: 20px;
            background: linear-gradient(
                135deg, 
                rgba(45, 98, 98, 0.2) 0%,
                rgba(45, 98, 98, 0.1) 100%
            );
        }

        .header {
            background-color: transparent;
            padding: 15px 0;
        }

        .navbar {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .logo-image-wrapper img {
            height: 50px;
            width: auto;
        }
    </style>
</head>
<body>
    <header class="header">
        <nav class="navbar">
            <a href="{{ route('library') }}">
                <div class="logo-image-wrapper">
                    <img src="{{ asset('images/MusicLibraryLogo.png') }}" alt="Logo" class="about-image">
                </div>
            </a>
        </nav>
    </header>

    <div class="container">
        <div class="setup-content">
            <h2>Recovery Codes</h2>
            
            <div class="warning">
                <p>⚠️ Important Security Information</p>
                <p>Save these recovery codes in a secure location.</p>
                <p>They can be used to access your account if you lose your 2FA device.</p>
                <p>Each code can only be used once.</p>
            </div>

            <div class="recovery-codes">
                @foreach($recoveryCodes as $code)
                    <div class="recovery-code">{{ $code }}</div>
                @endforeach
            </div>

            <form action="{{ route('2fa.complete-setup') }}" method="POST">
                @csrf
                <button type="submit" class="btn">
                    I've saved these codes
                </button>
            </form>
        </div>
    </div>
</body>
</html>