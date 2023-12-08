<div class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
    <img src="{{ static_asset('assets/img/placeholder.jpg') }}"
        data-src="{{ uploaded_asset($brand->logo) }}"
        alt="{{ $brand->getTranslation('name') }}" class="img-fluid img lazyload" style="width: 100%;"
        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
</div>
