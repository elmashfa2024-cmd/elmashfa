<?php
require_once 'config/settings.php';

// جلب معرف المقال من الرابط
$id = $_GET['id'] ?? 0;

// جلب المقال من قاعدة البيانات
$stmt = $pdo->prepare("SELECT * FROM blog_posts WHERE id = :id AND is_published = 1");
$stmt->execute(['id' => $id]);
$post = $stmt->fetch();

// لو المقال مش موجود، نرجع للرئيسية
if (!$post) {
    header('Location: blog.php');
    exit;
}

// زيادة عدد المشاهدات
$pdo->prepare("UPDATE blog_posts SET views = views + 1 WHERE id = ?")->execute([$id]);

// جلب إعدادات الموقع

// جلب مقالات ذات صلة
$relatedPosts = $pdo->prepare("
    SELECT * FROM blog_posts 
    WHERE is_published = 1 AND id != :id 
    ORDER BY created_at DESC 
    LIMIT 3
");
$relatedPosts->execute(['id' => $id]);
$related = $relatedPosts->fetchAll();
$stmt = $pdo->query("SELECT * FROM services LIMIT 5");
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php
// SEO ديناميكي لكل مقال
$pageTitle       = htmlspecialchars($post['title']) . ' - مركز المشفى';
$canonicalUrl = 'https://www.elmashfa.com/blog/' . (int)$post['id'];
$pageDescription = !empty($post['excerpt'])
    ? htmlspecialchars(mb_substr($post['excerpt'], 0, 160))
    : htmlspecialchars(mb_substr(strip_tags($post['content'] ?? ''), 0, 160));
?>

<?php include 'includes/header.php'; ?>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": "<?php echo htmlspecialchars($post['title']); ?>",
  "description": "<?php echo $pageDescription; ?>",
  "image": "<?php echo $post['image'] ?: 'https://www.elmashfa.com/Upload/footer.webp'; ?>",
  "datePublished": "<?php echo date('c', strtotime($post['created_at'])); ?>",
  "dateModified": "<?php echo date('c', strtotime($post['created_at'])); ?>",
  "author": {
    "@type": "Organization",
    "name": "مركز المشفى"
  },
  "publisher": {
    "@type": "Organization",
    "name": "مركز المشفى",
    "logo": {
      "@type": "ImageObject",
      "url": "https://i.ibb.co/zVTHKPC6/Elmashfa-Logo.webp"
    }
  },
  "mainEntityOfPage": {
    "@type": "WebPage",
    "@id": "https://www.elmashfa.com/blog-post.php?id=<?php echo $post['id']; ?>"
  }
}
</script>
<body>
<div class="scroll-progress"></div>
    <div id="preloader">
        <div class="loader">
          <div class="loader-logo">
    <img src="https://i.ibb.co/zVTHKPC6/Elmashfa-Logo.webp" alt="مركز المشفى" loading="lazy">
</div>
            <p class="mt-3 text-white">مركز المشفى</p>
        </div>
    </div>
 <!-- ==================== Navebar SECTION Elgazar ==================== -->
 <?php include 'includes/navbar.php'; ?>
    <!-- محتوى المقال -->
    <section style="padding: 140px 0 60px;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <!-- تصنيف وتاريخ -->
                    <div class="mb-3">
                        <span class="badge" style="background: #C41E3A; font-size: 14px; padding: 8px 16px;">
                            <?php echo htmlspecialchars($post['category'] ?? 'عام'); ?>
                        </span>
                        <small class="text-muted me-3">
                            <i class="far fa-calendar-alt me-1"></i>
                            <?php echo date('d/m/Y', strtotime($post['created_at'])); ?>
                        </small>
                        <small class="text-muted">
                            <i class="far fa-eye me-1"></i>
                            <?php echo $post['views']; ?> مشاهدة
                        </small>
                    </div>
                    
                    <!-- عنوان المقال -->
                    <h1 style="font-weight: 800; font-size: 2.2rem; margin-bottom: 20px;">
                        <?php echo htmlspecialchars($post['title']); ?>
                    </h1>
                    
                    <!-- صورة المقال -->
                   <?php if (!empty($post['image'])): ?>
    <img src="<?php echo htmlspecialchars($post['image']); ?>" 
         alt="<?php echo htmlspecialchars($post['title']); ?>" 
         loading="lazy" 
         style="width: 100%; border-radius: 16px; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
<?php endif; ?>
                    
                    <!-- محتوى المقال -->
                    <div style="font-size: 1.1rem; line-height: 2; color: #495057;">
                        <?php echo nl2br(htmlspecialchars($post['content'] ?? $post['excerpt'] ?? '')); ?>
                    </div>
                    
                    <!-- مشاركة -->
                    <div style="margin-top: 40px; padding: 20px; background: #f8f9fa; border-radius: 16px; text-align: center;">
                        <h6>شارك المقال</h6>
                        <a href="https://wa.me/?text=<?php echo urlencode($post['title']); ?>" target="_blank" class="btn btn-success btn-sm mx-1">
                            <i class="fab fa-whatsapp"></i> واتساب
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode('http://localhost/almashfa/blog-post.php?id='.$post['id']); ?>" target="_blank" class="btn btn-primary btn-sm mx-1">
                            <i class="fab fa-facebook"></i> فيسبوك
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- مقالات ذات صلة -->
    <?php if (!empty($related)): ?>
    <section style="padding: 40px 0 80px; background: #f8f9fa;">
        <div class="container">
            <h3 class="text-center mb-4">مقالات ذات صلة</h3>
            <div class="row g-4">
                <?php foreach ($related as $r): ?>
                <div class="col-md-4">
                    <div class="blog-card">
                        <img src="<?php echo $r['image'] ?: 'https://placehold.co/600x400/e8e8e8/333333?text=مقال'; ?>" loading="lazy" alt="<?php echo htmlspecialchars($r['title']); ?>" class="blog-img">
                        <div class="blog-content">
                            <span class="blog-date"><i class="far fa-calendar-alt"></i> <?php echo date('d/m/Y', strtotime($r['created_at'])); ?></span>
                            <h4><?php echo htmlspecialchars($r['title']); ?></h4>
                            <a href="blog-post.php?id=<?php echo $r['id']; ?>" class="blog-link">اقرأ المزيد</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

  <?php include 'includes/footer.php'; ?>
  <?php include 'includes/footer_scripts.php'; ?>
</body>
</html>