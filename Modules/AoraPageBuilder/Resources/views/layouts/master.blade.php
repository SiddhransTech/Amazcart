<!DOCTYPE html>
<html dir="{{isRtl()?'rtl':''}}" class="{{isRtl()?'rtl':''}}" lang="en" itemscope
      itemtype="{{url('/')}}">
<head>
    @laravelPWA
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <meta property="og:url" content="{{url()->current()}}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="{{app('general_setting')->site_title}}"/>
    <meta property="og:description" content="{{app('general_setting')->site_title}}"/>
    <meta property="og:image" content="{{showImage(app('general_setting')->favicon)}}"/>

    <title>Page Builder | {{ $row->title }}</title>

    {{-- <link rel="stylesheet" href="{{asset('public/backend/css/themify-icons.css')}}{{assetVersion()}}"/>

    <link rel="stylesheet" href="{{asset('Modules/AoraPageBuilder/Resources/assets/css/bootstrap.min.css')}}"
          data-type="aoraeditor-style"/>

    <link rel="stylesheet"
          href="{{ asset('public/frontend/infixlmstheme') }}/css/fontawesome.css{{assetVersion()}} "
          data-type="aoraeditor-style"> --}}

    <link rel="stylesheet" href="{{asset('Modules/AoraPageBuilder/Resources/assets/css/aoraeditor.css')}}"
          data-type="aoraeditor-style"/>
    <link rel="stylesheet"
          href="{{asset('Modules/AoraPageBuilder/Resources/assets/css/aoraeditor-components.css')}}"
          data-type="aoraeditor-style"/>


    <link rel="stylesheet" type="text/css" data-type="aoraeditor-style"
          href="{{asset('Modules/AoraPageBuilder/Resources/assets/css/style.css')}}">

    @php
        if(app('theme')->folder_path == 'amazy'){
            $frontend_asset = asset(asset_path('frontend/amazy/compile_css/app.css'));
        }else{
            $frontend_asset = asset(asset_path('frontend/default/compile_css/app.css'));
        }
    @endphp
    <link rel="stylesheet" data-type="aoraeditor-style" href="{{$frontend_asset}}" />

    @yield('styles')

    <script src="{{asset('public/js/common.js')}}"></script>
    <script type="text/javascript" data-type="aoraeditor-script"
            src="{{asset('Modules/AoraPageBuilder/Resources/assets/js/jquery-1.11.3.min.js')}}"></script>

    <link rel="stylesheet" href="{{asset('public/css/preloader.css')}}"/>

    <script type="text/javascript"
            src="{{asset('public/frontend/infixlmstheme/js/jquery.lazy.min.js')}}"></script>
            <style>
             .aoraeditor-ui.btn-add-content {
                    color: #fff;
                    width: 40px;
                    height: 40px;
                    background: #556ee6 !important;
                    border-radius: 50%;
                    border: 0;
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    transition: 0.3s;
                    border-radius: 50% !important;
                    text-decoration: none !important;
                }
            </style>
</head>
<body>
@if(str_contains(request()->url(), 'chat'))
    <link rel="stylesheet" href="{{asset('public/backend/css/jquery-ui.css')}}{{assetVersion()}}"/>
    <link rel="stylesheet" href="{{asset('public/backend/vendors/select2/select2.css')}}{{assetVersion()}}"/>
    <link rel="stylesheet" href="{{asset('public/chat/css/style-student.css')}}{{assetVersion()}}">
@endif

@if(auth()->check() && auth()->user()->role_id == 3 && !str_contains(request()->url(), 'chat'))
    <link rel="stylesheet" href="{{asset('public/chat/css/notification.css')}}{{assetVersion()}}">
@endif

@if(isModuleActive("WhatsappSupport"))
    <link rel="stylesheet" href="{{ asset('public/whatsapp-support/style.css') }}{{assetVersion()}}">
@endif
<script>
    window.Laravel = {
        "baseUrl": '{{ url('/') }}' + '/',
        "current_path_without_domain": '{{request()->path()}}',
        "csrfToken": '{{csrf_token()}}',
    }
</script>

<script>
    window._locale = '{{ app()->getLocale() }}';
    window._translations = {!! json_encode(cache('translations'), JSON_INVALID_UTF8_IGNORE) !!}
</script>

@if(auth()->check() && auth()->user()->role_id == 3)
    <style>
        .admin-visitor-area {
            margin: 0 30px 30px 30px !important;
        }

        .dashboard_main_wrapper .main_content_iner.main_content_padding {
            padding-top: 50px !important;
        }

        .primary_input {
            height: 50px;
            border-radius: 0px;
            border: unset;
            font-family: "Jost", sans-serif;
            font-size: 14px;
            font-weight: 400;
            color: unset;
            padding: unset;
            width: 100%;
            @if($errors->any())
margin-bottom: 5px;
            @else
margin-bottom: 30px;
        @endif








}

        .primary_input_field {
            border: 1px solid #ECEEF4;
            font-size: 14px;
            color: #415094;
            padding-left: 20px;
            height: 46px;
            border-radius: 30px;
            width: 100%;
            padding-right: 15px;
        }

        .primary_input_label {
            font-size: 12px;
            text-transform: uppercase;
            color: #828BB2;
            display: block;
            margin-bottom: 6px;
            font-weight: 400;
        }

        .chat_badge {
            color: #ffffff;
            border-radius: 20px;
            font-size: 10px;
            position: relative;
            left: -20px;
            top: -12px;
            padding: 0px 4px !important;
            max-width: 18px;
            max-height: 18px;
            box-shadow: none;
            background: #ed353b;
        }

        .chat-icon-size {
            font-size: 1.35em;
            color: #687083;
        }
    </style>
@endif


<input type="hidden" id="url" value="{{url('/')}}">
<input type="hidden" name="base_url" class="base_url" value="{{url('/')}}">
<input type="hidden" name="csrf_token" class="csrf_token" value="{{csrf_token()}}">
@if(auth()->check())
    <input type="hidden" name="balance" class="user_balance" value="{{auth()->user()->balance}}">
@endif
>
<div data-aoraeditor="html">

    <div id="content-area">
        @yield('content')
    </div>


</div>


<script type="text/javascript"
        src="{{asset('Modules/AoraPageBuilder/Resources/assets/js/bootstrap.min.js')}}"></script>
<script type="text/javascript"
        src="{{asset('Modules/AoraPageBuilder/Resources/assets/js/jquery-ui.min.js')}}"></script>
<script type="text/javascript"
        src="{{asset('Modules/AoraPageBuilder/Resources/assets/js/ckeditor.js')}}"></script>
<script type="text/javascript"
        src="{{asset('Modules/AoraPageBuilder/Resources/assets/js/form-builder.min.js')}}"></script>
<script type="text/javascript"
        src="{{asset('Modules/AoraPageBuilder/Resources/assets/js/form-render.min.js')}}"></script>
<script type="text/javascript"
        src="{{asset('Modules/AoraPageBuilder/Resources/assets/js/aoraeditor.js')}}"></script>

<script type="text/javascript"
        src="{{asset('Modules/AoraPageBuilder/Resources/assets/js/aoraeditor-components.js')}}"></script>



@yield('scripts')


<script type="text/javascript" data-aoraeditor="script">
    $(function () {
        // $('.dynamicData').each(function (i, obj) {
        //     aoraEditor.loadDynamicContent($(this));
        // });


    });
    $(function () {
        if ($.isFunction($.fn.lazy)) {
            $('.lazy').lazy();
        }
    });
</script>
</body>
</html>
