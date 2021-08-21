@extends('frontend.layouts.template')
@section('main')
    <main id="main" class="site-main place-04">
        <div class="place">
            <div class="slick-sliders">
                <div class="slick-slider photoswipe" data-item="1" data-arrows="false" data-itemScroll="1" data-dots="false" data-infinite="false" data-centerMode="false" data-centerPadding="0">
                    
                    <div class="place-slider__item photoswipe-item"><a href="{{$showTourism->url_cover_image}}" data-height="900" data-width="1200" data-caption="{{$showTourism->name}}"><img src="{{$showTourism->url_cover_image}}" alt="{{$showTourism->name}}"></a></div>
                        
                   
                </div>
                <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
                    <!-- Background of PhotoSwipe.
                           It's a separate element as animating opacity is faster than rgba(). -->
                    <div class="pswp__bg"></div>
                    <!-- Slides wrapper with overflow:hidden. -->
                    <div class="pswp__scroll-wrap">
                        <!-- Container that holds slides.
                              PhotoSwipe keeps only 3 of them in the DOM to save memory.
                              Don't modify these 3 pswp__item elements, data is added later on. -->
                        <div class="pswp__container">
                            <div class="pswp__item"></div>
                            <div class="pswp__item"></div>
                            <div class="pswp__item"></div>
                        </div>
                        <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
                        <div class="pswp__ui pswp__ui--hidden">
                            <div class="pswp__top-bar">
                                <!--  Controls are self-explanatory. Order can be changed. -->
                                <div class="pswp__counter"></div>
                                <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                                <button class="pswp__button pswp__button--share" title="Share"></button>
                                <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
                                <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
                                <!-- Preloader demo https://codepen.io/dimsemenov/pen/yyBWoR -->
                                <!-- element will get class pswp__preloader--active when preloader is running -->
                                <div class="pswp__preloader">
                                    <div class="pswp__preloader__icn">
                                        <div class="pswp__preloader__cut">
                                            <div class="pswp__preloader__donut"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                                <div class="pswp__share-tooltip"></div>
                            </div>
                            <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
                            </button>
                            <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
                            </button>
                            <div class="pswp__caption">
                                <div class="pswp__caption__center"></div>
                            </div>
                        </div>
                    </div>
                </div><!-- .pswp -->
            </div><!-- .place-slider -->
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="place__left">
                            <ul class="place__breadcrumbs breadcrumbs">
                                <li><a title="Karawang" href="{{route('city_detail', $showTourism->slug)}}">{{"KARAWANG"}}</a></li>
                            </ul><!-- .place__breadcrumbs -->
                            <div class="place__box place__box--npd">
                                <h1>{{$showTourism->name}}</h1>
                                <div class="place__meta">
                                    <div class="place__reviews reviews">
											<span class="place__reviews__number reviews__number"></span>
                                        <span class="place__places-item__count reviews_count"></span>
                                    </div>
                                    <!--<div class="place__currency"></div>-->
                                </div><!-- .place__meta -->
                            </div><!-- .place__box -->

                            <div class="place__box place__box-overview">
                                <h3>{{__('Gambaran Singkat')}}</h3>
                                <div class="place__desc">
                                    @php
                                        echo $showTourism->overview;
                                    @endphp
                                </div><!-- .place__desc -->
                                <a href="#" class="show-more" title="{{__('Show more')}}">{{__('Show more')}}</a>
                            </div>
                            <div class="place__box place__box-map">
                                <h3 class="place__title--additional">
                                    {{__('Lokasi & Maps')}}
                                </h3>
                                <div class="maps">
                                    <div id="golo-place-map"></div>

                                    <input type="hidden" id="place_lat" value="{{$showTourism->latitude}}">
                                    <input type="hidden" id="place_lng" value="{{$showTourism->longitude}}">
                                    <!--<input type="hidden" id="place_icon_marker" value="{{-- getImageUrl($categories[0]['icon_map_marker']) --}}">-->
                                </div>
                                <div class="address">
                                    <i class="la la-map-marker"></i>
                                    {{$showTourism->address}}
                                    <a href="https://www.google.com/maps/search/{{$showTourism->latitude.','.$showTourism->longitude}}" title="Direction" target="_blank" rel="nofollow">({{__('Direction')}})</a>
                                   
                                </div>
                            </div><!-- .place__box -->
                            <div class="place__box place__box-open">
                                <h3 class="place__title--additional">
                                    {{__('Jam Buka')}}
                                </h3>
                                @php
                                    $operationalTourisms = json_decode($showTourism->opening_hour);
                                @endphp
                                <table class="open-table">
                                    <tbody>
                                    @foreach($operationalTourisms as $operationalTourism)
                                            <tr>
                                                <td class="day">{{$operationalTourism->day}}</td>
                                                <td class="time">{{$operationalTourism->opening_hour}}</td>
                                            </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div><!-- .place__box -->     
                            <div class="place__box">
                                <h3>{{__('Info Kontak')}}</h3>
                                <ul class="place__contact">
                                    <li>
                                        <i class="la la-phone"></i>
                                        <a href="tel:{{$showTourism->phone}}" rel="nofollow">{{$showTourism->phone}}</a>
                                    </li>
                                    <li>
                                        <i class="la la-facebook"></i>
                                        <a href="{{$showTourism->facebook}}" rel="nofollow">{{$showTourism->facebook}}</a>
                                    </li>
                                    <li>
                                        <i class="la la-instagram"></i>
                                        <a href="{{$showTourism->instagram}}" rel="nofollow">{{$showTourism->instagram}}</a>
                                    </li>
                                </ul>
                            </div><!-- .place__box --> 
                                                  
                        </div><!-- .place__left -->
                    </div>

                    <div class="col-lg-4">
                        <div class="sidebar sidebar--shop sidebar--border">
                            <div class="widget-reservation-mini">                                
                                <h3>{{__('Booking Sekarang Yuk..')}}</h3>
                                <a href="#" class="open-wg btn">{{__('Book now')}}</a>
                            </div>
                            <aside class="widget widget-shadow widget-reservation">
                                <h3>{{__('Booking Sekarang Yuk..')}}</h3>
                                <form action="#" method="POST" class="form-underline" id="booking_form">
                                    @csrf
                                    <div class="field-select has-sub field-guest">
                                        <span class="sl-icon"><i class="la la-user-friends"></i></span>
                                        <input type="text" placeholder="Pengunjung" readonly>
                                        <i class="la la-angle-down"></i>
                                        <div class="field-sub">
                                            <ul>
                                                <li>
                                                    <span>{{$showTourism->categories[0]->name.' - '.number_format($showTourism->categories[0]->price) }} </span>
                                                    <div class="shop-details__quantity">
                                                    <span class="minus">
                                                        <i class="la la-minus"></i>
                                                    </span>
                                                        <input type="hidden" name="tourism_info_category_id[0]" value="{{ $showTourism->categories[0]->id }}">
                                                        <input type="hidden" name="category_name[0]" value="{{$showTourism->categories[0]->name}}">
                                                        <input type="hidden" name="price[0]" value="{{$showTourism->categories[0]->price}}">
                                                        <input type="number" name="qty[0]" value="0" class="qty number_adults">
                                                        <span class="plus">
                                                        <i class="la la-plus"></i>
                                                    </span>
                                                    </div>
                                                </li>
                                                @if (count($showTourism->categories) > 1)
                                                <li>
                                                    <span>{{$showTourism->categories[1]->name.' - '.number_format($showTourism->categories[1]->price)}}</span>
                                                    <div class="shop-details__quantity">
                                                    <span class="minus">
                                                        <i class="la la-minus"></i>
                                                    </span>
                                                        <input type="hidden" name="tourism_info_category_id[1]" value="{{ $showTourism->categories[1]->id }}">
                                                        <input type="hidden" name="category_name[1]" value="{{$showTourism->categories[1]->name}}">
                                                        <input type="hidden" name="price[1]" value="{{$showTourism->categories[1]->price}}">
                                                        <input type="number" name="qty[1]" value="0" class="qty number_childrens">
                                                        <span class="plus">
                                                        <i class="la la-plus"></i>
                                                    </span>
                                                    </div>
                                                </li>
                                                @endif
                                                
                                            </ul>
                                        </div>
                                    </div>
                                    @guest
                                        <div class="field-input">
                                            <input type="text" id="name" name="name" placeholder="Nama Kamu *" required>
                                        </div>
                                        <div class="field-input">
                                            <input type="text" id="email" name="email" placeholder="Email Kamu *" required>
                                        </div>
                                        <div class="field-input">
                                            <input type="text" id="phone_number" name="phone_number" placeholder="Nomor Telephone.">
                                        </div>
                                        <input type="hidden" name="type" value="{{ \App\Models\Booking::TYPE_CONTACT_FORM }}">
                                    @else
                                        <input type="hidden" name="type" value="{{ \App\Models\Booking::TYPE_BOOKING_FORM }}">
                                    @endguest
                                    <div class="field-input">
                                        <textarea type="text" id="message" name="message" placeholder="Pesan Tambahan"></textarea>
                                    </div>
                                    <input type="hidden" name="tourism_info_id" value="{{$showTourism->id }}">
                                    <input type="hidden" name="tourism_name" value="{{$showTourism->name }}">

                                        <button class="btn booking_submit_btn">{{__('Pembayaran')}}</button>
                                    <!--<p class="note">{{__("You won't be charged yet")}}</p>-->

                                    <div class="alert alert-success alert_booking booking_success">
                                        <p>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                                                <path fill="#20D706" fill-rule="nonzero" d="M9.967 0C4.462 0 0 4.463 0 9.967c0 5.505 4.462 9.967 9.967 9.967 5.505 0 9.967-4.462 9.967-9.967C19.934 4.463 15.472 0 9.967 0zm0 18.065a8.098 8.098 0 1 1 0-16.196 8.098 8.098 0 0 1 8.098 8.098 8.098 8.098 0 0 1-8.098 8.098zm3.917-12.338a.868.868 0 0 0-1.208.337l-3.342 6.003-1.862-2.266c-.337-.388-.784-.589-1.207-.336-.424.253-.6.863-.325 1.255l2.59 3.152c.194.252.415.403.646.446l.002.003.024.002c.052.008.835.152 1.172-.45l3.836-6.891a.939.939 0 0 0-.326-1.255z"></path>
                                            </svg>
                                            {{__('You successfully created your booking.')}}
                                        </p>
                                    </div>
                                    <div class="alert alert-error alert_booking booking_error">
                                        <p>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                                                <path fill="#FF2D55" fill-rule="nonzero"
                                                      d="M11.732 9.96l1.762-1.762a.622.622 0 0 0 0-.88l-.881-.882a.623.623 0 0 0-.881 0L9.97 8.198l-1.761-1.76a.624.624 0 0 0-.883-.002l-.88.881a.622.622 0 0 0 0 .882l1.762 1.76-1.758 1.759a.622.622 0 0 0 0 .88l.88.882a.623.623 0 0 0 .882 0l1.757-1.758 1.77 1.771a.623.623 0 0 0 .883 0l.88-.88a.624.624 0 0 0 0-.882l-1.77-1.771zM9.967 0C4.462 0 0 4.462 0 9.967c0 5.505 4.462 9.967 9.967 9.967 5.505 0 9.967-4.462 9.967-9.967C19.934 4.463 15.472 0 9.967 0zm0 18.065a8.098 8.098 0 1 1 8.098-8.098 8.098 8.098 0 0 1-8.098 8.098z"></path>
                                            </svg>
                                            {{__('An error occurred. Please try again.')}}
                                        </p>
                                    </div>
                                </form>
                            </aside><!-- .widget-reservation -->
                            
                                
                            
                        </div><!-- .sidebar -->

                    </div>
                </div>
            </div>
        </div><!-- .place -->
    </main><!-- .site-main -->
@stop

@push('scripts')
    <script src="{{asset('assets/js/page_place_detail.js')}}"></script>
    @if(setting('map_service', 'google_map') === 'google_map')
        <script src="{{asset('assets/js/page_place_detail_googlemap.js')}}"></script>
    @else
        <script src="{{asset('assets/js/page_place_detail_mapbox.js')}}"></script>
    @endif
@endpush