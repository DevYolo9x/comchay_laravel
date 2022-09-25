<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="robots" content="index,follow" />
    <title><?php echo isset($seo['meta_title']) ? $seo['meta_title'] : $fcSystem['seo_meta_title']; ?></title>
    <meta name="description" content="<?php echo isset($seo['meta_description']) ? $seo['meta_description'] : $fcSystem['seo_meta_description']; ?>" />
    <!-- META FOR FACEBOOK -->
    <meta property="og:site_name" content="<?php echo (isset($fcSystem['homepage_company'])) ? $fcSystem['homepage_company'] : ''; ?>" />
    <meta property="og:rich_attachment" content="true" />
    <meta property="og:type" content="website" />
    <meta property="og:url" itemprop="url" content="<?php echo isset($seo['canonical']) ? $seo['canonical'] : ''; ?>" />
    <meta property="og:image" itemprop="thumbnailUrl" content="<?php echo (isset($seo['meta_image']) && !empty($seo['meta_image'])) ? url($seo['meta_image']) : url($fcSystem['seo_meta_images']) ?>" />
    <meta property="og:image:width" content="800" />
    <meta property="og:image:height" content="354" />
    <meta content="<?php echo isset($seo['meta_title']) ? $seo['meta_title'] : $fcSystem['seo_meta_title']; ?>" itemprop="headline" property="og:title" />
    <meta content="<?php echo isset($seo['meta_description']) ? $seo['meta_description'] : $fcSystem['seo_meta_description']; ?>" itemprop="description" property="og:description" />
    <!-- Twitter Card -->
    <meta name="twitter:card" value="summary" />
    <meta name="twitter:url" content="<?php echo isset($seo['canonical']) ? $seo['canonical'] : ''; ?>" />
    <meta name="twitter:title" content="<?php echo isset($seo['meta_title']) ? $seo['meta_title'] : $fcSystem['seo_meta_title']; ?>" />
    <meta name="twitter:description" content="<?php echo isset($seo['meta_description']) ? $seo['meta_description'] : $fcSystem['seo_meta_description']; ?>" />
    <meta name="twitter:image" content="<<?php echo (isset($seo['meta_image']) && !empty($seo['meta_image'])) ? url($seo['meta_image']) : url($fcSystem['seo_meta_images']) ?>" />
    <meta name="twitter:site" content="<?php echo (isset($fcSystem['homepage_company'])) ? $fcSystem['homepage_company'] : ''; ?>" />
    <meta name="twitter:creator" content="<?php echo (isset($fcSystem['homepage_brandname'])) ? $fcSystem['homepage_brandname'] : ''; ?>" />
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo e($fcSystem['homepage_favicon']); ?>" />
    <!-- head-->
    <?php echo $__env->yieldPushContent('css'); ?>
    <?php echo $__env->make('homepage.common.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <script>
        var BASE_URL = '<?php echo url(''); ?>/';
        var BASE_URL_AJAX = '<?php echo url(''); ?>/';
    </script>
    <script type="application/ld+json">
        {
            "@context": "https://schema.org/",
            "@type": "CreativeWorkSeries",
            "name": "<?php echo isset($seo['meta_title']) ? $seo['meta_title'] : $fcSystem['seo_meta_title']; ?>",
            "aggregateRating": {
                "@type": "AggregateRating",
                "ratingValue": "5",
                "bestRating": "5",
                "ratingCount": "3"
            }
        }
    </script>
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@graph": [{
                "@type": "WebSite",
                "@id": "<?php echo isset($seo['canonical']) ? $seo['canonical'] : ''; ?>#website",
                "url": "<?php echo isset($seo['canonical']) ? $seo['canonical'] : ''; ?>",
                "name": "<?php echo $fcSystem['homepage_company'] ?>",
                "description": "<?php echo isset($seo['meta_description']) ? $seo['meta_description'] : $fcSystem['seo_meta_description']; ?>",
                "potentialAction": [{
                    "@type": "SearchAction",
                    "target": {
                        "@type": "EntryPoint",
                        "urlTemplate": "<?php echo isset($seo['canonical']) ? $seo['canonical'] : ''; ?>?s={search_term_string}"
                    },
                    "query-input": "required name=search_term_string"
                }],
                "inLanguage": "vi"
            }, {
                "@type": "ImageObject",
                "@id": "<?php echo isset($seo['canonical']) ? $seo['canonical'] : ''; ?>#primaryimage",
                "inLanguage": "vi",
                "url": "<?php echo (isset($seo['meta_image']) && !empty($seo['meta_image'])) ? url($seo['meta_image']) : url($fcSystem['seo_meta_images']) ?>",
                "contentUrl": "<?php echo (isset($seo['meta_image']) && !empty($seo['meta_image'])) ? url($seo['meta_image']) : url($fcSystem['seo_meta_images']) ?>",
                "width": 932,
                "height": 680
            }, {
                "@type": "WebPage",
                "@id": "<?php echo isset($seo['canonical']) ? $seo['canonical'] : ''; ?>#webpage",
                "url": "<?php echo isset($seo['canonical']) ? $seo['canonical'] : ''; ?>",
                "name": "Lorem ipsum dolor sit amet - <?php echo $fcSystem['homepage_company'] ?>",
                "isPartOf": {
                    "@id": "<?php echo isset($seo['canonical']) ? $seo['canonical'] : ''; ?>#website"
                },
                "primaryImageOfPage": {
                    "@id": "<?php echo isset($seo['canonical']) ? $seo['canonical'] : ''; ?>#primaryimage"
                },
                "author": {
                    "@id": "<?php echo isset($seo['canonical']) ? $seo['canonical'] : ''; ?>#/schema/person/6923a1ffbe49cb2449ae873dc7254c27"
                },
                "breadcrumb": {
                    "@id": "<?php echo isset($seo['canonical']) ? $seo['canonical'] : ''; ?>#breadcrumb"
                },
                "inLanguage": "vi",
                "potentialAction": [{
                    "@type": "ReadAction",
                    "target": ["<?php echo isset($seo['canonical']) ? $seo['canonical'] : ''; ?>"]
                }]
            }, {
                "@type": "BreadcrumbList",
                "@id": "<?php echo isset($seo['canonical']) ? $seo['canonical'] : ''; ?>#breadcrumb",
                "itemListElement": [{
                    "@type": "ListItem",
                    "position": 1,
                    "name": "Trang chủ",
                    "item": "<?php echo url(''); ?>"
                }, {
                    "@type": "ListItem",
                    "position": 2,
                    "name": "<?php echo isset($seo['meta_title']) ? $seo['meta_title'] : $fcSystem['seo_meta_title']; ?>"
                }]
            }]
        }
    </script>

</head>

<body class="bg-green">
    <?php echo $__env->make('homepage.common.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldContent('content'); ?>
    <?php echo $__env->make('homepage.common.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('homepage.common.script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php /*@include('homepage.common.cart')*/ ?>
    <?php echo $__env->yieldPushContent('javascript'); ?>

    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v14.0&appId=2586825361606351&autoLogAppEvents=1" nonce="OCqVGwdA"></script>
    <!-- loading -->
    <style>
        .lds-ring {
            width: 80px;
            height: 80px;
            position: fixed;
            z-index: 9999;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .lds-ring div {
            box-sizing: border-box;
            display: block;
            position: absolute;
            width: 64px;
            height: 64px;
            margin: 8px;
            border: 8px solid #000;
            border-radius: 50%;
            animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
            border-color: #000 transparent transparent transparent;
        }

        .lds-ring div:nth-child(1) {
            animation-delay: -0.45s;
        }

        .lds-ring div:nth-child(2) {
            animation-delay: -0.3s;
        }

        .lds-ring div:nth-child(3) {
            animation-delay: -0.15s;
        }

        @keyframes  lds-ring {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .lds-show {
            width: 100%;
            height: 100vh;
            float: left;
            position: fixed;
            z-index: 999999999999999999999;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #0000004f;
        }
    </style>
    <div class="hidden lds-show">
        <div class="lds-ring ">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <script>
        $(document).ajaxStart(function() {
            $('.lds-show').removeClass('hidden');
        }).ajaxStop(function() {
            $('.lds-show').addClass('hidden');
        });
    </script>
    <!-- end: loading -->
</body>


</html><?php /**PATH D:\Xampp\htdocs\comchay.laravel\resources\views/homepage/layout/home.blade.php ENDPATH**/ ?>