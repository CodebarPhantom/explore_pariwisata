@extends('frontend.layouts.template')
@section('main')
    <main id="main" class="site-main">
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
                                        <a href="{{ $myBooking->url_qrcode }}" target="_blank">
                                            <img alt="QR Code {{$myBooking->code_unique}}" width="100px" src="{{ $myBooking->url_qrcode }}">
                                        </a>
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
                                       todo action bayar
                                    </td>

                                </tr>
                            @endforeach
                        @else
                            {{__('No item found')}}
                        @endif
                        </tbody>
                    </table>
                    <div class="pagination align-left">
                        {{ $myBookings->render('frontend.common.pagination') }}
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
    </script>
@endpush