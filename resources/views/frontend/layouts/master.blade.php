<!DOCTYPE html>
<html lang="zxx">
<head>
	@include('frontend.layouts.head')
</head>
<body class="js">

@notverified
<div class="" style="color: #ffffff;
    background-color: red;
    border-color: #de0000;
    border: 1px solid transparent;
    text-align: center;
    position: relative;
    padding: 0.75rem 1.25rem;
    margin-bottom: 1rem;
    border-radius: 0.25rem;
    ">
    You need to verify your email address before order any products. <a href="{{ route('verification.resend') }}" style="color: blue">Resend Verification Link</a>
</div>
@endnotverified
	@include('frontend.layouts.notification')
	<!-- Header -->
	@include('frontend.layouts.header')
	<!--/ End Header -->
	@yield('main-content')

	@include('frontend.layouts.footer')

</body>
</html>
