@extends('templates.vietstar.layouts.app')
@inject('carbon', 'Carbon\Carbon')


@section('content')

@if(Auth::guard('company')->check())
<!-- Header start -->
@include('templates.employers.includes.header')
<!-- Header end -->
@else
@include('templates.vietstar.includes.header')
@endif


@include('templates.employers.includes.company_dashboard_menu')

<div class="company-wrapper main-content">

    @include('templates.employers.includes.mobile_dashboard_menu')
    <div class="container company-content">
        <div class="card mb-2">
            <div class="card-body">
                <div class="posted-manager-header">
                    <h1 class="title-manage">{{__('Company\'s Posted Jobs')}}</h1>
                    <a href="{{route('post.job')}}" class="btn btn-primary text-white"><i class="bi bi-pen text-white m-1"></i>{{ __('Create a Recruitment Form') }}</a>
                </div>
                <form action="{{ route('posted.jobs') }}" method="get" class="form-search pt-2">
                    <div class="row filter-job">
                        <div class="col-md-5 col-lg-3 col-sm-12">
                            <div class="form-group">
                                <label for="">Từ khóa</label>
                                <input type="text" name="title" placeholder="{{ __('Research Jobs') }}" class="form-control search-title" value="{{ isset($request['title']) ? $request['title'] : '' }}">

                            </div>
                        </div>
                        {{-- <div class="col-md-6 col-lg-3">
                                        <div class="form-group">
                                            <select name="status" class="form-select" name="" id="">
                                                <option value="">{{ __('Select status') }}</option>
                        @foreach (\App\Job::getListStatusJob() as $key => $value)
                        <option {{ isset($request['status']) && $request['status'] == $key ? 'selected' : '' }} value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                        </select>
                    </div>
            </div> --}}

            <div class="col-md-3 col-lg-2 col-sm-12">
                <div class="form-group">
                    <label for="find_day">Tìm theo ngày</label>
                    <select name="find_day" value="{{ isset($request['find_day']) ? $request['find_day'] : '0' }}" class="form-select" id="find_day">
                        <option value="0">Ngày đăng</option>
                        <option value="1">Ngày hết hạn</option>

                    </select>
                </div>
            </div>
            <div class="col-md-3 col-lg-2 col-sm-12">
                <div class="form-group form-group-datepicker ">
                    <label for="from_to">Từ</label>
                    <input type="date" value="{{ isset($request['from']) ? $request['from'] : '' }}" class=" form-control " name="from" id="from_to" placeholder="{{ __('Start date-End date') }}" />
                </div>
            </div>

            <div class="col-md-3 col-lg-2 col-sm-12">
                <div class="form-group form-group-datepicker ">
                    <label for="from_to2">Đến</label>
                    <input type="date" class=" form-control " value="{{ isset($request['to']) ? $request['to'] : '' }}" name="to" id="from_to2" placeholder="{{ __('Start date-End date') }}" />
                </div>
            </div>
            <div class="col-md-3 col-lg-3 col-sm-12">
                <div class="form-group">
                    <label for="city_id">{{ __('City') }}</label>
                    <select name="city_id" class="form-select" name="" id="city_id" value="{{ isset($request['city_id']) ? $request['city_id'] : '' }}">
                        <option value="">{{ __('Select cities') }}</option>
                        @foreach ($cities as $key => $value)
                        <option {{ isset($request['city_id']) && $request['city_id'] == $key ? 'selected' : '' }} value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>



        </div>

            <div class="d-flex justify-content-end">
             <div class="w-10">
                 <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search text-white m-2 "></i>{{ __('Search') }}</button>
             </div>
            </div>

        </form>
    </div>

    <div class="card-body pt-0">
        
        <ul class="tabslet-tab d-flex justify-content-start">
        <li>
            <a href="{{ route('posted.jobs', ['status' => '1']) }}" class=" {{ Request::get('status') == 1 ? 'type-active' : '' }}">{{ __('Active job') }}</a>
        </li>
        <li>
            <a href="{{ route('posted.jobs', ['status' => '2']) }}" class="{{ Request::get('status') == 2 ? 'type-active' : '' }}">{{ __('Pending job') }}</a>
        </li>
        <li>
            <a href="{{ route('posted.jobs', ['status' => '3']) }}" class=" {{ Request::get('status') == 3 ? 'type-active' : '' }}">{{ __('Inactive job') }}</a>
        </li>
        <li>
            <a href="{{ route('posted.jobs', ['expired' => 'true']) }}" class=" {{ Request::get('expired') == 'true' ? 'type-active' : '' }}">{{ __('Job is expired') }}</a>
        </li>
    </ul>
        <div class="table-responsive table-content">
            <div class="d-flex justify-content-end p-2">
                <button type="button" onclick="exportFile()" class="btn btn-sm btn-primary"><i class="bi bi-download text-white m-2"></i>{{ __('Export file') }}</button>
                <label for="show-table" class="py-1 px-2">{{__('Show')}}</label>
                <div class="form-group m-0">
                <select class="form-control-sm " id="show-table">
                    <option>10</option>
                    <option>20</option>
                    <option>30</option>
                    <option>40</option>
                    <option>50</option>
                </select>
            </div>
              
            </div>
            <table class="table table-applican-manager table-hover mb-0 border-0">
                <thead>
                    <tr>
                        <th class="font-weight-bold p-2 fx-16px" colspan="2">{{ __('Positions') }}</th>
                        <!-- <th class="font-weight-bold"></th> -->
                        <th class="font-weight-bold p-2 fx-16px">Ngày đăng</th>
                        <th class="font-weight-bold p-2 fx-16px">Ngày hết hạn</th>
                        <th class="font-weight-bold p-2 fx-16px">{{ __('Status') }}</th>

                        <th class="font-weight-bold p-2 fx-16px">{{ __('Location') }}</th>
                        <th class="font-weight-bold p-2 fx-16px">{{ __('Salary') }}</th>

                        <th class="font-weight-bold p-2 fx-16px">{{ __('List of Candidates') }}</th>
                        <th class="font-weight-bold p-2 fx-16px">{{ __('Interview Candidates') }}</th>
                        <th class="font-weight-bold p-2 fx-16px">{{ __('List of Hired Candidates') }}</th>
                        <th class="font-weight-bold p-2 fx-16px">{{ __('List of Rejected Candidates') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($jobs) && count($jobs))
                    @foreach ($jobs as $job)

                    <tr class="posted-manager_tb_row">

                        <td colspan="2">
                            <div class="d-flex align-items-center h-100">
                                <div class="fs-18px font-weight-bold text-primary">
                                    {{ $job->title }}
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center h-100 fs-18px">
                                {{ $job->created_at }}
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center h-100 fs-18px">
                                {{ $job->expiry_date }}
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center h-100 fs-18px">
                                @if(Carbon\Carbon::parse($job->expiry_date)->format('Y-m-d') > Carbon\Carbon::now()->format('Y-m-d'))
                                {{ __(\App\Job::getListStatusJob()[$job->status]) }}
                                @else
                                {{ __('Job is expired') }}
                                @endif
                            </div>
                        </td>

                        <td>
                            <div class="tags h-100">
                                <span class="tag location fs-18px">{{ $job->getCity('city') }} </span>
                                <span class="tag time">{{ $job->getJobShift('job_shift') }}</span>
                            </div>
                        </td>

                        <td>
                            <div class="d-flex align-items-center h-100 fs-18px">
                                @php($from = round($job->salary_from/1000000,0))
                                @php($to = round($job->salary_to/1000000,0))
                                @if($job->salary_type == \App\Job::SALARY_TYPE_FROM)
                                <span class="fas fa-dollar-sign mx-2"></span> {{__('From: ')}} {{$from}} {{__('million')}} ({{$job->salary_currency}})
                                @elseif($job->salary_type == \App\Job::SALARY_TYPE_TO)
                                <span class="fas fa-dollar-sign mx-2"></span> {{__('Up To: ')}} {{$to}} {{__('million')}} ({{$job->salary_currency}})
                                @elseif($job->salary_type == \App\Job::SALARY_TYPE_RANGE)
                                <span class="fas fa-dollar-sign mx-2"></span> {{$from}} - {{$to}} {{__('million')}} ({{$job->salary_currency}})
                                @elseif($job->salary_type == \App\Job::SALARY_TYPE_NEGOTIABLE)
                                <span class="fas fa-money-bill mx-2"></span> {{__('Negotiable')}}
                                @else
                                <span class="fas fa-dollar-sign mx-2"></span> {{__('Salary Not provided')}}
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center justify-content-center h-100 fs-18px">
                                {{ $job->appliedUsers->count() }}
                            </div>
                        </td>

                        <td>
                            <div class="d-flex align-items-center justify-content-center h-100 fs-18px">
                                {{ $job->getStatusInterview()->count() }}
                            </div>
                        </td>

                        <td>
                            <div class="d-flex align-items-center justify-content-center h-100 fs-18px">
                                {{ $job->getStatusInterview(3)->count() }}
                            </div>
                        </td>

                        <td>
                            <div class="d-flex align-items-center justify-content-center h-100 fs-18px">
                                {{ $job->getStatusInterview(4)->count() }}
                            </div>
                        </td>


                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('flash::message')

<!-- job end -->
<!-- Pagination Start -->
<div class="pagiWrap">
    <div class="row">
        <div class="col-md-5">
            <div class="showreslt">
                {{ __('Showing Pages') }} : {{ $jobs->firstItem() }} - {{ $jobs->lastItem() }}
                {{ __('Total') }} {{ $jobs->total() }}
            </div>
        </div>
        <div class="col-md-7 text-right">
            @if (isset($jobs) && count($jobs))
            {{ $jobs->appends(request()->query())->links() }}
            @endif
        </div>
    </div>
</div>
<!-- Pagination end -->
</div>



</div>
@include('templates.employers.includes.footer')
@endsection
@push('styles')
<style type="text/css">
    input.form-control.search-title {}

    a.px-auto.btn.btn-outline-primary {
        width: 24%;
        margin-left: 8px;
    }

    .type-active {
        background: #981b1d;
        color: white;
    }

    .row.filter-job {}

    .fx-16px {
        font-size: 16px !important;
    }
    .w-10 {
        width: 10%;
    }

  
</style>
@endpush
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $(".chosen").chosen();

        function deleteJob(id) {
            var msg = 'Are you sure?';
            if (confirm(msg)) {
                $.post("{{ route('delete.front.job') }}", {
                        id: id,
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    })
                    .done(function(response) {
                        if (response == 'ok') {
                            $('#job_li_' + id).remove();
                        } else {
                            alert('Request Failed!');
                        }
                    });
            }
        }

        $('.btn-refresh').on('click', function() {
            var id = $(this).data('id');
            var url = "{{ route('refresh.front.job',':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                data: {
                    _token: '{{ csrf_token() }}'
                },
                method: 'get',
                beforeSend: function() {
                    console.log(id);
                },
                success: function(data) {
                    console.log(data);
                    if (data.success == true) {
                        alert("{{__('Refresh job success!')}}");
                        refreshPage();
                    } else {
                        alert("{{__('Refresh job failed!')}}");
                    }
                }
            });
        });
    });

    function refreshPage() {
        location.reload(true);
    }

    function exportFile() {

    }
</script>
@endpush