<?php
require_once 'config/settings.php';
// جلب أعضاء الفريق الطبي من قاعدة البيانات
$therapyTeam = $pdo->query("SELECT * FROM staff WHERE team='therapy'")->fetchAll(PDO::FETCH_ASSOC);
// الاخصائيين
$specialists = $pdo->query("SELECT * FROM staff WHERE team='specialist'")->fetchAll(PDO::FETCH_ASSOC);


?>
<?php
$services = $pdo->query("SELECT * FROM services WHERE is_active = 1")->fetchAll();
?>
<?php
$pageTitle = "الفريق العلاجي - مركز المشفى";
$pageDescription = "الفريق العلاجي في مركز المشفى يضم نخبة من المعالجين النفسيين والأخصائيين الاجتماعيين المتخصصين في برامج إعادة التأهيل وعلاج الإدمان. رعاية متكاملة على مدار الساعة.";
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

    <a href="https://wa.me/<?php echo $whatsapp; ?>?text=<?php echo rawurlencode('السلام عليكم، أريد الاستفسار عن خدمات مركز المشفى'); ?>" class="whatsapp-float" target="_blank">
        <i class="fab fa-whatsapp fa-2x"></i>
    </a>
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
                    <span class="section-badge bg-white bg-opacity-25 text-white">فريقنا العلاجي</span>
                    <h1 class="page-hero-title">نخبة من أمهر <span class="text-gradient">المعالجين والاخصائيين</span></h1>
                   <p class="page-hero-subtitle">فريق علاجي متكامل يضم معالجين واخصائيين في الطب النفسي وعلاج الادمان</p>
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
  
<!-- Team Buttons -->
<div class="team-tabs">
    <button class="team-tab-btn active" data-target="therapy-section">
        المعالجين
    </button>

    <button class="team-tab-btn" data-target="specialist-section">
        الاخصائيين
    </button>
</div>

<!-- المعالجين -->
<div class="team-grid team-section active" id="therapy-section">
    <?php foreach($therapyTeam as $member): ?>
        <div class="team-member">
            <img src="<?= $member['photo'] ?>" loading="lazy" alt="<?= $member['name'] ?>">

            <h3><?= $member['name'] ?></h3>

            <p><?= $member['specialty'] ?></p>

            <p><?= $member['bio'] ?></p>
        </div>
    <?php endforeach; ?>
</div>

<!-- الاخصائيين -->
<div class="team-grid team-section" id="specialist-section">
    <?php foreach($specialists as $member): ?>
        <div class="team-member">
            <img src="<?= $member['photo'] ?>" loading="lazy" alt="<?= $member['name'] ?>">

            <h3><?= $member['name'] ?></h3>

            <p><?= $member['specialty'] ?></p>

            <p><?= $member['bio'] ?></p>
        </div>
    <?php endforeach; ?>
</div>
  

    <section class="cta-banner" data-aos="fade-up">
        <div class="container text-center">
            <h2>هل أنت مستعد للقاء فريقنا؟</h2>
            <p>اختر الدكتور المناسب لك وابدأ رحلة التعافي بكل ثقة وأمان</p>
            <a href="booking.php" class="btn btn-primary-custom btn-lg"><i class="fas fa-calendar-check me-2"></i>احجز موعدك الآن</a>
        </div>
    </section>

  <?php include 'includes/footer.php'; ?>
    <?php include 'includes/footer_scripts.php'; ?>
    <style>
        /* Team Tabs */

.team-tabs{
    display:flex;
    justify-content:center;
    align-items:center;
    gap:15px;
    margin:40px 0;
    flex-wrap:wrap;
}

.team-tab-btn{
    border:none;
    padding:14px 30px;
    border-radius:50px;
    background:#f1f5f9;
    color:#222;
    font-weight:700;
    cursor:pointer;
    transition:0.3s ease;
    font-size:16px;
}

.team-tab-btn.active{
    background:linear-gradient(135deg,#00b4d8,#0077b6);
    color:#fff;
    box-shadow:0 10px 25px rgba(0,0,0,0.1);
}

.team-tab-btn:hover{
    transform:translateY(-2px);
}

/* Sections */

.team-section{
    display:none;
}

.team-section.active{
    display:grid;
}
    </style>
    <script>
const tabButtons = document.querySelectorAll('.team-tab-btn');
const sections = document.querySelectorAll('.team-section');

tabButtons.forEach(button => {

    button.addEventListener('click', () => {

        // remove active
        tabButtons.forEach(btn => btn.classList.remove('active'));
        sections.forEach(sec => sec.classList.remove('active'));

        // add active
        button.classList.add('active');

        const target = document.getElementById(button.dataset.target);

        target.classList.add('active');

    });

});
</script>
</body>