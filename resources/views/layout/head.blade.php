<meta charset="utf-8" />
<title>Sarpras | {{ session('title') }}</title>
<meta name="description" content="Base portlet examples">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<!--begin::Web font -->
<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
<script>
    WebFont.load({
        google: {
            "families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]
        },
        active: function() {
            sessionStorage.fonts = true;
        }
    });
</script>

<!--end::Web font -->

<!--begin::Global Theme Styles -->
<link href="{{ asset('asset/css/vendors.bundle.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('asset/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />

<!--RTL version:<link href="../../assets/demo/default/base/style.bundle.rtl.css" rel="stylesheet" type="text/css" />-->

<!--end::Global Theme Styles -->
<link rel="shortcut icon" href="{{ asset('asset/img/favicon.ico') }}" />
@stack('styles')
