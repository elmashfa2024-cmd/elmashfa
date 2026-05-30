<?php
require_once 'config/settings.php';

$pageTitle = "من نحن | فريقنا الطبي في مركز المشفى - أفضل أطباء نفسيين في قويسنا المنوفية";
$pageDescription = "مركز المشفى للطب النفسي وعلاج الإدمان يضم نخبة من أفضل الأطباء النفسيين في مصر. أكثر من 10 سنوات خبرة في علاج الاضطرابات النفسية بسرية تامة.";

// جلب الإدارة (is_active = 2)
$adminTeam = $pdo->query("SELECT * FROM doctors WHERE is_active = 2 ORDER BY rating DESC")->fetchAll();
if (empty($adminTeam)) $adminTeam = [];

// جلب الفريق الطبي (is_active = 1)
$medicalTeam = $pdo->query("SELECT * FROM doctors WHERE is_active = 1 ORDER BY rating DESC")->fetchAll();
if (empty($medicalTeam)) $medicalTeam = [];

// جلب المعالجين
$therapists = $pdo->query("SELECT * FROM staff WHERE team = 'therapy'")->fetchAll(PDO::FETCH_ASSOC);
if (empty($therapists)) $therapists = [];

// جلب الأخصائيين
$specialists = $pdo->query("SELECT * FROM staff WHERE team = 'specialist'")->fetchAll(PDO::FETCH_ASSOC);
if (empty($specialists)) $specialists = [];
try {
    $services = $pdo->query("SELECT * FROM services WHERE is_active = 1")->fetchAll();
} catch(PDOException $e) {
    $services = [];
}
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

<?php include 'includes/navbar.php'; ?>

<!-- Hero -->
<section class="hero-section" id="home">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <span class="section-badge bg-white bg-opacity-25 text-white">تعرف علينا</span>
              
                
                <h1 class="page-hero-title">فريقنا الطبي <span class="text-gradient">نخبة من أفضل الأطباء النفسيين في مصر</span></h1>
<p class="page-hero-subtitle">أكثر من 25 طبيب واستشاري ومعالج متخصص في علاج الإدمان والاضطرابات النفسية - خبرات محلية وعالمية</p>
            </div>
        </div>
    </div>
    <div class="hero-wave">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#fff" fill-opacity="1" d="M0,192L80,202.7C160,213,320,235,480,218.7C640,203,800,149,960,133.3C1120,117,1280,139,1360,149.3L1440,160L1440,320L0,320Z"></path>
        </svg>
    </div>
</section>
<!-- Teams Section -->
<section class="teams-tabs-section py-5">
    <div class="container">

        <!-- Tab Buttons -->
        <div class="teams-tab-nav" data-aos="fade-up">
            <button class="team-tab-btn active" onclick="switchTeamTab('admin', this)">
                <i class="fas fa-building"></i>
                <span>الإدارة</span>
                <span class="tab-count"><?php echo count($adminTeam); ?></span>
            </button>
            <button class="team-tab-btn" onclick="switchTeamTab('medical', this)">
                <i class="fas fa-user-md"></i>
                <span>الفريق الطبي</span>
                <span class="tab-count"><?php echo count($medicalTeam); ?></span>
            </button>
            <button class="team-tab-btn" onclick="switchTeamTab('therapists', this)">
                <i class="fas fa-brain"></i>
                <span>المعالجين</span>
                <span class="tab-count"><?php echo count($therapists); ?></span>
            </button>
            <button class="team-tab-btn" onclick="switchTeamTab('specialists', this)">
                <i class="fas fa-clipboard-list"></i>
                <span>الأخصائيين</span>
                <span class="tab-count"><?php echo count($specialists); ?></span>
            </button>
        </div>

        <!-- Tab: الإدارة -->
        <div id="tab-admin" class="team-tab-content active">
            <div class="tab-header text-center mb-4">
                <h2 class="tab-title">فريق الإدارة</h2>
                <p class="tab-subtitle">قيادة متمرسة تضمن أعلى معايير الرعاية والجودة</p>
            </div>
            <?php if (!empty($adminTeam)): ?>
                <!-- أول عضو مميز -->
                <?php $first = $adminTeam[0]; ?>
                <div class="director-card mb-4" data-aos="fade-up">
                    <div class="row align-items-center g-0">
                        <div class="col-lg-4">
                            <div class="director-image-wrapper">
                                <img src="<?php echo $first['image'] ?: 'https://placehold.co/500x600/1a1a2e/ffffff?text=Admin'; ?>" loading="lazy" alt="<?php echo htmlspecialchars($first['name']); ?>" class="director-img">
                                <div class="director-badge"><i class="fas fa-star"></i> مدير المركز</div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="director-content">
                                  <h2 class="director-name"><?php echo htmlspecialchars($first['name']); ?></h2>
                                <p class="director-title"><?php echo htmlspecialchars($first['specialty']); ?></p>
                                 <span class="section-badge" style="color: #C41E3A !important; background: transparent !important;">مدير الفريق العلاجي والمؤسس</span>
                                <div class="director-stats">
								
                                    <div class="director-stat"><span class="stat-num"><?php echo $first['rating']; ?></span><span class="stat-lbl">التقييم</span></div>
                                </div>
								<?php echo nl2br(htmlspecialchars($first['bio'] ?? 'خبرة واسعة في مجال الطب النفسي وعلاج الإدمان.')); ?></p>
                                <div class="director-actions">
									<a href="tel:<?php echo $footerPhone2; ?>" class="btn btn-primary-custom">
								        <?php echo $footerPhone2; ?>
										<i class="fa-solid fa-mobile-screen-button me-2"></i>
                                    </a>
                                    <a href="booking.php?doctor_id=<?php echo $first['id']; ?>" class="btn btn-primary-custom">
                                        <i class="fas fa-calendar-check me-2"></i>احجز مع الدكتور
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- باقي أعضاء الإدارة -->
                <?php if (count($first) > 1): ?>
                <?php $first = $adminTeam[1]; ?>
                 <div class="director-card mb-4" data-aos="fade-up">
                    <div class="row align-items-center g-0">
                        <div class="col-lg-4">
                            <div class="director-image-wrapper">
                                <img src="<?php echo $first['image'] ?: 'https://placehold.co/500x600/1a1a2e/ffffff?text=Admin'; ?>" loading="lazy" alt="<?php echo htmlspecialchars($first['name']); ?>" class="director-img">
                                <div class="director-badge"><i class="fas fa-star"></i> مدير المركز</div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="director-content">
                                  <h2 class="director-name"><?php echo htmlspecialchars($first['name']); ?></h2>
                                <p class="director-title"><?php echo htmlspecialchars($first['specialty']); ?></p>
                                 <span class="section-badge" style="color: #C41E3A !important; background: transparent !important;">مدير الفريق العلاجي والمؤسس</span>
                                <div class="director-stats">
								
                                    <div class="director-stat"><span class="stat-num"><?php echo $first['rating']; ?></span><span class="stat-lbl">التقييم</span></div>
                                </div>
								<?php echo nl2br(htmlspecialchars($first['bio'] ?? 'خبرة واسعة في مجال الطب النفسي وعلاج الإدمان.')); ?></p>
                                <div class="director-actions">
									<a href="tel:<?php echo $footerPhone2; ?>" class="btn btn-primary-custom">
								        <?php echo $footerPhone2; ?>
										<i class="fa-solid fa-mobile-screen-button me-2"></i>
                                    </a>
                                    <a href="booking.php?doctor_id=<?php echo $first['id']; ?>" class="btn btn-primary-custom">
                                        <i class="fas fa-calendar-check me-2"></i>احجز مع الدكتور
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            <?php else: ?>
                <p class="text-center py-5 text-muted">لا يوجد أعضاء متاحين حالياً</p>
            <?php endif; ?>
        </div>

        <!-- Tab: الفريق الطبي -->
        <div id="tab-medical" class="team-tab-content">
            <div class="tab-header text-center mb-4">
                <h2 class="tab-title">الفريق الطبي</h2>
                <p class="tab-subtitle">نخبة من الأطباء والاستشاريين في الطب النفسي وعلاج الإدمان</p>
            </div>
            <?php if (!empty($medicalTeam)): ?>
                <?php $firstDoc = $medicalTeam[0]; ?>
                <div class="director-card mb-4" data-aos="fade-up">
                    <div class="row align-items-center g-0">
                        <div class="col-lg-4">
                            <div class="director-image-wrapper">
                                <img src="<?php echo $firstDoc['image'] ?: 'https://placehold.co/500x600/1a1a2e/ffffff?text=Dr'; ?>" loading="lazy" alt="<?php echo htmlspecialchars($firstDoc['name']); ?>" class="director-img">
                                <div class="director-badge"><i class="fas fa-star"></i> استشاري أول</div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="director-content">
                                <h2 class="director-name"><?php echo htmlspecialchars($firstDoc['name']); ?></h2>
                                <p class="director-title"><?php echo htmlspecialchars($firstDoc['specialty']); ?></p>
                                <div class="director-stats">
                                    <div class="director-stat">
                                        <span class="stat-num"><?php echo $firstDoc['rating']; ?></span>
                                        <span class="stat-lbl">التقييم</span>
                                    </div>
                                </div>
                                <p class="director-bio"><?php echo nl2br(htmlspecialchars($firstDoc['bio'] ?? '')); ?></p>
                                <div class="director-actions">
                                    <a href="booking.php?doctor_id=<?php echo $firstDoc['id']; ?>" class="btn btn-primary-custom">
                                        <i class="fas fa-calendar-check me-2"></i>احجز مع الدكتور
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if (count($medicalTeam) > 1): ?>
                <div class="doctors-grid-new">
            
                      <?php foreach (array_slice($medicalTeam, 1) as $doctor): ?>
                    <div class="doctor-card-new" data-aos="fade-up">
                        <img src="<?php echo $doctor['image'] ?: 'https://placehold.co/400x450/e8e8e8/333?text=Dr'; ?>" alt="<?php echo htmlspecialchars($doctor['name']); ?>" class="doctor-image-new" loading="lazy">
                        <div class="doctor-info-new">
                            <h3 class="doctor-name-new"><?php echo htmlspecialchars($doctor['name']); ?></h3>
                            <span class="doctor-specialty-new"><?php echo htmlspecialchars($doctor['specialty']); ?></span>
                            <div class="doctor-rating-new">
                                <?php echo str_repeat('⭐', min(5, round($doctor['rating']))); ?>
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
                <?php endif; ?>
            <?php else: ?>
                <p class="text-center py-5 text-muted">لا يوجد أطباء متاحين حالياً</p>
            <?php endif; ?>
        </div>

        <!-- Tab: المعالجين -->
        <div id="tab-therapists" class="team-tab-content">
            <div class="tab-header text-center mb-4">
                <h2 class="tab-title">المعالجين</h2>
                <p class="tab-subtitle">فريق متخصص في علاج الإدمان والتأهيل السلوكي</p>
            </div>
            <?php if (!empty($therapists)): ?>
            <div class="doctors-grid-new">
                <?php foreach ($therapists as $member): ?>
                <div class="doctor-card-new" data-aos="fade-up">
                    <img src="<?php echo htmlspecialchars($member['photo'] ?? ''); ?>" alt="<?php echo htmlspecialchars($member['name']); ?>" class="doctor-image-new" loading="lazy" onerror="this.src='https://placehold.co/400x450/e8e8e8/333?text=معالج'">
                    <div class="doctor-info-new">
                        <h3 class="doctor-name-new"><?php echo htmlspecialchars($member['name']); ?></h3>
                          <div class="doctor-rating-new">
                                <?php echo str_repeat('⭐', min(5, round($member['rating']))); ?>
                                <span>(<?php echo $member['rating']; ?>)</span>
                            </div>
                        <span class="doctor-specialty-new"><?php echo htmlspecialchars($member['specialty']); ?></span>
                             <p class="doctor-bio-new">
    <?php 
    $fullBio = htmlspecialchars($member['bio'] ?? '');
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
                   
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
                <p class="text-center py-5 text-muted">لا يوجد معالجين متاحين حالياً</p>
            <?php endif; ?>
        </div>

        <!-- Tab: الأخصائيين -->
        <div id="tab-specialists" class="team-tab-content">
            <div class="tab-header text-center mb-4">
                <h2 class="tab-title">الأخصائيين</h2>
                <p class="tab-subtitle">أخصائيون نفسيون واجتماعيون يدعمون رحلة التعافي</p>
            </div>
            <?php if (!empty($specialists)): ?>
            <div class="doctors-grid-new">
                <?php foreach ($specialists as $member): ?>
                <div class="doctor-card-new" data-aos="fade-up">
                    <img src="<?php echo htmlspecialchars($member['photo'] ?? ''); ?>" alt="<?php echo htmlspecialchars($member['name']); ?>" class="doctor-image-new" loading="lazy" onerror="this.src='https://placehold.co/400x450/e8e8e8/333?text=أخصائي'">
                    <div class="doctor-info-new">
                        <h3 class="doctor-name-new"><?php echo htmlspecialchars($member['name']); ?></h3>
                          <div class="doctor-rating-new">
                                <?php echo str_repeat('⭐', min(5, round($member['rating']))); ?>
                                <span>(<?php echo $member['rating']; ?>)</span>
                            </div>
                        <span class="doctor-specialty-new"><?php echo htmlspecialchars($member['specialty']); ?></span>
                       <p class="doctor-bio-new">
    <?php 
    $fullBio = htmlspecialchars($member['bio'] ?? '');
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
                   
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
                <p class="text-center py-5 text-muted">لا يوجد أخصائيين متاحين حالياً</p>
            <?php endif; ?>
        </div>

    </div>
</section>

<!-- ==================== قصة المركز (جديد) ==================== -->
<section class="about-story" style="padding: 60px 0; background: #f8f9fa;">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <span class="section-badge">قصتنا</span>
                <h2 class="section-title mt-3">مركز المشفى <span class="text-primary-custom">أول مركز متخصص</span> في قويسنا</h2>
                <p style="color:#555; line-height:1.9;">تأسس مركز المشفى ليكون منارة أمل لكل من يعاني من الإدمان أو الاضطرابات النفسية. نقدم خدماتنا بسرية تامة ورعاية فائقة، تحت إشراف نخبة من أمهر الأطباء النفسيين والمعالجين في مصر والوطن العربي.</p>
                <p style="color:#555; line-height:1.9; margin-top:15px;">نؤمن أن التعافي ممكن لكل إنسان، وأن الصحة النفسية هي أساس الحياة الصحية. لهذا نوفر بيئة علاجية هادئة ومتكاملة تجمع بين أحدث الأساليب العلمية والرعاية الإنسانية.</p>
          
            </div>

        </div>
    </div>
</section>
<!-- CTA -->
<section class="cta-banner" data-aos="fade-up">
    <div class="container text-center">
        <h2>هل أنت مستعد للقاء فريقنا؟</h2>
        <p>اختر المتخصص المناسب لك وابدأ رحلة التعافي بكل ثقة وأمان</p>
        <a href="booking.php" class="btn btn-primary-custom btn-lg">
            <i class="fas fa-calendar-check me-2"></i>احجز موعدك الآن
        </a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>

<style>
/* ===== TAB NAV ===== */
.teams-tab-nav {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 40px;
}

.team-tab-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    border: 2px solid #e9ecef;
    background: #fff;
    color: #555;
    font-family: 'Cairo', sans-serif;
    font-size: 0.95rem;
    font-weight: 600;
    border-radius: 50px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.team-tab-btn:hover {
    border-color: #C41E3A;
    color: #C41E3A;
}

.team-tab-btn.active {
    background: #C41E3A;
    border-color: #C41E3A;
    color: #fff;
    box-shadow: 0 6px 20px rgba(196, 30, 58, 0.3);
}

.tab-count {
    background: rgba(255,255,255,0.25);
    font-size: 0.75rem;
    padding: 2px 8px;
    border-radius: 20px;
    font-weight: 700;
}

.team-tab-btn:not(.active) .tab-count {
    background: #f0f0f0;
    color: #888;
}

/* ===== TAB CONTENT ===== */
.team-tab-content {
    display: none;
    animation: tabFadeUp 0.4s ease forwards;
}

.team-tab-content.active {
    display: block;
}

@keyframes tabFadeUp {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ===== TAB HEADER ===== */
.tab-title {
    font-size: 1.8rem;
    font-weight: 800;
    color: #1a1a2e;
    margin-bottom: 6px;
}

.tab-subtitle {
    color: #777;
    font-size: 0.95rem;
}

/* ===== CARDS (reuse medical-team style) ===== */
.doctors-grid-new {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 24px;
    margin-top: 10px;
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
    box-shadow: 0 20px 40px rgba(196,30,58,0.12);
    border-color: #C41E3A;
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
    font-size: 1.15rem;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 6px;
}

.doctor-specialty-new {
    color: #C41E3A;
    font-weight: 600;
    font-size: 0.82rem;
    background: rgba(196,30,58,0.1);
    padding: 4px 12px;
    border-radius: 50px;
    display: inline-block;
    margin-bottom: 10px;
}

.doctor-rating-new {
    margin-bottom: 10px;
    font-size: 13px;
    color: #C8A951;
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
    gap: 6px;
    background: linear-gradient(135deg, #C41E3A, #8B0000);
    color: #fff;
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
    color: #fff;
    transform: translateY(-2px);
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .team-tab-btn span:not(.tab-count) { display: none; }
    .team-tab-btn { padding: 12px 16px; }

    .doctors-grid-new {
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;

    }

    .doctor-image-new { height: 180px; }
    .doctor-info-new { padding: 12px; }
    .doctor-name-new { font-size: 0.95rem; }
    .doctor-specialty-new { font-size: 0.7rem; }
        .doctor-bio-new {
        font-size: 0.7rem;
        line-height: 1.5;
         display: block !important;
    }
    .btn-booking-new { padding: 8px 10px; font-size: 11px; }
}
</style>

<script>
function switchTeamTab(name, btn) {
    document.querySelectorAll('.team-tab-content').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.team-tab-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('tab-' + name).classList.add('active');
    btn.classList.add('active');
}
</script>

<?php include 'includes/footer_scripts.php'; ?>
</body>