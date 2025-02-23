
    <div class="modal-body">
        <div class="row">
            <div class="col-xl-6 col-md-6">
                <label for="name" class="mb-2">{{ __('common.bank_name') }} <span class="text-danger">*</span></label>
                <input type="text"  class="primary_input_field form-control mb_20"

                placeholder="{{ __('common.bank_name') }}"

                    name="bank_name" value="{{@old('bank_name')}}">
                <span class="invalid-feedback" role="alert" id="bank_name"></span>
            </div>
            <div class="col-xl-6 col-md-6">
                <label for="name" class="mb-2">{{ __('common.branch_name') }} <span class="text-danger">*</span></label>
                <input type="text"  name="branch_name"
                    class="primary_input_field form-control mb_20" placeholder="{{ __('common.branch_name') }}"
                    value="{{@old('branch_name')}}">
                <span class="invalid-feedback" role="alert" id="branch_name"></span>
            </div>
        </div>
        <div class="row mb-20">
            <div class="col-xl-6 col-md-6">
                <label for="name" class="mb-2">{{ __('common.account_number') }} <span class="text-danger">*</span></label>
                <input type="text"  class="primary_input_field form-control mb_20"
                    placeholder="{{ __('common.account_number') }}" name="account_number"
                    value="{{@old('account_number')}}">
                <span class="invalid-feedback" role="alert" id="account_number"></span>
            </div>
            <div class="col-xl-6 col-md-6">
                <label for="name" class="mb-2">{{ __('wallet.account_holder') }} <span class="text-danger">*</span></label>
                <input type="text"  name="account_holder"
                    class="primary_input_field form-control mb_20"
                    placeholder="{{ __('wallet.account_holder') }}" value="{{@old('account_holder')}}">
                <span class="invalid-feedback" role="alert" id="account_holder"></span>
            </div>
            <input type="hidden" name="bank_amount" value="{{ $total_pay}}">

        </div>

        <div class="row  mb-20">
            <div class="col-xl-12 col-md-12">
                <div class="primary_file_uploader">
                    <label for="name" class="mb-2 w-100">{{ __('wallet.cheque_slip') }} <span class="text-danger">*</span></label>
                    <input type="file" class="imgBrowse" name="image" id="document_file_1">
                </div>

            </div>
        </div>
        <div class="QA_section3 QA_section_heading_custom th_padding_l0 mt-3">
            <div class="QA_table">
                <!-- table-responsive -->
                <div class="table-responsive">
                    @php
                    if($bank){
                            $bank_info  = DB::table('seller_wise_payment_gateways')->where('payment_method_id',$bank->id)->first();
                    }else{
                            $bank_info = null;
                    }

                    @endphp
                    <table class="table pos_table pt-0 shadow_none pb-0 ">
                        <tbody>
                            <tr>
                                <td>{{ __('common.bank_name') }}</td>
                                <td>{{!empty($bank_info) ? $bank_info->perameter_1:''}}</td>
                            </tr>
                            <tr>
                                <td>{{ __('common.branch_name') }}</td>
                                <td>{{!empty($bank_info) ?  $bank_info->perameter_2:''}}</td>
                            </tr>

                            <tr>
                                <td>{{ __('wallet.account_number') }}</td>
                                <td>{{!empty($bank_info) ?  $bank_info->perameter_3:''}}</td>
                            </tr>

                            <tr>
                                <td>{{ __('common.account_holder') }}</td>
                                <td>{{!empty($bank_info) ?  $bank_info->perameter_4:''}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-12 text-center d-none">
            <div class="d-flex justify-content-center pt_20">
                <button type="submit" class="primary-btn semi_large2 fix-gr-bg" id="save_button_parent"><i
                        class="ti-check"></i>{{ __('common.payment') }}</button>
            </div>
        </div>
    </div>

@push("scripts")

@endpush

