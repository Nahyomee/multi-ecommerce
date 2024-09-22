@extends('frontend.layouts.master')

@section('title', 'Verify Email')
@section('content')
    <!--============================
        FORGET PASSWORD START
    ==============================-->
    <section id="wsus__login_register">
        <div class="container">
            <div class="row">
                <div class="col-xl-7 m-auto">
                    <div class="wsus__forget_area">
                        <h4>Verify Email</h4>
                        <p>Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.</p>

                        @if (session('status') == 'verification-link-sent')
                        <div class="text-success">
                            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                        </div>
                    @endif
                        <div class="wsus__login">
                            <form method="POST" action="{{ route('verification.send') }}">
                                @csrf
                                <button class="common_btn" type="submit">Resend Verification Email</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        FORGET PASSWORD END
    ==============================-->

@endsection