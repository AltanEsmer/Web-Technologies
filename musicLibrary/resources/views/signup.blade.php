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
            <form action="{{ route('signup.post') }}" method="POST">
                @csrf
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <h2>Sign Up</h2>

                <div class="input-box">
                    <span class="icon"><i class='bx bxs-user'></i></span>
                    <input type="text" name="username" id="username" value="{{ old('username') }}" required>
                    <label>Username</label>
                </div>

                <div class="input-box">
                    <span class="icon"><i class='bx bxs-envelope'></i></span>
                    <input type="email" name="mail" id="mail" value="{{ old('mail') }}" required>
                    <label>Email</label>
                </div>

                <div class="input-box">
                    <span class="icon"><i class='bx bxs-lock-alt'></i></span>
                    <input type="password" name="pass" id="pass" required>
                    <label>Password</label>
                </div>

                <div class="input-box">
                    <span class="icon"><i class='bx bxs-lock-alt'></i></span>
                    <input type="password" name="pass_confirmation" id="pass_confirmation" required>
                    <label>Confirm Password</label>
                </div>

                <div class="remember-forgot">
                    <label><input type="checkbox" required> I agree to the terms & conditions</label>
                </div>

                <button type="submit" class="btn">Sign Up</button>

                <div class="login-register">
                    <p>Already have an account? <a href="{{ route('signin') }}" class="login-link">Sign In</a></p>
                </div>
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

.remember-forgot {
    display: flex;
    justify-content: space-between;
    font-size: 0.9em;
    color: rgba(255, 255, 255, 0.7);
    margin: 15px 0 20px;
}

.remember-forgot label input {
    accent-color: #4CAF50;
    margin-right: 4px;
}

.btn {
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

.btn:hover {
    background: #45a049;
}

.login-register {
    text-align: center;
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.9em;
    margin-top: 20px;
}

.login-register p a {
    color: #fff;
    font-weight: 600;
    text-decoration: none;
}

.login-register p a:hover {
    text-decoration: underline;
}

.alert {
    background: rgba(255, 0, 0, 0.1);
    border: 1px solid rgba(255, 0, 0, 0.3);
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 20px;
    color: #ff6b6b;
}
</style>
@endsection
