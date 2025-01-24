@php
    use App\Services\SeoService;
    $seo = app(SeoService::class);
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="chrome=1,IE=edge">
    {{-- 默认使用谷歌浏览器内核--}}
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <title>{{getSetting('web_title')}} - {{ $seo->getTitle() }}</title>
    <meta name="keywords" content="{{ $seo->getKeywords(getSetting('web_keywords')) }}">
    <meta name="description" content="{{ $seo->getDescription(getSetting('web_description')) }}">


    {{-- 这边添加样式 --}}
    @yield('style')
</head>
<body>
@include('home.layouts.header')

@yield('content')

@include('home.layouts.footer')
{{-- 这边添加js --}}
@yield('script')
</body>
</html>
