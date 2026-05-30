<?php
require_once 'config/settings.php';

// جلب المقالات المنشورة
$posts = $pdo->query("SELECT * FROM blog_posts WHERE is_published = 1 ORDER BY created_at DESC")->fetchAll();
if (empty($posts)) $posts = [];

// جلب التصنيفات المختلفة
$categories = $pdo->query("SELECT DISTINCT category FROM blog_posts WHERE is_published = 1 AND category IS NOT NULL")->fetchAll(PDO::FETCH_COLUMN);

?>
<?php
$pageTitle = "المدونه - مركز المشفى";
$pageDescription = "مدونة مركز المشفى - أحدث المقالات والنصائح الطبية عن علاج الإدمان والصحة النفسية من نخبة الأطباء المتخصصين. اقرأ وتعلم كيف تبدأ رحلة التعافي.";;
?>
<?php
$stmt = $pdo->query("SELECT * FROM services LIMIT 5");
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php include 'includes/header.php'; ?>
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
   <section class="hero-section" id="home">

    <!-- Background -->
    <div class="hero-overlay"></div>

    <!-- Content -->
    <div class="hero-content">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <span class="section-badge bg-white bg-opacity-25 text-white">المدونة الطبية</span>
                    <h1 class="page-hero-title">أحدث المقالات <span class="text-gradient">والنصائح الطبية</span></h1>
                    <p class="page-hero-subtitle">معلومات موثوقة ونصائح قيمة من فريقنا الطبي المتخصص</p>
                </div>
            </div>
        </div>
          <div class="hero-wave">
   <svg xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 1440 320">
      <path fill="#fff"
      fill-opacity="1"
      d="M0,192L80,202.7C160,213,320,235,480,218.7C640,203,800,149,960,133.3C1120,117,1280,139,1360,149.3L1440,160L1440,320L0,320Z"></path>
   </svg>
</div>
    </section>

    <section class="blog-full-section">
        <div class="container">
            <!-- شريط البحث والتصنيفات -->
            <div class="blog-toolbar mb-4" data-aos="fade-up">
                <div class="row align-items-center">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <div class="search-box">
                            <input type="text" class="form-control" id="blogSearch" placeholder="ابحث في المقالات..." onkeyup="filterPosts()">
                            <button><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="blog-categories">
                            <a  class="cat-btn active" onclick="filterByCategory('all', this)">الكل</a>
                            <?php foreach ($categories as $cat): ?>
                            <a  class="cat-btn" onclick="filterByCategory('<?php echo htmlspecialchars($cat); ?>', this)"><?php echo htmlspecialchars($cat); ?></a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- عرض المقالات -->
            <div class="row g-4" id="blogGrid">
                <?php if (!empty($posts)): ?>
                    <?php foreach ($posts as $post): ?>
                    <div class="col-lg-4 col-md-6 blog-item" data-category="<?php echo htmlspecialchars($post['category'] ?? 'عام'); ?>" data-aos="fade-up">
                        <article class="blog-card-full">
                            <div class="blog-img-wrapper">
                                <img src="<?php echo $post['image'] ?: 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?w=600&q=80'; ?>" loading="lazy" alt="<?php echo htmlspecialchars($post['title']); ?>">
                                <span class="blog-category-tag"><?php echo htmlspecialchars($post['category'] ?? 'عام'); ?></span>
                            </div>
                            <div class="blog-card-content">
                                <div class="blog-meta">
                                    <span><i class="far fa-calendar-alt"></i> <?php echo date('d/m/Y', strtotime($post['created_at'])); ?></span>
                                    <span><i class="far fa-eye"></i> <?php echo $post['views']; ?> مشاهدة</span>
                                </div>
                                <h4><?php echo htmlspecialchars($post['title']); ?></h4>
                                <p><?php echo htmlspecialchars($post['excerpt'] ?? substr(strip_tags($post['content']), 0, 120) . '...'); ?></p>
                                <a href="blog-post.php?id=<?php echo $post['id']; ?>" class="blog-read-more">اقرأ المقال كاملاً <i class="fas fa-arrow-left"></i></a>
                            </div>
                        </article>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                        <h4>لا توجد مقالات منشورة حالياً</h4>
                        <p>تابعنا قريباً لمقالات جديدة</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

  <?php include 'includes/footer.php'; ?>

    <script>
        
        // فلترة المقالات
        function filterByCategory(category, btn) {
            document.querySelectorAll('.cat-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            
            document.querySelectorAll('.blog-item').forEach(item => {
                if (category === 'all' || item.getAttribute('data-category') === category) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }
        
        function filterPosts() {
            const query = document.getElementById('blogSearch').value.toLowerCase();
            document.querySelectorAll('.blog-item').forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(query) ? 'block' : 'none';
            });
        }
    </script>
    <?php include 'includes/footer_scripts.php'; ?>
</body>
