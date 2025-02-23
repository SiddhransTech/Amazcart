<div class="modal fade admin-query" id="edit_page_modal">
    <div class="modal-dialog modal_800px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{__('page-builder.Update Page')}}</h4>
                <button type="button" class="close " data-dismiss="modal">
                    <i class="ti-close "></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="update_form" method="post" action="{{ route('page_builder.pages.update') }}">
                    <div class="row">

                        @csrf
                        <input type="hidden" value="{{$row->id}}" name="id" id="rowId">
                        @if(isModuleActive('FrontendMultiLang'))
                            @php
                                $LanguageList = getLanguageList();
                            @endphp
                        @endif
                        @if(isModuleActive('FrontendMultiLang'))
                            <div class="col-lg-12">
                                <ul class="nav nav-tabs justify-content-start mt-sm-md-20 mb-30 grid_gap_5" role="tablist">
                                    @foreach ($LanguageList as $key => $language)
                                        <li class="nav-item lang_code" data-id="{{$language->code}}">
                                            <a class="nav-link anchore_color @if (auth()->user()->lang_code == $language->code) active @endif" href="#element{{$language->code}}" role="tab" data-toggle="tab" aria-selected="@if (auth()->user()->lang_code == $language->code) true @else false @endif">{{ $language->native }} </a>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="tab-content">
                                    @foreach ($LanguageList as $key => $language)
                                        <div role="tabpanel" class="tab-pane fade @if (auth()->user()->lang_code == $language->code) show active @endif" id="element{{$language->code}}">
                                            <div class="col-lg-12">
                                                <div class="primary_input mb-25">
                                                    <label class="primary_input_label" for="coupon_title"> {{__('page-builder.Title')}} <span class="text-danger">*</span></label>
                                                    <input class="primary_input_field page_title" type="text" id="title_title_{{$language->code}}" name="title[{{$language->code}}]" autocomplete="off" value="{{ old('title.'.$language->code,$row->getTranslation('title',$language->code)) }}" placeholder="{{__('page-builder.Title')}}">
                                                    <span class="text-danger" id="error_title_{{$language->code}}"></span>
                                                </div>

                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                        <div class="col-lg-12">
                            <div class="primary_input mb-15">
                                <label class="primary_input_label" for="title"> {{__('page-builder.Title')}} <span class="required_mark_theme">*</span></label>
                                <input class="primary_input_field page_title" id="title" name="title" placeholder="{{__('page-builder.Title')}}" type="text" value="{{$row->title}}">
                                <span class="text-danger" id="error_title"></span>
                            </div>
                        </div>
                        @endif



                        <div class="col-lg-12">
                            <div class="primary_input mb-15">
                                <label class="primary_input_label" for="slug"> {{__('page-builder.Slug')}} <span class="required_mark_theme">*</span></label>
                                <input class="primary_input_field page_slug" id="slug" name="slug" placeholder="{{__('page-builder.Slug')}}" type="text" value="{{$row->slug}}">
                                <span class="text-danger" id="error_slug"></span>
                            </div>
                        </div>
                        <div class="col-lg-12 text-center">
                            <div class="d-flex justify-content-center">
                                <button class="primary-btn semi_large2  fix-gr-bg mr-10"  type="submit"><i class="ti-check"></i>{{__('common.update') }}</button>
                                <button class="primary-btn semi_large2  fix-gr-bg" id="save_button_parent" data-dismiss="modal" type="button"><i class="ti-check"></i>{{__('common.cancel') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

