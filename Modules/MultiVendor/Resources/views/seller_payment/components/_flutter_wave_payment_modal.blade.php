<div class="modal-body">
    @csrf
    <input type="hidden" name="method" value="flutterwave">
    <div class="row">
        <div class="col-xl-6 col-md-6">
            <label for="name" class="mb-2">{{ __('common.name') }} <span class="text-danger">*</span></label>
            <input type="text" required class="primary_input4 form-control mb_20" placeholder="" name="name" value="{{auth()->user()->first_name}}">
            <span class="invalid-feedback" role="alert" id="name"></span>
        </div>
        <div class="col-xl-6 col-md-6">
            <label for="name" class="mb-2">{{ __('common.email') }} <span class="text-danger">*</span></label>
            <input type="email" required name="email" class="primary_input4 form-control mb_20" placeholder="" value="{{auth()->user()->email}}">
            <span class="invalid-feedback" role="alert" id="email"></span>
        </div>
    </div>
    <div class="row mb-20">
        <div class="col-xl-6 col-md-6">
            <label for="name" class="mb-2">{{ __('common.mobile') }} <span class="text-danger">*</span></label>
            <input type="text" required class="primary_input4 form-control mb_20" placeholder="" name="phone" value="{{@old('phone')}}">
            <span class="invalid-feedback" role="alert" id="phone"></span>
        </div>
        <div class="col-xl-6 col-md-6">
            <label for="name" class="mb-2">{{ __('common.amount') }} <span class="text-danger">*</span></label>
            <input type="number" min="0" step="{{step_decimal()}}" value="{{ $recharge_amount }}" id="amount" name="amount" class="primary_input4 form-control mb_20">
            <span class="invalid-feedback" role="alert" id="name"></span>
        </div>
    </div>
    <input type="hidden" name="purpose" value="wallet recharge">
</div>
