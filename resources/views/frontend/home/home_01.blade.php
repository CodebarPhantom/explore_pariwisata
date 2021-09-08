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
@push('style')
<style>
  
    

    .overlay::before {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        top: 0;
        background: rgba(0, 0, 0, 0.2);
    }

   .icon  {
        color: white;
        font-size: 100px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        text-align: center;
        opacity: 1 !important;
        text-decoration: none;

    }

    /*.thumb-home::after {
        content: "";
        position: absolute;
        top: 0; right: 0; bottom: 0; left: 0;
        background: linear-gradient(
            to bottom, 
            rgba(64,64,64,0) 0%, 
            rgba(64,64,64,0) 60%, 
            rgba(64,64,64,1) 90%, 
            rgba(64,64,64,1) 100%
        ); 
    }*/

    .section-center {
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        -webkit-transform: translateY(-50%);
        transform: translateY(-50%);
    }

    .booking-cta {
        margin-top: 45px;
        
    }

    .booking-cta h1 {
        font-size: 38px;
        font-family: 'Poppins';
        color: #181818;
        font-weight: 700;
    }

    .booking-cta p {
        
        margin-top: 10px;

        font-family: Poppins;
        font-style: normal;
        font-weight: normal;
        font-size: 18px;
        line-height: 27px;

        color: #000000;
    }

    .booking-form {
        background: #fff;
        -webkit-box-shadow: 0px 8px 32px rgba(130, 130, 130, 0.25);
        box-shadow: 0px 8px 32px rgba(130, 130, 130, 0.25);
        border-radius: 20px;
        max-width: 642px;
        width: 100%;
        margin: auto;
        padding: 40px 30px;
    }

    .box-search{
        background: #FFFFFF;
        border: 1px solid #B5B5B5;
        box-sizing: border-box;
        border-radius: 10px;
    }

    
</style>
@endpush
@section('main')
    <main id="main" class="site-main">
        <div class="site-banner"  {{$home_banner}}>
            <div class="container">
                <div class="site-banner__content golo-ajax-search">
                    <h1 class="site-banner__title">{{__('Exploring Karawang')}}</h1>
                </div>
            </div>
        </div><!-- .site-banner -->
        <div class="news">
            <div class="container">
                <div class="news__content">
                    <div class="row">
                        <div class="col-md-4">
                            <article class="post hover__box">
                                <div class="post__thumb hover__box__thumb ">
                                    <a title="Berwisata di Karawang dengan penuh kesan" href="#"><img src="{{ asset('assets/images/home/UWQP2mh5YJI.png') }}" alt="Berwisata di Karawang dengan penuh kesan"></a>
                                    <div class="overlay">
                                        <span class="icon">
                                            <i class="la la-map-marked-alt"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="post__info">
                                    <h3 class="post__title text-center"><a title="Berwisata di Karawang dengan penuh kesan" href="#">Berwisata di Karawang dengan penuh kesan</a></h3>
                                    <p class="text-center">Dapatkan pengalaman berwisata tanpa ribet bersama UlinYu</p>
                                </div>
                            </article>
                        </div>
                        <div class="col-md-4">
                            <article class="post hover__box">
                                <div class="post__thumb hover__box__thumb">
                                    <a title="Kemudahan Pesan Tiket" href="#"><img src="{{ asset('assets/images/home/heLWtuAN3c.png') }}" alt="Kemudahan Pesan Tiket"></a>
                                    <div class="overlay">
                                        <span class="icon">
                                            <i class="la la-ticket-alt"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="post__info">
                                    <h3 class="post__title text-center"><a title="Kemudahan Pesan Tiket" href="#">Kemudahan Pesan Tiket</a></h3>
                                    <p class="text-center">Pesan tiket mudah dan cepat dalam genggaman</p>
                                </div>
                            </article>
                        </div>
                        <div class="col-md-4">
                            <article class="post hover__box">
                                <div class="post__thumb hover__box__thumb">
                                    <a title="Kemudahan dalam Pembayaran" href="#"><img src="{{ asset('assets/images/home/fG5jun4bYBQ.png') }}" alt="Kemudahan dalam Pembayaran"></a>
                                    <div class="overlay">
                                        <span class="icon">
                                            <i class="la la-credit-card"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="post__info">
                                    <h3 class="post__title text-center"><a title="Kemudahan dalam Pembayaran" href="#">Kemudahan dalam Pembayaran</a></h3>
                                    <p class="text-center">Bayar tiket kapanpun dan dimanapun</p>
                                </div>
                            </article>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- .news -->
        <div class="cities">
            <div class="container">
                <div class="cities__content">
                    <div class="row col-xs-12 mx-auto">
                        @foreach($dataTourismInfos as $dataTourismInfo)
                            <div class="col-lg-3 col-sm-6">
                                <div class="cities__item hover__box thumb-home">
                                    <div class="cities__thumb hover__box__thumb">
                                        <a title="{{ $dataTourismInfo->name }}" href="{{route('place_detail', $dataTourismInfo->slug)}}">
                                            <img src="{{$dataTourismInfo->url_cover_image}}" alt="{{$dataTourismInfo->name}}">                                            
                                        </a>
                                    </div>
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

        <div class="banner-apps">
            <div class="container">
                <div class="banner-apps__content text-center">
                    <h2 class="banner-apps__title ">{{"Download Aplikasi UlinYu"}}</h2>
                    <p class="banner-apps__desc">{{"Dapatkan kemudahan dalam satu genggaman"}}</p>
                    <div class="banner-apps__download">
                        <a title="Google Play" href="#" class="banner-apps__download__android"><img src="{{asset('assets/images/assets/google-play.png')}}" alt="Google Play"></a>
                    </div>
                </div>
            </div>
        </div><!-- .banner-apps -->
    </main><!-- .site-main -->
@stop
