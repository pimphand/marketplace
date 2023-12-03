@extends('backend.layouts.app')

@section('content')

@php
// CoreComponentRepository::instantiateShopRepository();
// CoreComponentRepository::initializeCache();
@endphp

<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{translate('Jasa & Lowongan Kerja')}}</h5>
            </div>
            <div class="card-body">
                <form class="form-horizontal" action="{{ route('services.update', $data->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{translate('Judul')}}</label>
                        <div class="col-md-9">
                            <input type="text" placeholder="{{translate('Judul')}}" id="title" name="title"
                                value="{{ $data->title }}" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{translate('Nama Perusahaan')}}</label>
                        <div class="col-md-9">
                            <input type="text" placeholder="{{translate('Nama Perusahaan')}}" id="company"
                                name="company" value="{{ $data->company }}" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{translate('Logo Perusahaan')}}</label>
                        <div class="col-md-9">
                            <input type="file" placeholder="{{translate('Logo Perusahaan')}}" id="logo" name="logo"
                                class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{translate('Tipe Pekerjaan')}}</label>
                        <div class="col-md-9">
                            <select name="type" class="form-control" id="type">
                                <option value="Freelance" {{ $data->type =='Freelance' ? 'selected' : '' }}>Freelance
                                </option>
                                <option value="Parttime" {{ $data->type =='Parttime' ? 'selected' : '' }}>Parttime
                                </option>
                                <option value="Fulltime" {{ $data->type =='Fulltime' ? 'selected' : '' }}>Fulltime
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{translate('Rentang Gaji')}}</label>
                        <div class="col-md-4">
                            <input type="number" name="start_salary" value="{{ $data->start_salary }}"
                                class="form-control" required>
                        </div>
                        <div class="col-md-5">
                            <input type="number" name="end_salary" value="{{ $data->end_salary }}" class="form-control"
                                required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{translate('Lokasi')}}</label>
                        <div class="col-md-9">
                            <select type="text" id="province" name="province" class="form-control" required>
                                @foreach (DB::table('tb_ro_provinces')->get() as $province)
                                <option value="{{ $province->province_id }}" {{ $province->province_id ==
                                    $data->province ? 'selected' : '' }}>{{ $province->province_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label class="col-md-3 col-form-label mt-2">&NonBreakingSpace;</label>
                        <div class="col-md-9 mt-2">
                            <select type="text" id="city" name="city" class="form-control" required>
                                <option value="{{ $data->city }}">{{ $data->getCity->city_name }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">{{translate('Tanggal berkahir')}}</label>
                        <div class="col-md-9">
                            <input type="date" name="{{ $data->end_date }}" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">
                            {{translate('Deskripsi')}}
                        </label>
                        <div class="col-md-9">
                            <textarea class="aiz-text-editor" name="description">{{ $data->description }}</textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">
                            {{translate('Kualifikasi')}}
                        </label>
                        <div class="col-md-9">
                            <textarea class="aiz-text-editor" name="qualification">{{ $data->qualification }}</textarea>
                        </div>
                    </div>

                    <div class="form-group mb-0 text-right">
                        <button type="submit" class="btn btn-primary">{{translate('Save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    $('#province').change(function (e) {
        e.preventDefault();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('get-city')}}",
            type: 'POST',
            data: {
                state_id: $(this).val()
            },
            success: function (response) {
                var obj = JSON.parse(response);
                if(obj != '') {
                    $('[name="city"]').html(obj);
                    AIZ.plugins.bootstrapSelect('refresh');
                }
            }
        });
    });
</script>
@endsection