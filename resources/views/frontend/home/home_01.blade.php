@php
    $img_home_banner = getImageUrl(setting('home_banner'));
    $img_home_banner_app = getImageUrl(setting('home_banner_app'));
    if (setting('home_banner')) {
        $home_banner = "style=background-image:url({$img_home_banner})";
    } else {
        $home_banner = "style=background-image:url(/assets/images/top-banner.png)";
    }
    if (setting('home_banner_app')) {
        $home_banner_app = "style=background-image:url({$img_home_banner_app})";
    } else {
        $home_banner_app = "style=background-image:url(/assets/images/banner-apps.jpg)";
    }
@endphp
@extends('frontend.layouts.template')
@section('main')
    <main id="main" class="site-main">
        <div class="site-banner" {{$home_banner}}>
            <div class="container">
                <div class="site-banner__content golo-ajax-search">
                    <h1 class="site-banner__title">{{__('Exploring Karawang')}}</h1>
                </div><!-- .site-banner__content -->
            </div>
        </div><!-- .site-banner -->
        <div class="cities">
            <div class="container">
                <h2 class="cities__title title">{{__('Popular Location')}}</h2>
                <div class="cities__content">
                    <div class="row">
                        @foreach($dataTourismInfos as $dataTourismInfo)
                            <div class="col-lg-3 col-sm-6">
                                <div class="cities__item hover__box">
                                    <div class="cities__thumb hover__box__thumb">
                                        <a title="{{ $dataTourismInfo->name }}" href="{{route('place_detail', $dataTourismInfo->slug)}}">
                                            <img src="{{$dataTourismInfo->url_cover_image}}" alt="{{$dataTourismInfo->name}}">
                                        </a>
                                    </div>
                                    <h4 class="cities__name">{{$dataTourismInfo->name}}</h4>
                                    <div class="cities__info">
                                        <h3 class="cities__capital">{{$dataTourismInfo->name}}</h3>
                                    </div>
                                </div><!-- .cities__item -->
                            </div>
                        @endforeach
                    </div>
                </div><!-- .cities__content -->
            </div>
        </div><!-- .cities -->
    </main><!-- .site-main -->
@stop
