@extends('layout.main')

@section('content')

<section class="theme-details pb-120" id="section-principal">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h1> Profile</h1>
            </div>
            <div class="col-md-10">
                <profile-component auth="{{ Auth::user()->toJson() }}"></profile-component>
            </div>
        </div>
    </div>
</section>

@endsection
