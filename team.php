<?php
require_once 'config/settings.php';

// جلب الأطباء من قاعدة البيانات
$doctors = $pdo->query("SELECT * FROM doctors WHERE is_active = 2 ORDER BY rating DESC")->fetchAll();
if (empty($doctors)) $doctors = [];
?>
<?php
$pageTitle = "الفريق الاداري - مركز المشفى";
$pageDescription = "تعرّف على المؤسسين والمديرين في مركز المشفى للطب النفسي وعلاج الإدمان بقويسنا. فريق إداري محترف يضمن أعلى معايير الرعاية والسرية لكل مريض.";
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

    <?php

    ?>
    <a href="https://wa.me/<?php echo $whatsapp; ?>?text=<?php echo rawurlencode('السلام عليكم، أريد الاستفسار عن خدمات مركز المشفى'); ?>" class="whatsapp-float" target="_blank"><i class="fab fa-whatsapp fa-2x"></i></a>

     <!-- ==================== Navebar SECTION Elgazar ==================== -->
 <?php include 'includes/navbar.php'; ?>

     <section class="hero-section" id="home">

    <!-- Background -->
    <div class="hero-overlay"></div>

    <!-- Content -->
    <div class="hero-content">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <span class="section-badge bg-white bg-opacity-25 text-white">المديرين والمؤسسين</span>
                    <h1 class="page-hero-title"> المؤسسين <span class="text-gradient"> والمديرين </span></h1>
                    <p class="page-hero-subtitle">الاداره @ مركز المشفي </p>
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

    <!-- عرض الأطباء -->
    <section class="team-grid-section">
        <div class="container">
            <?php if (!empty($doctors)): ?>
                <!-- الطبيب الأول (المدير) - كرت مميز -->
                <?php $director = $doctors[0]; ?>
                <div class="director-card mb-5" data-aos="fade-up">
                    <div class="row align-items-center g-0">
                        <div class="col-lg-4">
                            <div class="director-image-wrapper">
                                <img src="<?php echo $director['image'] ?: 'https://placehold.co/500x600/1a1a2e/ffffff?text=Dr'; ?>" loading="lazy" alt="<?php echo htmlspecialchars($director['name']); ?>" class="director-img">
                                <div class="director-badge"><i class="fas fa-star"></i> مدير الفريق العلاجي</div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="director-content">
                               
                                <h2 class="director-name"><?php echo htmlspecialchars($director['name']); ?></h2>
                                <p class="director-title"><?php echo htmlspecialchars($director['specialty']); ?></p>
                                 <span class="section-badge" style="color: #C41E3A !important; background: transparent !important;">مدير الفريق العلاجي والمؤسس</span>
                                <div class="director-stats">
								
                                    <div class="director-stat"><span class="stat-num"><?php echo $director['rating']; ?></span><span class="stat-lbl">التقييم</span></div>
                                </div>
								
                                <p class="director-bio">
								
								<?php echo nl2br(htmlspecialchars($director['bio'] ?? 'خبرة واسعة في مجال الطب النفسي وعلاج الإدمان.')); ?></p>
                                <div class="director-actions">
									<a href="tel:<?php echo $footerPhone2; ?>" class="btn btn-primary-custom">
								        <?php echo $footerPhone2; ?>
										<i class="fa-solid fa-mobile-screen-button me-2"></i>
                                    </a>
                                    <a href="booking.php?doctor_id=<?php echo $director['id']; ?>" class="btn btn-primary-custom">
                                        <i class="fas fa-calendar-check me-2"></i>احجز مع الدكتور
                                    </a>
                                </div>
                            </div>
                        </div>
						
                    </div>
                </div>

                <!-- باقي الأطباء -->
              <?php else: ?>
                <p class="text-center py-5">لا يوجد أطباء متاحين حالياً</p>
            <?php endif; ?>
        </div>
		  <div class="container">
            <?php if (!empty($doctors)): ?>
                <!-- الطبيب الأول (المدير) - كرت مميز -->
                <?php $director = $doctors[1]; ?>
                <div class="director-card mb-5" data-aos="fade-up">
                    <div class="row align-items-center g-0">
                        <div class="col-lg-4">
                            <div class="director-image-wrapper">
                                <img src="<?php echo $director['image'] ?: 'https://placehold.co/500x600/1a1a2e/ffffff?text=Dr'; ?>" loading="lazy" alt="<?php echo htmlspecialchars($director['name']); ?>" class="director-img">
                                <div class="director-badge"><i class="fas fa-star"></i> مدير الفريق العلاجي</div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="director-content">
                            
                                <h2 class="director-name"><?php echo htmlspecialchars($director['name']); ?></h2>
                                <p class="director-title"><?php echo htmlspecialchars($director['specialty']); ?></p>
                                    <span class="section-badge" style="color: #C41E3A !important; background: transparent !important;">مدير الفريق العلاجي والمؤسس</span>
                                <div class="director-stats">
                                    <div class="director-stat"><span class="stat-num"><?php echo $director['rating']; ?></span><span class="stat-lbl">التقييم</span></div>
                                </div>
                                <p class="director-bio"><?php echo nl2br(htmlspecialchars($director['bio'] ?? 'خبرة واسعة في مجال الطب النفسي وعلاج الإدمان.')); ?></p>
                                <div class="director-actions">
								
								
							<a href="tel:<?php echo $footerPhone; ?>" class="btn btn-primary-custom">
								        <?php echo $footerPhone; ?>
										<i class="fa-solid fa-mobile-screen-button me-2"></i>
                                    </a>
								 
                                    <a href="booking.php?doctor_id=<?php echo $director['id']; ?>" class="btn btn-primary-custom">
								        <i class="fas fa-calendar-check me-2"></i>احجز مع الدكتور
                                    </a>
                                </div>
                            </div>
                        </div>
						
                    </div>
                </div>

                <!-- باقي الأطباء -->
              <?php else: ?>
                <p class="text-center py-5">لا يوجد أطباء متاحين حالياً</p>
            <?php endif; ?>
        </div>
		
 
    </section>

    <section class="cta-banner" data-aos="fade-up">
        <div class="container text-center">
            <h2>هل أنت مستعد للقاء فريقنا؟</h2>
            <p>اختر الدكتور المناسب لك وابدأ رحلة التعافي بكل ثقة وأمان</p>
            <a href="booking.php" class="btn btn-primary-custom btn-lg"><i class="fas fa-calendar-check me-2"></i>احجز موعدك الآن</a>
        </div>
    </section>

  <?php include 'includes/footer.php'; ?>

    <script>AOS.init({ duration: 800, once: true });</script>
    <?php include 'includes/footer_scripts.php'; ?>
</body>