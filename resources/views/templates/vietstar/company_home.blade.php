@extends('templates.vietstar.layouts.app')

@section('content') 

@include('templates.employers.includes.header')

@include('templates.employers.includes.company_dashboard_menu')

<div class="company-wrapper">

    
    @include('templates.employers.includes.mobile_dashboard_menu')
    <div class="container company-content">
            @include('flash::message')
            @include('templates.employers.includes.company_dashboard_top')
            @include('templates.employers.includes.company_dashboard_stats')
           
           <?php
         
            if((bool)config('company.is_company_package_active')){     
                   
                $package = Auth::guard('company')->user()->getPackage();
                $packages = App\Package::where('package_for', 'like', 'employer')
               ->whereNotIn('id', [$package->id])
               ->get();
              ?>
            <?php if(null !== $package){ ?>

            @include('templates.employers.includes.company_package_msg')
          
            @include('templates.employers.includes.company_packages_upgrade')
            
          
            <?php }elseif(null !== $packages){ ?>

            @include('templates.employers.includes.company_packages_new')

            <?php }} ?>
           
        </div>
    
</div>

@include('templates.employers.includes.footer')

@endsection

@push('scripts')

@include('templates.vietstar.includes.immediate_available_btn')

@endpush

