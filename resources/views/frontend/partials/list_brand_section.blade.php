@php
    $top10_brands = \App\Models\Brand::whereTop(1)->get();
@endphp
<section class="mb-4">
    <div class="container">
        <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
            <div class="d-flex mb-3 align-items-baseline border-bottom">
                <h3 class="h5 fw-700 mb-0">
                    <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ translate('Brand') }}
                    </span>
                </h3>
            </div>
            <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="7" data-xl-items="7" data-lg-items="4"
                data-md-items="6" data-sm-items="2" data-xs-items="2" data-arrows='true' data-infinite='true'>
                @foreach ($top10_brands as $brand)
                <div class="carousel-box">
                    @include('frontend.partials.brand',['brand' => $brand])
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>