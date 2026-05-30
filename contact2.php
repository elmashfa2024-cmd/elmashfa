<?php
session_start();
require_once 'config/csrf.php';
require_once 'config/settings.php';
$csrf_token = csrf_generate();

// جلب الأطباء من قاعدة البيانات
$doctors = $pdo->query("SELECT * FROM doctors WHERE is_active = 1 ORDER BY rating DESC")->fetchAll();
if (empty($doctors)) $doctors = [];
?>
<?php
$pageTitle = "الرئيسية - مركز المشفى";
$pageDescription = "مركز المشفى للطب النفسي وعلاج الإدمان";
?>

<?php include 'includes/header.php'; ?>
<body>

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

     <section class="page-hero">
        <div class="page-hero-overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <span class="section-badge bg-white bg-opacity-25 text-white">اتصل بنا</span>
                    <h1 class="page-hero-title">نحن هنا  <span class="text-gradient">لمساعدتك</span></h1>
                    <p class="page-hero-subtitle">ا تتردد في التواصل معنا. فريقنا جاهز للرد على استفساراتك على مدار الساعة بكل سرية</p>
                </div>
            </div>
        </div>
      
    </section>
    <section class="contact-section">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-5" data-aos="fade-left">
                    <h3 class="mb-4">معلومات التواصل</h3>
                    
                    <div class="contact-info-card">
                        <div class="contact-icon"><i class="fas fa-phone-alt"></i></div>
                        <div><h6>اتصل بنا</h6><a href="tel:<?php echo $phone; ?>"><?php echo $phone; ?></a></div>
                    </div>
                    <div class="contact-info-card">
                        <div class="contact-icon"><i class="fab fa-whatsapp"></i></div>
                        <div><h6>واتساب</h6><a href="https://wa.me/<?php echo $whatsapp; ?>" target="_blank">تواصل عبر الواتساب</a><small class="text-muted">رد فوري على مدار الساعة</small></div>
                    </div>
                    <div class="contact-info-card">
                        <div class="contact-icon"><i class="fas fa-envelope"></i></div>
                        <div><h6>البريد الإلكتروني</h6><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></div>
                    </div>
                    <div class="contact-info-card">
                        <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <div><h6>العنوان</h6><span><?php echo $address; ?></span></div>
                    </div>
                    <div class="contact-info-card">
                        <div class="contact-icon"><i class="fas fa-clock"></i></div>
                        <div><h6>مواعيد العمل</h6><span>متاح 24 ساعة / 7 أيام</span><small class="text-muted">نستقبل اتصالات الطوارئ في أي وقت</small></div>
                    </div>

                    <div class="emergency-banner mt-4">
                        <i class="fas fa-exclamation-triangle"></i>
                        <div>
                            <strong>حالة طارئة؟</strong>
                            <p class="mb-0">إذا كنت تفكر في إيذاء نفسك، اتصل بنا فوراً:</p>
                            <a href="tel:<?php echo $phone; ?>" class="emergency-phone"><?php echo $phone; ?></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7" data-aos="fade-right">
                    <div class="contact-form-card">
                        <h3 class="mb-3">أرسل لنا رسالة</h3>
                        <p class="text-muted mb-4">جميع الرسائل سرية ويتم الرد عليها خلال 24 ساعة</p>
                        
                        <form id="contactForm">
                            <input type="hidden" id="csrf_token_contact" value="<?php echo htmlspecialchars($csrf_token); ?>">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">الاسم</label>
                                    <input type="text" class="form-control form-control-lg" id="contactName" placeholder="اسمك الكريم">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">رقم الهاتف <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control form-control-lg" id="contactPhone" placeholder="01xxxxxxxxx" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold">البريد الإلكتروني</label>
                                    <input type="email" class="form-control form-control-lg" id="contactEmail" placeholder="example@email.com">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold">الموضوع</label>
                                    <select class="form-select form-select-lg" id="contactSubject">
                                        <option>استفسار عام</option>
                                        <option>حجز موعد</option>
                                        <option>استشارة طبية</option>
                                        <option>شكوى أو اقتراح</option>
                                        <option>طلب تعاون</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold">الرسالة <span class="text-danger">*</span></label>
                                    <textarea class="form-control" rows="5" id="contactMessage" placeholder="اكتب رسالتك هنا..." required></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary-custom btn-lg w-100">
                                        <i class="fas fa-paper-plane me-2"></i>إرسال الرسالة
                                    </button>
                                </div>
                                <div class="col-12">
                                    <div id="contactSuccess" style="display:none;" class="text-center">
                                        <i class="fas fa-check-circle fa-4x text-success"></i>
                                        <h4 class="mt-3">تم إرسال رسالتك بنجاح!</h4>
                                        <p>سيتواصل معك فريقنا قريباً. شكراً لثقتك بنا.</p>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
 <?php include 'includes/footer.php'; ?>

    <script>AOS.init({ duration: 800, once: true });</script>
    <?php include 'includes/footer_scripts.php'; ?>
</body>
</html>