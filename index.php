<?php
/**
 * الصفحة الرئيسية - مركز المشفى للطب النفسي وعلاج الإدمان
 * Dynamic Version - تستخرج البيانات من قاعدة البيانات
 */

// 1. الاتصال بقاعدة البيانات
require_once 'config/settings.php';

// 2. جلب الإحصائيات الحية من قاعدة البيانات
try {
    // عدد سنوات الخبرة (من settings.php)
    // $experience already loaded by config/settings.php
    
    // عدد الحالات التي تم علاجها = عدد الحجوزات المكتملة
    $stmt = $pdo->query("SELECT COUNT(*) FROM appointments WHERE status = 'completed'");
    $treatedCases = $stmt->fetchColumn() ?: '1000';
    
    // عدد الأطباء النشطين
    $stmt = $pdo->query("SELECT COUNT(*) FROM doctors WHERE is_active = 1");
    $activeDoctors = $stmt->fetchColumn() ?: '25';
    
    // نسبة النجاح (من settings.php)
    $successRate = $success_rate;
    
} catch(PDOException $e) {
    // لو حصل خطأ، نستخدم قيم افتراضية
    $experience = '10';
    $treatedCases = '1000';
    $activeDoctors = '25';
    $successRate = '95';
}

// 3. جلب الخدمات من قاعدة البيانات
try {
    $services = $pdo->query("SELECT * FROM services WHERE is_active = 1")->fetchAll();
} catch(PDOException $e) {
    $services = [];
}

// 4. جلب أحدث المقالات
try {
    $blogPosts = $pdo->query("SELECT * FROM blog_posts WHERE is_published = 1 ORDER BY created_at DESC LIMIT 3")->fetchAll();
} catch(PDOException $e) {
    $blogPosts = [];
}

// 5. جلب تقييمات المتعافين (آخر 3 حجوزات مكتملة)
try {
    $testimonials = $pdo->query("
        SELECT patient_name, notes, created_at 
        FROM appointments 
        WHERE status = 'completed' AND notes IS NOT NULL 
        ORDER BY created_at DESC LIMIT 3
    ")->fetchAll();
} catch(PDOException $e) {
    $testimonials = [];
}
?>

<?php
$pageTitle = "مركز المشفى | أفضل مركز لعلاج الإدمان والطب النفسي في قويسنا المنوفية";;
$pageDescription = "مركز المشفى - أفضل مركز لعلاج الإدمان والصحة النفسية في مصر. نقدم برامج علاجية متكاملة بإشراف أفضل الأطباء النفسيين. استشارة سرية وتقييم مجاني. اتصل بنا الآن 24/7";
?>

<?php include 'includes/header.php'; ?>

<body>
<div class="scroll-progress"></div>
    <!-- Preloader -->
    <div id="preloader">
        <div class="loader">
          <div class="loader-logo">
    <img src="https://i.ibb.co/zVTHKPC6/Elmashfa-Logo.webp" alt="مركز المشفى" loading="lazy" fetchpriority="high">
</div>
            <p class="mt-3 text-white">مركز المشفى</p>
        </div>
    </div>

 

    <!-- Live Chat Toggle -->
    <div class="chat-float" id="chatToggle">
        <i class="fas fa-comment-medical fa-2x"></i>
    </div>
   <a href="https://wa.me/<?php echo $whatsapp; ?>?text=<?php echo rawurlencode('السلام عليكم، أريد الاستفسار عن خدمات مركز المشفى'); ?>" class="whatsapp-float" target="_blank">
        <i class="fab fa-whatsapp fa-2x"></i>
    </a>
    <!-- Live Chat Box -->
    <div class="chat-box" id="chatBox">
        <div class="chat-header">
            <h6><i class="fas fa-comment-medical me-2"></i>استشارة سريعة</h6>
            <i class="fas fa-times" id="chatClose"></i>
        </div>
        <div class="chat-body">
            <div class="chat-message bot-message">
                <p>مرحباً بك في مركز المشفى. كيف يمكننا مساعدتك اليوم؟</p>
            </div>
            <div class="chat-message bot-message">
                <p>جميع استشاراتنا بسرية تامة ومجانية.</p>
            </div>
        </div>
        <div class="chat-footer">
            <input type="text" class="form-control" placeholder="اكتب رسالتك هنا..."></input>
            <button class="btn btn-send"><i class="fas fa-paper-plane"></i></button>
        </div>
    </div>
    <!-- ==================== Navebar SECTION Elgazar ==================== -->
 <?php include 'includes/navbar.php'; ?>
     <!-- ==================== HERO SECTION ==================== -->
    <!-- ==================== HERO SECTION ==================== -->
 <section class="hero-section" id="home">
    <div class="hero-overlay"></div>

    <div class="hero-content">
        <div class="container">
            <div class="row align-items-center min-vh-100">
                <div class="col-lg-8 mx-auto text-center">

                    <!-- Badge -->
                    <div class="hero-badge" data-aos="fade-down" data-aos-duration="1000">
                     
                        <span>
                                <span>🏥
                                    مركز
                                المشفي للطب النفسي وعلاج الادمان</span>
                             خبرة <?php echo $experience; ?> عاماً في الطب النفسي</span>
                    </div>

                    <!-- Title -->
                 <h1 class="hero-title">
    أفضل مركز لعلاج الإدمان والطب النفسي<br>
    <span class="text-gradient">في قويسنا والمنوفية</span>
</h1>

                    <!-- Subtitle -->
                    <p class="hero-subtitle" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                        مركز المشفى للطب النفسي وعلاج الإدمان - نقدم لك رعاية نفسية متكاملة تحت إشراف نخبة من أمهر الأطباء المتخصصين في مصر والمنوفية والوطن العربي
                    </p>
                     <p class="hero-subtitle" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
               شفاؤك يبدأ من هنا بسريه وامان تامين
                    </p>
<div class="hero-features" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="800">
                        <div class="hero-feature-item">
                            <i class="fas fa-shield-alt"></i>
                            <span>سرية تامة</span>
                        </div>
                        <div class="hero-feature-item">
                            <i class="fas fa-user-md"></i>
                            <span>أطباء متخصصون</span>
                        </div>
                        <div class="hero-feature-item">
                            <i class="fas fa-clock"></i>
                            <span>دعم 24/7</span>
                        </div>
                    </div>
                    <!-- Buttons -->
                    <div class="hero-buttons" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="600">
                        <a href="booking.php#booking-form" class="btn btn-primary-custom btn-lg">
                            <i class="fas fa-calendar-check me-2"></i>احجز استشارتك الآن
                        </a>
                        <a href="tel:<?php echo $phone; ?>" class="btn btn-outline-custom btn-lg">
                            <i class="fas fa-phone-alt me-2"></i>اتصل بنا
                        </a>
                    </div>

                    <!-- Features -->
                    

                </div>
            </div>
        </div>
    </div>

    <!-- Hero Wave -->
    <div class="hero-wave">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#ffffff" fill-opacity="1" d="M0,160L48,176C96,192,192,224,288,213.3C384,203,480,149,576,138.7C672,128,768,160,864,181.3C960,203,1056,213,1152,197.3C1248,181,1344,139,1392,117.3L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </div>
</section>

    <!-- ==================== STATS COUNTER ==================== -->
    <section class="stats-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-duration="800">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-calendar-alt"></i></div>
                        <div class="stat-number counter" data-target="<?php echo $experience; ?>">0</div>
                        <div class="stat-label">عاماً من الخبرة</div>
                    </div>
                </div>
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-user-check"></i></div>
                       <div class="stat-number counter" data-target="<?php echo $treatedCases; ?>">0</div>
                        <div class="stat-label">حالة تم علاجها</div>
                    </div>
                </div>
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-user-md"></i></div>
                        <div class="stat-number counter" data-target="<?php echo $activeDoctors; ?>">0</div>
                        <div class="stat-label">طبيب متخصص</div>
                    </div>
                </div>
                <div class="col-md-3 col-6" data-aos="fade-up" data-aos-duration="800" data-aos-delay="300">
                    <div class="stat-card">
                        <div class="stat-icon"><i class="fas fa-star"></i></div>
                        <div class="stat-number counter" data-target="<?php echo $successRate; ?>">0</div>
                        <div class="stat-label">% نسبة النجاح</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== SERVICES SECTION ==================== -->
    <section class="services-section" id="services">
        <div class="container">
            <div class="section-header text-center" data-aos="fade-up">
                <span class="section-badge">خدماتنا</span>
                <h2 class="section-title">نقدم لك رعاية نفسية <span class="text-primary-custom">متكاملة</span></h2>
                <p class="section-subtitle">مجموعة شاملة من الخدمات العلاجية تحت سقف واحد لضمان راحتك وسرعة تعافيك</p>
            </div>
            <div class="row g-4">
                <?php if (!empty($services)): ?>
                    <?php foreach ($services as $service): ?>
                    <div class="col-lg-4 col-md-6" data-aos="fade-up">
                        <div class="service-card">
                            <div class="service-icon"><i class="fas <?php echo $service['icon'] ?? 'fa-capsules'; ?>"></i></div>
                            <h4><?php echo htmlspecialchars($service['title']); ?></h4>
                            <p><?php echo htmlspecialchars($service['description']); ?></p>
                            <a href="services.php#service-<?php echo $service['id']; ?>" class="service-link">اعرف خطه العلاج  <i class="fas fa-arrow-left"></i></a>
                            
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center">لا توجد خدمات متاحة حالياً</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- ==================== CTA BANNER ==================== -->
    <section class="cta-banner" data-aos="fade-up">
        <div class="container text-center">
            <h2>هل تحتاج مساعدة عاجلة؟</h2>
            <p>فريقنا الطبي متواجد على مدار الساعة لمساعدتك بسرية تامة</p>
            <div class="cta-buttons">
                <a href="tel:<?php echo $phone; ?>" class="btn btn-primary-custom btn-lg">
                    <i class="fas fa-phone-alt me-2"></i>اتصل بنا الآن
                </a>
                <a href="booking.php" class="btn btn-outline-custom btn-lg">
                    <i class="fas fa-calendar-check me-2"></i>احجز استشارة مجانية
                </a>
            </div>
        </div>
    </section>
<!-- ==================== شهادات المرضى SECTION ==================== -->
<section class="testimonials-section" style="padding: 80px 0; background: #f8f9fa;">
    <div class="container">
        <div class="section-header text-center mb-5">
            <span class="section-badge" style="background: #d32f2f20; color: #d32f2f; padding: 8px 20px; border-radius: 50px; font-size: 14px;">
                <i class="fas fa-quote-right me-2"></i>قصص نجاح حقيقية
            </span>
            <h2 class="section-title" style="font-size: 2.5rem; margin-top: 15px;">
                ماذا قال <span style="color: #d32f2f;">مرضانا</span> عنا؟
            </h2>
            <p style="color: #666; margin-top: 10px;">نفخر بثقة مرضانا ونجاح رحلة تعافيهم معنا</p>
        </div>

        <div class="row">
            <!-- شهادة 1 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="testimonial-card" style="background: white; border-radius: 15px; padding: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); height: 100%;">
                    <div class="quote-icon" style="color: #d32f2f; font-size: 40px; margin-bottom: 20px;">
                        <i class="fas fa-quote-right"></i>
                    </div>
                    <p class="testimonial-text" style="color: #555; line-height: 1.8; font-size: 16px;">
                        "كنت أعاني من إدمان المخدرات لمدة 5 سنوات. بفضل الله ثم فريق مركز المشفى، تمكنت من التعافي الكامل. العلاج كان متكاملاً والدعم النفسي رائع. شكراً لكم على فرصة الحياة الجديدة."
                    </p>
                    <div class="testimonial-author" style="margin-top: 20px;">
                        <h5 style="font-weight: 700; margin-bottom: 5px;">أحمد م.</h5>
                        <p style="color: #888; font-size: 14px;">متعافي من الإدمان</p>
                        <div class="stars" style="color: #ffc107;">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- شهادة 2 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="testimonial-card" style="background: white; border-radius: 15px; padding: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); height: 100%;">
                    <div class="quote-icon" style="color: #d32f2f; font-size: 40px; margin-bottom: 20px;">
                        <i class="fas fa-quote-right"></i>
                    </div>
                    <p class="testimonial-text" style="color: #555; line-height: 1.8; font-size: 16px;">
                        "عانيت من الاكتئاب لسنوات وجربت مراكز كثيرة. مركز المشفى كان مختلفاً من ناحية الاهتمام والاحترافية. الأطباء فهموا حالتي وقدموا لي خطة علاج غيرت حياتي 180 درجة."
                    </p>
                    <div class="testimonial-author" style="margin-top: 20px;">
                        <h5 style="font-weight: 700; margin-bottom: 5px;">سارة ر.</h5>
                        <p style="color: #888; font-size: 14px;">تحسنت من الاكتئاب</p>
                        <div class="stars" style="color: #ffc107;">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- شهادة 3 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="testimonial-card" style="background: white; border-radius: 15px; padding: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); height: 100%;">
                    <div class="quote-icon" style="color: #d32f2f; font-size: 40px; margin-bottom: 20px;">
                        <i class="fas fa-quote-right"></i>
                    </div>
                    <p class="testimonial-text" style="color: #555; line-height: 1.8; font-size: 16px;">
                        "والدي كان يعاني من الوسواس القهري الشديد. بعد العلاج في مركز المشفى، تحسنت حالته بشكل كبير. الفريق كان محترماً جداً ويتعامل مع المريض بكرامة واحترام. أنصح أي حد بالعلاج عندهم."
                    </p>
                    <div class="testimonial-author" style="margin-top: 20px;">
                        <h5 style="font-weight: 700; margin-bottom: 5px;">محمد خ.</h5>
                        <p style="color: #888; font-size: 14px;">ابن أحد المرضى</p>
                        <div class="stars" style="color: #ffc107;">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- زر عرض المزيد -->
        <div class="text-center mt-4">
            <a href="#" class="btn" style="background: #d32f2f; color: white; padding: 12px 30px; border-radius: 50px; text-decoration: none;">
                <i class="fas fa-comments me-2"></i>اقرأ المزيد من قصص النجاح
            </a>
        </div>
    </div>
</section>

<style>
.testimonial-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.testimonial-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.1) !important;
}
</style>
    <!-- ==================== BLOG PREVIEW ==================== -->
    <section class="blog-section" id="blog">
        <div class="container">
            <div class="section-header text-center" data-aos="fade-up">
                <span class="section-badge">المدونة الطبية</span>
                <h2 class="section-title">أحدث <span class="text-primary-custom">المقالات والنصائح</span></h2>
            </div>
            <div class="row g-4">
                <?php if (!empty($blogPosts)): ?>
                    <?php foreach ($blogPosts as $post): ?>
                    <div class="col-md-4" data-aos="fade-up">
                        <div class="blog-card">
                            <img src="<?php echo $post['image'] ?: 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?w=600&q=80'; ?>" loading="lazy" alt="<?php echo htmlspecialchars($post['title']); ?>" class="blog-img">
                            <div class="blog-content">
                                <span class="blog-date"><i class="far fa-calendar-alt"></i> <?php echo date('d M Y', strtotime($post['created_at'])); ?></span>
                                <h4><?php echo htmlspecialchars($post['title']); ?></h4>
                                <p><?php echo htmlspecialchars($post['excerpt'] ?? substr($post['content'], 0, 100) . '...'); ?></p>
                                <a href="blog.php?id=<?php echo $post['id']; ?>" class="blog-link">اقرأ المزيد</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center">لا توجد مقالات منشورة حالياً</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

   <?php include 'includes/footer.php'; ?>

    <!-- Bootstrap JS -->
    <!-- AOS Animation JS -->
    <!-- Custom JS -->
    <?php include 'includes/footer_scripts.php'; ?>
</body>