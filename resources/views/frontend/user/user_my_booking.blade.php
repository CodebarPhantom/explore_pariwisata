@extends('frontend.layouts.template')
@section('main')
<style>
    .modal-content{
        position: relative;
        display: flex;
        flex-direction: column;
        margin-top: 50%;
    }
    .btn-primary{
        background-color: #23d3d3;
        border-color: #23d3d3;
    }

    #cover-spin {
        position:fixed;
        width:100%;
        left:0;right:0;top:0;bottom:0;
        background-color: rgba(255,255,255,0.7);
        z-index:9999;
        display:none;
    }

    @-webkit-keyframes spin {
        from {-webkit-transform:rotate(0deg);}
        to {-webkit-transform:rotate(360deg);}
    }

    @keyframes spin {
        from {transform:rotate(0deg);}
        to {transform:rotate(360deg);}
    }

    #cover-spin::after {
        content:'';
        display:block;
        position:absolute;
        left:48%;top:40%;
        width:40px;height:40px;
        border-style:solid;
        border-color:black;
        border-top-color:transparent;
        border-width: 4px;
        border-radius:50%;
        -webkit-animation: spin .8s linear infinite;
        animation: spin .8s linear infinite;
    }
</style>
    <main id="main" class="site-main">
        <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">              
                <div class="modal-body">
                  <img src="" class="imagepreview" style="width: 100%;" >
                  <div class="text-center" style="padding-top:25px; font-size: 150%;">
                      <strong class="qrcodeunique"></strong>
                  </div>
                </div>
              </div>
            </div>
        </div>
        <div id="cover-spin"></div>
        <div class="site-content">
            <div class="member-menu">
                <div class="container">
                    @include('frontend.user.user_menu')
                </div>
            </div>
            <div class="container">
                <div class="member-place-wrap">
                    <div class="member-place-top flex-inline">
                        <h1>{{__('Place')}}</h1>
                    </div><!-- .member-place-top -->
                    @include('frontend.common.box-alert')
                    <div class="member-filter">
                        <div class="mf-left">
                            <form id="my_booking_filter" action="" method="GET">
                                
                                
                            </form>
                        </div><!-- .mf-left -->
                        <div class="mf-right">
                            <form action="" class="site__search__form" method="GET">
                                <div class="site__search__field">
										<span class="site__search__icon">
											<i class="la la-search"></i>
										</span><!-- .site__search__icon -->
                                    <input class="site__search__input" type="text" name="keyword" value="" placeholder="{{__('Search')}}">
                                </div><!-- .search__input -->
                            </form><!-- .search__form -->
                        </div><!-- .mf-right -->
                    </div><!-- .member-filter -->
                    <table class="member-place-list table-responsive">
                        <thead>
                        <tr>
                            <th></th>
                            <th  style="width:15%;">{{__('QR Code')}}</th>
                            <th  style="width:15%;">{{__('Wisata')}}</th>
                            <th  style="width:15%;">{{__('Jumlah Tiket')}}</th>
                            <th  style="width:15%;">{{__('Status')}}</th>
                            <th>{{__('Grand Total')}}</th>
                            <th>{{__('Code')}}</th>
                            <th  style="width:15%;">{{__('Action') }}</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($myBookings))
                            @foreach($myBookings as $myBooking)
                                <tr>
                                    <td data-title=""></td>
                                    <td data-title="QR Code">
                                        @if ($myBooking->status === 1)
                                            <a href="#" class="pop" data-image="{{$myBooking->url_qrcode}}" data-code="{{$myBooking->code_unique}}">
                                                <img alt="QR Code {{$myBooking->code_unique}}" width="100px" src="{{ $myBooking->url_qrcode }}">
                                            </a>
                                        @endif
                                    </td>   
                                    <td data-title="Wisata">
                                        <b>{{$myBooking->tourism_name}}</b>
                                        <div>{{$myBooking->created_at->translatedFormat("d F \'y")}}</div>
                                    </td>
                                    <td data-title="Jumlah Tiket">
                                        @foreach ($myBooking->detail as $bookingDetail)
                                            <div>{{ $bookingDetail->category_name.' '.$bookingDetail->qty}}</div>
                                        @endforeach
                                    </td>
                                    <td data-title="Status" class="{{ PAYMENTSTATUS[$myBooking->status]['bs_color'] }}">{{ PAYMENTSTATUS[$myBooking->status]['text'] }}</td>
                                    <td data-title="Grand Total" class="">{{ number_format($myBooking->grand_total) }}</td>
                                    <td data-title="Code">{{$myBooking->code_unique}}</td>
                                                                     
                                    <td data-title="Action">
                                        @if ($myBooking->status === 1)
                                        <a href="{{route('user_booking_receipt', $myBooking->code_unique)}}" class="view" title="{{__('Print')}}"><i class="la la-print"></i></a>
                                        <a href="#" class="pop view" data-image="{{$myBooking->url_qrcode}}" data-code="{{$myBooking->code_unique}}" title="{{__('Show QR')}}"><i class="la la-qrcode"></i></a>
                                        @elseif($myBooking->status === 2)
                                            <form action="{{ route('user_booking_payment') }}" method="POST">   
                                                @csrf 
                                                <input id="code-unique" name="code_unique" type="hidden" value="{{ $myBooking->code_unique }}">
                                                <button type="submit" class="btn bg-transparent view button-payment" title="Pembayaran"><i class="la la-money-bill text-success"></i></button>
                                            </form>
                                        @endif

                                    </td>

                                </tr>
                            @endforeach
                        @else
                            {{__('No item found')}}
                        @endif
                        </tbody>
                    </table>
                    <div class="pagination align-left">
                        {{$myBookings->appends(["keyword" => $filter['keyword']])->render('frontend.common.pagination')}}
                    </div><!-- .pagination -->
                </div><!-- .member-place-wrap -->
            </div>
        </div><!-- .site-content -->
    </main><!-- .site-main -->
@stop

@push('scripts')
    <script>
        $('.my_place_filter').change(function () {
            $('#my_place_filter').submit();
        });

        $('.button-payment').click(function(){
            $('#cover-spin').show();
        });
        $(function() {
            $('.pop').on('click', function() {
                $('.imagepreview').attr('src', $(this).attr('data-image'));
                $('.qrcodeunique').text($(this).attr('data-code'));
                $('#imagemodal').modal('show');   
            });		
        });
    </script>
@endpush