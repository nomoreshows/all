<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc><?php echo Router::url('/',true); ?></loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc>http://www.serieall.fr/series-tv</loc>
        <changefreq>monthly</changefreq>
        <priority>0.9</priority>
    </url>
    <url>
        <loc>http://www.serieall.fr/planning-series-tv</loc>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>
     <url>
        <loc>http://www.serieall.fr/actualite</loc>
        <changefreq>daily</changefreq>
        <priority>0.9</priority>
    </url>
     <url>
        <loc>http://www.serieall.fr/critiques</loc>
        <changefreq>daily</changefreq>
        <priority>0.9</priority>
    </url>
    <url>
        <loc>http://www.serieall.fr/videos-trailers</loc>
        <changefreq>daily</changefreq>
        <priority>0.9</priority>
    </url>
    <url>
        <loc>http://www.serieall.fr/dossiers</loc>
        <changefreq>weekly</changefreq>
        <priority>0.5</priority>
    </url>
    <url>
        <loc>http://www.serieall.fr/portraits</loc>
        <changefreq>monthly</changefreq>
        <priority>0.5</priority>
    </url>
    <url>
        <loc>http://www.serieall.fr/bilans</loc>
        <changefreq>monthly</changefreq>
        <priority>0.5</priority>
    </url>
    <url>
        <loc>http://www.serieall.fr/focus</loc>
        <changefreq>monthly</changefreq>
        <priority>0.5</priority>
    </url>
    <?php foreach ($articles as $article):?>
    <url>
        <loc><?php echo 'http://www.serieall.fr/article/' . $article['Article']['url'] . '.html'; ?></loc>
        <lastmod><?php echo $time->toAtom($article['Article']['created']); ?></lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <?php endforeach; ?>
    <?php foreach ($shows as $show):?>
    <url>
        <loc><?php echo 'http://www.serieall.fr/serie/' . $show['Show']['menu']; ?></loc>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    <?php endforeach; ?>
    <?php foreach ($seasons as $season):?>
    <url>
        <loc><?php echo 'http://www.serieall.fr/saison/' . $season['Show']['menu'] . '/' . $season['Season']['name']; ?></loc>
        <changefreq>weekly</changefreq>
        <priority>0.6</priority>
    </url>
    <?php endforeach; ?>
    <?php foreach ($episodes as $episode):?>
    <url>
        <loc><?php echo 'http://www.serieall.fr/episode/' . $episode['Season']['Show']['menu'] . '/s' . str_pad($episode['Season']['name'], 2, 0, STR_PAD_LEFT) . 'e' . str_pad($episode['Episode']['numero'], 2, 0, STR_PAD_LEFT); ?></loc>
        <changefreq>weekly</changefreq>
        <priority>0.6</priority>
    </url>
    <?php endforeach; ?>
    <?php foreach ($users as $user):?>
    <url>
        <loc><?php echo 'http://www.serieall.fr/profil/' . $user['User']['login']; ?></loc>
        <changefreq>weekly</changefreq>
        <priority>0.4</priority>
    </url>
    <?php endforeach; ?>
</urlset> 