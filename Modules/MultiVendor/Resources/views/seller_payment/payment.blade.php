@extends('frontend.amazy.layouts.app')
@push('styles')
    <link rel="stylesheet" href="{{asset(asset_path('frontend/amazy/css/page_css/product_details.css'))}}" />
    <link rel="stylesheet" href="{{asset(asset_path('frontend/default/css/lightbox.css'))}}" />
    @if(isRtl())
        <style>
            .zoomWindowContainer div {
                left: 0!important;
                right: 510px;
            }
            .product_details_part .cs_color_btn .radio input[type="radio"] + .radio-label:before {
                left: -1px !important;
            }
            @media (max-width: 970px) {
                .zoomWindowContainer div {
                    right: inherit!important;
                }
            }
        </style>
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush
@section('content')
<div class="product_details_wrapper">
    <div class="container">
        <div class="row mb-5">
            <div class="col-xl-6">
                <form action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12 mb_10">
                            <h3 class="check_v3_title2">{{ __("common.plan_details") }}</h3>
                            <h6 class="shekout_subTitle_text">{{__('defaultTheme.all_transactions_are_secure_and_encrypted')}}.</h6>
                        </div>
                        <div class="col-12">
                            <table class="table table-bordered">
                                <tr>
                                    <td style="width: 20%">{{ __("common.plan_name") }}:</td>
                                    <td>{{ $seller_subscription->pricing->name }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 20%">{{ __("common.stock_limit") }}:</td>
                                    <td>{{ $seller_subscription->pricing->stock_limit }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 20%">{{ __('common.category_limit') }}:</td>
                                    <td>{{ $seller_subscription->pricing->category_limit }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 20%">{{ __("common.team_size") }}:</td>
                                    <td>{{ $seller_subscription->pricing->team_size }}</td>
                                </tr>

                                <tr>
                                    <td style="width: 20%">{{ __("common.expire_in") }}:</td>
                                    <td>{{ $seller_subscription->pricing->expire_in }} {{ __("common.days") }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <a href="{{ route('seller.subscriptionPaymentGateway',$seller_subscription->id) }}" class="amaz_primary_btn style2  min_200 text-center text-uppercase">
                                {{ __("common.continue_payment") }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-6">
                    <div class="order_sumery_box flex-fill">
                        <h3 class="check_v3_title mb_25">{{ __('common.payment_summery') }}</h3>
                        <div class="subtotal_lists">
                                <div class="single_total_list d-flex align-items-center">
                                    <div class="single_total_left flex-fill">
                                        <span class="total_text">{{ __("common.plan_price") }}</span>
                                    </div>
                                    <div class="single_total_right">
                                        <span class="total_text">{{ single_price($seller_subscription->pricing->plan_price) }}</span>
                                    </div>
                                </div>

                                @php
                                    $discount = 0;
                                    $dis_percent = !empty($seller_subscription->pricing) ? $seller_subscription->pricing->discount:0;
                                    if(!empty($seller_subscription->pricing) && $seller_subscription->pricing->discount_type == 1){
                                       $discount = ($seller_subscription->pricing->plan_price * $seller_subscription->pricing->discount) / 100;
                                    }else{
                                       $discount = $seller_subscription->pricing->discount;
                                    }

                                    $sub_total = $seller_subscription->pricing->plan_price - $discount;
                                @endphp

                                <div class="single_total_list d-flex align-items-center">
                                    <div class="single_total_left flex-fill">
                                        <span class="total_text">{{ __("common.discount") }} {{$seller_subscription->pricing->discount_type == 1 ?  "(".$seller_subscription->pricing->discount.'%'.")" :''}} </span>
                                    </div>
                                    <div class="single_total_right">
                                        <span class="total_text"  > {{ single_price($discount) }} </span>
                                    </div>
                                </div>

                                @if(session()->has('coupon_discount'))
                                    <div class="single_total_list d-flex align-items-center">
                                        <div class="single_total_left flex-fill">
                                            <span class="total_text">{{ __("common.coupon_discount") }}  {{session()->get('coupon_type') == 0 ? "(".session()->get('coupon_amount').'%'.")":'' }} </span>
                                        </div>
                                        <div class="single_total_right">
                                            <span class="total_text"  > {{ single_price(session()->get('coupon_discount')) }} </span>
                                        </div>
                                    </div>
                                    @php
                                        $sub_total = $sub_total - session()->get('coupon_discount');
                                    @endphp
                                @endif

                                <div class="single_total_list d-flex align-items-center">
                                    <div class="single_total_left flex-fill">
                                        <span class="total_text">{{ __("common.subtotal") }}</span>
                                    </div>
                                    <div class="single_total_right">
                                        <span class="total_text"  > {{ single_price($sub_total) }} </span>
                                    </div>
                                </div>



                                @php
                                    $tax = !empty($seller_subscription->pricing) && !empty($seller_subscription->pricing->vat) ? $seller_subscription->pricing->vat->tax_percentage:0;
                                    $vat = ($sub_total * $tax) / 100
                                @endphp

                                <div class="single_total_list d-flex align-items-center">
                                    <div class="single_total_left flex-fill">
                                        <span class="total_text"> {{__('common.vat/tax/gst')}} ({{$tax}} %) </span>
                                    </div>
                                    <div class="single_total_right">
                                        <span class="total_text"  > {{ single_price($vat) }} </span>
                                    </div>
                                </div>



                                <div class="total_amount d-flex align-items-center flex-wrap pb_25">
                                    <div class="single_total_left flex-fill">
                                        <span class="total_text">{{ __("common.total") }} </span>
                                    </div>
                                    <div class="single_total_right">
                                        <span class="total_text"  > {{ single_price($vat + $sub_total) }} </span>
                                    </div>
                                </div>


                                @if(!session()->has('coupon_discount'))
                                <div class="coupon_wrapper  couponCodeDiv">

                                        <input data-price="{{ $vat + $sub_total }}" data-url='{{ route('seller.plan.apply_coupon',$seller_subscription->pricing->id) }}' placeholder="Coupon Code" id="coupon_code" class="primary_input5 "  onfocus="this.placeholder = ''" onblur="this.placeholder = 'Coupon Code'" type="text">
                                        <button type="button" class="amaz_primary_btn style4 min_100 text-uppercase text-center coupon_apply_btn" data-total="19">Apply</button>

                                </div>
                                @endif

                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
    <script>
        $(document).on('click','.coupon_apply_btn',function(){
            let coupon = $("#coupon_code").val();
            let url = $("#coupon_code").attr('data-url');

            $.ajax({
                url:url,
                method:"post",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data:{
                    coupon: coupon,
                },
            }).done(function(response){
                if(response.status == 1)
                {
                    toastr.success(response.msg,'Successs');
                    window.location.reload();
                }else{
                    toastr.error(response.msg,'Successs');
                }
            });
        });
    </script>
@endpush
