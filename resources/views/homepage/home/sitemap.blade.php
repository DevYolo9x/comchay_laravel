<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{url('')}}</loc>
        <lastmod>{{ gmdate(DateTime::W3C) }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc>{{url('about-us')}}</loc>
        <lastmod>{{ gmdate(DateTime::W3C) }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc>{{url('lien-he')}}</loc>
        <lastmod>{{ gmdate(DateTime::W3C) }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>

    @if(count($router) > 0)
    @foreach($router as $v)
    <url>
        <loc>{{ route('routerURL',['slug' => $v->slug]) }}</loc>
        <lastmod>{{ gmdate(DateTime::W3C, strtotime($v->created_at)) }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    @endforeach
    @endif
    <?php /*@if(count($Tags) > 0)
    @foreach($Tags as $v)
    <url>
        <loc>{{ route('tagURL',['slug' => $v->slug]) }}</loc>
        <lastmod>{{ gmdate(DateTime::W3C, strtotime($v->created_at)) }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    @endforeach
    @endif
    @if(count($Brands) > 0)
    @foreach($Brands as $v)
    <url>
        <loc>{{ route('brandURL',['slug' => $v->slug]) }}</loc>
        <lastmod>{{ gmdate(DateTime::W3C, strtotime($v->created_at)) }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    @endforeach
    @endif*/ ?>
</urlset>