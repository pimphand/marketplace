@extends('frontend.layouts.app')
@section('content')
<section class="mb-4 pt-3">
    <div class="container">
        <div class="bg-white shadow-sm rounded p-3">
            <div class="row">
                <div class="col-xl-5 col-lg-6 mb-4">
                    <div class="sticky-top z-3 row gutters-10">
                        <div class="col order-1 order-md-2">
                            <div class="aiz-carousel product-gallery slick-initialized slick-slider"
                                data-nav-for=".product-gallery-thumb" data-fade="true" data-auto-height="true">
                                <div class="slick-list draggable" style="height: 404.75px;">
                                    <div class="slick-track" style="opacity: 1; width: 920px;">
                                        <div class="slick-slide slick-current slick-active" data-slick-index="0"
                                            aria-hidden="false"
                                            style="width: 460px; position: relative; left: 0px; top: 0px; z-index: 999; opacity: 1;">
                                            <div>
                                                <div class="carousel-box img-zoom rounded"
                                                    style="width: 100%; display: inline-block;">
                                                    <img class="img-fit lazyload mx-auto h-140px h-md-210px"
                                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                        data-src="{{ asset('public/'.$service->logo) }}" alt=""
                                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-7 col-lg-6">
                    <div class="text-left">
                        <h1 class="mb-2 fs-20 fw-600" id="title">
                            {{ $service->title }}
                        </h1>

                        <div class="row align-items-center">
                            <div class="col-8">
                                {{ $service->location }}
                            </div>
                            <div class="col-4 text-right">
                                @if ($service->applies()->count() > 0)
                                Jumlah pelamar ({{ $service->applies()->count() }})
                                @endif
                            </div>
                        </div>

                        <hr>

                        <div class="row no-gutters pb-3" id="chosen_price_div">
                            <div class="col-sm-2">
                                <div class="opacity-50 my-2">Rentang Gaji:</div>
                            </div>
                            <div class="col-sm-10">
                                <div class="product-price">
                                    <strong id="chosen_price" class="h4 fw-600 text-primary">
                                        Rp. {{ number_format($service->start_salary,2) }} - Rp. {{
                                        number_format($service->end_salary,2) }}
                                    </strong>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row no-gutters mt-3">
                            <div class="col-sm-2">
                                <div class="opacity-50 my-2">Deskripsi :</div>
                            </div>
                            <div class="col-sm-10">
                                <div class="">
                                    {!! $service->description !!}
                                </div>
                            </div>
                        </div>

                        <div class="row no-gutters mt-3">
                            <div class="col-sm-2">
                                <div class="opacity-50 my-2">Kualifikasi :</div>
                            </div>
                            <div class="col-sm-10">
                                <div class="">
                                    {!! $service->qualification !!}
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row no-gutters mt-3">
                            <div class="col-sm-2">
                                <div class="opacity-50 my-2">Tanggal berkahir :</div>
                            </div>
                            <div class="col-sm-10 mt-2">
                                <strong class="">
                                    @php
                                    $sekarang = \Carbon\Carbon::now();
                                    $endDate = \Carbon\Carbon::parse($service->end_date.' 12:00:00');
                                    $selisih = $endDate->diff($sekarang);
                                    @endphp
                                    @if ($endDate->isPast())
                                    <span class="text-danger">Sudah berakhir</span>
                                    @else
                                    <span>
                                        {{ $service->end_date }} ( {{ $selisih->days }} hari lagi )
                                    </span>
                                    @endif
                                </strong>
                            </div>
                        </div>
                        <hr>

                        <div class="d-table width-100 mt-3">
                            <div class="d-table-cell">
                                @auth
                                <button type="button" class="btn btn-success" id="daftar">
                                    Daftar
                                </button>
                                @endauth
                            </div>
                        </div>


                        <div class="row no-gutters mt-4">
                            <div class="col-sm-2">
                                {{-- <div class="opacity-50 my-2">Share:</div> --}}
                            </div>
                            <div class="col-sm-10">
                                {{-- <div class="aiz-share jssocials">
                                    <div class="jssocials-shares">
                                        <div class="jssocials-share jssocials-share-email"><a target="_self"
                                                href="mailto:?&amp;body=http%3A%2F%2F127.0.0.1%2Fmarket%2Fproduct%2Fdemo-product-22-Gn7G4"
                                                class="jssocials-share-link"><i
                                                    class="lar la-envelope jssocials-share-logo"></i></a></div>
                                        <div class="jssocials-share jssocials-share-twitter"><a target="_blank"
                                                href="https://twitter.com/share?url=http%3A%2F%2F127.0.0.1%2Fmarket%2Fproduct%2Fdemo-product-22-Gn7G4"
                                                class="jssocials-share-link"><i
                                                    class="lab la-twitter jssocials-share-logo"></i></a></div>
                                        <div class="jssocials-share jssocials-share-facebook"><a target="_blank"
                                                href="https://facebook.com/sharer/sharer.php?u=http%3A%2F%2F127.0.0.1%2Fmarket%2Fproduct%2Fdemo-product-22-Gn7G4"
                                                class="jssocials-share-link"><i
                                                    class="lab la-facebook-f jssocials-share-logo"></i></a></div>
                                        <div class="jssocials-share jssocials-share-linkedin"><a target="_blank"
                                                href="https://www.linkedin.com/shareArticle?mini=true&amp;url=http%3A%2F%2F127.0.0.1%2Fmarket%2Fproduct%2Fdemo-product-22-Gn7G4"
                                                class="jssocials-share-link"><i
                                                    class="lab la-linkedin-in jssocials-share-logo"></i></a></div>
                                        <div class="jssocials-share jssocials-share-whatsapp"><a target="_self"
                                                href="whatsapp://send?text=http%3A%2F%2F127.0.0.1%2Fmarket%2Fproduct%2Fdemo-product-22-Gn7G4 "
                                                class="jssocials-share-link"><i
                                                    class="lab la-whatsapp jssocials-share-logo"></i></a></div>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
<div class="modal fade" id="apply-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="apply-modal-title">{{ translate('Apply') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="p-3">

                    <form action="{{ route('service.apply', $service->slug) }}" method="post" id="form-apply"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-3 mt-4">
                                <label>{{ translate('Nama lengkap')}}</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control mt-3" placeholder="{{ translate('nama')}}"
                                    name="name" id="name" required>
                                <span class="text-danger" id="error-name"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 mt-4">
                                <label>{{ translate('Email')}}</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control mt-3" placeholder="{{ translate('email')}}"
                                    value="{{ auth()->user()->email ?? '' }}" name="email" id="email" required>
                                <span class="text-danger" id="error-email"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 mt-4">
                                <label>{{ translate('Nomor Telepon')}}</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control mt-3" placeholder="{{ translate('62123456789')}}"
                                    name="phone" id="phone" required>
                                <span class="text-danger" id="error-phone"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 mt-4">
                                <label>{{ translate('Alamat')}}</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control mt-3" placeholder="{{ translate('alamat')}}"
                                    name="address" id="address" required>
                                <span class="text-danger" id="error-address"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 mt-4">
                                <label>{{ translate('CV / Resume')}}</label>
                            </div>
                            <div class="col-md-9">
                                <input type="file" class="form-control mt-3" name="resume" id="resume" required>
                                <span class="text-danger" id="error-resume"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 mt-4">
                                <label>{{ translate('Surat lamaran')}}</label>
                            </div>
                            <div class="col-md-9">
                                <input type="file" class="form-control mt-3" name="letter" id="letter">
                                <span class="text-danger" id="error-letter"></span>
                            </div>
                        </div>
                    </form>

                    <div class="text-right">
                        <button type="button" id="simpan" class="btn btn-success">{{translate('Simpan')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#daftar').click(function (e) {
            $('#apply-modal').modal({
                backdrop: 'static',
                keyboard: false,
                show:true
            });
            $('#apply-modal-title').text($('#title').text());
        });

        $('#simpan').click(function (e) {
            e.preventDefault();
            $('.form-control').removeClass('is-invalid');
            $('.text-danger').text('');
            var form = $('#form-apply')[0];
            var formData = new FormData(form);
            $.ajax({
                method: "post",
                url: form.action,
                data: formData,
                type: 'json',
                contentType: false,
                processData: false,
                success: function (response) {
                    console.log(response);
                },
                error: function (xhr, status, error) {
                    if (xhr.status === 422) {
                        var data = xhr.responseJSON;

                        $.each(data.errors, function (key, value) {
                            // Show errors
                            $('#' + key).addClass('is-invalid');
                            $('#' + 'error-' + key).html(value);

                            // Hide error on keyup
                            $('#' + key).on('keyup', function () {
                                $('#' + key).removeClass('is-invalid');
                                $('#' + 'error-' + key).html('');
                            });
                        });
                    }
                }
            });
        });
    });
</script>
@endsection