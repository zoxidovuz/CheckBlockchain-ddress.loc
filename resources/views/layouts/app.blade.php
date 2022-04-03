<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ asset('css/bootstrap-multiselect.min.css') }}" type="text/css" />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
    @yield('meta')
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('imgs/favicon.ico') }}">
    <title>@yield('title')</title>
    @if (trim($__env->yieldContent('page-head')))
        @yield('page-head')
    @endif
</head>

<body itemscope itemtype="https://schema.org/WebPage">

@include('components.header')

@yield('content')

@include('components.footer')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js"></script>
<script type="text/javascript" src="{{ asset('js/script.js') }}"></script>

@if (trim($__env->yieldContent('page-script')))
    @yield('page-script')
@endif
<script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "WebSite",
            "url": "http://checkblockchainaddress.com",
            "name": "CheckBlockchainAddress.com",
            "potentialAction": {
              "@type": "SearchAction",
              "target": "http://checkblockchainaddress.com/?q={query}",
              "query-input": "required name=query"
            }
        }
    </script>
</body>

</html>
