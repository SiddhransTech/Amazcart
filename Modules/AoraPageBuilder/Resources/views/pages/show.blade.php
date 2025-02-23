@extends(theme('layouts.app'))
@section('styles')
    {{-- <link rel="stylesheet" type="text/css" href="{{asset('Modules/PageBuilder/Resources/assets/css/affiliate.css')}}">
    <style>
        .row{
            margin: 0!important;
        }
    </style> --}}
    <link rel="stylesheet"
          href="{{ asset('public/frontend/infixlmstheme') }}/css/fontawesome.css{{assetVersion()}} "
          data-type="aoraeditor-style">

    <link rel="stylesheet" href="{{asset('Modules/AoraPageBuilder/Resources/assets/css/aoraeditor.css')}}"
          data-type="aoraeditor-style"/>
    <link rel="stylesheet"
          href="{{asset('Modules/AoraPageBuilder/Resources/assets/css/aoraeditor-components.css')}}"
          data-type="aoraeditor-style"/>


    <link rel="stylesheet" type="text/css" data-type="aoraeditor-style"
          href="{{asset('Modules/AoraPageBuilder/Resources/assets/css/style.css')}}">
@endsection

@section('content')


<div class="row">
    <div class="container mt_30 mb_30">
        @php
            echo $row->description;
        @endphp
    </div>
</div>
@endsection

@push('scripts')
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
@endpush


