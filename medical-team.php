<?php
require_once 'config/settings.php';

// أضف هذا السطر في أول الصفحة بعد <?php
header('Content-Type: text/html; charset=utf-8');

// جلب الأطباء من قاعدة البيانات
$doctors = $pdo->query("SELECT * FROM doctors WHERE is_active = 1 ORDER BY rating DESC")->fetchAll();
if (empty($doctors)) $doctors = [];
?>
<?php
$pageTitle = "الفريق الطبي - مركز المشفى";
$pageDescription = "تعرّف على نخبة الأطباء النفسيين والاستشاريين في مركز المشفى بقويسنا المنوفية. فريق متخصص في علاج الإدمان والاضطرابات النفسية بخبرات تتجاوز 10 سنوات. احجز مع طبيبك الآن.";
?>
<?php
$stmt = $pdo->query("SELECT * FROM services LIMIT 5");
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php include 'includes/header.php'; ?>
<html lang="ar" dir="rtl">
<head>
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
                    <span class="section-badge bg-white bg-opacity-25 text-white">فريقنا الطبي</span>
                    <h1 class="page-hero-title">نخبة من أمهر <span class="text-gradient">الأطباء والمتخصصين</span></h1>
                    <p class="page-hero-subtitle">فريق طبي متكامل يضم استشاريين وأخصائيين في الطب النفسي وعلاج الإدمان</p>
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
                               
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="director-content">
                       
                                <h2 class="director-name"><?php echo htmlspecialchars($director['name']); ?></h2>
                                <p class="director-title"><?php echo htmlspecialchars($director['specialty']); ?></p>
                                <div class="director-stats">
                                    <div class="director-stat"><span class="stat-num"><?php echo $director['rating']; ?></span><span class="stat-lbl">التقييم</span></div>
                                </div>
                                <p class="director-bio"><?php echo nl2br(htmlspecialchars($director['bio'] ?? 'خبرة واسعة في مجال الطب النفسي وعلاج الإدمان.')); ?></p>
                                <div class="director-actions">
                                    <a href="booking.php?doctor_id=<?php echo $director['id']; ?>" class="btn btn-primary-custom">
                                        <i class="fas fa-calendar-check me-2"></i>احجز مع الدكتور
                                    </a>
                                </div>
                            </div>
                        </div>
						
                    </div>
                </div>

                <!-- باقي الأطباء -->
              <div class="doctors-grid-new">
    <?php foreach (array_slice($doctors, 1) as $doctor): ?>
    <div class="doctor-card-new">
        <img src="<?php echo $doctor['image'] ?: 'https://placehold.co/400x450/e8e8e8/333333?text=Dr'; ?>" 
             alt="<?php echo htmlspecialchars($doctor['name']); ?>" 
             class="doctor-image-new">
        <div class="doctor-info-new">
            <h3 class="doctor-name-new"><?php echo htmlspecialchars($doctor['name']); ?></h3>
            <span class="doctor-specialty-new"><?php echo htmlspecialchars($doctor['specialty']); ?></span>
            <div class="doctor-rating-new">
                <?php echo str_repeat('⭐', round($doctor['rating'])); ?>
                <span>(<?php echo $doctor['rating']; ?>)</span>
            </div>
       <p class="doctor-bio-new">
    <?php 
    $fullBio = htmlspecialchars($doctor['bio'] ?? '');
    $shortBio = mb_substr($fullBio, 0, 120, 'UTF-8');
    if (mb_strlen($fullBio, 'UTF-8') > 120) {
        echo $shortBio . '... <a href="#" class="read-more-link" onclick="showFullBio(this, `' . addslashes($fullBio) . '`); return false;">اقرأ المزيد</a>';
    } else {
        echo $fullBio;
    }
    ?>
</p>

<script>
function showFullBio(element, fullText) {
    element.parentElement.innerHTML = fullText;
}
</script>
<a href="booking.php?doctor_id=<?php echo $doctor['id']; ?>" class="btn-booking-new">
    <i class="fas fa-calendar-check me-1"></i> احجز موعد
</a>
        </div>
    </div>
    <?php endforeach; ?>
</div>
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
<style>
/* تصميم جديد لبطاقات الأطباء - متجاوب وجنب بعض */
.doctors-grid-new {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 24px;
    margin-top: 40px;
}

.doctor-card-new {
    background: var(--white, #ffffff);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    border: 1px solid var(--gray-200, #e9ecef);
}

.doctor-card-new:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(196, 30, 58, 0.12);
    border-color: var(--primary-red, #C41E3A);
}

.doctor-image-new {
    width: 100%;
    height: 280px;
    object-fit: cover;
    border-bottom: 3px solid var(--primary-red, #C41E3A);
}

.doctor-info-new {
    padding: 20px;
    text-align: center;
}

.doctor-name-new {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--gray-900, #1a1a2e);
    margin-bottom: 5px;
}

.doctor-specialty-new {
    color: var(--primary-red, #C41E3A);
    font-weight: 600;
    font-size: 0.85rem;
    margin-bottom: 12px;
    display: inline-block;
    background: rgba(196, 30, 58, 0.1);
    padding: 4px 12px;
    border-radius: 50px;
}

.doctor-rating-new {
    margin-bottom: 12px;
    font-size: 14px;
    color: var(--gold, #C8A951);
}

.doctor-bio-new {
    display: -webkit-box;
    -webkit-line-clamp: 3;  /* عدد الأسطر اللي تظهر */
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}

.btn-booking-new {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    background: linear-gradient(135deg, #C41E3A, #8B0000);
    color: white;
    padding: 10px 20px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 14px;
    text-decoration: none;
    transition: all 0.3s ease;
    width: 100%;
}

.btn-booking-new:hover {
    background: linear-gradient(135deg, #8B0000, #C41E3A);
    color: white;
    transform: translateY(-2px);
}

/* للموبايل: بطاقتين جنب بعض */
@media (max-width: 768px) {
    .doctors-grid-new {
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }
    
    .doctor-image-new {
        height: 180px;
    }
    
    .doctor-info-new {
        padding: 12px;
    }
    
    .doctor-name-new {
        font-size: 1rem;
    }
    
    .doctor-specialty-new {
        font-size: 0.7rem;
    }
    
    .doctor-bio-new {
        font-size: 0.7rem;
        line-height: 1.5;
         display: block !important;
    }
    
    .btn-booking-new {
        padding: 6px 12px;
        font-size: 11px;
    }
}

@media (max-width: 480px) {
    .doctors-grid-new {
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }
    
    .doctor-image-new {
        height: 140px;
    }
}

/* تنسيق القسم اللي فيه الدكتور المميز */
.director-section-new {
    margin-bottom: 50px;
}

.director-card-new {
    display: flex;
    flex-wrap: wrap;
    background: linear-gradient(135deg, #f8f9fa, #ffffff);
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    border: 1px solid var(--gray-200);
}

.director-image-new {
    flex: 1;
    min-width: 250px;
}

.director-image-new img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    min-height: 320px;
}

.director-content-new {
    flex: 1.5;
    padding: 30px;
}

.director-badge-new {
    display: inline-block;
    background: var(--primary-red, #C41E3A);
    color: white;
    padding: 6px 16px;
    border-radius: 50px;
    font-size: 12px;
    font-weight: 600;
    margin-bottom: 15px;
}

.director-name-new {
    font-size: 1.8rem;
    font-weight: 800;
    margin-bottom: 5px;
}

.director-title-new {
    color: var(--primary-red);
    font-weight: 600;
    margin-bottom: 15px;
}

@media (max-width: 768px) {
    .director-card-new {
        flex-direction: column;
    }
    
    .director-image-new {
        min-width: auto;
    }
    
    .director-image-new img {
        min-height: 250px;
    }
    
    .director-content-new {
        padding: 20px;
    }
    
    .director-name-new {
        font-size: 1.3rem;
    }
}
</style>
</head>
</html>