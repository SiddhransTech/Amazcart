@extends('backEnd.master')
@section('mainContent')
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="box_header common_table_header">
                        <div class="main-title d-md-flex">
                            <h3 class="mb-0 mr-30 mb_xs_15px mb_sm_20px">{{__('page-builder.Pages')}}</h3>
                            <ul class="d-flex">
                                @if(permissionCheck('page_builder.pages.store'))
                                    <li>
                                        <a  data-toggle="modal" data-target="#add_page_modal" class="primary-btn radius_30px mr-10 fix-gr-bg" href="#">
                                            <i class="ti-plus"></i> {{ __('page-builder.Add New') }}
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="QA_section QA_section_heading_custom check_box_table">
                        <div class="QA_table ">
                            <div class="" id="lms_data_table">
                                @include('aorapagebuilder::pages.list')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="append_html"></div>
        @includeIf('aorapagebuilder::pages.create')
    </section>
@endsection
@push('scripts')
    <script src="{{asset('Modules/aorapagebuilder/Resources/assets/js/datatable_active.js')}}"></script>
    <script src="{{asset('Modules/aorapagebuilder/Resources/assets/js/pages.js')}}"></script>
    <script>
        $(document).ready(function(){
                $(document).on('click','.edit_row',function(event){
                    event.preventDefault();
                    let url = $(this).attr('data-url');
                    $.ajax({
                        url:url,
                        method:"get"
                    }).done(function(response){
                        $("#append_html").html(response);
                        $("#edit_page_modal").modal('show');
                    });
                });

                $(document).on('click','.delete_row',function(event){
                    event.preventDefault();
                    let url = $(this).attr('data-url');
                    $.ajax({
                        url:url,
                        method:"get"
                    }).done(function(response){
                        $("#append_html").html(response);
                        $("#deleteItemModal").modal('show');
                    });
                });
        });

        function convertToSlug(Text, element) {
          let string =  Text.toLowerCase()
            .replace(/ /g, "-")
            .replace(/[^\w-]+/g, "");
          $(element).val(string);
        }
    </script>
@endpush
