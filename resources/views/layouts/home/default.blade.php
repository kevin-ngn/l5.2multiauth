@extends($extend)
@section('content')
	@include('layouts.home.partials.nav')
	@include('layouts.home.partials.flash')
	@include($body)
	@include('layouts.home.partials.footer')
@endsection
