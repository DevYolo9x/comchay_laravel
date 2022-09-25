<style>
.box_product_detail .disabled,
.box_product_detail .checked {
    position: relative;
}

.box_product_detail .disabled:after {
    background-color: rgba(255, 255, 255, 0.3);
    background-image: url(https://asset.uniqlo.com/g/icons/chip_disabled.svg);
    background-position: top left;
    background-size: contain;
    bottom: 0;
    content: '';
    left: 0;
    position: absolute;
    right: 0;
    top: 0;
}

.box_product_detail .disabled {
    color: #dbd6d6 !important;
}

.box_product_detail .checked {
    border-color: #d61c1f;
    color: #d61c1f;
}

.box_product_detail .checked::before {
    border: 10px solid #621f1f00;
    border: 13px solid #621f1f00;
    border-bottom-color: rgba(98, 31, 31, 0);
    border-bottom-style: solid;
    border-bottom-width: 13px;
    border-bottom: 13px solid #ee4d2d;
    content: "";
    position: absolute;
    right: -13px;
    bottom: -13px;
    transform: rotate(135deg);
}

.box_product_detail .checked::after {
    content: "" !important;
    position: absolute;
    right: 3px;
    bottom: 2px;
    font-size: 10px;
    color: #fff;
    display: inline-block;
    transform: rotate(45deg);
    height: 9px;
    width: 5px;
    margin-left: 56%;
    border-bottom: 2px solid #fff;
    border-right: 2px solid #fff;
}

input[type='number']::-webkit-inner-spin-button,
input[type='number']::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.custom-number-input input:focus {
    outline: none !important;
}

.custom-number-input button:focus {
    outline: none !important;
}
</style>