@php
$list_service = \App\Models\Service::where('status', 1)->orderBy('id', 'desc')->limit(20)->get();
@endphp

@if (get_setting('service_job_vacancies') == 1)
<section class="mb-4">
    <div class="container">
        <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
            <div class="d-flex mb-3 align-items-baseline border-bottom">
                <h3 class="h5 fw-700 mb-0">
                    <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ translate('Jasa &
                        Lowongan Kerja') }}
                    </span>
                </h3>
            </div>
            <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="4" data-xl-items="4" data-lg-items="4"
                data-md-items="4" data-sm-items="2" data-xs-items="2" data-arrows='true' data-infinite='true'>
                @foreach ($list_service as $service)
                <div class="carousel-box">
                    @include('frontend.partials.service_box',['service' => $service])
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif