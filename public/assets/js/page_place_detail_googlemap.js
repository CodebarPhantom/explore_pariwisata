(function ($) {
    'use strict';

    $(document).ready(function () {
        let bounds = new google.maps.LatLngBounds();
        let silver = [
            {
                elementType: 'geometry',
                stylers: [{color: '#f5f5f5'}]
            },
            {
                elementType: 'labels.icon',
                stylers: [{visibility: 'off'}]
            },
            {
                elementType: 'labels.text.fill',
                stylers: [{color: '#616161'}]
            },
            {
                elementType: 'labels.text.stroke',
                stylers: [{color: '#f5f5f5'}]
            },
            {
                featureType: 'administrative.land_parcel',
                elementType: 'labels.text.fill',
                stylers: [{color: '#bdbdbd'}]
            },
            {
                featureType: 'poi',
                elementType: 'geometry',
                stylers: [{color: '#eeeeee'}]
            },
            {
                featureType: 'poi',
                elementType: 'labels.text.fill',
                stylers: [{color: '#757575'}]
            },
            {
                featureType: 'poi.park',
                elementType: 'geometry',
                stylers: [{color: '#e5e5e5'}]
            },
            {
                featureType: 'poi.park',
                elementType: 'labels.text.fill',
                stylers: [{color: '#9e9e9e'}]
            },
            {
                featureType: 'road',
                elementType: 'geometry',
                stylers: [{color: '#ffffff'}]
            },
            {
                featureType: 'road.arterial',
                elementType: 'labels.text.fill',
                stylers: [{color: '#757575'}]
            },
            {
                featureType: 'road.highway',
                elementType: 'geometry',
                stylers: [{color: '#dadada'}]
            },
            {
                featureType: 'road.highway',
                elementType: 'labels.text.fill',
                stylers: [{color: '#616161'}]
            },
            {
                featureType: 'road.local',
                elementType: 'labels.text.fill',
                stylers: [{color: '#9e9e9e'}]
            },
            {
                featureType: 'transit.line',
                elementType: 'geometry',
                stylers: [{color: '#e5e5e5'}]
            },
            {
                featureType: 'transit.station',
                elementType: 'geometry',
                stylers: [{color: '#eeeeee'}]
            },
            {
                featureType: 'water',
                elementType: 'geometry',
                stylers: [{color: '#9dcaef'}]
            },
            {
                featureType: 'water',
                elementType: 'labels.text.fill',
                stylers: [{color: '#9e9e9e'}]
            }
        ];

        let place_lat = parseFloat($('#place_lat').val()),
            place_lng = parseFloat($('#place_lng').val()),
            place_icon_marker = $('#place_icon_marker').val();

        let marker;
        let position = new google.maps.LatLng(place_lat, place_lng);
        let mapOptions = {
            mapTypeId: 'roadmap',
            center: position,
            scrollwheel: false,
            styles: silver,
            mapTypeControl: false,
            streetViewControl: false,
            rotateControl: false,
            zoomControl: true,
            fullscreenControl: true,
        };
        let map = new google.maps.Map(document.getElementById("golo-place-map"), mapOptions);
        bounds.extend(position);

        marker = new google.maps.Marker({
            position: position,
            map: map,
            icon: place_icon_marker,
            animation: google.maps.Animation.DROP
        });

        map.fitBounds(bounds);
        let boundsListener = google.maps.event.addListener((map), 'idle', function (event) {
            this.setZoom(15);
            google.maps.event.removeListener(boundsListener);
        });
    });

})(jQuery);