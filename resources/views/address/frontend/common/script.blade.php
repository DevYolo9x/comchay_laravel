<script>
    $(document).on('change', '.showroom_store', function(e, data) {
        var id = $(this).find(':selected').attr('data-id');
        var type = $(this).attr('data-type');
        let formURL = '<?php echo route('addressFrontend.getLocation') ?>';
        if(typeof id == 'undefined'){
            id = $('select[name="showroom_city_id"]').find(':selected').attr('data-id');
            type = $('select[name="showroom_city_id"]').attr('data-type');
        }
        $.post(formURL, {
                id: id,
                type:type,
                "_token": $('meta[name="csrf-token"]').attr("content")
            },
            function(data) {
                let json = JSON.parse(data);
                if(type === 'city'){
                    $('select[name="showroom_districtid"]').html(json.district_html);
                }
                $('.city_0').html(json.html);
                $('.count_store').html(json.count);
            });
    });
    $(document).on('change', '#showroom_districtid', function(e, data) {
        var value = $(this).val();
        var keyword = $(this).find(':selected').attr('data-key');
        var provinceid = $(this).find(':selected').attr('data-province');
        let formURL = 'getDistrict-store.html';
        $.post(formURL, {
                keyword: keyword,
                provinceid: provinceid
            },
            function(data) {
                let json = JSON.parse(data);
                $('.city-wrapper').hide();
                $('.city_' + value).html(json.html);
                $('.city_' + value).show();
                $('.count_store').html(json.count);

            });
    });
</script>
<script type="text/javascript">
    var locations;
    $(document).ready(function() {
        $(document).on('click', '.showroom-item', function(e, data) {
            $('.showroom-item').removeClass('active');
            $(this).addClass('active');
        });
        $('.showroom-item').hover(
            function() {
                $(this).addClass('hover');
            },
            function() {
                $(this).removeClass('hover');
            }
        );

    });
    var icon = {
        url: "<?php echo asset('image/maker_app.png')?>", // url
        scaledSize: new google.maps.Size(24, 32), // scaled size
        origin: new google.maps.Point(0, 0), // origin
        anchor: new google.maps.Point(50, 50) // anchor
    };

    function initialize() {
        locations = [

            <?php if (isset($Liststores)) { ?>
                <?php foreach ($Liststores as $key => $val) { ?>


                    ['<div class="store-address"><?php echo $val->title ?></div>' +
            '<div class="store-address-item"><i class="ion-location"></i>&nbsp;Địa chỉ: <?php echo $val->address ?></div>' +
            '<div class="store-address-item"><i class="ion-android-phone-portrait"></i>&nbsp;Điện thoại: <?php echo $val->hotline ?></div>',<?php echo $val->lat?>,<?php echo $val->long?>,<?php echo $key?>],
                <?php } ?>
            <?php } ?>

        ];
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 8,
            center: new google.maps.LatLng(20.7629819, 106.3070388),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        var infowindow = new google.maps.InfoWindow();
        var marker, i;
        for (i = 0; i < locations.length; i++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: map,
                icon: icon
            });
            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    infowindow.setContent(locations[i][0]);
                    infowindow.open(map, marker);
                }
            })(marker, i));
        }
    }
    $('.showroom_store').on('change', function initialize() {
        const lat = $('option:selected', this).attr('lat-city');
        const lon = $('option:selected', this).attr('long-city');
        const myLatlng = { lat: parseFloat(lat), lng: parseFloat(lon) };
        const type = $(this).attr('data-type');
        if(type == 'city'){
            var zoom = 10;
        }else{
            var zoom = 14;
        }
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: zoom,
            center: myLatlng,
            gestureHandling: "cooperative",
            
        });
        var infowindow = new google.maps.InfoWindow();
        var marker, i;
        for (i = 0; i < locations.length; i++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: map,
                icon: icon
            });
            google.maps.event.addListener(marker, 'click', (function (marker, i) {
                return function () {
                    infowindow.setContent(locations[i][0]);
                    infowindow.open(map, marker);
                }
            })(marker, i));
        }
    });

    $(document).on('click', '.showroom-item', function initialize() {
        var lat = $(this).attr('data-lat');
        var lon = $(this).attr('data-long');
        var latLng = new google.maps.LatLng(lat, lon);
        var mapOptions = {
            zoom: 16,
            center: latLng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var contentString = '<div class="store-address">' + $(this).attr('data-brand') + '</div>' +
            '<div class="store-address-item"><i class="ion-location"></i>&nbsp;Địa chỉ: ' + $(this).attr('data-address') + '</div>' +
            '<div class="store-address-item"><i class="ion-android-phone-portrait"></i>&nbsp;Điện thoại: ' + $(this).attr('data-phone') + '</div>';
        var infowindow = new google.maps.InfoWindow({
            content: contentString
        });
        var map = new google.maps.Map(document.getElementById('map'), mapOptions);
        marker = new google.maps.Marker({
            position: latLng,
            map: map,
            icon: {
                url: "<?php echo asset('image/maker_app.png')?>", // url
                scaledSize: new google.maps.Size(24, 32), // scaled size
                origin: new google.maps.Point(0, 0), // origin
                anchor: new google.maps.Point(0, 0) // anchor
            }
        });
        infowindow.open(map, marker);
    });
    google.maps.event.addDomListener(window, 'load', initialize);
</script>