(function ($) {
    'use strict';

    let place_lat = parseFloat($('#place_lat').val()),
        place_lng = parseFloat($('#place_lng').val()),
        place_icon_marker = $('#place_icon_marker').val();

    var map = new mapboxgl.Map({
        container: 'golo-place-map',
        style: 'mapbox://styles/mapbox/streets-v11', // stylesheet location
        center: [place_lng, place_lat], // starting position [lng, lat]
        zoom: 12 // starting zoom
    });

    var marker = new mapboxgl.Marker()
        .setLngLat([place_lng, place_lat])
        .addTo(map);
})(jQuery);