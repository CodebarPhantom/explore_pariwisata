@extends('frontend.layouts.template_03')
@section('main')
    <main id="main" class="site-main single single-02">
        <div class="place">
            <div class="single-slider slick-sliders">
                <div class="slick-slider photoswipe" data-item="1" data-arrows="true" data-itemscroll="1" data-dots="true" data-infinite="true"
                     data-centermode="true" data-centerpadding="418px" data-tabletitem="1" data-tabletscroll="1" data-tabletpadding="70px"
                     data-mobileitem="1" data-mobilescroll="1" data-mobilepadding="30px">

                    @if(isset($place->gallery))
                        @foreach($place->gallery as $gallery)
                            <div class="place-slider__item bd photoswipe-item">
                                <a href="{{getImageUrl($gallery)}}" data-height="900" data-width="1200" data-caption="{{$gallery}}"><img src="{{getImageUrl($gallery)}}" alt="{{$gallery}}"></a>
                            </div>
                        @endforeach
                    @else
                        <div class="place-slider__item bd">
                            <a href="#"><img src="https://via.placeholder.com/1280x500?text=GOLO" alt="slider no image"></a>
                        </div>
                    @endif

                </div><!-- .page-title -->
                <div class="place-share">
                    <a title="Save" href="#"
                       class="add-wishlist @if($place->wish_list_count) remove_wishlist active @else @guest open-login @else add_wishlist @endguest @endif"
                       data-id="{{$place->id}}">
                        <i class="la la-bookmark large"></i>
                    </a>
                    <a title="Share" href="#" class="share">
                        <i class="la la-share-square la-24"></i>
                    </a>
                    <div class="social-share">
                        <div class="list-social-icon">
                            <a class="facebook"
                               onclick="window.open('https://www.facebook.com/sharer.php?u=https%3A%2F%2Fwp.getgolo.com%2Fplace%2Fthe-louvre%2F','sharer', 'toolbar=0,status=0');"
                               href="javascript:void(0)"> <i class="fab fa-facebook-f"></i> </a>
                            <a class="twitter"
                               onclick="popUp=window.open('https://twitter.com/share?url=https%3A%2F%2Fwp.getgolo.com%2Fplace%2Fthe-louvre%2F','sharer','scrollbars=yes');popUp.focus();return false;"
                               href="javascript:void(0)"> <i class="fab fa-twitter"></i> </a>
                            <a class="linkedin"
                               onclick="popUp=window.open('http://linkedin.com/shareArticle?mini=true&amp;url=https%3A%2F%2Fwp.getgolo.com%2Fplace%2Fthe-louvre%2F&amp;title=The+Louvre','sharer','scrollbars=yes');popUp.focus();return false;"
                               href="javascript:void(0)"> <i class="fab fa-linkedin-in"></i> </a>
                            <a class="pinterest"
                               onclick="popUp=window.open('http://pinterest.com/pin/create/button/?url=https%3A%2F%2Fwp.getgolo.com%2Fplace%2Fthe-louvre%2F&amp;description=The+Louvre&amp;media=https://wp.getgolo.com/wp-content/uploads/2019/10/ef3cc68f-2e02-41cc-aad6-4b301a655555.jpg','sharer','scrollbars=yes,width=800,height=400');popUp.focus();return false;"
                               href="javascript:void(0)"> <i class="fab fa-pinterest-p"></i> </a>
                        </div>
                    </div>
                </div><!-- .place-share -->
                <div class="place-slider__nav slick-nav">
                    <div class="place-slider__prev slick-nav__prev">
                        <i class="las la-angle-left"></i>
                    </div><!-- .place-slider__prev -->
                    <div class="place-slider__next slick-nav__next">
                        <i class="las la-angle-right"></i>
                    </div><!-- .place-slider__next -->
                </div><!-- .place-slider__nav -->
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
                                <li><a title="{{$city->name}}" href="{{route('page_search_listing', ['city[]' => $city->id])}}">{{$city->name}}</a>
                                </li>
                                @foreach($categories as $cat)
                                    <li><a href="{{route('page_search_listing', ['category[]' => $cat->id])}}"
                                           title="{{$cat->name}}">{{$cat->name}}</a></li>
                                @endforeach
                            </ul><!-- .place__breadcrumbs -->

                            <div class="place__box place__box--npd">
                                <h1>{{$place->name}}</h1>
                                <div class="place__meta">
                                    <div class="place__reviews reviews">
											<span class="place__reviews__number reviews__number">
												{{$review_score_avg}}
												<i class="la la-star"></i>
											</span>
                                        <span class="place__places-item__count reviews_count">({{count($reviews)}} reviews)</span>
                                    </div>
                                    <div class="place__currency">{{PRICE_RANGE[$place->price_range]}}</div>
                                    @if(isset($place_types))
                                        <div class="place__category">
                                            @foreach($place_types as $type)
                                                <a title="{{$type->name}}"
                                                   href="{{route('page_search_listing', ['amenities[]' => $type->id])}}">{{$type->name}}</a>
                                            @endforeach
                                        </div>
                                    @endif
                                </div><!-- .place__meta -->
                            </div><!-- .place__box -->

                            @if(isset($amenities))
                                <div class="place__box place__box-hightlight">
                                    <div class="hightlight-grid">
                                        @foreach($amenities as $key => $item)
                                            @if($key < 4)
                                                <div class="place__amenities">
                                                    <img src="{{getImageUrl($item->icon)}}" alt="{{$item->name}}">
                                                    <span>{{$item->name}}</span>
                                                </div>
                                            @endif
                                        @endforeach
                                        @if(count($amenities) > 4)
                                            <a class="open-popup" href="#show-amenities"><span
                                                        class="hightlight-count">+({{count($amenities) - 4}})</span></a>
                                        @endif
                                        <div class="popup-wrap" id="show-amenities">
                                            <div class="popup-bg popupbg-close"></div>
                                            <div class="popup-middle">
                                                <a title="Close" href="#" class="popup-close">
                                                    <i class="la la-times la-24"></i>
                                                </a><!-- .popup-close -->
                                                <h3>{{__('Amenities')}}</h3>
                                                <div class="popup-content">
                                                    <div class="hightlight-flex">
                                                        @foreach($amenities as $key => $item)
                                                            <div class="place__amenities">
                                                                <img src="{{getImageUrl($item->icon)}}" alt="{{$item->name}}">
                                                                <span>{{$item->name}}</span>
                                                            </div>
                                                        @endforeach
                                                    </div><!-- .hightlight-flex -->
                                                </div><!-- .popup-content -->
                                            </div><!-- .popup-middle -->
                                        </div><!-- .popup-wrap -->
                                    </div>
                                </div><!-- .place__box -->
                            @endif

                            <div class="place__box place__box-overview">
                                <h3>{{__('Overview')}}</h3>
                                <div class="place__desc">
                                    @php
                                        echo $place->description;
                                    @endphp
                                </div><!-- .place__desc -->
                                <a href="#" class="show-more" title="{{__('Show more')}}">{{__('Show more')}}</a>
                            </div>

                            <div class="place__box place__box-map">
                                <h3 class="place__title--additional">
                                    Menu
                                </h3>
                                <div class="menu-tab">
                                    <div class="menu-wrap active" id="diner">
                                        <div class="flex">
                                            @foreach($place->menu as $menu)
                                                <div class="menu-item">
                                                    <img src="{{$menu['thumb']}}" alt="Calamari Fritti">
                                                    <div class="menu-info">
                                                        <h4>{{$menu['name']}}</h4>
                                                        <p>{{$menu['description']}}</p>
                                                        <span class="price">{{$menu['price']}}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <a href="#" class="menu-more">Show more</a>
                                    </div>
                                </div>
                            </div><!-- .place__box -->

                            @if(isset($place['faq']))
                                <div class="place__box">
                                    <h3>FAQ's</h3>
                                    <ul class="faqs-accordion">
                                        @foreach($place['faq'] as $faq)
                                            <li>
                                                <h4>{{$faq['question']}}</h4>
                                                <div class="desc">
                                                    <p>{{$faq['answer']}}</p>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div><!-- .place__box -->
                            @endif

                            @if(isset($place['video']))
                                <div class="place__box">
                                    <h3>Videos</h3>
                                    <iframe width="100%" height="400" src="https://www.youtube.com/embed/{{getYoutubeId($place['video'])}}" frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                </div><!-- .place__box -->
                            @endif

                            <div class="place__box place__box--reviews">
                                <h3 class="place__title--reviews">
                                    {{__('Review')}} ({{count($reviews)}})
                                    @if(isset($reviews))
                                        <span class="place__reviews__number"> {{$review_score_avg}}
                                            <i class="la la-star"></i>
                                        </span>
                                    @endif
                                </h3>

                                <ul class="place__comments">
                                    @foreach($reviews as $review)
                                        <li>
                                            <div class="place__author">
                                                <div class="place__author__avatar">
                                                    <a title="Nitithorn" href="#"><img src="{{getUserAvatar($review['user']['avatar'])}}" alt=""></a>
                                                </div>
                                                <div class="place__author__info">
                                                    <h4>
                                                        <a title="Nitithorn" href="#">{{$review['user']['name']}}</a>
                                                        <div class="place__author__star">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12">
                                                                <path fill="#DDD" fill-rule="evenodd"
                                                                      d="M6.12.455l1.487 3.519 3.807.327a.3.3 0 0 1 .17.525L8.699 7.328l.865 3.721a.3.3 0 0 1-.447.325L5.845 9.4l-3.272 1.973a.3.3 0 0 1-.447-.325l.866-3.721L.104 4.826a.3.3 0 0 1 .17-.526l3.807-.327L5.568.455a.3.3 0 0 1 .553 0z"/>
                                                            </svg>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12">
                                                                <path fill="#DDD" fill-rule="evenodd"
                                                                      d="M6.12.455l1.487 3.519 3.807.327a.3.3 0 0 1 .17.525L8.699 7.328l.865 3.721a.3.3 0 0 1-.447.325L5.845 9.4l-3.272 1.973a.3.3 0 0 1-.447-.325l.866-3.721L.104 4.826a.3.3 0 0 1 .17-.526l3.807-.327L5.568.455a.3.3 0 0 1 .553 0z"/>
                                                            </svg>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12">
                                                                <path fill="#DDD" fill-rule="evenodd"
                                                                      d="M6.12.455l1.487 3.519 3.807.327a.3.3 0 0 1 .17.525L8.699 7.328l.865 3.721a.3.3 0 0 1-.447.325L5.845 9.4l-3.272 1.973a.3.3 0 0 1-.447-.325l.866-3.721L.104 4.826a.3.3 0 0 1 .17-.526l3.807-.327L5.568.455a.3.3 0 0 1 .553 0z"/>
                                                            </svg>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12">
                                                                <path fill="#DDD" fill-rule="evenodd"
                                                                      d="M6.12.455l1.487 3.519 3.807.327a.3.3 0 0 1 .17.525L8.699 7.328l.865 3.721a.3.3 0 0 1-.447.325L5.845 9.4l-3.272 1.973a.3.3 0 0 1-.447-.325l.866-3.721L.104 4.826a.3.3 0 0 1 .17-.526l3.807-.327L5.568.455a.3.3 0 0 1 .553 0z"/>
                                                            </svg>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12">
                                                                <path fill="#DDD" fill-rule="evenodd"
                                                                      d="M6.12.455l1.487 3.519 3.807.327a.3.3 0 0 1 .17.525L8.699 7.328l.865 3.721a.3.3 0 0 1-.447.325L5.845 9.4l-3.272 1.973a.3.3 0 0 1-.447-.325l.866-3.721L.104 4.826a.3.3 0 0 1 .17-.526l3.807-.327L5.568.455a.3.3 0 0 1 .553 0z"/>
                                                            </svg>
                                                            @php
                                                                $width = $review->score * 20;
                                                                $review_width = "style='width:{$width}%'";
                                                            @endphp
                                                            <span {!! $review_width !!}>
																<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12">
																    <path fill="#23D3D3" fill-rule="evenodd"
                                                                          d="M6.12.455l1.487 3.519 3.807.327a.3.3 0 0 1 .17.525L8.699 7.328l.865 3.721a.3.3 0 0 1-.447.325L5.845 9.4l-3.272 1.973a.3.3 0 0 1-.447-.325l.866-3.721L.104 4.826a.3.3 0 0 1 .17-.526l3.807-.327L5.568.455a.3.3 0 0 1 .553 0z"/>
																</svg>
																<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12">
																    <path fill="#23D3D3" fill-rule="evenodd"
                                                                          d="M6.12.455l1.487 3.519 3.807.327a.3.3 0 0 1 .17.525L8.699 7.328l.865 3.721a.3.3 0 0 1-.447.325L5.845 9.4l-3.272 1.973a.3.3 0 0 1-.447-.325l.866-3.721L.104 4.826a.3.3 0 0 1 .17-.526l3.807-.327L5.568.455a.3.3 0 0 1 .553 0z"/>
																</svg>
																<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12">
																    <path fill="#23D3D3" fill-rule="evenodd"
                                                                          d="M6.12.455l1.487 3.519 3.807.327a.3.3 0 0 1 .17.525L8.699 7.328l.865 3.721a.3.3 0 0 1-.447.325L5.845 9.4l-3.272 1.973a.3.3 0 0 1-.447-.325l.866-3.721L.104 4.826a.3.3 0 0 1 .17-.526l3.807-.327L5.568.455a.3.3 0 0 1 .553 0z"/>
																</svg>
																<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12">
																    <path fill="#23D3D3" fill-rule="evenodd"
                                                                          d="M6.12.455l1.487 3.519 3.807.327a.3.3 0 0 1 .17.525L8.699 7.328l.865 3.721a.3.3 0 0 1-.447.325L5.845 9.4l-3.272 1.973a.3.3 0 0 1-.447-.325l.866-3.721L.104 4.826a.3.3 0 0 1 .17-.526l3.807-.327L5.568.455a.3.3 0 0 1 .553 0z"/>
																</svg>
																<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12">
																    <path fill="#23D3D3" fill-rule="evenodd"
                                                                          d="M6.12.455l1.487 3.519 3.807.327a.3.3 0 0 1 .17.525L8.699 7.328l.865 3.721a.3.3 0 0 1-.447.325L5.845 9.4l-3.272 1.973a.3.3 0 0 1-.447-.325l.866-3.721L.104 4.826a.3.3 0 0 1 .17-.526l3.807-.327L5.568.455a.3.3 0 0 1 .553 0z"/>
																</svg>
															</span>
                                                        </div>
                                                    </h4>
                                                    <time>{{formatDate($review->created_at, 'd/m/Y')}}</time>
                                                </div>
                                            </div>
                                            <div class="place__comments__content">
                                                <p>{{$review->comment}}</p>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>

                                @guest
                                    <div class="login-for-review account logged-out">
                                        <a href="#" class="btn-login open-login">{{__('Login')}}</a>
                                        <span>{{__('to review')}}</span>
                                    </div>
                                @else
                                    <div class="review-form">
                                        <h3>{{__('Write a review')}}</h3>
                                        <form id="submit_review">
                                            @csrf
                                            <div class="rate">
                                                <span>{{__('Rate This Place')}}</span>
                                                <div class="stars">
                                                    <a href="#" class="star-item" data-value="1" title="star-1">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12">
                                                            <path fill="#DDD" fill-rule="evenodd"
                                                                  d="M6.12.455l1.487 3.519 3.807.327a.3.3 0 0 1 .17.525L8.699 7.328l.865 3.721a.3.3 0 0 1-.447.325L5.845 9.4l-3.272 1.973a.3.3 0 0 1-.447-.325l.866-3.721L.104 4.826a.3.3 0 0 1 .17-.526l3.807-.327L5.568.455a.3.3 0 0 1 .553 0z"/>
                                                        </svg>
                                                    </a>
                                                    <a href="#" class="star-item" data-value="2" title="star-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12">
                                                            <path fill="#DDD" fill-rule="evenodd"
                                                                  d="M6.12.455l1.487 3.519 3.807.327a.3.3 0 0 1 .17.525L8.699 7.328l.865 3.721a.3.3 0 0 1-.447.325L5.845 9.4l-3.272 1.973a.3.3 0 0 1-.447-.325l.866-3.721L.104 4.826a.3.3 0 0 1 .17-.526l3.807-.327L5.568.455a.3.3 0 0 1 .553 0z"/>
                                                        </svg>
                                                    </a>
                                                    <a href="#" class="star-item" data-value="3" title="star-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12">
                                                            <path fill="#DDD" fill-rule="evenodd"
                                                                  d="M6.12.455l1.487 3.519 3.807.327a.3.3 0 0 1 .17.525L8.699 7.328l.865 3.721a.3.3 0 0 1-.447.325L5.845 9.4l-3.272 1.973a.3.3 0 0 1-.447-.325l.866-3.721L.104 4.826a.3.3 0 0 1 .17-.526l3.807-.327L5.568.455a.3.3 0 0 1 .553 0z"/>
                                                        </svg>
                                                    </a>
                                                    <a href="#" class="star-item" data-value="4" title="star-4">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12">
                                                            <path fill="#DDD" fill-rule="evenodd"
                                                                  d="M6.12.455l1.487 3.519 3.807.327a.3.3 0 0 1 .17.525L8.699 7.328l.865 3.721a.3.3 0 0 1-.447.325L5.845 9.4l-3.272 1.973a.3.3 0 0 1-.447-.325l.866-3.721L.104 4.826a.3.3 0 0 1 .17-.526l3.807-.327L5.568.455a.3.3 0 0 1 .553 0z"/>
                                                        </svg>
                                                    </a>
                                                    <a href="#" class="star-item" data-value="5" title="star-5">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12">
                                                            <path fill="#DDD" fill-rule="evenodd"
                                                                  d="M6.12.455l1.487 3.519 3.807.327a.3.3 0 0 1 .17.525L8.699 7.328l.865 3.721a.3.3 0 0 1-.447.325L5.845 9.4l-3.272 1.973a.3.3 0 0 1-.447-.325l.866-3.721L.104 4.826a.3.3 0 0 1 .17-.526l3.807-.327L5.568.455a.3.3 0 0 1 .553 0z"/>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="field-textarea">
                                                <img class="author-avatar" src="{{getUserAvatar(user()->avatar)}}" alt="">
                                                <textarea name="comment" placeholder="Write a review"></textarea>
                                            </div>
                                            <div class="field-submit">
                                                <small class="form-text text-danger" id="review_error">error!</small>
                                                <input type="hidden" name="score" value="">
                                                <input type="hidden" name="place_id" value="{{$place->id}}">
                                                <button type="submit" class="btn" id="btn_submit_review">{{__('Submit')}}</button>
                                            </div>
                                        </form>
                                    </div>
                                @endguest

                            </div><!-- .place__box -->

                        </div><!-- .place__left -->
                    </div>

                    <div class="col-lg-4">
                        @if($place->booking_type === \App\Models\Booking::TYPE_AFFILIATE)
                            <div class="sidebar sidebar--shop sidebar--border">
                                <aside class="widget widget-shadow widget-booking">
                                    <h3>{{__('Booking online')}}</h3>
                                    <a href="{{$place->link_bookingcom}}" class="btn" target="_blank" rel="nofollow">{{__('Book now')}}</a>
                                    <p class="note">{{__('By Booking.com')}}</p>
                                </aside><!-- .widget -->
                            </div>
                        @elseif($place->booking_type === \App\Models\Booking::TYPE_BOOKING_FORM)
                            <div class="sidebar sidebar--shop sidebar--border">
                                <aside class="widget widget-shadow widget-reservation">
                                    <h3>{{__('Make a reservation')}}</h3>
                                    <form action="#" method="POST" class="form-underline" id="booking_form">
                                        @csrf
                                        <div class="field-select has-sub field-guest">
                                            <span class="sl-icon"><i class="la la-user-friends"></i></span>
                                            <input type="text" placeholder="Guest *" readonly>
                                            <i class="la la-angle-down"></i>
                                            <div class="field-sub">
                                                <ul>
                                                    <li>
                                                        <span>{{__('Adults')}}</span>
                                                        <div class="shop-details__quantity">
                                                        <span class="minus">
                                                            <i class="la la-minus"></i>
                                                        </span>
                                                            <input type="number" name="numbber_of_adult" value="0" class="qty number_adults">
                                                            <span class="plus">
                                                            <i class="la la-plus"></i>
                                                        </span>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <span>{{__('Childrens')}}</span>
                                                        <div class="shop-details__quantity">
                                                        <span class="minus">
                                                            <i class="la la-minus"></i>
                                                        </span>
                                                            <input type="number" name="numbber_of_children" value="0" class="qty number_childrens">
                                                            <span class="plus">
                                                            <i class="la la-plus"></i>
                                                        </span>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="field-select field-date">
                                            <span class="sl-icon"><i class="la la-calendar-alt"></i></span>
                                            <input type="text" name="date" placeholder="Date *" class="datepicker" autocomplete="off">
                                            <i class="la la-angle-down"></i>
                                        </div>
                                        <div class="field-select has-sub field-time">
                                            <span class="sl-icon"><i class="la la-clock"></i></span>
                                            <input type="text" name="time" placeholder="Time" readonly>
                                            <i class="la la-angle-down"></i>
                                            <div class="field-sub">
                                                <ul>
                                                    <li><a href="#">12:00 AM</a></li>
                                                    <li><a href="#">12:30 AM</a></li>
                                                    <li><a href="#">1:00 AM</a></li>
                                                    <li><a href="#">1:30 AM</a></li>
                                                    <li><a href="#">2:00 AM</a></li>
                                                    <li><a href="#">2:30 AM</a></li>
                                                    <li><a href="#">3:00 AM</a></li>
                                                    <li><a href="#">3:30 AM</a></li>
                                                    <li><a href="#">4:00 AM</a></li>
                                                    <li><a href="#">4:30 AM</a></li>
                                                    <li><a href="#">5:00 AM</a></li>
                                                    <li><a href="#">5:30 AM</a></li>
                                                    <li><a href="#">6:00 AM</a></li>
                                                    <li><a href="#">6:30 AM</a></li>
                                                    <li><a href="#">7:00 AM</a></li>
                                                    <li><a href="#">7:30 AM</a></li>
                                                    <li><a href="#">8:00 AM</a></li>
                                                    <li><a href="#">8:30 AM</a></li>
                                                    <li><a href="#">9:00 AM</a></li>
                                                    <li><a href="#">9:30 AM</a></li>
                                                    <li><a href="#">10:00 AM</a></li>
                                                    <li><a href="#">10:30 AM</a></li>
                                                    <li><a href="#">11:00 AM</a></li>
                                                    <li><a href="#">11:30 AM</a></li>
                                                    <li><a href="#">12:00 PM</a></li>
                                                    <li><a href="#">12:30 PM</a></li>
                                                    <li><a href="#">1:00 PM</a></li>
                                                    <li><a href="#">1:30 PM</a></li>
                                                    <li><a href="#">2:00 PM</a></li>
                                                    <li><a href="#">2:30 PM</a></li>
                                                    <li><a href="#">3:00 PM</a></li>
                                                    <li><a href="#">3:30 PM</a></li>
                                                    <li><a href="#">4:00 PM</a></li>
                                                    <li><a href="#">4:30 PM</a></li>
                                                    <li><a href="#">5:00 PM</a></li>
                                                    <li><a href="#">5:30 PM</a></li>
                                                    <li><a href="#">6:00 PM</a></li>
                                                    <li><a href="#">6:30 PM</a></li>
                                                    <li><a href="#">7:00 PM</a></li>
                                                    <li><a href="#">7:30 PM</a></li>
                                                    <li><a href="#">8:00 PM</a></li>
                                                    <li><a href="#">8:30 PM</a></li>
                                                    <li><a href="#">9:00 PM</a></li>
                                                    <li><a href="#">9:30 PM</a></li>
                                                    <li><a href="#">10:00 PM</a></li>
                                                    <li><a href="#">10:30 PM</a></li>
                                                    <li><a href="#">11:00 PM</a></li>
                                                    <li><a href="#">11:30 PM</a></li>
                                                </ul>
                                            </div>
                                        </div>

                                        <input type="hidden" name="type" value="{{\App\Models\Booking::TYPE_BOOKING_FORM}}">
                                        <input type="hidden" name="place_id" value="{{$place->id}}">
                                        @guest()
                                            <button class="btn btn-login open-login">{{__('Send')}}</button>
                                        @else
                                            <button class="btn booking_submit_btn">{{__('Send')}}</button>
                                        @endguest
                                        <p class="note">{{__("You won't be charged yet")}}</p>

                                        <div class="alert alert-success alert_booking booking_success">
                                            <p>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                                                    <path fill="#20D706" fill-rule="nonzero"
                                                          d="M9.967 0C4.462 0 0 4.463 0 9.967c0 5.505 4.462 9.967 9.967 9.967 5.505 0 9.967-4.462 9.967-9.967C19.934 4.463 15.472 0 9.967 0zm0 18.065a8.098 8.098 0 1 1 0-16.196 8.098 8.098 0 0 1 8.098 8.098 8.098 8.098 0 0 1-8.098 8.098zm3.917-12.338a.868.868 0 0 0-1.208.337l-3.342 6.003-1.862-2.266c-.337-.388-.784-.589-1.207-.336-.424.253-.6.863-.325 1.255l2.59 3.152c.194.252.415.403.646.446l.002.003.024.002c.052.008.835.152 1.172-.45l3.836-6.891a.939.939 0 0 0-.326-1.255z"></path>
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
                            </div>
                        @elseif($place->booking_type === \App\Models\Booking::TYPE_CONTACT_FORM)
                            <div class="sidebar sidebar--shop sidebar--border">
                                <aside class="widget widget-shadow widget-booking-form">
                                    <h3>{{__('Send me a message')}}</h3>
                                    <form class="form-underline" id="booking_submit_form" action="" method="post">
                                        @csrf
                                        <div class="field-input">
                                            <input type="text" id="name" name="name" placeholder="Enter your name *" required>
                                        </div>
                                        <div class="field-input">
                                            <input type="text" id="email" name="email" placeholder="Enter your email *" required>
                                        </div>
                                        <div class="field-input">
                                            <input type="text" id="phone_number" name="phone_number" placeholder="Enter your phone">
                                        </div>
                                        <div class="field-input">
                                            <textarea type="text" id="message" name="message" placeholder="Enter your message"></textarea>
                                        </div>
                                        <input type="hidden" name="type" value="{{\App\Models\Booking::TYPE_CONTACT_FORM}}">
                                        <input type="hidden" name="place_id" value="{{$place->id}}">
                                        <button class="btn booking_submit_btn">{{__('Send')}}</button>

                                        <div class="alert alert-success alert_booking booking_success">
                                            <p>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                                                    <path fill="#20D706" fill-rule="nonzero"
                                                          d="M9.967 0C4.462 0 0 4.463 0 9.967c0 5.505 4.462 9.967 9.967 9.967 5.505 0 9.967-4.462 9.967-9.967C19.934 4.463 15.472 0 9.967 0zm0 18.065a8.098 8.098 0 1 1 0-16.196 8.098 8.098 0 0 1 8.098 8.098 8.098 8.098 0 0 1-8.098 8.098zm3.917-12.338a.868.868 0 0 0-1.208.337l-3.342 6.003-1.862-2.266c-.337-.388-.784-.589-1.207-.336-.424.253-.6.863-.325 1.255l2.59 3.152c.194.252.415.403.646.446l.002.003.024.002c.052.008.835.152 1.172-.45l3.836-6.891a.939.939 0 0 0-.326-1.255z"></path>
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
                            </div>
                        @elseif($place->booking_type === \App\Models\Booking::TYPE_MAP)
                            <div class="sidebar sidebar-shadow sidebar-sticky">
                                <aside class="widget widget-sb-detail">
                                    @php
                                        $have_opening_hour = false;
                                        foreach ($place->opening_hour as $opening):
                                            if ($opening['title'] && $opening['value']):
                                            $have_opening_hour = true;
                                            endif;
                                        endforeach
                                    @endphp
                                    @if($have_opening_hour)
                                        <div class="widget-top">
                                            <div class="flex">
                                                <div class="store-detail">
                                                    {{--                                                    <span class="open">Open Now</span>--}}
                                                    <div class="toggle-select">
                                                        <div class="toggle-show">
                                                            <span>Openning</span>Hours
                                                            <i class="las la-angle-down"></i>
                                                        </div>
                                                        <div class="toggle-list">
                                                            <ul>
                                                                @foreach($place->opening_hour as $opening)
                                                                    @if($opening['title'] && $opening['value'])
                                                                        <li><span>{{$opening['title']}}</span>{{$opening['value']}}</li>
                                                                    @endif
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="map-detail">
                                        <div id="golo-place-map" style="height: 170px;"></div>
                                        <input type="hidden" id="place_lat" value="{{$place->lat}}">
                                        <input type="hidden" id="place_lng" value="{{$place->lng}}">
                                        <input type="hidden" id="place_icon_marker" value="{{asset('assets/images/icon-mapker.svg')}}">
                                        <a href="https://maps.google.com/?q={{$place->address}}" class="direction btn" target="_blank">Get Direction<i class="las la-external-link-alt"></i></a>
                                    </div>
                                    <div class="business-info">
                                        <h4>Business Info</h4>
                                        <ul>
                                            @if($place->address)
                                                <li><i class="las la-map-marked-alt large"></i> <a href="https://maps.google.com/?q={{$place->address}}" target="_blank">{{$place->address}}</a>
                                                </li>
                                            @endif
                                            @if($place->email)
                                                <li><i class="las la-envelope"></i><a href="mailto:{{$place->email}}">{{$place->email}}</a></li>
                                            @endif
                                            @if($place->phone_number)
                                                <li><i class="la la-phone large"></i> <a
                                                            href="tel:{{$place->phone_number}}">{{$place->phone_number}}</a>
                                                </li>
                                            @endif
                                            @if($place->website)
                                                <li><i class="la la-globe large"></i> <a href="//{{$place->website}}"
                                                                                         target="_blank">{{$place->website}}</a></li>
                                            @endif
                                            @foreach($place->social as $social)
                                                @if($social['name'] && $social['url'])
                                                    <li><i class="{{SOCIAL_LIST[$social['name']]['icon']}}"></i><a
                                                                href="{{SOCIAL_LIST[$social['name']]['base_url'] . $social['url']}}"
                                                                target="_blank">{{$social['url']}}</a></li>
                                                @endif
                                            @endforeach
                                        </ul>
                                        <div class="button-wrap">
                                            <div class="button"><a href="tel:{{$place->phone_number}}" class="btn">Call Us</a></div>
                                        </div>
                                    </div>
                                </aside><!-- .widget-reservation -->
                            </div>
                        @else
                            <div class="sidebar sidebar--shop sidebar--border">
                                <aside class="sidebar--shop__item widget widget--ads">
                                    @if(setting('ads_sidebar_banner_image'))
                                        <a title="Ads" href="{{setting('ads_sidebar_banner_link')}}" target="_blank" rel="nofollow"><img
                                                    src="{{asset('uploads/' . setting('ads_sidebar_banner_image'))}}" alt="banner ads golo"></a>
                                    @endif
                                </aside>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div><!-- .place -->

        <div class="similar-places">
            <div class="container">
                <h2 class="similar-places__title title">{{__('Similar places')}}</h2>
                <div class="similar-places__content">
                    <div class="row">
                        @foreach($similar_places as $place)
                            <div class="col-lg-3 col-md-6">
                                @include('frontend.common.place_item')
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div><!-- .similar-places -->
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
