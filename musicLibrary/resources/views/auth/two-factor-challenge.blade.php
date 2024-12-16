@extends('layouts.app')

@section('content')
<div class="wrapper">
    <div class="background"></div>
    <div class="container">
        <div class="content">
            <div class="logo-section">
                <img src="{{ asset('images/MusicLibraryLogo.png') }}" alt="Logo" class="auth-logo">
                <h2 class="logo"><i class='bx bxs-shield'></i>Two Factor Authentication</h2>
            </div>
            
            <div class="text-sci">
                <h2>Verify Your Identity<br><span>Secure Your Account</span></h2>
                <p>
                    Enter the 6-digit code from your authenticator app.
                    <br>The code refreshes every 30 seconds.
                </p>
            </div>
        </div>

        <div class="logreg-box">
            <div class="form-box">
                <form method="POST" action="{{ route('2fa.verify.post') }}" class="verify-form">
                    @csrf

                    @if ($errors->any())
                        <div class="error-box">
                            @foreach ($errors->all() as $error)
                                <div class="error-msg">{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-lock-alt'></i></span>
                        <input type="text" 
                               name="code" 
                               required 
                               autocomplete="one-time-code"
                               inputmode="numeric"
                               pattern="[0-9]*"
                               maxlength="6">
                        <label>Authentication Code</label>
                    </div>

                    <div class="recovery-text">
                        <p>Lost access to your authenticator?</p>
                        <a href="#" class="recovery-link">Use a recovery code →</a>
                    </div>

                    <button type="submit" class="btn">
                        <i class='bx bx-check-shield'></i>
                        Verify Code
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.wrapper {
    position: relative;
    width: 100%;
    min-height: 100vh;
    background: linear-gradient(45deg, #83C5BE, #006D77);
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
}

.background {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: -1;
}

.container {
    position: relative;
    width: 100%;
    max-width: 1000px;
    height: 600px;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    overflow: hidden;
    display: flex;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

.content {
    flex: 1;
    padding: 60px;
    color: #fff;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.logo-section {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 20px;
}

.auth-logo {
    width: 120px;
    height: auto;
}

.logo {
    font-size: 28px;
    display: flex;
    align-items: center;
    gap: 12px;
    color: #fff;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.text-sci h2 {
    font-size: 40px;
    line-height: 1.2;
}

.text-sci h2 span {
    font-size: 25px;
}

.text-sci p {
    font-size: 16px;
    margin: 20px 0;
}

.logreg-box {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
}

.form-box {
    width: 100%;
    max-width: 400px;
    padding: 40px;
    background: rgba(0, 0, 0, 0.2);
    border-radius: 20px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
}

.input-box {
    position: relative;
    width: 100%;
    height: 50px;
    margin: 25px 0;
    border-bottom: 2px solid #fff;
}

.input-box input {
    width: 100%;
    height: 100%;
    background: transparent;
    border: none;
    outline: none;
    font-size: 16px;
    color: #fff;
    font-weight: 500;
    padding-right: 25px;
    letter-spacing: 8px;
    font-size: 20px;
    padding-left: 8px;
}

.input-box label {
    position: absolute;
    top: 50%;
    left: 0;
    transform: translateY(-50%);
    font-size: 16px;
    color: #fff;
    pointer-events: none;
    transition: .5s;
}

.input-box input:focus~label,
.input-box input:valid~label {
    top: -5px;
}

.input-box .icon {
    position: absolute;
    top: 50%;
    right: 0;
    transform: translateY(-50%);
    font-size: 20px;
    color: #E29578;
}

.btn {
    width: 100%;
    height: 45px;
    background: #E29578;
    border: none;
    outline: none;
    border-radius: 40px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, .2);
    cursor: pointer;
    font-size: 16px;
    color: #fff;
    font-weight: 600;
    transition: .5s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.btn:hover {
    background: #fff;
    color: #006D77;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.recovery-text {
    text-align: center;
    margin: 25px 0;
}

.recovery-text p {
    color: rgba(255, 255, 255, 0.8);
    margin-bottom: 8px;
}

.recovery-link {
    color: #E29578;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
}

.recovery-link:hover {
    color: #fff;
    text-decoration: underline;
}

.error-box {
    background: rgba(226, 149, 120, 0.2);
    border: 1px solid #E29578;
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 20px;
}

.error-msg {
    color: #fff;
    font-size: 14px;
    margin-bottom: 5px;
}

.error-msg:last-child {
    margin-bottom: 0;
}

/* Add smooth transitions */
.input-box input,
.btn,
.recovery-link {
    transition: all 0.3s ease;
}

/* Improve mobile responsiveness */
@media (max-width: 768px) {
    .container {
        margin: 20px;
        height: auto;
        min-height: 600px;
    }
    
    .auth-logo {
        width: 100px;
    }
    
    .logo {
        font-size: 24px;
    }
    
    .text-sci h2 {
        font-size: 28px;
    }
    
    .text-sci h2 span {
        font-size: 18px;
    }
    
    .form-box {
        padding: 30px 20px;
    }
}
</style>
@endsection
