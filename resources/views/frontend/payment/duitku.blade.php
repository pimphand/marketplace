@if ($data['responseMessage'] == 'SUCCESS')
<div class="modal-header">
    <h3>Duitku Payment</h3>
</div>
<div class="modal-body">
    <div class="row p-2 m-2">
        @foreach ($data['paymentFee'] as $payment)
        <div class="col-6 col-md-4">
            <label class="aiz-megabox d-block mb-3">
                <input value="{{ $payment['paymentMethod'] }}" class="online_payment" type="radio" name="payment_option"
                    onclick="paymentMethod('{{ $payment['paymentMethod'] }}','{{ $payment['totalFee'] }}')">
                <span class="d-block aiz-megabox-elem p-3">
                    <img src="{{ $payment['paymentImage'] }}" class="img-fluid mb-2">
                    <span class="d-block text-center">
                        <span class="d-block fw-600 fs-15">
                            {{ $payment['paymentName'] }}
                        </span>
                        <span class="d-block fw-600 fs-15">
                            Fee Rp.{{ number_format($payment['totalFee']) }}
                        </span>
                    </span>
                </span>

            </label>
        </div>
        @endforeach
    </div>
    <div class="modal-footer">
        @if ($cart)
        <button type="button" id="_button-duitku" class="btn btn-success">Simpan</button>
        @else
        <button type="button" id="_button-duitku" class="btn btn-success">Bayar</button>
        @endif
    </div>
</div>

@else
<div class="modal-header">
    <h3>Duitku Payment</h3>
</div>
<div class="modal-body">
    <div class="row p-2 m-2">
        <h1>Data tidak ditemukan</h1>
    </div>
</div>
<div class="modal-footer">
</div>
@endif