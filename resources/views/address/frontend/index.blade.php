@extends('homepage.layout.home')
@section('content')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBPYwKdcUYplwZuW9gSMfSB7naz42TcUE0&callback=initMap"></script>
<main id="maincontent" class="page-main container">
    <div class="page-title-wrapper">
        <h1 class="page-title">
            <span class="base" data-ui-id="page-title-wrapper">Tìm kiếm cửa hàng</span>
        </h1>
    </div>
    <div class="columns">
        <div class="column main">
            <div id="store-locator-search-wrapper" class="store-search row">
                <div class="contextual-bar col-md-6">

                    <div class="shop-search">
                        <?php if (isset($listCity)) { ?>
                            <div class="fulltext-search-wrapper">
                                <div class="geocoder-wrapper">
                                    <div class="form">
                                        <div class="geolocalize-container row">
                                            <div class="field col-md-6 ">
                                                <p class="title-map">Chọn tỉnh thành</p>
                                                <select name="showroom_city_id" class="form-control showroom_store" data-type="city">
                                                    <option label=" -- Thành phố / Tỉnh -- " value="0" lat-city="14.058324" long-city="108.277199"> -- Thành phố / Tỉnh --</option>
                                                    <?php foreach ($listCity as $key => $val) { ?>
                                                        <option label="<?php echo $val->name ?>" value="<?php echo $key ?>" lat-city="<?php echo $val->lat ?>" long-city="<?php echo $val->long ?>" data-id='<?php echo $val->provinceid ?>'><?php echo $val->name ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="field col-md-6">
                                                <p class="title-map">Chọn quận/huyện</p>
                                                <select name="showroom_districtid" class="form-control showroom_store" data-type="district">
                                                    <option value=""> -- Quận / Huyện --</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        <?php }  ?>
                        <div class="search-result-list list-level">
                            <div class="search-result-header">
                                <p><span class="count_store"><?php echo !empty($Liststores) ? count($Liststores) : 0 ?></span> kết quả</p>
                            </div>
                            <ul class="city_0 city-wrapper" style="display: block;">
                                <?php echo htmlAddress($Liststores)?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="map col-md-6">
                    <fieldset class="gllpLatlonPicker">
                        <div class="gllpMap" id="map"></div>
                        <input type="hidden" class="gllpLatitude" value="14.058324" name="showroom_lat">
                        <input type="hidden" class="gllpLongitude" value="108.277199" name="showroom_lon">
                        <input type="button" class="gllpUpdateButton" value="update map">
                        <input type="hidden" class="gllpZoom" value="17">
                    </fieldset>
                </div>
            </div>
        </div>

    </div>

</main>
@include('address.frontend.common.script')
@include('address.frontend.common.css')
@endsection
