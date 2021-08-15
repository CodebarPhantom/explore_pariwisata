@php
    if (setting('home_banner')) {
        $home_banner = getImageUrl(setting('home_banner'));
    } else {
        $home_banner = "/assets/images/home-bsn-banner.jpg";
    }

    $img_home_banner_app = getImageUrl(setting('home_banner_app'));
    if (setting('home_banner_app')) {
        $home_banner_app = "style=background-image:url({$img_home_banner_app})";
    } else {
        $home_banner_app = "style=background-image:url(/assets/images/banner-apps.jpg)";
    }
@endphp
@extends('frontend.layouts.template_03')
@section('main')
    <main id="main" class="site-main">
        <section class="banner-wrap">
            <div class="flex">
                <div class="banner-left"></div>
                <div class="banner slick-sliders">
                    <div class="banner-sliders slick-slider" data-item="1" data-arrows="false" data-dots="true">
                        <div class="item"><img src="{{$home_banner}}" alt="Banner"></div>
                    </div>
                </div><!-- .banner -->
            </div>
            <div class="container">
                <div class="banner-content">
                    <span>{{__('Drink, Food & Enjoy')}}</span>
                    <h1>{{__('Discover the best restaurant.')}}</h1>

                    <form action="{{route('page_search_listing')}}" class="site-banner__search layout-02">
                        <div class="field-input">
                            <label for="s">{{__('Find')}}</label>
                            <input type="text" class="site-banner__search__input open-suggestion" id="input_search" placeholder="{{__('Keywork...')}}"
                                   autocomplete="off">
                            <input type="hidden" name="category[]" id="category_id">
                            <div class="search-suggestions name-suggestions category-suggestion">
                                <ul>
                                    <li><a href="#"><span>{{__('Loading...')}}</span></a></li>
                                </ul>
                            </div>
                        </div><!-- .site-banner__search__input -->
                        <div class="field-input">
                            <label for="loca">{{__('Where')}}</label>
                            <input type="text" class="site-banner__search__input open-suggestion" id="location_search" placeholder="{{__('Location...')}}"
                                   name="location" autocomplete="off">
                            <input type="hidden" id="city_id">
                            <div class="search-suggestions location-suggestions location-suggestion">
                                <ul>
                                    <li><a href="#"><span>{{__('Loading...')}}</span></a></li>
                                </ul>
                            </div>
                        </div><!-- .site-banner__search__input -->
                        <div class="field-submit">
                            <button><i class="las la-search la-24-black"></i></button>
                        </div>
                    </form>

                </div>
            </div>
        </section><!-- .banner-wrap -->

        <section class="restaurant-wrap">
            <div class="container">
                <div class="title_home">
                    <h2>{{__('Popular Restaurants in Town')}}</h2>
                </div>
                <div class="restaurant-sliders slick-sliders">
                    <div class="restaurant-slider slick-slider" data-item="4" data-itemScroll="4" data-arrows="true" data-dots="true"
                         data-tabletItem="2" data-tabletScroll="2" data-mobileItem="1" data-mobileScroll="1">

                        @foreach($trending_places as $place)
                            <div class="place-item layout-02 place-hover">
                                <div class="place-inner">
                                    <div class="place-thumb hover-img">
                                        <a class="entry-thumb" href="{{route('place_detail', $place->slug)}}"><img
                                                src="{{getImageUrl($place->thumb)}}" alt="{{$place->name}}"></a>
                                        <a href="#"
                                           class="golo-add-to-wishlist btn-add-to-wishlist @if($place->wish_list_count) remove_wishlist active @else @guest open-login @else add_wishlist @endguest @endif"
                                           data-id="{{$place->id}}">
											<span class="icon-heart">
												<i class="la la-bookmark large"></i>
											</span>
                                        </a>
                                        @if(isset($place['categories'][0]))
                                        <a class="entry-category rosy-pink"
                                           href="{{route('page_search_listing', ['category[]' => $place['categories'][0]['id']])}}"
                                           style="background-color:{{$place['categories'][0]['color_code']}};">
                                            <img src="{{getImageUrl($place['categories'][0]['icon_map_marker'])}}"
                                                 alt="{{$place['categories'][0]['name']}}">
                                            <span>{{$place['categories'][0]['name']}}</span>
                                        </a>
                                        @endif
                                    </div>
                                    <div class="entry-detail">
                                        <div class="entry-head">
                                            <div class="place-type list-item">
                                                @foreach($place['place_types'] as $type)
                                                    <span>{{$type->name}}</span>
                                                @endforeach
                                            </div>
                                            <div class="place-city">
                                                <a href="{{route('page_search_listing', ['city[]' => $place['city']['id']])}}">{{$place['city']['name']}}</a>
                                            </div>
                                        </div>
                                        <h3 class="place-title"><a href="{{route('place_detail', $place->slug)}}">{{$place->name}}</a></h3>
                                        {{--                                        <div class="open-now"><i class="las la-door-open"></i>Open now</div>--}}
                                        <div class="entry-bottom">
                                            <div class="place-preview">
                                                <div class="place-rating">
                                                    @if($place->reviews_count)
                                                        {{number_format($place->avgReview, 1)}}
                                                        <i class="la la-star"></i>
                                                    @endif
                                                </div>
                                                <span class="count-reviews">({{$place->reviews_count}} {{__('reviews')}})</span>
                                            </div>
                                            <div class="place-price">
                                                <span>{{PRICE_RANGE[$place['price_range']]}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div><!-- .restaurant-slider -->
                    <div class="place-slider__nav slick-nav">
                        <div class="place-slider__prev slick-nav__prev">
                            <i class="las la-angle-left"></i>
                        </div><!-- .place-slider__prev -->
                        <div class="place-slider__next slick-nav__next">
                            <i class="las la-angle-right"></i>
                        </div><!-- .place-slider__next -->
                    </div><!-- .place-slider__nav -->
                </div><!-- .restaurant-sliders -->
            </div>
        </section><!-- .restaurant-wrap -->

        <section class="cuisine-wrap section-bg">
            <div class="container">
                <div class="title_home">
                    <h2>{{__('Search By Cuisine')}}</h2>
                    <p>{{__('Explore restaurants and cafes by your favorite cuisine')}}</p>
                </div>
                <div class="cuisine-sliders slick-sliders">
                    <div class="cuisine-slider slick-slider" data-item="6" data-itemScroll="6" data-arrows="true" data-dots="true"
                         data-smallpcItem="4" data-smallpcScroll="4" data-tabletItem="3" data-tabletScroll="3" data-mobileItem="2"
                         data-mobileScroll="2">

                        @foreach($categories as $cat)
                            <div class="item">
                                <a href="{{route('page_search_listing', ['category[]' => $cat->id])}}" title="{{$cat->name}}">
                                    <span class="hover-img"><img src="{{getImageUrl($cat->icon_map_marker)}}" alt="{{$cat->name}}"></span>
                                    <span class="title">{{$cat->name}}<span class="number">({{$cat->place_count}})</span></span>
                                </a>
                            </div>
                        @endforeach

                    </div><!-- .cuisine-slider -->
                    <div class="place-slider__nav slick-nav">
                        <div class="place-slider__prev slick-nav__prev">
                            <i class="las la-angle-left"></i>
                        </div><!-- .place-slider__prev -->
                        <div class="place-slider__next slick-nav__next">
                            <i class="las la-angle-right"></i>
                        </div><!-- .place-slider__next -->
                    </div><!-- .place-slider__nav -->
                </div><!-- .cuisine-sliders -->
            </div><!-- .container -->
        </section><!-- .cuisine-wrap -->

        <section class="featured-home featured-wrap">
            <div class="container">
                <div class="title_home">
                    <h2>{{__('Featured Cities')}}</h2>
                    <p>{{__('Explore restaurants & cafes by locality')}}</p>
                </div>
                <div class="featured-inner">
                    <div class="item">
                        <div class="flex">
                            <div class="flex-col">
                                @foreach($popular_cities as $index => $city)
                                    @if($index === 0)
                                        <div class="cities">
                                            <div class="cities-inner">
                                                <a href="{{route('page_search_listing', ['city[]' => $city->id])}}" class="hover-img">
                                                    <span class="entry-thumb"><img src="{{getImageUrl($city->thumb)}}" alt="{{$city->name}}"></span>
                                                    <span class="entry-details">
                                                    <h3>{{$city->name}}</h3>
                                                    <span>{{$city->places_count}} {{__('places')}}</span>
                                                </span>
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <div class="flex-col">
                                @foreach($popular_cities as $index => $city)
                                    @if(($index >= 1) && ($index <= 2))
                                        <div class="cities">
                                            <div class="cities-inner">
                                                <a href="{{route('page_search_listing', ['city[]' => $city->id])}}" class="hover-img">
                                                    <span class="entry-thumb"><img src="{{getImageUrl($city->thumb)}}" alt="{{$city->name}}"></span>
                                                    <span class="entry-details">
                                                    <h3>{{$city->name}}</h3>
                                                    <span>{{$city->places_count}} {{__('places')}}</span>
                                                </span>
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <div class="flex-col">
                                @foreach($popular_cities as $index => $city)
                                    @if(($index >= 3) && ($index <= 4))
                                        <div class="cities">
                                            <div class="cities-inner">
                                                <a href="{{route('page_search_listing', ['city[]' => $city->id])}}" class="hover-img">
                                                    <span class="entry-thumb"><img src="{{getImageUrl($city->thumb)}}" alt="{{$city->name}}"></span>
                                                    <span class="entry-details">
                                                    <h3>{{$city->name}}</h3>
                                                    <span>{{$city->places_count}} {{__('places')}}</span>
                                                </span>
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div><!-- .featured-inner -->
            </div><!-- .container -->
        </section><!-- .featured-wrap -->

        <section class="join-wrap" {!! $home_banner_app !!}>
            <div class="container">
                <div class="join-inner">
                    <h2>{{__('Restaurateurs Join Us')}}</h2>
                    <p>{{__('Join the more than 10,000 restaurants which fill seats and manage reservations with Golo.')}}</p>
                    <a href="#" class="btn" title="Learn More">{{__('Learn More')}}</a>
                </div>
            </div>
        </section><!-- .join-wrap -->

        <section class="home-testimonials testimonials">
            <div class="container">
                <div class="title_home">
                    <h2>{{__('People Talking About Us')}}</h2>
                </div>
                <div class="testimonial-sliders slick-sliders">
                    <div class="testimonial-slider slick-slider" data-item="2" data-itemScroll="2" data-arrows="true" data-dots="true"
                         data-tabletItem="1" data-tabletScroll="1" data-mobileItem="1" data-mobileScroll="1">
                        @foreach($testimonials as $item)
                            <div class="item">
                                <div class="testimonial-item flex">
                                    <div class="testimonial-thumb">
                                        <img class="ava" src="{{getImageUrl($item->avatar)}}" alt="Avatar">
                                        <img src="{{asset('assets/images/quote-active.png')}}" alt="Quote" class="quote">
                                    </div>
                                    <div class="testimonial-info">
                                        <p>{{$item->content}}</p>
                                        <div class="cite">
                                            <h4>{{$item->name}}</h4>
                                            <span>{{$item->job_title}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div><!-- .testimonial-slider -->
                    <div class="place-slider__nav slick-nav">
                        <div class="place-slider__prev slick-nav__prev">
                            <i class="las la-angle-left"></i>
                        </div><!-- .place-slider__prev -->
                        <div class="place-slider__next slick-nav__next">
                            <i class="las la-angle-right"></i>
                        </div><!-- .place-slider__next -->
                    </div><!-- .place-slider__nav -->
                </div><!-- .testimonial-sliders -->
            </div>
        </section><!-- .testimonials -->

        <section class="blogs-wrap section-bg">
            <div class="container">
                <div class="title_home">
                    <h2>From Our Blog</h2>
                </div>
                <div class="blog-wrap">
                    <div class="row">
                        @foreach($blog_posts as $post)
                            <div class="col-md-4">
                                <article class="post hover__box">
                                    <div class="post__thumb hover__box__thumb">
                                        <a title="{{$post->title}}" href="{{route('post_detail', [$post->slug, $post->id])}}"><img
                                                src="{{getImageUrl($post->thumb)}}" alt="{{$post->title}}"></a>
                                    </div>
                                    <div class="post__info">
                                        <ul class="post__category">
                                            @foreach($post['categories'] as $cat)
                                                <li><a title="{{$cat->name}}" href="{{route('post_list', $cat->slug)}}">{{$cat->name}}</a></li>
                                            @endforeach
                                        </ul>
                                        <h3 class="post__title"><a title="{{$post->title}}"
                                                                   href="{{route('post_detail', [$post->slug, $post->id])}}">{{$post->title}}</a></h3>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>
                    <div class="button-wrap">
                        <a href="{{route('post_list_all')}}" class="btn" title="View more">View more</a>
                    </div>
                </div>
            </div>
        </section><!-- .blogs-wrap -->
    </main><!-- .site-main -->
@endsection
