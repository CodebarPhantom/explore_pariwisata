(function ($) {
    'use strict';

    mapboxgl.accessToken = 'pk.eyJ1IjoibWluaHRoZSIsImEiOiJja2phc2l1eWc0OHF1MnJtMGw3ZzFjeXdxIn0.mJAsm20swzej4lWDUBucow';
    let ajax_url = window.location.href;
    (ajax_url.indexOf('?') > -1) ? ajax_url += '&ajax=1' : ajax_url += '?ajax=1';

    $.ajax({
        dataType: 'json',
        url: ajax_url,
        beforeSend: function () {
            console.log("before call api get places map");
        },
        success: function (response) {
            let data = response.data;
            let places = []
            console.log('data places: ', data)

            data.places.forEach(function (value, index) {
                let html_review = '';
                let html_category = '';
                if (value.avg_review.length) {
                    html_review = `
                            ${value.avg_review[0]['aggregate']} <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"><path fill="#DDD" fill-rule="evenodd" d="M6.12.455l1.487 3.519 3.807.327a.3.3 0 0 1 .17.525L8.699 7.328l.865 3.721a.3.3 0 0 1-.447.325L5.845 9.4l-3.272 1.973a.3.3 0 0 1-.447-.325l.866-3.721L.104 4.826a.3.3 0 0 1 .17-.526l3.807-.327L5.568.455a.3.3 0 0 1 .553 0z"/></svg>
                            `;
                }
                if (value.categories) {
                    for (var j = 0; j < value.categories.length; j++) {
                        html_category += `<a style="color: #666;"> ${value.categories[j]['name']}</a>`;
                    }
                }
                var html_infowindow = `
                        <div id='infowindow'>
                            <div class="places-item" data-title="${value.name}" data-lat="-33.796864" data-lng="150.620614" data-index="${index}">
                                <a href="/place/${value.slug}"><img src="/uploads/${value.thumb}" alt=""></a>
                                <div class="places-item__info">
                                    <span class="places-item__category">${html_category}</span>
                                    <a href="/place/${value.slug}"><h3>${value.name}</h3></a>
                                    <div class="places-item__meta">
                                        <div class="places-item__reviews">
                                            <span class="places-item__number">
                                                ${html_review}
                                                <span class="places-item__count">(${value.reviews_count} reviews)</span>
                                            </span>
                                        </div>
                                        <div class="places-item__currency">${PRICE_RANGE[value.price_range]}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

                places.push({
                    'type': 'Feature',
                    'properties': {
                        'description': html_infowindow
                    },
                    'geometry': {
                        'type': 'Point',
                        'coordinates': [value.lng, value.lat]
                    }
                })
            })

            let golo_map_option = {
                container: 'place-map-filter',
                style: 'mapbox://styles/mapbox/streets-v11',
                center: [parseFloat(data.city.lng), parseFloat(data.city.lat)],
                zoom: 12
            }

            if (data.city) {
                golo_map_option.center = {lat: parseFloat(data.city.lat), lng: parseFloat(data.city.lng)};
            } else {
                golo_map_option.center = new google.maps.LatLng(0, 0);
                golo_map_option.zoom = 2;
            }

            var map = new mapboxgl.Map(golo_map_option);

            map.on('load', function () {
                map.loadImage(
                    '/assets/images/icon-mapker.png',
                    function (error, image) {
                        if (error) throw error;
                        map.addImage('custom-marker', image);

                        map.addSource('places', {
                            'type': 'geojson',
                            'data': {
                                'type': 'FeatureCollection',
                                'features': places
                            }
                        });

                        map.addLayer({
                            'id': 'places',
                            'type': 'symbol',
                            'source': 'places',
                            'layout': {
                                'icon-image': 'custom-marker',
                                'icon-allow-overlap': true
                            }
                        });
                    }
                );

                var popup = new mapboxgl.Popup({
                    closeButton: true,
                    closeOnClick: false
                });

                map.on('mouseenter', 'places', function (e) {
                    map.getCanvas().style.cursor = 'pointer';

                    var coordinates = e.features[0].geometry.coordinates.slice();
                    var description = e.features[0].properties.description;

                    while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                        coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                    }

                    popup.setLngLat(coordinates).setHTML(description).setMaxWidth("350px").addTo(map);
                });

                // map.on('mouseleave', 'places', function () {
                //     map.getCanvas().style.cursor = '';
                //     popup.remove();
                // });
            });

        },
    });


})(jQuery);