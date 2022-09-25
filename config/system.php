<?php
$data['homepage'] =  array(
    'label' => 'Thông tin chung',
    'description' => 'Cài đặt đầy đủ thông tin chung của website. Tên thương hiệu website. Logo của website và icon website trên tab trình duyệt',
    'value' => array(
        'brandname' => array('type' => 'text', 'label' => 'Tên thương hiệu'),
        'company' => array('type' => 'text', 'label' => 'Tên công ty'),
        'logo' => array('type' => 'images', 'label' => 'Logo'),
        'logo_footer' => array('type' => 'images', 'label' => 'Logo footer'),
        'favicon' => array('type' => 'images', 'label' => 'Favicon'),
        // 'copyright' => array('type' => 'text', 'label' => 'Copyright'),
        // 'mst' => array('type' => 'text', 'label' => 'Mã số thuế'),
        'footer' => array('type' => 'editor', 'label' => 'Thông tin footer'),
        'ads' => array('type' => 'editor', 'label' => 'Liên hệ quảng cáo'),
        // 'size' => array('type' => 'editor', 'label' => 'Bảng size'),
        // 'aboutus' => array('type' => 'textarea', 'label' => 'Giới thiệu'),
    ),
);
$data['contact'] =  array(
    'label' => 'Thông tin liên lạc',
    'description' => 'Cấu hình đầy đủ thông tin liên hệ giúp khách hàng dễ dàng tiếp cận với dịch vụ của bạn',
    'value' => array(
        'address' => array('type' => 'text', 'label' => 'Địa chỉ'),
        'hotline' => array('type' => 'text', 'label' => 'Hotline'),
        'time' => array('type' => 'text', 'label' => 'Thời gian làm việc'),
        // 'phone' => array('type' => 'text', 'label' => 'Số điện thoại'),
        'email' => array('type' => 'text', 'label' => 'Email'),
        'map' => array('type' => 'textarea', 'label' => 'Bản đồ'),

    ),
);
$data['seo'] =  array(
    'label' => 'Cấu hình thẻ tiêu đề',
    'description' => 'Cài đặt đầy đủ Thẻ tiêu đề và thẻ mô tả giúp xác định cửa hàng của bạn xuất hiện trên công cụ tìm kiếm.',
    'value' => array(
        'meta_title' => array('type' => 'text', 'label' => 'Tiêu đề trang', 'extend' => ' trên 70 kí tự', 'class' => 'meta-title', 'id' => 'titleCount'),
        'meta_description' => array('type' => 'textarea', 'label' => 'Mô tả trang', 'extend' => ' trên 320 kí tự', 'class' => 'meta-description', 'id' => 'descriptionCount'),
        'meta_images' => array('type' => 'images', 'label' => 'Ảnh'),
    ),
);
$data['social'] =  array(
    'label' => 'Cấu hình mạng xã hội',
    'description' => 'Cài đặt đầy đủ Thẻ tiêu đề và thẻ mô tả giúp xác định cửa hàng của bạn xuất hiện trên công cụ tìm kiếm.',
    'value' => array(
        'facebook' => array('type' => 'text', 'label' => 'Facebook'),
        'tiktok' => array('type' => 'text', 'label' => 'Tiktok'),
        //       'facebookm' => array('type' => 'text', 'label' => 'Facebook message'),
        // 'instagram' => array('type' => 'text', 'label' => 'Instagram'),
        'twitter' => array('type' => 'text', 'label' => 'Twitter'),
        // 'google_plus' => array('type' => 'text', 'label' => 'Google plus'),
        // 'pinterest' => array('type' => 'text', 'label' => 'Pinterest'),
        'youtube' => array('type' => 'text', 'label' => 'Youtube'),
        // 'rss' => array('type' => 'text', 'label' => 'RSS'),
        // 'vimeo' => array('type' => 'text', 'label' => 'Vimeo'),
        //      'skype' => array('type' => 'text', 'label' => 'Skype'),
        'zalo' => array('type' => 'text', 'label' => 'Số zalo'),
    ),
);

$data['script'] =  array(
    'label' => 'Script',
    'description' => '',
    'value' => array(
        'header' => array('type' => 'textarea', 'label' => 'Script header'),
        'footer' => array('type' => 'textarea', 'label' => 'Script footer'),
    ),
);
// $data['message'] =  array(
//     'label' => 'Thông báo',
//     'description' => '',
//     'value' => array(
//         '1' => array('type' => 'text', 'label' => 'SUBSCRIBE'),
//         '2' => array('type' => 'text', 'label' => 'Gửi thông tin liên hệ thành công'),
//     ),
// );
$data['title'] =  array(
    'label' => 'Tiêu đề',
    'description' => '',
    'value' => array(
        'sale' => array('type' => 'editor', 'label' => 'Content thay đổi mật khẩu'),
    ),
);

// $data['banner'] =  array(
//     'label' => 'Banner',
//     'description' => '',
//     'value' => array(
//         '1' => array('type' => 'images', 'label' => 'Banner home 1'),
//     ),
// );

$data['404'] =  array(
    'label' => '404',
    'description' => '',
    'value' => array(
        '1' => array('type' => 'text', 'label' => 'Tiêu đề'),
        '3' => array('type' => 'textarea', 'label' => 'Mô tả'),
        '4' => array('type' => 'textarea', 'label' => 'Chi tiết'),
        '2' => array('type' => 'images', 'label' => 'Background image'),
    ),
);
// $data['cart'] =  array(
//     'label' => 'Giỏ hàng',
//     'description' => '',
//     'value' => array(
//         'shipping' => array('type' => 'text', 'label' => 'Phí vận chuyển'),
//         '1' => array('type' => 'editor', 'label' => 'Thông tin thanh toán COD'),
//         '2' => array('type' => 'editor', 'label' => 'Thông tin thanh toán chuyển khoản ngân hàng'),
//     ),
// );
return $data;
