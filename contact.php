<?php
session_start();
require_once 'config/csrf.php';
require_once 'config/settings.php';
$csrf_token = csrf_generate();

$pageTitle = "تواصل معنا - مركز المشفى";
$pageDescription = "تواصل مع فريق مركز المشفى على مدار الساعة. استشارات نفسية وعلاج إدمان بسرية تامة. رقم الهاتف والواتساب متاحين 24 ساعة للرد على استفساراتك.";

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
                    <span class="section-badge bg-white bg-opacity-25 text-white">اتصل بنا</span>
                    <h1 class="page-hero-title">نحن هنا  <span class="text-gradient">لمساعدتك</span></h1>
                    <p class="page-hero-subtitle">لا تتردد في التواصل معنا. فريقنا جاهز للرد على استفساراتك على مدار الساعة بكل سرية</p>
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
    <section class="contact-section">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-5" >
                    <h3 class="mb-4">معلومات التواصل</h3>
                    
                    <div class="contact-info-card">
                        <div class="contact-icon"><i class="fas fa-phone-alt"></i></div>
                        <div><h6>اتصل بنا</h6><a href="tel:<?php echo $phone; ?>"><?php echo $phone; ?></a><a href="tel:<?php echo $phone2; ?>"><?php echo $phone2; ?></a></div>
                    </div>
                    <div class="contact-info-card">
                        <div class="contact-icon"><i class="fab fa-whatsapp"></i></div>
                        <div><h6>واتساب</h6><a href="https://wa.me/<?php echo $whatsapp; ?>" target="_blank">تواصل عبر الواتساب</a><a href="https://wa.me/<?php echo $whatsapp2; ?>" target="_blank">تواصل عبر الواتساب</a><small class="text-muted">رد فوري على مدار الساعة</small></div>
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





  
                </div>

                <div class="col-lg-7" >
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
    <!-- ==================== خريطة Google Maps ==================== -->
    <section class="map-section" style="padding: 60px 0; background: #f8f9fa;">
        <div class="container">
            <div class="section-header text-center mb-5">
                <span class="section-badge" style="background: #d32f2f15; color: #d32f2f; padding: 8px 25px; border-radius: 50px; display: inline-block;">
                    <i class="fas fa-map-marker-alt me-2"></i>موقعنا
                </span>
                <h2 class="section-title" style="font-size: 2.5rem; font-weight: 700; margin-top: 20px;">
                    كيف تصل <span style="color: #d32f2f;">إلينا؟</span>
                </h2>
                <p style="color: #666;">📍 <?php echo $address; ?></p>
            </div>

            <div class="row g-4">
                <!-- معلومات إضافية جنب الخريطة -->
                <div class="col-lg-4">
                    <div class="map-info-card" style="background: white; border-radius: 20px; padding: 25px; height: 100%; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
                        <div class="mb-4">
                            <i class="fas fa-car" style="color: #d32f2f; font-size: 30px; margin-bottom: 15px; display: inline-block;"></i>
                            <h5 style="font-weight: 700;">الوصول بالسيارة</h5>
                            <p style="color: #555;">يوجد موقف سيارات خاص بالمركز، ويمكنك استخدام خرائط جوجل للحصول على الاتجاهات الدقيقة.</p>
                        </div>
                        <div class="mb-4">
                            <i class="fas fa-subway" style="color: #d32f2f; font-size: 30px; margin-bottom: 15px; display: inline-block;"></i>
                            <h5 style="font-weight: 700;">الوصول بالمواصلات</h5>
                            <p style="color: #555;">أقرب محطة قطار: <strong>محطه قويسنا</strong>، ثم 5 دقائق مشي أو تكسي.</p>
                        </div>
                        <div>
                            <i class="fas fa-clock" style="color: #d32f2f; font-size: 30px; margin-bottom: 15px; display: inline-block;"></i>
                            <h5 style="font-weight: 700;">مواعيد الزيارة</h5>
                            <p style="color: #555;">الاستقبال مفتوح 24 ساعة طوال أيام الأسبوع<br>زيارة المرضى: من 4 عصراً حتى 8 مساءً</p>
                        </div>
                    </div>
                </div>

                <!-- الخريطة -->
                <div class="col-lg-8">
                    <div class="map-container" style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
                  
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d109949.13273780028!2d31.28241495664064!3d30.5518355!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14f7d9da6b0e9ddb%3A0x8b45f9231866f3d7!2z2KfZhNmF2LTZgdmJ!5e0!3m2!1sar!2seg!4v1779458860690!5m2!1sar!2seg"    width="100%" 
                            height="400" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                        <div style="padding: 15px; text-align: center; background: #f8f9fa;">
                            <a href="https://www.google.com/maps/dir//<?php echo urlencode($address); ?>" target="_blank" style="color: #d32f2f; text-decoration: none; font-weight: 600;">
                                <i class="fas fa-directions me-2"></i> احصل على الاتجاهات عبر خرائط جوجل
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
  <?php include 'includes/footer.php'; ?>

    <script>
        
        // إرسال رسالة التواصل
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData();
            formData.append('name', document.getElementById('contactName').value);
            formData.append('phone', document.getElementById('contactPhone').value);
            formData.append('email', document.getElementById('contactEmail').value);
            formData.append('subject', document.getElementById('contactSubject').value);
            formData.append('message', document.getElementById('contactMessage').value);
            formData.append('csrf_token', document.getElementById('csrf_token_contact').value);
            
            fetch('api/submit_contact.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('contactForm').style.display = 'none';
                    document.getElementById('contactSuccess').style.display = 'block';
                } else {
                    alert('❌ ' + data.message);
                }
            })
            .catch(error => {
                alert('❌ حدث خطأ. حاول مرة أخرى.');
            });
        });
    </script>
    <?php include 'includes/footer_scripts.php'; ?>
</body>
