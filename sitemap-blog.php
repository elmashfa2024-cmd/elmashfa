<?php
/**
 * sitemap-blog.php
 * Sitemap ديناميكي لمقالات المدونة - يتحدث تلقائياً
 */

require_once 'config/settings.php';

header('Content-Type: application/xml; charset=utf-8');

try {
    $posts = $pdo->query("
        SELECT id, created_at 
        FROM blog_posts 
        WHERE is_published = 1 
        ORDER BY created_at DESC
    ")->fetchAll();
} catch (Exception $e) {
    $posts = [];
}

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($posts as $post): ?>
    <url>
        <loc>https://www.elmashfa.com/blog-post.php?id=<?php echo (int)$post['id']; ?></loc>
        <lastmod><?php echo date('Y-m-d', strtotime($post['created_at'])); ?></lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>
<?php endforeach; ?>
</urlset>