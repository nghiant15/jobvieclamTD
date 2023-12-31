@extends('templates.vietstar.layouts.app')
@section('content')
<!-- Header start -->
@include('templates.employers.includes.header')
<!-- Header end --> 
<!-- Inner Page Title start -->
@include('templates.employers.includes.inner_page_title', ['page_title'=>__('Service Unavailable')])
<!-- Inner Page Title end -->
<div class="about-wraper"> 
    <!-- About -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>{{__('Service Unavailable')}}</h2>
                <p>{{__('Be right back.')}}</p>
            </div>      
        </div>
    </div>  
</div>
@include('templates.employers.includes.footer')
@endsection
