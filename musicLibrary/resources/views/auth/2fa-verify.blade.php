@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Two Factor Authentication</div>

                <div class="card-body">
                    <div class="setup-content">
                        <h2>Two-Factor Authentication</h2>
                        
                        <form method="POST" action="{{ route('2fa.verify') }}">
                            @csrf
                            <div class="input-box">
                                <input type="text" name="code" id="code" required>
                                <label>Authentication Code or Recovery Code</label>
                            </div>

                            @error('code')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror

                            <button type="submit" class="btn">Verify</button>
                        </form>

                        <div class="help-text">
                            <p>Enter the authentication code from your authenticator app</p>
                            <p>Or use a recovery code if you've lost access to your device</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
