@extends('backEnd.master')

@section('mainContent')
@if(isModuleActive('FrontendMultiLang'))
    @php
        $LanguageList = getLanguageList();
    @endphp
@else
    @php
        $LanguageList = getLanguageList();
    @endphp
@endif

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">

            <div class="row">
                <div class="col-4">
                    <div class="white_box_50px box_shadow_white mb-20">
                        <form action="{{ route('form_builder.builder.translation.store') }}" method="post">
                            @csrf
                            <div class="row">

                                <div class="col-lg-12">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for=""> {{__("common.languages")}} <span class="text-danger">*</span></label>
                                        <select name="language" id="language" class="primary_select">
                                            <option value="">{{ __("common.please_select") }}</option>
                                            @foreach($LanguageList as $language)
                                                <option value="{{ $language->code }}">{{ $language->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for=""> {{__("common.key")}} <span class="text-danger">*</span></label>
                                        <input class="primary_input_field" name="key" id="key" placeholder="{{__("common.key")}}" type="text" value="{{old('key')}}">
                                        <span class="text-danger" id="name_error"></span>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="primary_input mb-15">
                                        <label class="primary_input_label" for=""> {{__("common.value")}} <span class="text-danger">*</span></label>
                                        <input class="primary_input_field" name="value" id="value" placeholder="{{__("common.value")}}" type="text" value="{{old('value')}}">
                                        <span class="text-danger" id="name_error"></span>
                                    </div>
                                </div>


                                <div class="col-lg-12 mt-2">
                                    <button id="create_btn" type="submit" class="primary-btn fix-gr-bg submit_btn" data-toggle="tooltip" data-original-title=""><span class="ti-check"></span>{{__('common.save')}} </button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

