<?php
/**
 * gallery.php — معرض الصور والفيديوهات
 * مركز المشفى للطب النفسي وعلاج الإدمان
 */
require_once 'config/settings.php';

// جلب الخدمات للفوتر
try {
    $stmt = $pdo->query("SELECT * FROM services WHERE is_active = 1 LIMIT 5");
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $services = [];
}

$pageTitle       = "معرض المركز — مركز المشفى";
$pageDescription = "استعرض صور وفيديوهات مركز المشفى للطب النفسي وعلاج الإدمان —施設، وجلسات العلاج";
?>
<?php include 'includes/header.php'; ?>

<!-- ==================== GALLERY-SPECIFIC STYLES ==================== -->
<style>
/* ────────────────────────────────────────────
   1.  CSS Variables (نفس palette المشروع)
   ──────────────────────────────────────────── */
:root {
  --gallery-dark: #0D1117;
  --gallery-glass: rgba(255,255,255,0.06);
  --gallery-border: rgba(255,255,255,0.10);
  --gallery-gold: #C8A951;
  --gallery-red: #C41E3A;
  --gallery-red-glow: rgba(196,30,58,0.30);
  --ease-expo: cubic-bezier(0.16,1,0.3,1);
}

/* ────────────────────────────────────────────
   2.  Hero Section
   ──────────────────────────────────────────── */
.gallery-hero {
  position: relative;
  min-height: 55vh;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  background:
    linear-gradient(rgba(10,15,35,.90), rgba(10,15,35,.90)),
    url('https://images.unsplash.com/photo-1538108149393-fbbd81895907?w=1600&q=80') center/cover no-repeat fixed;
  text-align: center;
  color: #fff;
}

.gallery-hero::before {
  content: '';
  position: absolute;
  inset: 0;
  background:
    radial-gradient(ellipse 70% 60% at 50% 0%, var(--gallery-red-glow), transparent 65%);
  pointer-events: none;
}

.gallery-hero-content {
  position: relative;
  z-index: 2;
  padding-top: 110px;
  padding-bottom: 60px;
}

.gallery-hero h1 {
  font-size: clamp(2rem, 5vw, 3.5rem);
  font-weight: 900;
  letter-spacing: -0.5px;
  line-height: 1.15;
}

.gallery-hero p {
  font-size: 1.1rem;
  color: rgba(255,255,255,.75);
  max-width: 620px;
  margin: 1rem auto 0;
}

/* ────────────────────────────────────────────
   3.  Filter Tabs
   ──────────────────────────────────────────── */
.gallery-filters {
  display: flex;
  flex-wrap: wrap;
  gap: .6rem;
  justify-content: center;
  padding: 2.5rem 1rem 0;
}

.gf-btn {
  padding: .55rem 1.5rem;
  border-radius: 50px;
  font-size: .9rem;
  font-weight: 600;
  font-family: 'Cairo', sans-serif;
  border: 1.5px solid var(--gallery-border);
  background: var(--gallery-glass);
  color: rgba(255,255,255,.75);
  cursor: pointer;
  transition: all .3s var(--ease-expo);
  backdrop-filter: blur(8px);
  -webkit-backdrop-filter: blur(8px);
  white-space: nowrap;
}

.gf-btn:hover,
.gf-btn.active {
  background: var(--gallery-red);
  border-color: var(--gallery-red);
  color: #fff;
  box-shadow: 0 4px 20px var(--gallery-red-glow);
  transform: translateY(-2px);
}

/* ────────────────────────────────────────────
   4.  Main Gallery Wrapper
   ──────────────────────────────────────────── */
.gallery-section {
  background: var(--gallery-dark);
  min-height: 100vh;
  padding-bottom: 6rem;
}

.gallery-grid {
  columns: 3;
  column-gap: 1rem;
  padding: 2.5rem 1rem 0;
  max-width: 1280px;
  margin: 0 auto;
}

@media (max-width: 991px)  { .gallery-grid { columns: 2; } }
@media (max-width: 575px)  { .gallery-grid { columns: 1; } }

/* ────────────────────────────────────────────
   5.  Individual Card
   ──────────────────────────────────────────── */
.g-card {
  break-inside: avoid;
  margin-bottom: 1rem;
  border-radius: 18px;
  overflow: hidden;
  position: relative;
  cursor: pointer;
  display: block;
  background: #111;
  /* smooth appear on filter change */
  animation: gCardIn .45s var(--ease-expo) both;
}

@keyframes gCardIn {
  from { opacity:0; transform: scale(.95) translateY(12px); }
  to   { opacity:1; transform: scale(1)  translateY(0);    }
}

.g-card.hidden {
  display: none;
}

/* Image cards */
.g-card img {
  width: 100%;
  height: auto;
  display: block;
  transition: transform .55s var(--ease-expo);
  object-fit: cover;
}

.g-card:hover img {
  transform: scale(1.06);
}

/* Overlay */
.g-card-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(to top, rgba(0,0,0,.80) 0%, transparent 55%);
  opacity: 0;
  transition: opacity .35s ease;
  display: flex;
  align-items: flex-end;
  padding: 1.2rem;
  border-radius: 18px;
}

.g-card:hover .g-card-overlay {
  opacity: 1;
}

.g-card-overlay span {
  color: #fff;
  font-size: .9rem;
  font-weight: 600;
}

/* Zoom icon */
.g-card-overlay::before {
  content: '\f00e';
  font-family: 'Font Awesome 6 Free';
  font-weight: 900;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%,-50%) scale(.7);
  font-size: 1.8rem;
  color: rgba(255,255,255,.9);
  opacity: 0;
  transition: all .3s ease;
}

.g-card:hover .g-card-overlay::before {
  opacity: 1;
  transform: translate(-50%,-50%) scale(1);
}

/* ────────────────────────────────────────────
   6.  Video cards
   ──────────────────────────────────────────── */
.g-card.g-video {
  background: #0a0a0a;
}

.g-card.g-video iframe,
.g-card.g-video video {
  width: 100%;
  display: block;
  border: 0;
  border-radius: 18px;
  aspect-ratio: 16/9;
}

.g-card.g-video::after {
  content: '';
  position: absolute;
  top: 1rem;
  right: 1rem;
  width: 36px;
  height: 36px;
  background: var(--gallery-red);
  border-radius: 50%;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='white'%3E%3Cpath d='M8 5v14l11-7z'/%3E%3C/svg%3E");
  background-size: 55%;
  background-repeat: no-repeat;
  background-position: 55% 50%;
  box-shadow: 0 2px 10px var(--gallery-red-glow);
  pointer-events: none;
}

/* Wide card (full column span) */
.g-card.g-wide {
  columns: unset;
  break-inside: avoid;
}

/* Category badge on card */
.g-badge {
  position: absolute;
  top: .9rem;
  left: .9rem;
  padding: .25rem .8rem;
  border-radius: 50px;
  font-size: .75rem;
  font-weight: 700;
  background: rgba(0,0,0,.55);
  color: #fff;
  backdrop-filter: blur(6px);
  border: 1px solid rgba(255,255,255,.15);
  z-index: 2;
}

/* ────────────────────────────────────────────
   7.  Lightbox
   ──────────────────────────────────────────── */
.lightbox-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,.94);
  z-index: 9999;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 1rem;
  opacity: 0;
  pointer-events: none;
  transition: opacity .35s ease;
  backdrop-filter: blur(12px);
  -webkit-backdrop-filter: blur(12px);
}

.lightbox-overlay.active {
  opacity: 1;
  pointer-events: all;
}

.lightbox-inner {
  position: relative;
  max-width: 90vw;
  max-height: 90vh;
  display: flex;
  align-items: center;
  justify-content: center;
}

.lightbox-inner img {
  max-width: 100%;
  max-height: 85vh;
  border-radius: 16px;
  box-shadow: 0 30px 80px rgba(0,0,0,.7);
  object-fit: contain;
  transform: scale(.92);
  transition: transform .4s var(--ease-expo);
}

.lightbox-overlay.active .lightbox-inner img {
  transform: scale(1);
}

/* caption */
.lightbox-caption {
  position: absolute;
  bottom: -2.5rem;
  left: 0; right: 0;
  text-align: center;
  color: rgba(255,255,255,.7);
  font-size: .9rem;
}

/* Close btn */
.lightbox-close {
  position: fixed;
  top: 1.2rem;
  left: 1.2rem;
  width: 46px;
  height: 46px;
  background: rgba(255,255,255,.12);
  border: 1.5px solid rgba(255,255,255,.18);
  border-radius: 50%;
  color: #fff;
  font-size: 1.3rem;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background .2s;
  z-index: 10000;
  backdrop-filter: blur(8px);
}

.lightbox-close:hover { background: var(--gallery-red); }

/* Prev / Next */
.lightbox-nav {
  position: fixed;
  top: 50%;
  transform: translateY(-50%);
  width: 48px;
  height: 48px;
  background: rgba(255,255,255,.10);
  border: 1.5px solid rgba(255,255,255,.15);
  border-radius: 50%;
  color: #fff;
  font-size: 1.2rem;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background .2s;
  z-index: 10000;
  backdrop-filter: blur(8px);
}

.lightbox-nav:hover { background: var(--gallery-red); }
.lightbox-prev { right: 1.2rem; }
.lightbox-next { left:  1.2rem; }

/* ────────────────────────────────────────────
   8.  Stats banner
   ──────────────────────────────────────────── */
.gallery-stats {
  display: flex;
  flex-wrap: wrap;
  gap: 1.5rem;
  justify-content: center;
  padding: 2rem 1rem;
  max-width: 900px;
  margin: 0 auto;
}

.g-stat {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: .2rem;
  color: rgba(255,255,255,.55);
  font-size: .85rem;
}

.g-stat strong {
  font-size: 1.5rem;
  font-weight: 800;
  color: var(--gallery-gold);
}

/* ────────────────────────────────────────────
   9.  Empty state
   ──────────────────────────────────────────── */
.gallery-empty {
  text-align: center;
  color: rgba(255,255,255,.35);
  padding: 5rem 1rem;
  display: none;
}

.gallery-empty i {
  font-size: 3rem;
  margin-bottom: 1rem;
  display: block;
}

/* ────────────────────────────────────────────
   10. Hero wave
   ──────────────────────────────────────────── */
.gallery-hero-wave {
  position: absolute;
  bottom: -1px;
  left: 0;
  width: 100%;
  line-height: 0;
}

/* ────────────────────────────────────────────
   11. CTA strip
   ──────────────────────────────────────────── */
.gallery-cta {
  background: linear-gradient(135deg, var(--gallery-red) 0%, #8B0000 100%);
  padding: 3.5rem 1rem;
  text-align: center;
  color: #fff;
}

.gallery-cta h3 {
  font-size: 1.8rem;
  font-weight: 800;
  margin-bottom: .5rem;
}

.gallery-cta p {
  opacity: .85;
  margin-bottom: 1.5rem;
}

.gallery-cta .btn-light {
  border-radius: 50px;
  padding: .75rem 2.2rem;
  font-weight: 700;
  font-family: 'Cairo', sans-serif;
}
</style>

<body>
<div class="scroll-progress"></div>

<!-- Preloader -->
<div id="preloader">
  <div class="loader">
    <div class="loader-logo">
      <img src="https://i.ibb.co/zVTHKPC6/Elmashfa-Logo.webp" alt="مركز المشفى" loading="lazy">
    </div>
    <p class="mt-3 text-white">مركز المشفى</p>
  </div>
</div>

<!-- WhatsApp Float -->
<a href="https://wa.me/<?php echo $whatsapp; ?>?text=<?php echo rawurlencode('السلام عليكم، أريد الاستفسار عن خدمات مركز المشفى'); ?>"
   class="whatsapp-float" target="_blank" rel="noopener">
  <i class="fab fa-whatsapp fa-2x"></i>
</a>

<!-- Chat Toggle -->
<div class="chat-float" id="chatToggle">
  <i class="fas fa-comment-medical fa-2x"></i>
</div>

<!-- Chat Box -->
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
    <input type="text" class="form-control" placeholder="اكتب رسالتك هنا...">
    <button class="btn btn-send"><i class="fas fa-paper-plane"></i></button>
  </div>
</div>

<!-- ==================== NAVBAR ==================== -->
<?php include 'includes/navbar.php'; ?>

<!-- ==================== HERO ==================== -->
<section class="gallery-hero">
  <div class="gallery-hero-content container">

    <div class="section-badge mb-3" data-aos="fade-down" data-aos-duration="800"
         style="background:rgba(255,255,255,.15);color:#fff;display:inline-block;">
      <i class="fas fa-images me-2"></i>معرض المركز
    </div>

<h1 data-aos="fade-up" data-aos-duration="900" data-aos-delay="100">
  <span style="color:#fff;">لقطات من</span>
  <span class="text-gradient">عالمنا</span>
</h1>

    <p data-aos="fade-up" data-aos-duration="900" data-aos-delay="250">
      نافذة شفافة على بيئة العلاج، والمرافق الحديثة التي نوفرها لكل مريض
    </p>

    <!-- Mini Stats -->
    <div class="gallery-stats" data-aos="fade-up" data-aos-delay="400">
      <div class="g-stat"><strong id="countPhotos">0</strong> صورة</div>
      <div class="g-stat"><strong id="countVideos">0</strong> فيديو</div>
      <div class="g-stat"><strong id="countCats">0</strong> قسم</div>
    </div>

  </div>

  <!-- Wave -->
  <div class="gallery-hero-wave">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 80">
      <path fill="#0D1117" fill-opacity="1"
        d="M0,40 C360,80 1080,0 1440,40 L1440,80 L0,80 Z"/>
    </svg>
  </div>
</section>

<!-- ==================== GALLERY SECTION ==================== -->
<section class="gallery-section">

  <!-- Filter Tabs -->
  <div class="gallery-filters" data-aos="fade-up" data-aos-duration="700">
    <button class="gf-btn active" data-filter="all">
      <i class="fas fa-border-all me-1"></i> الكل
    </button>
    <button class="gf-btn" data-filter="facility">
      <i class="fas fa-hospital me-1"></i> المنشأة
    </button>
    <button class="gf-btn" data-filter="rooms">
      <i class="fas fa-bed me-1"></i> غرف الإقامة
    </button>
    <button class="gf-btn" data-filter="sessions">
      <i class="fas fa-couch me-1"></i> جلسات العلاج
    </button>
    <button class="gf-btn" data-filter="events">
      <i class="fas fa-calendar-star me-1"></i> فعاليات
    </button>
    <button class="gf-btn" data-filter="video">
      <i class="fas fa-play-circle me-1"></i> فيديوهات
    </button>
  </div>

  <!-- ═══════════════════════════════════════════════
       MASONRY GRID
       ─ كل card عليها data-cat وdata-label
       ─ لإضافة صور جديدة: انسخ أي .g-card وعدّل
         src والـ data-cat والـ data-label فقط
       ═══════════════════════════════════════════════ -->
  <div class="gallery-grid" id="galleryGrid" data-aos="fade-up" data-aos-delay="150">

    <!-- ══ واجهة المركز ══ -->
    <div class="g-card lightbox-item" data-cat="facility" data-label="واجهة مركز المشفى — مدخل المركز الرئيسي"
         onclick="openLightbox(this)">
      <span class="g-badge">المنشأة</span>
      <img src="/gallery/entrance.webp" alt="واجهة مركز المشفى" loading="lazy">
      <div class="g-card-overlay"><span>واجهة مركز المشفى — المدخل الرئيسي</span></div>
    </div>

    <!-- ══ ركن الترفيه ══ -->
    <div class="g-card lightbox-item" data-cat="facility" data-label="قاعة الترفيه — تلفزيون ومكتبة للمرضى"
         onclick="openLightbox(this)">
      <span class="g-badge">المنشأة</span>
      <img src="/gallery/tv_lounge.webp" alt="قاعة الترفيه" loading="lazy">
      <div class="g-card-overlay"><span>قاعة الترفيه — تلفزيون ومكتبة للمرضى</span></div>
    </div>

    <!-- ══ غرفة إقامة واسعة ══ -->
    <div class="g-card lightbox-item" data-cat="rooms" data-label="غرفة الإقامة الواسعة — تتسع لعدة مرضى"
         onclick="openLightbox(this)">
      <span class="g-badge">غرف الإقامة</span>
      <img src="/gallery/room_multi_1.webp" alt="غرفة إقامة واسعة" loading="lazy">
      <div class="g-card-overlay"><span>غرفة الإقامة الواسعة</span></div>
    </div>

    <!-- ══ حقوق المريض ══ -->
    <div class="g-card lightbox-item" data-cat="facility" data-label="لوحة حقوق المريض النفسي — وزارة الصحة"
         onclick="openLightbox(this)">
      <span class="g-badge">الاعتماد</span>
      <img src="/gallery/patient_rights_1.webp" alt="حقوق المريض النفسي" loading="lazy">
      <div class="g-card-overlay"><span>لوحة حقوق المريض — وزارة الصحة والسكان</span></div>
    </div>

    <!-- ══ غرفة فردية ══ -->
    <div class="g-card lightbox-item" data-cat="rooms" data-label="غرفة الإقامة الفردية — أمان وخصوصية"
         onclick="openLightbox(this)">
      <span class="g-badge">غرف الإقامة</span>
      <img src="/gallery/single_room.webp" alt="غرفة إقامة فردية" loading="lazy">
      <div class="g-card-overlay"><span>غرفة الإقامة الفردية — أمان وخصوصية</span></div>
    </div>

    <!-- ══ أسرّة جديدة ══ -->
    <div class="g-card lightbox-item" data-cat="rooms" data-label="تجديد المفروشات — أسرّة جديدة كلياً"
         onclick="openLightbox(this)">
      <span class="g-badge">غرف الإقامة</span>
      <img src="/gallery/new_beds.webp" alt="أسرّة جديدة" loading="lazy">
      <div class="g-card-overlay"><span>تجديد المفروشات — أسرّة جديدة كلياً</span></div>
    </div>

    <!-- ══ غرفة مع نافذة طبيعية 2 سراير ══ -->
    <div class="g-card lightbox-item" data-cat="rooms" data-label="غرفة مزدوجة مع إضاءة طبيعية"
         onclick="openLightbox(this)">
      <span class="g-badge">غرف الإقامة</span>
      <img src="/gallery/room_window_2bed.webp" alt="غرفة مزدوجة" loading="lazy">
      <div class="g-card-overlay"><span>غرفة مزدوجة — إضاءة طبيعية رائعة</span></div>
    </div>

    <!-- ══ حقوق المريض 2 ══ -->
    <div class="g-card lightbox-item" data-cat="facility" data-label="لائحة حقوق المريض — الاعتماد الرسمي"
         onclick="openLightbox(this)">
      <span class="g-badge">الاعتماد</span>
      <img src="/gallery/patient_rights_2.webp" alt="حقوق المريض النفسي" loading="lazy">
      <div class="g-card-overlay"><span>الاعتماد الرسمي — لائحة حقوق المريض</span></div>
    </div>

    <!-- ══ غرفة واسعة 3 سراير ══ -->
    <div class="g-card lightbox-item" data-cat="rooms" data-label="غرفة ثلاثية واسعة مع نافذة"
         onclick="openLightbox(this)">
      <span class="g-badge">غرف الإقامة</span>
      <img src="/gallery/room_wide_3bed.webp" alt="غرفة ثلاثية" loading="lazy">
      <div class="g-card-overlay"><span>غرفة ثلاثية واسعة — مع نافذة ونور طبيعي</span></div>
    </div>


    <!-- ══ غرفة مشرقة ══ -->
    <div class="g-card lightbox-item" data-cat="rooms" data-label="غرفة الإقامة المشرقة — إضاءة وتهوية"
         onclick="openLightbox(this)">
      <span class="g-badge">غرف الإقامة</span>
      <img src="/gallery/room_bright_multi.webp" alt="غرفة مشرقة" loading="lazy">
      <div class="g-card-overlay"><span>غرفة الإقامة المشرقة — تهوية وإضاءة طبيعية</span></div>
    </div>

    <!-- ══ فيديو يوتيوب ══ -->
    <div class="g-card g-video" data-cat="video" data-label="فيديو تعريفي بمركز المشفى">
      <span class="g-badge">فيديو</span>
      <iframe
        src="https://www.youtube.com/embed/HmZKgaHa3Fg?rel=0&modestbranding=1"
        title="مركز المشفى — التعريف بالمركز"
        loading="lazy"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
        allowfullscreen>
      </iframe>
    </div>

  </div><!-- /.gallery-grid -->

  <!-- Empty state (يظهر لو مفيش نتائج للفلتر) -->
  <div class="gallery-empty" id="galleryEmpty">
    <i class="fas fa-images"></i>
    <p>لا توجد عناصر في هذا القسم حالياً</p>
  </div>

</section><!-- /.gallery-section -->

<!-- ==================== CTA STRIP ==================== -->
<div class="gallery-cta" data-aos="fade-up">
  <h3>هل أنت جاهز لبدء رحلة الشفاء؟</h3>
  <p>تواصل معنا الآن — جميع الاستشارات مجانية وبسرية تامة</p>
  <a href="booking.php" class="btn btn-light fw-bold">
    <i class="fas fa-calendar-check me-2"></i> احجز موعدك الآن
  </a>
</div>

<!-- ==================== FOOTER ==================== -->
<?php include 'includes/footer.php'; ?>
<?php include 'includes/footer_scripts.php'; ?>

<!-- ==================== LIGHTBOX ==================== -->
<div class="lightbox-overlay" id="lightbox" role="dialog" aria-label="معاينة الصورة">
  <button class="lightbox-close" onclick="closeLightbox()" aria-label="إغلاق">
    <i class="fas fa-times"></i>
  </button>
  <button class="lightbox-prev lightbox-nav" onclick="lightboxNav(-1)" aria-label="السابق">
    <i class="fas fa-chevron-right"></i>
  </button>
  <div class="lightbox-inner">
    <img id="lightboxImg" src="" alt="">
    <div class="lightbox-caption" id="lightboxCaption"></div>
  </div>
  <button class="lightbox-next lightbox-nav" onclick="lightboxNav(1)" aria-label="التالي">
    <i class="fas fa-chevron-left"></i>
  </button>
</div>

<!-- ==================== GALLERY JS (مستقل لا يتداخل) ==================== -->
<script>
(function () {
  'use strict';

  /* ── 1. Filter ─────────────────────────────── */
  const cards       = Array.from(document.querySelectorAll('#galleryGrid .g-card'));
  const filterBtns  = document.querySelectorAll('.gf-btn');
  const emptyState  = document.getElementById('galleryEmpty');

  function applyFilter(cat) {
    let visible = 0;
    cards.forEach(function (c) {
      const match = cat === 'all' || c.dataset.cat === cat;
      if (match) {
        c.classList.remove('hidden');
        // restart animation
        c.style.animation = 'none';
        void c.offsetWidth;
        c.style.animation = '';
        visible++;
      } else {
        c.classList.add('hidden');
      }
    });
    emptyState.style.display = visible === 0 ? 'block' : 'none';
  }

  filterBtns.forEach(function (btn) {
    btn.addEventListener('click', function () {
      filterBtns.forEach(function (b) { b.classList.remove('active'); });
      btn.classList.add('active');
      applyFilter(btn.dataset.filter);
    });
  });

  /* ── 2. Counter animation ───────────────────── */
  function animateCount(el, end, duration) {
    const start = Date.now();
    const step = function () {
      const pct = Math.min((Date.now() - start) / duration, 1);
      el.textContent = Math.round(pct * end);
      if (pct < 1) requestAnimationFrame(step);
    };
    requestAnimationFrame(step);
  }

  const photoCount = cards.filter(function (c) { return c.dataset.cat !== 'video' && !c.classList.contains('g-video'); }).length;
  const videoCount = cards.filter(function (c) { return c.classList.contains('g-video'); }).length;
  const catCount   = new Set(cards.map(function (c) { return c.dataset.cat; })).size;

  animateCount(document.getElementById('countPhotos'), photoCount, 1200);
  animateCount(document.getElementById('countVideos'), videoCount, 1200);
  animateCount(document.getElementById('countCats'),   catCount,   1000);

  /* ── 3. Lightbox ─────────────────────────────── */
  let lightboxItems = [];
  let currentIndex  = 0;

  window.openLightbox = function (card) {
    lightboxItems = cards.filter(function (c) {
      return c.classList.contains('lightbox-item') && !c.classList.contains('hidden');
    });
    currentIndex = lightboxItems.indexOf(card);
    showLightboxItem(currentIndex);
    document.getElementById('lightbox').classList.add('active');
    document.body.style.overflow = 'hidden';
  };

  function showLightboxItem(idx) {
    const c = lightboxItems[idx];
    if (!c) return;
    const img  = c.querySelector('img');
    const lb   = document.getElementById('lightboxImg');
    const cap  = document.getElementById('lightboxCaption');
    lb.src     = img ? img.src : '';
    cap.textContent = c.dataset.label || '';
  }

  window.closeLightbox = function () {
    document.getElementById('lightbox').classList.remove('active');
    document.body.style.overflow = '';
  };

  window.lightboxNav = function (dir) {
    currentIndex = (currentIndex + dir + lightboxItems.length) % lightboxItems.length;
    showLightboxItem(currentIndex);
  };

  // Close on backdrop click
  document.getElementById('lightbox').addEventListener('click', function (e) {
    if (e.target === this) window.closeLightbox();
  });

  // Keyboard nav
  document.addEventListener('keydown', function (e) {
    if (!document.getElementById('lightbox').classList.contains('active')) return;
    if (e.key === 'Escape')     window.closeLightbox();
    if (e.key === 'ArrowRight') window.lightboxNav(-1);
    if (e.key === 'ArrowLeft')  window.lightboxNav(1);
  });

  // Touch / swipe support
  var touchStartX = 0;
  document.getElementById('lightbox').addEventListener('touchstart', function (e) {
    touchStartX = e.changedTouches[0].clientX;
  }, { passive: true });
  document.getElementById('lightbox').addEventListener('touchend', function (e) {
    var diff = e.changedTouches[0].clientX - touchStartX;
    if (Math.abs(diff) > 50) window.lightboxNav(diff > 0 ? -1 : 1);
  });

})();
</script>

</body>
</html>
