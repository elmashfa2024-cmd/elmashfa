<?php
require_once 'config/settings.php';

// جلب كل الخدمات من قاعدة البيانات
$services = $pdo->query("SELECT * FROM services WHERE is_active = 1")->fetchAll();

// لو مفيش خدمات، نستخدم مصفوفة فاضية
if (empty($services)) $services = [];
?>
<?php
$pageTitle = "الخدمات - مركز المشفى";
$pageDescription = "خدمات علاجية متخصصة في مركز المشفى: علاج الإدمان، الصحة النفسية، الوسواس القهري، الاكتئاب، والاستشارات الأسرية. برامج فردية آمنة ونتائج مضمونة.";
?>

<?php include 'includes/header.php'; ?>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "name": "الرئيسية",
      "item": "https://www.elmashfa.com/"
    },
    {
      "@type": "ListItem",
      "position": 2,
      "name": "خدماتنا",
      "item": "https://www.elmashfa.com/services.php"
    }
  ]
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

     <?php

    ?>
    <a href="https://wa.me/<?php echo $whatsapp; ?>?text=<?php echo rawurlencode('السلام عليكم، أريد الاستفسار عن خدمات مركز المشفى'); ?>" class="whatsapp-float" target="_blank"><i class="fab fa-whatsapp fa-2x"></i></a>

    <div class="chat-float" id="chatToggle"><i class="fas fa-comment-medical fa-2x"></i></div>
    <div class="chat-box" id="chatBox">
        <div class="chat-header"><h6><i class="fas fa-comment-medical me-2"></i>استشارة سريعة</h6><i class="fas fa-times" id="chatClose"></i></div>
        <div class="chat-body"><div class="chat-message bot-message"><p>مرحباً بك في مركز المشفى. كيف يمكننا مساعدتك اليوم؟</p></div></div>
        <div class="chat-footer"><input type="text" class="form-control" placeholder="اكتب رسالتك هنا..."><button class="btn btn-send"><i class="fas fa-paper-plane"></i></button></div>
    </div>

     <!-- ==================== Navebar SECTION Elgazar ==================== -->
 <?php include 'includes/navbar.php'; ?>
   <section class="hero-section" id="home">

    <!-- Background -->
    <div class="hero-overlay"></div>

    <!-- Content -->
    <div class="hero-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">

                    <!-- Badge -->
                    <span class="section-badge bg-white bg-opacity-25 text-white">
                        خدماتنا المتكاملة
                    </span>

                    <!-- Title -->
                    <h1 class="page-hero-title">
                        نقدم لك رعاية نفسية <span class="text-gradient">شاملة ومتكاملة</span>
                    </h1>

                    <!-- Subtitle -->
                    <p class="page-hero-subtitle">
                        مجموعة متكاملة من الخدمات العلاجية المصممة خصيصاً لتلبية احتياجاتك الفردية
                    </p>

                </div>
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

    <!-- عرض الخدمات التفصيلية -->
    <?php if (!empty($services)): ?>
        <?php $counter = 0; foreach ($services as $service): $counter++; ?>
        <section class="service-detail <?php echo ($counter % 2 == 0) ? 'bg-light' : ''; ?>" id="service-<?php echo $service['id']; ?>">
            <div class="container">
                <div class="row align-items-center g-5"
     data-aos="fade-up">
                    <div class="col-lg-6 <?php echo ($counter % 2 != 0) ? 'order-lg-2' : ''; ?>" >
                        <div class="service-detail-image">
                            <img src="<?php echo $service['image'] ?: 'https://images.unsplash.com/photo-1582719471384-894fbb4cce3d?w=800&q=80'; ?>" loading="lazy" alt="<?php echo htmlspecialchars($service['title']); ?>" class="service-img-main">
                            <div class="service-img-badge">
                                <i class="fas fa-shield-alt"></i> خدمة متخصصة
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 <?php echo ($counter % 2 != 0) ? 'order-lg-1' : ''; ?>" >
                        <span class="section-badge">الخدمة رقم <?php echo $counter; ?></span>
                        <h2 class="section-title"><?php echo htmlspecialchars($service['title']); ?></h2>
                        <p class="service-description"><?php echo nl2br(htmlspecialchars($service['description'])); ?></p>
                        
                        <div class="treatment-steps mt-4">
                            <h5><i class="fas fa-list-ol me-2"></i>خطوات العلاج:</h5>
                            <div class="step-item">
                                <div class="step-dot">1</div>
                                <div><strong>التقييم والتشخيص</strong><p>جلسة تقييم شاملة لتحديد حالتك وخطة العلاج المناسبة</p></div>
                            </div>
                            <div class="step-item">
                                <div class="step-dot">2</div>
                                <div><strong>بدء العلاج</strong><p>جلسات علاجية فردية وجماعية حسب خطتك العلاجية</p></div>
                            </div>
                            <div class="step-item">
                                <div class="step-dot">3</div>
                                <div><strong>التأهيل والمتابعة</strong><p>برامج تأهيل ومتابعة دورية لضمان التعافي الكامل</p></div>
                            </div>
                        </div>
                        
                        <a href="booking.php?service_id=<?php echo $service['id']; ?>" class="btn btn-primary-custom btn-lg mt-4">
                            <i class="fas fa-calendar-check me-2"></i>احجز استشارة  
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <?php endforeach; ?>
    <?php else: ?>
        <section class="text-center py-5">
            <h3>لا توجد خدمات متاحة حالياً</h3>
            <p>يرجى التواصل معنا لمزيد من المعلومات</p>
        </section>
    <?php endif; ?>

    <!-- FAQ Section -->
   <section class="faq-section" style="padding: 80px 0; background: #f9f9f9;">
  <div class="container">
    <div class="section-header text-center mb-5">
      <span class="section-badge" style="font-size:1rem; color:#d32f2f;">أسئلة شائعة</span>
      <h2 class="section-title" style="font-weight:700; font-size:2rem; margin-top:10px;">
        كل ما تريد <span class="text-primary-custom">معرفته</span>
      </h2>
      <p style="color:#555; margin-top:10px;">إليك أهم الأسئلة التي يطرحها عملاؤنا والإجابات عليها.</p>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-8">
        
        <div class="faq-item mb-4" style="background:white; border-radius:10px; padding:25px; box-shadow:0 4px 10px rgba(0,0,0,0.05);">
          <h5 style="font-weight:600; color:#d32f2f; margin-bottom:10px;">
            <i class="fas fa-question-circle me-2"></i>هل العلاج سري 100%؟
          </h5>
          <p style="color:#555; line-height:1.7; margin-left:25px;">نعم، الخصوصية والسرية التامة هي من أهم أولوياتنا. جميع معلوماتك وملفاتك الطبية محمية بالكامل.</p>
        </div>

        <div class="faq-item mb-4" style="background:white; border-radius:10px; padding:25px; box-shadow:0 4px 10px rgba(0,0,0,0.05);">
          <h5 style="font-weight:600; color:#d32f2f; margin-bottom:10px;">
            <i class="fas fa-question-circle me-2"></i>كم مدة برنامج العلاج؟
          </h5>
          <p style="color:#555; line-height:1.7; margin-left:25px;">تختلف مدة العلاج حسب حالة كل مريض. نقدم برامج تتراوح من 28 يوماً إلى 90 يوماً وأكثر.</p>
        </div>

        <div class="faq-item mb-4" style="background:white; border-radius:10px; padding:25px; box-shadow:0 4px 10px rgba(0,0,0,0.05);">
          <h5 style="font-weight:600; color:#d32f2f; margin-bottom:10px;">
            <i class="fas fa-question-circle me-2"></i>ما هي طرق الدفع المتاحة؟
          </h5>
          <p style="color:#555; line-height:1.7; margin-left:25px;">نوفر طرق دفع متعددة: الدفع النقدي، التحويل البنكي، وفودافون كاش مع خطط دفع مرنة.</p>
        </div>

        <div class="faq-item mb-4" style="background:white; border-radius:10px; padding:25px; box-shadow:0 4px 10px rgba(0,0,0,0.05);">
          <h5 style="font-weight:600; color:#d32f2f; margin-bottom:10px;">
            <i class="fas fa-question-circle me-2"></i>هل يمكن للعائلة الزيارة أثناء العلاج؟
          </h5>
          <p style="color:#555; line-height:1.7; margin-left:25px;">نعم، نؤمن بأهمية دعم الأسرة. نوفر برامج زيارة عائلية منظمة ضمن الخطة العلاجية.</p>
        </div>

      </div>
    </div>
  </div>
</section>

<section class="cta-banner" style="padding:60px 0; background:#d32f2f; color:white; text-align:center;">
  <div class="container">
    <h2 style="font-weight:700; font-size:2rem;">مستعد تبدأ رحلة التعافي؟</h2>
    <p style="margin-top:10px; font-size:1.1rem;">فريقنا الطبي جاهز لاستقبالك على مدار الساعة</p>
    <div class="cta-buttons" style="margin-top:25px;">
      <a href="tel:<?php echo $phone; ?>" class="btn" style="background:white; color:#d32f2f; padding:12px 25px; border-radius:8px; font-weight:600; margin-right:10px;">
        <i class="fas fa-phone-alt me-2"></i>اتصل بنا الآن
      </a>
      <a href="booking.php" class="btn" style="border:2px solid white; color:white; padding:12px 25px; border-radius:8px; font-weight:600;">
        <i class="fas fa-calendar-check me-2"></i>احجز موعدك
      </a>
    </div>
  </div>
</section>
  <?php include 'includes/footer.php'; ?>
    
<?php include 'includes/footer_scripts.php'; ?>
<!-- Schema Markup for FAQ -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [
        {
    "@type": "Question",
    "name": "هل يمكن زيارة المركز بدون حجز مسبق؟",
    "acceptedAnswer": {
        "@type": "Answer",
        "text": "يُفضل الحجز المسبق لضمان توفر الطبيب في الوقت المناسب. يمكن التواصل معنا على مدار الساعة عبر الهاتف أو واتساب لتحديد موعد فوري."
    }
},
        {
            "@type": "Question",
            "name": "كم مدة برنامج العلاج؟",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "تختلف مدة العلاج حسب حالة كل مريض. نقدم برامج تتراوح من 28 يوماً إلى 90 يوماً وأكثر."
            }
        }
    ]
}
</script>
</body>
</html>