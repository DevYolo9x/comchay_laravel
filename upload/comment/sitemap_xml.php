<?php
header("Content-type: text/xml");
echo "<?xml version='1.0' encoding='UTF-8'?>";
?>
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<!-- created with Free Online Sitemap Generator www.xml-sitemaps.com -->
<?php if(isset($ArticlesNews) && is_array($ArticlesNews) && count($ArticlesNews)){ ?>
<?php foreach($ArticlesNews as $keyMain => $valMain){ ?>
<?php
$title = htmlspecialchars($valMain['title']);
$url = rewrite_url($valMain['canonical'], $valMain['slug'], $valMain['id'], 'articles');						
?>
<url><loc><?php echo $url;?></loc></url>
<?php } ?>
<?php } ?>
<?php if(isset($ArticlesCatalogues) && is_array($ArticlesCatalogues) && count($ArticlesCatalogues)){ ?>
<?php foreach($ArticlesCatalogues as $keyMain => $valMain){ ?>
<?php
$title = htmlspecialchars($valMain['title']);
$url = rewrite_url($valMain['canonical'], $valMain['slug'], $valMain['id'], 'articles_catalogues');						
?>
<url><loc><?php echo $url;?></loc></url>
<?php } ?>
<?php } ?>
</urlset>