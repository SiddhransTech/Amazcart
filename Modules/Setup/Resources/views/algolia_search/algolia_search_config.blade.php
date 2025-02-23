@extends('backEnd.master')
@section('styles')
<link rel="stylesheet" href="{{asset(asset_path('modules/marketing/css/flash_deal_create.css'))}}" />
<style>
    .fieldtable td{
        padding-left: 0px;
    }
</style>
@endsection
@section('mainContent')
@if(isModuleActive('FrontendMultiLang'))
@php
$LanguageList = getLanguageList();
@endphp
@endif
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="main-title">
                            <h3 class="mb-30">{{__('setup.algolia_search_config')}}</h3>
                        </div>
                    </div>
                </div>
                
                <div class="row mb-2">
                    <div id="formHtml" class="col-lg-12">
                        <div class="white-box">
                            <a href="{{route('setup.import.data.to.algolia')}}" class="primary-btn fix-gr-bg" data-toggle="tooltip" title="Import Data to Algolia server" data-original-title=""> <span class="ti-check"></span> {{__('common.import_to_algolia')}} </a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div id="formHtml" class="col-lg-12">
                        <div class="white-box">
                                <div class="add-visitor">
                                    <div class="row">
                                        <table class="table fieldtable">
                                            <thead>
                                                <tr>
                                                    <td>{{__('setup.Field Name')}}</td>
                                                    <td>{{__('setup.Status')}}</td>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr>
                                                    <td>{{__('setup.algolia_search')}}</td>
                                                    <td>
                                                        <div class="primary_input mb-15">
                                                            <label class="switch_toggle" for="status">
                                                                <input type="checkbox" name="status" id="status" value="1" class="status_change_checkbox" @if($algoliaSearch->status==1) {{'checked'}} @endif>
                                                                <div class="slider round"></div>
                                                            </label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')
    <script>
            $(document).ready(function() {
                $(document).on("change", "#status", function(event){
                    $('#pre-loader').removeClass('d-none');
                    event.preventDefault();
                    if ($('#status').is(":checked"))
                    {
                        var status = 1;
                    }else{
                        var status = 0;
                    }
                    $.ajax({
                        url:  "{{route('setup.update.algolia.search.config')}}",
                        type: "POST",
                        data: {status: status,  _token: "{{ csrf_token() }}"},
                        dataType : 'json',
                        success: function (response) {
                            toastr.success("{{__('setup.algolia_updated_successfully')}}", "{{__('common.success')}}");
                            $('#pre-loader').addClass('d-none');
                        },
                        error: function (response) {
                            $('#pre-loader').addClass('d-none');
                        }
                    });
                });
            });
    </script>
@endpush
