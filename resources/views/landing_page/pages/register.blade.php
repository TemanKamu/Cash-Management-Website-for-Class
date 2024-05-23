@extends('landing_page.layout.auth')
@section('title', 'Sign up')
@section('content')
    <main class="card-container slideUp-animation">
        <div class="image-container">
            <h1 class="company">Kelas-ku <sup>&trade;</sup></h1>
            <img src="{{ asset('landing_page/images/undraw_remotely_2j6y.svg') }}" class="illustration" alt="">
            <p class="quote">Sign up today now..!</p>
            <a href="#btm" class="mobile-btm-nav">
                <img src="./assets/images/dbl-arrow.png" alt="">
            </a>
        </div>
        <form action="/register" method="POST">
            @csrf
            <div class="form-container slideRight-animation">
                <h1 class="form-header">
                    Get started
                </h1>

                <div class="input-container">
                    <label for="f-name"></label>
                    <input type="text" name="name" id="f-name" required>
                    <span>
                        Name
                    </span>
                    @error('name')
                        <div class="error">* This field is required</div>
                    @enderror
                </div>

                <div class="input-container">
                    <label for="mail">
                    </label>
                    <input type="email" name="email" id="mail" required>
                    <span>
                        E-mail
                    </span>
                    @error('email')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-container">
                    <label for="phone">
                    </label>
                    <input type="text" name="no_hp" id="phone" required>
                    <span>Phone</span>
                    @error('no_hp')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="input-container">
                    <label for="profile">
                    </label>
                    <input type="file" name="profile_user" id="profile" required>
                    <span>Profile picture</span>
                    @error('profile_user')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-container">
                    <label for="user-password"></label>
                    <input type="password" name="password" id="user-password" class="user-password" required>
                    <span>Password</span>
                    @error('password')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-container">
                    <label for="user-password"></label>
                    <input type="password" name="password_confirmation" id="user-password"
                        class="password-confirmation" required>
                    <span>
                        Confirm Password
                    </span>
                    @error('user-password-confirm')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
                <br>
                <div id="btm">
                    <button type="submit" class="submit-btn">Create Account</button>
                    <p class="btm-text">
                        Already have an account..? <a class="btm-text-highlighted" href="/login"> Log in</a>
                    </p>
                </div>
            </div>
        </form>
    </main>
@endsection
