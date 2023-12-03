@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{translate('All Sellers')}}</h1>
        </div>
        <div class="col text-right">
            <a href="{{ route('services.create') }}" class="btn btn-circle btn-info">
                <span>{{translate('Add New Product')}}</span>
            </a>
        </div>
    </div>
</div>

<div class="card">
    <form class="" id="sort_sellers" action="" method="GET">
        <div class="card-header row gutters-5">
            <div class="col">
                <h5 class="mb-md-0 h6">{{ translate('Sellers') }}</h5>
            </div>

            @can('delete_seller')
            <div class="dropdown mb-2 mb-md-0">
                <button class="btn border dropdown-toggle" type="button" data-toggle="dropdown">
                    {{translate('Bulk Action')}}
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#" onclick="bulk_delete()">{{translate('Delete selection')}}</a>
                </div>
            </div>
            @endcan

            <div class="col-md-3 ml-auto">
                <select class="form-control aiz-selectpicker" name="status" id="status" onchange="sort_sellers()">
                    <option value="">{{translate('Filter by Status')}}</option>
                    <option value="1" @isset($status) @if($status=='1' ) selected @endif @endisset>
                        {{translate('Aktif')}}</option>
                    <option value="0" @isset($status) @if($status=='0' ) selected @endif @endisset>
                        {{translate('Non-Aktif')}}</option>
                </select>
            </div>
            <div class="col-md-3">
                <div class="form-group mb-0">
                    <input type="text" class="form-control" id="search" name="search" @isset($sort_search)
                        value="{{ $sort_search }}" @endisset
                        placeholder="{{ translate('Type name or email & Enter') }}">
                </div>
            </div>
        </div>

        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>

                        <th>
                            @if(auth()->user()->can('delete_seller'))
                            <div class="form-group">
                                <div class="aiz-checkbox-inline">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" class="check-all">
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                            </div>
                            @else
                            #
                            @endif
                        </th>
                        <th>{{translate('Title')}}</th>
                        <th data-breakpoints="lg">{{translate('Perusahaan')}}</th>
                        <th data-breakpoints="lg">{{translate('Tipe')}}</th>
                        <th data-breakpoints="lg">{{translate('Rentang Gaji')}}</th>
                        <th data-breakpoints="lg">{{translate('Status')}}</th>
                        <th data-breakpoints="lg">{{translate('Pelamar')}}</th>
                        <th data-breakpoints="lg">{{ translate('Lokasi') }}</th>
                        <th width="10%">{{translate('Options')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $key => $service)
                    <tr>
                        <td>
                            <div class="form-group">
                                <div class="aiz-checkbox-inline">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" class="check-one" name="id[]" value="{{$service->id}}">
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                            </div>
                        </td>
                        <td>{{ $service->title }}</td>
                        <td>{{ $service->company }}</td>
                        <td>{{ $service->type }}</td>
                        <td>Rp.{{ number_format($service->start_salary,2) }} - Rp. {{
                            number_format($service->end_salary,2) }}</td>
                        <td>
                            <label class="aiz-switch aiz-switch-success mb-0">
                                <input type="checkbox" @can('publish_blog') onchange="change_status(this)" @endcan
                                    value="{{ $service->id }}" <?php if($service->status == 1) echo "checked";?>
                                @cannot('publish_blog') disabled @endcan
                                >
                                <span></span>
                            </label>
                        </td>
                        <td>
                            @if ($service->applies()->count() > 0)
                            {{ $service->applies()->count() }} Pelamar
                            @else
                            -
                            @endif
                        </td>
                        <td>Provinsi {{ $service->getCity->province->province_name }},
                            {{ $service->getCity->city_name }}</td>
                        <td>
                            @can('edit_blog')
                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                href="{{ route('services.edit',$service->id)}}" title="{{ translate('Edit') }}">
                                <i class="las la-pen"></i>
                            </a>
                            @endcan
                            @can('delete_blog')
                            <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                data-href="{{route('services.destroy', $service->id)}}"
                                title="{{ translate('Delete') }}">
                                <i class="las la-trash"></i>
                            </a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{ $data->appends(request()->input())->links() }}
            </div>
        </div>
    </form>
</div>

@endsection

@section('modal')
<!-- Delete Modal -->
@include('modals.delete_modal')

<!-- Seller Profile Modal -->
<div class="modal fade" id="profile_modal">
    <div class="modal-dialog">
        <div class="modal-content" id="profile-modal-content">

        </div>
    </div>
</div>

<!-- Seller Payment Modal -->
<div class="modal fade" id="payment_modal">
    <div class="modal-dialog">
        <div class="modal-content" id="payment-modal-content">

        </div>
    </div>
</div>

<!-- Ban Seller Modal -->
<div class="modal fade" id="confirm-ban">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h6">{{translate('Confirmation')}}</h5>
                <button type="button" class="close" data-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">
                <p>{{translate('Do you really want to ban this seller?')}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">{{translate('Cancel')}}</button>
                <a class="btn btn-primary" id="confirmation">{{translate('Proceed!')}}</a>
            </div>
        </div>
    </div>
</div>

<!-- Unban Seller Modal -->
<div class="modal fade" id="confirm-unban">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h6">{{translate('Confirmation')}}</h5>
                <button type="button" class="close" data-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">
                <p>{{translate('Do you really want to unban this seller?')}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">{{translate('Cancel')}}</button>
                <a class="btn btn-primary" id="confirmationunban">{{translate('Proceed!')}}</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    $(document).on("change", ".check-all", function() {
            if(this.checked) {
                // Iterate each checkbox
                $('.check-one:checkbox').each(function() {
                    this.checked = true;
                });
            } else {
                $('.check-one:checkbox').each(function() {
                    this.checked = false;
                });
            }

        });

        function change_status(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('services.status') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    AIZ.plugins.notify('success', '{{ translate('Services status updated successfully') }}');
                }
                else{
                    AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                }
            });
        }

        function sort_sellers(el){
            $('#sort_sellers').submit();
        }

        function confirm_ban(url)
        {
            $('#confirm-ban').modal('show', {backdrop: 'static'});
            document.getElementById('confirmation').setAttribute('href' , url);
        }

        function confirm_unban(url)
        {
            $('#confirm-unban').modal('show', {backdrop: 'static'});
            document.getElementById('confirmationunban').setAttribute('href' , url);
        }

        function bulk_delete() {
            var data = new FormData($('#sort_sellers')[0]);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('bulk-service-delete')}}",
                type: 'POST',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    if(response == 1) {
                        location.reload();
                    }
                }
            });
        }

</script>
@endsection