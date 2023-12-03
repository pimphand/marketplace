<div class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
    <div class="position-relative">

        <a href="{{ route('service',[ $service->slug]) }}" class="d-block">
            <img class="img-fit lazyload mx-auto h-140px h-md-210px"
                src="{{ static_asset('assets/img/placeholder.jpg') }}" data-src="{{ asset('public/'.$service->logo) }}"
                alt="" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
        </a>
    </div>
    <div class="p-md-3 p-2 text-left">
        <div class="fs-15">
            <span class="fw-700 text-primary">Rp. {{ number_format($service->start_salary,2) }} - Rp. {{
                number_format($service->end_salary,2) }}</span>
        </div>
        <div class="rating rating-sm mt-1">
            {{ $service->location }}
        </div>
        <h3 class="fw-600 fs-13 text-truncate-2 lh-1-4 mb-0 h-35px">
            <a href="{{ route('service',[ $service->slug]) }}" class="d-block text-reset" tabindex="0">
                {{ $service->title }}
            </a>
        </h3>
    </div>
</div>