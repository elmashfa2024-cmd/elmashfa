<?php
require_once 'config/settings.php';


$pageTitle = "لماذا مركز المشفى؟ | أفضل مركز لعلاج الإدمان والطب النفسي في قويسنا المنوفية";
$pageDescription = "لماذا تختار مركز المشفى لعلاج الإدمان والطب النفسي في قويسنا المنوفية؟ فريق طبي متخصص، سرية تامة 100%، دعم 24 ساعة، استشارة مجانية، وأعلى نسب نجاح. اكتشف الفرق بنفسك.";
include 'includes/header.php';

?>
<?php
$stmt = $pdo->query("SELECT * FROM services LIMIT 5");
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
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
<?php include 'includes/navbar.php'; ?>

<a href="https://wa.me/<?php echo $whatsapp; ?>?text=<?php echo rawurlencode('السلام عليكم، أريد الاستفسار عن خدمات مركز المشفى'); ?>" class="whatsapp-float" target="_blank">
    <i class="fab fa-whatsapp fa-2x"></i>
</a>

<!-- HERO -->

<section class="why-hero">

    <div class="container">

        <div class="row align-items-center">

            <div class="col-lg-6">

                <span class="hero-badge">لماذا يختارنا المرضى؟</span>

<h1>
    <span style="color: #ffffff;">لماذا مركز المشفى هو الخيار الأمثل</span><br>
    <span>لعلاج الإدمان والطب النفسي في قويسنا؟</span>
</h1>

           <p>
    في مركز المشفى - أول مركز متخصص في قويسنا، المنوفية - إحنا مش مجرد مكان للعلاج.
    بنقدملك رحلة تعافي متكاملة من الإدمان والاضطرابات النفسية، فيها دعم نفسي،
    رعاية طبية على أعلى مستوى، خصوصية كاملة، وفريق من أمهر الأطباء النفسيين
    اللي هيساعدك ترجع لحياتك أقوى من الأول.
</p>

                <div class="hero-actions">

                    <a href="booking.php" class="btn btn-danger btn-lg">
                        <i class="fas fa-calendar-check me-2"></i>
                        احجز استشارتك الآن
                    </a>

                    <a href="tel:<?php echo $phone; ?>" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-phone-alt me-2"></i>
                        تواصل معنا
                    </a>

                </div>

            </div>

           

        </div>

    </div>

</section>

<!-- FEATURES -->

<section class="why-features">

    <div class="container">

        <div class="section-title text-center">

            <span>ليه مركز المشفى؟</span>

            <h2>نوفرلك بيئة علاجية آمنة ومتكاملة</h2>

            <p>
                هدفنا إنك تبدأ رحلة التعافي وأنت مطمن وواثق إنك في المكان الصح
            </p>

        </div>

        <div class="row g-4">

            <div class="col-lg-4 col-md-6">

                <div class="feature-box">

                    <div class="feature-icon">
                        <i class="fas fa-user-shield"></i>
                    </div>

                    <h4>سرية وخصوصية كاملة</h4>

                    <p>
                        بنحافظ على خصوصيتك بشكل كامل،
                        وكل بياناتك واستشاراتك في أمان تام.
                    </p>

                </div>

            </div>

            <div class="col-lg-4 col-md-6">

                <div class="feature-box">

                    <div class="feature-icon">
                        <i class="fas fa-user-md"></i>
                    </div>

                    <h4>فريق متخصص</h4>

                    <p>
                        فريق طبي وعلاجي بخبرة كبيرة
                        في الطب النفسي وعلاج الإدمان.
                    </p>

                </div>

            </div>

            <div class="col-lg-4 col-md-6">

                <div class="feature-box">

                    <div class="feature-icon">
                        <i class="fas fa-heart"></i>
                    </div>

                    <h4>دعم نفسي مستمر</h4>

                    <p>
                        بنكون معاك خطوة بخطوة
                        لحد ما ترجع لحياتك الطبيعية بثقة.
                    </p>

                </div>

            </div>

            <div class="col-lg-4 col-md-6">

                <div class="feature-box">

                    <div class="feature-icon">
                        <i class="fas fa-hospital"></i>
                    </div>

                    <h4>بيئة علاجية مريحة</h4>

                    <p>
                        مكان هادئ ومجهز بالكامل
                        يساعدك على الراحة والاستقرار النفسي.
                    </p>

                </div>

            </div>

            <div class="col-lg-4 col-md-6">

                <div class="feature-box">

                    <div class="feature-icon">
                        <i class="fas fa-clock"></i>
                    </div>

                    <h4>متابعة مستمرة</h4>

                    <p>
                        متابعة بعد العلاج لضمان الاستقرار
                        ومنع الانتكاسة.
                    </p>

                </div>

            </div>

            <div class="col-lg-4 col-md-6">

                <div class="feature-box">

                    <div class="feature-icon">
                        <i class="fas fa-smile"></i>
                    </div>

                    <h4>نسب نجاح مرتفعة</h4>

                    <p>
                        ساعدنا حالات كتير تبدأ حياة جديدة
                        وتستعيد ثقتها بنفسها.
                    </p>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- CTA -->

<section class="why-cta">

    <div class="container text-center">

        <h2>
            مستني إيه؟
        </h2>

        <p>
            ابدأ أول خطوة في رحلة التعافي النهارده،
            وإحنا هنكون معاك لحد ما توصل للأمان الكامل.
        </p>

        <a href="booking.php" class="btn btn-light btn-lg">
            <i class="fas fa-calendar-check me-2"></i>
            احجز الآن
        </a>

    </div>

</section>

<?php include 'includes/footer.php'; ?>

<?php include 'includes/footer_scripts.php'; ?>
</body>