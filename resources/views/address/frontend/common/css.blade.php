<style>
    button:focus {
        outline: 0px dotted;
        outline: 0px auto -webkit-focus-ring-color;
    }
     #map {
        height: 523px;
    }
    .gm-style .gm-style-iw-t::after {

        top: -1px !important;
    }

    .fulltext-search-wrapper {
        border-bottom: 1px solid #c2c2c2;
        padding: 10px 20px 15px;
        background: #3e54d3;
        color: #fff;
    }

    .fulltext-search-wrapper .form {
        display: flex;
        padding: 10px 0 5px;
        align-items: center;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: center;
    }

    .form .geolocalize-container {
        flex: 0 0 100%;
    }

    .showroom-item {
        cursor: pointer;
    }

    .store-address {
        font-size: 16px;
        margin-bottom: 0.8rem;
        font-weight: 700;
    }

    .page-title-wrapper h1 {
        font-size: 20px;
        text-transform: none;
        color: #20315c;
        margin-bottom: 15px;
        font-weight: 600;
    }

    .search-result-list .search-result-header {
        background: #e5e5e5;
        padding: 0;
    }

    .search-result-list .search-result-header p {
        color: #434343;
        padding: 8px 20px;
    }

    .search-result-list ul {
        overflow-y: overlay;
        list-style: none;
        padding: 0px;
        max-height: 375px;
    }

    .search-result-list ul::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        border-radius: 10px;
        background-color: #F5F5F5;
    }

    .search-result-list ul::-webkit-scrollbar {
        width: 5px;
        background-color: #F5F5F5;
    }

    .search-result-list ul::-webkit-scrollbar-thumb {
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
        background-color: #3e54d3;
    }


    .search-result-list ul li.result-item {
        position: relative;
        border-bottom: 1px solid #eaeaea;
        padding: 20px 0 5px;
    }

    .search-result-list ul li div {
        padding-right: 100px;
    }

    .search-result-list ul li div.details p.button-view {
        position: absolute;
        right: 0;
        top: 50%;
        width: 80px;
        z-index: 1;
        -webkit-transform: translateY(-50%);
        height: 80px;
        transform: translateY(-50%);
        -o-transform: translateY(-50%);
        -ms-transform: translateY(-50%);
    }

    .search-result-list ul li div.details p.button-view {
        background-color: #acb9cb;
        padding: 10px;
        cursor: pointer;
        -webkit-transition: all .3s;
        transition: all .3s;
    }

    .search-result-list ul li.result-item .details a {
        color: #fff;
        font-size: 12px;
        text-decoration: none;
        line-height: normal;
        display: block;
        text-transform: uppercase;
    }

    .arrow-right span {
        width: 40px;
        position: absolute;
        bottom: 3px;
        height: 23px;
        right: 10px;
        text-align: right;
        line-height: 23px;
        font-size: 23px;
        display: block;
    }

    .arrow-right span:before {
        content: "";
        height: 2px;
        width: 25px;
        background: #fff;
        position: absolute;
        left: 12px;
        top: 12px;
        -webkit-transform: translateY(0);
        transform: translateY(0);
    }

    .loc_link.active p.button-view {
        background-color: #292bb7 !important;
    }

    input[type="text"],
    input[type="email"],
    input[type="tel"],
    input[type="password"],
    textarea.form-control,
    select.form-control {
        border-radius: 0;
        outline: none;
        box-shadow: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        border: 1px solid #e1e1e1
    }

    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="tel"]:focus,
    input[type="password"]:focus,
    textarea.form-control:focus,
    select.form-control:focus {
        outline: none;
        box-shadow: none
    }


    .btn-blues {
        color: #fff;
        background-color: #f54337;
        border-color: #f54337;
        border-radius: 2px !important;
        text-transform: uppercase;
        position: relative;
        overflow: hidden;
        z-index: 1
    }

    .btn-blues:after {
        position: absolute;
        bottom: 0;
        left: 0;
        display: block;
        content: " ";
        width: 100%;
        height: 100%;
        background-color: #f65a4f;
        border-radius: inherit;
        z-index: -1;
        -webkit-transform-origin: 0 100%;
        -moz-transform-origin: 0 100%;
        transform-origin: 0 100%;
        -webkit-transform: scaleY(0);
        -moz-transform: scaleY(0);
        transform: scaleY(0);
        -webkit-transition: -webkit-transform .25s ease-in-out;
        -moz-transition: -moz-transform .25s ease-in-out;
        transition: transform .25s ease-in-out
    }

    .btn-blues:hover {
        color: #fff
    }

    .btn-blues:hover:after {
        -webkit-transform: scaleY(1);
        -moz-transform: scaleY(1);
        transform: scaleY(1)
    }


    @media (max-width: 767px) {
        header .topbar {
            padding: 4px 0;
            font-size: 13px
        }
    }


    @-webkit-keyframes pulse {
        0% {
            -webkit-transform: scale(1.1);
            transform: scale(1.1)
        }

        50% {
            -webkit-transform: scale(0.8);
            transform: scale(0.8)
        }

        100% {
            -webkit-transform: scale(1.1);
            transform: scale(1.1)
        }
    }

    @keyframes pulse {
        0% {
            -webkit-transform: scale(1.1);
            -ms-transform: scale(1.1);
            transform: scale(1.1)
        }

        50% {
            -webkit-transform: scale(0.8);
            -ms-transform: scale(0.8);
            transform: scale(0.8)
        }

        100% {
            -webkit-transform: scale(1.1);
            -ms-transform: scale(1.1);
            transform: scale(1.1)
        }
    }

    .animated {
        animation-duration: 1s;
        animation-fill-mode: both
    }

    .animated.infinite {
        animation-iteration-count: infinite
    }

    .animated.hinge {
        animation-duration: 2s
    }

    .animated.flipOutX,
    .animated.flipOutY,
    .animated.bounceIn,
    .animated.bounceOut {
        animation-duration: .75s
    }

    @keyframes zoomIn {
        from {
            opacity: 0;
            transform: scale3d(0.3, 0.3, 0.3)
        }

        50% {
            opacity: 1
        }
    }

    .zoomIn {
        animation-name: zoomIn
    }

    @keyframes pulse {
        from {
            transform: scale3d(1, 1, 1)
        }

        50% {
            transform: scale3d(1.05, 1.05, 1.05)
        }

        to {
            transform: scale3d(1, 1, 1)
        }
    }

    .pulse {
        animation-name: pulse
    }

    @keyframes rubberBand {
        from {
            transform: scale3d(1, 1, 1)
        }

        30% {
            transform: scale3d(1.25, 0.75, 1)
        }

        40% {
            transform: scale3d(0.75, 1.25, 1)
        }

        50% {
            transform: scale3d(1.15, 0.85, 1)
        }

        65% {
            transform: scale3d(0.95, 1.05, 1)
        }

        75% {
            transform: scale3d(1.05, 0.95, 1)
        }

        to {
            transform: scale3d(1, 1, 1)
        }
    }


    .showroom-list {
        background-color: #000;
        height: 500px
    }

    .showroom-list .city-selector {
        background-color: #f54337;
        padding: 20px 10px
    }

    .showroom-list .city-selector h2 {
        font-size: 15px;
        text-transform: uppercase;
        text-align: center;
        margin-bottom: 10px
    }

    .showroom-list .showroom-item {
        margin: 15px 10px;
        cursor: pointer
    }

    .showroom-list .showroom-item.active h2.title {
        color: #f54337
    }

    .showroom-list h2.title {
        color: #fff;
        text-transform: uppercase;
        font-size: 16px;
        margin-top: 0
    }

    .showroom-list p {
        color: #858585;
        font-size: 12px !important;
        margin: 5px 0px;
        line-height: 1.5em;
        display: table;
        width: 100%
    }

    .showroom-list p i {
        display: table-cell;
        width: 15px
    }

    .showroom-list p a {
        color: #858585
    }

    .showroom-list p:last-child {
        border-bottom: 1px solid #333333;
        padding-bottom: 15px
    }

    .showroom-list select {
        display: block;
        outline: none;
        box-shadow: none;
        border-radius: 0;
        background-color: #fff;
        background: url(data:image/svg+xml;base64,PHN2ZyBpZD0iTGF5ZXJfMSIgZGF0YS1uYW1lPSJMYXllciAxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA0Ljk1IDEwIj48ZGVmcz48c3R5bGU+LmNscy0xe2ZpbGw6I2ZmZjt9LmNscy0ye2ZpbGw6IzQ0NDt9PC9zdHlsZT48L2RlZnM+PHRpdGxlPmFycm93czwvdGl0bGU+PHJlY3QgY2xhc3M9ImNscy0xIiB3aWR0aD0iNC45NSIgaGVpZ2h0PSIxMCIvPjxwb2x5Z29uIGNsYXNzPSJjbHMtMiIgcG9pbnRzPSIxLjQxIDQuNjcgMi40OCAzLjE4IDMuNTQgNC42NyAxLjQxIDQuNjciLz48cG9seWdvbiBjbGFzcz0iY2xzLTIiIHBvaW50cz0iMy41NCA1LjMzIDIuNDggNi44MiAxLjQxIDUuMzMgMy41NCA1LjMzIi8+PC9zdmc+) no-repeat 100% 50% #fff;
        -moz-appearance: none;
        -webkit-appearance: none;
        appearance: none
    }

    .city-wrapper {
        overflow-y: scroll
    }

    .city-wrapper .has-scrollbar .content {
        outline: none;
        box-shadow: none;
        border: none
    }

    .city-wrapper::-webkit-scrollbar {
        width: 5px
    }

    .city-wrapper::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(255, 255, 255, 0.5);
        border-radius: 10px
    }

    .city-wrapper::-webkit-scrollbar-thumb {
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 6px rgba(255, 255, 255, 0.5)
    }

    .gllpMap {
        width: 100%;
        height: 500px
    }

    .gllpUpdateButton {
        display: none
    }

    .gllpLatlonPicker {
        padding: 0;
        border: 0px;
    }
    .store-address-item{
        font-size: 15px;
    }
</style>