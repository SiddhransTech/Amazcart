@extends('aorapagebuilder::layouts.master')
@section('styles')
    <style>
        .aoraeditor-header .header_area {
            padding: 0 !important;
            position: relative !important;
            top: 0;
        }

        .aoraeditor-header {
            width: calc(100% - var(--editor-width));
            margin-left: var(--editor-width);
        }

        .aoraeditor-footer {
            width: calc(100% - var(--editor-width));
            margin-left: var(--editor-width);
        }

    </style>
@endsection
@php
    $active =   isset($_GET['lang']) && !empty($_GET['lang']) ? $_GET['lang']:'en';
    $langCode = isset($_GET['lang']) && !empty($_GET['lang']) ? $_GET['lang']:'en';
@endphp
@section('content')
    {!! $row->getTranslation('description',$active) !!}
@endsection

@section('scripts')



    <script type="text/javascript" data-aoraeditor="script">
        $(function () {
            $('#content-area').aoraeditor({
                snippetsUrl: '{{route('page_builder.snippet')}}',
                title: '{{__('common.Design')}} {{$row->title}} {{__('frontendmanage.Page')}}',
                onSave: function (content) {
                    let jHtmlObject = jQuery(content);
                    let editor = jQuery("<p>").append(jHtmlObject);
                    editor.find(".aoraeditor-skip").remove();
                    let newHtml = editor.html();


                    var url = '{{ route("page_builder.pages.design.update",":id") }}';
                    url = url.replace(':id', {{$row->id}});


                    $.ajax({
                        url: url,
                        type: "PUT",
                        data: {
                            'body': newHtml,
                            'lang': '{{$active}}',
                            _token: "{{csrf_token()}}"
                        },
                        success: function (data) {
                            location.reload();
                            toastr.success("{{__('frontendmanage.Page Designed Save Successfully')}}")
                        }
                    });
                },
            });

            $('.aoraeditor-topbar-right').prepend(
                '<a href="#" title="Responsive View" class="aoraeditor-ui aoraeditor-topbar-btn toggleResponsiveBar"><i class="fas fa-laptop"></i></a>'
            );
            $('.aoraeditor-topbar-right').prepend(
                '<a target="_blank" href="{{ $row->is_static!=1?url('pages/'.$row->slug):url($row->slug)}}" title="Frontend View" class="aoraeditor-ui aoraeditor-topbar-btn"><i class="fas fa-external-link-alt"></i></a>'
            );

            @if(isModuleActive('FrontendMultiLang'))
            @php
                $LanguageList = getLanguageList();
            @endphp
            $('.aoraeditor-topbar-right').prepend(
                '<select name="lang" id="languageChanger">' +
                @foreach ($LanguageList as $key => $language)
                    '<option value="{{ url()->current().'?lang='.$language->code}}" {{$active==$language->code?'selected':''}}>{{$language->native}}</option>' +
                @endforeach
                    '</select>'
            );

            $(document).on('change', '#languageChanger', function (e) {
                e.preventDefault();
                window.location.href = $(this).val();

            });
            @endif




            $('.aoraeditor-topbar').prependTo(".aoraeditor-header");
            $('.aoraeditor-topbar').appendTo(".aoraeditor-footer");

            // $(".aoraeditor-topbar-right").clone().appendTo(".aoraeditor-modal-footer");
            $(".aoraeditor-topbar-right").appendTo(".aoraeditor-modal-footer");


            $(document).on("click", ".toggleResponsiveBar", function () {
                $('.aoraeditor-topbar').toggleClass('hide-desktop')
            });


            function checkWindowSize() {
                if (window.matchMedia('(min-width: 992px)').matches) {
                    $('.aoraeditor-modal').addClass('show_modal');
                } else {
                    $('.aoraeditor-modal').removeClass('show_modal');

                }
                $(document).on("click", "[data-snippet]", function () {
                    $('.aoraeditor-modal').hide();
                });
            }

            checkWindowSize();
            $(window).on('resize', function () {
                checkWindowSize();
            });

        });



    </script>
@endsection
