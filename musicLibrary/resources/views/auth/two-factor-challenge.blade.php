@extends('layouts.app')

@section('content')
<div class="wrapper">
    <header>
        <div class="logo">
            <img src="{{ asset('images/MusicLibraryLogo.png') }}" alt="Music Library">
            <span>Music Library</span>
        </div>
        <div class="search">
            <input type="text" placeholder="Search...">
        </div>
    </header>

    <div class="logreg-box">
        <div class="form-box login">
            <form method="POST" action="{{ route('2fa.verify') }}" class="verify-form">
                @csrf
                <h2>Two Factor Authentication</h2>

                @if ($errors->any())
                    <div class="error-box">
                        @foreach ($errors->all() as $error)
                            <div class="error-msg">{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <div class="input-box">
                    <input type="text" 
                           name="code" 
                           id="code" 
                           inputmode="numeric"
                           pattern="[0-9]*"
                           autocomplete="one-time-code"
                           required>
                    <label>Authentication Code</label>
                </div>

                <div class="recovery-text">
                    <p>Lost access to your device?</p>
                    <p>Use a recovery code instead.</p>
                </div>

                <button type="submit" class="verify-btn">Verify</button>
            </form>
        </div>
    </div>
</div>

<style>
.wrapper {
    position: relative;
    width: 100%;
    min-height: 100vh;
    background: linear-gradient(45deg, #1f1f1f, #2a2a2a);
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
}

header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    padding: 20px 40px;
    background: rgba(0, 0, 0, 0.2);
    backdrop-filter: blur(10px);
    display: flex;
    justify-content: space-between;
    align-items: center;
    z-index: 99;
}

.logo {
    display: flex;
    align-items: center;
    gap: 10px;
}

.logo img {
    height: 36px;
    width: auto;
}

.logo span {
    color: #fff;
    font-size: 1.5em;
    font-weight: 700;
}

.search input {
    width: 300px;
    padding: 8px 15px;
    border: none;
    border-radius: 20px;
    background: rgba(255, 255, 255, 0.1);
    color: #fff;
    font-size: 0.9em;
}

.search input::placeholder {
    color: rgba(255, 255, 255, 0.7);
}

.form-box {
    position: relative;
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.1);
    border-radius: 20px;
    padding: 30px;
    width: 100%;
    max-width: 400px;
}

.form-box h2 {
    color: #fff;
    text-align: center;
    font-size: 1.8em;
    margin-bottom: 30px;
}

.input-box {
    position: relative;
    margin-bottom: 30px;
}

.input-box input {
    width: 100%;
    padding: 15px;
    background: rgba(255, 255, 255, 0.1);
    border: none;
    outline: none;
    border-radius: 10px;
    color: #fff;
    font-size: 1em;
    letter-spacing: 0.1em;
}

.input-box label {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: rgba(255, 255, 255, 0.7);
    pointer-events: none;
    transition: 0.3s;
}

.input-box input:focus ~ label,
.input-box input:valid ~ label {
    top: -10px;
    left: 10px;
    font-size: 0.8em;
    padding: 0 5px;
    background: rgba(0, 0, 0, 0.5);
    border-radius: 5px;
}

.recovery-text {
    text-align: center;
    color: rgba(255, 255, 255, 0.7);
    margin: 20px 0;
}

.verify-btn {
    width: 100%;
    padding: 15px;
    background: #4CAF50;
    border: none;
    border-radius: 10px;
    color: #fff;
    font-size: 1em;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
}

.verify-btn:hover {
    background: #45a049;
}

.error-box {
    background: rgba(255, 0, 0, 0.1);
    border: 1px solid rgba(255, 0, 0, 0.3);
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 20px;
}

.error-msg {
    color: #ff6b6b;
    font-size: 0.9em;
    margin-bottom: 5px;
}

.error-msg:last-child {
    margin-bottom: 0;
}
</style>
@endsection
