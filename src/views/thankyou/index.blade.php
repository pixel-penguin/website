@extends('pixel-penguin-website::layouts.website')

@section('content')

<main class="main">
	<div class="page-header" style="background-image: url(https://res.cloudinary.com/pixel-penguin/image/upload/c_fill,g_face,h_400,w_1970/v1/placeholders/placeholder-image.png)">
		<div class="container">
			<h1>Thank you!</h1>
		</div><!-- End .container -->
	</div><!-- End .page-header -->

	<nav aria-label="breadcrumb" class="breadcrumb-nav">
		<div class="container">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="/">Home</a></li>
				
				<li class="breadcrumb-item active" aria-current="page">Thank you!</li>
			</ol>
		</div><!-- End .container -->
	</nav>

	<div class="container">

		<p>Your order has been placed</p>
		<p><a target="_blank" href="/invoice/{{ $referenceCode }}">View Invoice</a></p>


		<div class="mb-2 mb-lg-5"></div><!-- margin -->
	</div><!-- End .container -->


</main><!-- End .main -->	
		
@endsection

@section('style')
<style>

	
</style>
@endsection
@section('scripts')
<script>
	
</script>
@endsection