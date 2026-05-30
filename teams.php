<?php
require_once 'config/settings.php';

$pageTitle = "من نحن - مركز المشفى";
$pageDescription = "تعرف على فريق مركز المشفى المتكامل من إداريين وأطباء ومعالجين وأخصائيين";

$stmt = $pdo->query("SELECT * FROM services LIMIT 5");
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);

// جلب عدد الأعضاء لكل فريق
$count_admin   = $pdo->query("SELECT COUNT(*) FROM doctors WHERE is_active = 1")->fetchColumn();
$count_medical = $pdo->query("SELECT COUNT(*) FROM doctors WHERE is_active = 1")->fetchColumn();
$count_therapy = $pdo->query("SELECT COUNT(*) FROM doctors WHERE is_active = 1")->fetchColumn();
?>
<?php include 'includes/header.php'; ?>
<body>
<div class="scroll-progress"></div>
<div id="preloader">
    <div class="loader">
        <div class="loader-logo">
            <img src="photos/ElmashfaLogo.webp" alt="مركز المشفى" loading="lazy">
        </div>
        <p class="mt-3 text-white">مركز المشفى</p>
    </div>
</div>

<a href="https://wa.me/<?php echo $whatsapp; ?>?text=<?php echo rawurlencode('السلام عليكم، أريد الاستفسار عن خدمات مركز المشفى'); ?>" class="whatsapp-float" target="_blank">
    <i class="fab fa-whatsapp fa-2x"></i>
</a>

<?php include 'includes/navbar.php'; ?>

<!-- ==================== HERO ==================== -->
<section class="teams-hero">
    <div class="teams-hero-bg"></div>
    <div class="teams-hero-glow glow-1"></div>
    <div class="teams-hero-glow glow-2"></div>
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <span class="teams-hero-badge">
                    <i class="fas fa-star me-1"></i> تعرف على فريقنا
                </span>
                <h1 class="teams-hero-title">
                    خبراء <span class="teams-hero-highlight">متخصصون</span><br>في خدمتك
                </h1>
                <p class="teams-hero-sub">
                    فريق متكامل من الإداريين والأطباء والمعالجين والأخصائيين<br>
                    يعملون معاً لتقديم أفضل رعاية نفسية بسرية تامة
                </p>
                <div class="teams-hero-stats">
                    <div class="teams-stat">
                        <div class="teams-stat-num">+20</div>
                        <div class="teams-stat-label">متخصص</div>
                    </div>
                    <div class="teams-stat-divider"></div>
                    <div class="teams-stat">
                        <div class="teams-stat-num"><?php echo $experience ?? '10'; ?></div>
                        <div class="teams-stat-label">سنوات خبرة</div>
                    </div>
                    <div class="teams-stat-divider"></div>
                    <div class="teams-stat">
                        <div class="teams-stat-num"><?php echo $success_rate ?? '95'; ?>%</div>
                        <div class="teams-stat-label">نسبة النجاح</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==================== TEAM CARDS ==================== -->
<section class="teams-cards-section">
    <div class="container">
        <div class="text-center mb-2">
            <span class="section-badge">أقسامنا</span>
            <h2 class="section-title mt-2">اختر القسم الذي تريد<br>التعرف عليه</h2>
        </div>
        <div class="row g-4 justify-content-center">

            <!-- الإدارة -->
         <div class="col-lg-4 col-md-6">
                <a href="team.php" class="team-card team-card--admin text-decoration-none">
                    <div class="team-card-img">
                        <img src="Upload/edara.webp" alt="الإدارة" loading="lazy">
                        <div class="team-card-overlay">
                            <i class="fas fa-arrow-left team-card-arrow"></i>
                        </div>
                    </div>
                    <div class="team-card-body">
                        <div class="team-card-icon-wrap admin-icon">
                            <i class="fas fa-users-cog"></i>
                        </div>
                        <h3 class="team-card-title">الإدارة</h3>
                        <p class="team-card-desc">تعرف على فريق القيادة والإدارة وخبراتهم في قيادة مركز المشفى نحو التميز.</p>
                        <div class="team-card-footer">
                            <span class="team-card-link">
                                تعرف على الفريق <i class="fas fa-arrow-left ms-1"></i>
                            </span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- الفريق الطبي -->
         <div class="col-lg-4 col-md-6">
                <a href="medical-team.php" class="team-card team-card--medical text-decoration-none">
                    <div class="team-card-img">
                        <img src="Upload/docs.webp" alt="الفريق الطبي" loading="lazy">
                        <div class="team-card-overlay">
                            <i class="fas fa-arrow-left team-card-arrow"></i>
                        </div>
                    </div>
                    <div class="team-card-body">
                        <div class="team-card-icon-wrap medical-icon">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <h3 class="team-card-title">الفريق الطبي</h3>
                        <p class="team-card-desc">نخبة من الأطباء والاستشاريين المتخصصين في الطب النفسي وعلاج الإدمان.</p>
                        <div class="team-card-footer">
                            <span class="team-card-link">
                                تعرف على الفريق <i class="fas fa-arrow-left ms-1"></i>
                            </span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- الفريق العلاجي -->
         <div class="col-lg-4 col-md-6">
                <a href="therapy-team.php" class="team-card team-card--therapy text-decoration-none">
                    <div class="team-card-img">
                        <img src="Upload/mo3.webp" alt="الفريق العلاجي" loading="lazy">
                        <div class="team-card-overlay">
                            <i class="fas fa-arrow-left team-card-arrow"></i>
                        </div>
                    </div>
                    <div class="team-card-body">
                        <div class="team-card-icon-wrap therapy-icon">
                            <i class="fas fa-hand-holding-heart"></i>
                        </div>
                        <h3 class="team-card-title">المعالجون والأخصائيون</h3>
                        <p class="team-card-desc">فريق المعالجين والأخصائيين النفسيين المتخصصين في برامج التعافي والدعم.</p>
                        <div class="team-card-footer">
                            <span class="team-card-link">
                                تعرف على الفريق <i class="fas fa-arrow-left ms-1"></i>
                            </span>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>
</section>

<!-- ==================== CTA ==================== -->
<section class="teams-cta">
    <div class="container">
        <div class="teams-cta-inner">
            <div class="teams-cta-icon"><i class="fas fa-calendar-check"></i></div>
               <p2>مستعد تبدأ رحله التعافي دلوقتي؟</p>

            <p>فريقنا الطبي جاهز لاستقبالك على مدار الساعة بسرية تامة</p>
            <div class="d-flex gap-3 justify-content-center flex-wrap">
                <a href="booking.php" class="btn btn-light btn-lg px-4">
                    <i class="fas fa-calendar-alt me-2"></i>احجز موعدك الآن
                </a>
                <a href="tel:<?php echo $phone ?? '01069555446'; ?>" class="btn btn-outline-light btn-lg px-4">
                    <i class="fas fa-phone me-2"></i>اتصل بنا
                </a>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>

<style>
/* ==================== TEAMS HERO ==================== */
.teams-hero {
    position: relative;
    min-height: 85vh;
    display: flex;
    align-items: center;
    background: linear-gradient(135deg, #0a0f23 0%, #12172e 50%, #1a0a10 100%);
    overflow: hidden;
    padding: 120px 0 80px;
}
.teams-hero-bg {
    position: absolute; inset: 0;
    background:
        radial-gradient(ellipse 600px 400px at 80% 20%, rgba(196,30,58,.18) 0%, transparent 70%),
        radial-gradient(ellipse 400px 300px at 10% 80%, rgba(196,30,58,.1) 0%, transparent 70%);
}
.teams-hero-glow {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    pointer-events: none;
}
.glow-1 {
    width: 400px; height: 400px;
    background: rgba(196,30,58,.12);
    top: -100px; right: -100px;
}
.glow-2 {
    width: 300px; height: 300px;
    background: rgba(196,30,58,.08);
    bottom: -80px; left: -80px;
}
.teams-hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(196,30,58,.2);
    border: 1px solid rgba(196,30,58,.4);
    color: #ff8099;
    font-size: 13px;
    font-weight: 700;
    padding: 6px 18px;
    border-radius: 30px;
    margin-bottom: 20px;
}
.teams-hero-title {
    font-size: clamp(2rem, 5vw, 3.2rem);
    font-weight: 900;
    color: #fff;
    line-height: 1.25;
    margin-bottom: 20px;
}
.teams-hero-highlight {
    color: #ff4d6d;
    position: relative;
}
.teams-hero-sub {
    font-size: 16px;
    color: #94a3b8;
    line-height: 1.8;
    margin-bottom: 40px;
}
.teams-hero-stats {
    display: inline-flex;
    align-items: center;
    gap: 0;
    background: rgba(255,255,255,.06);
    border: 1px solid rgba(255,255,255,.1);
    border-radius: 20px;
    padding: 16px 32px;
    backdrop-filter: blur(10px);
}
.teams-stat { text-align: center; padding: 0 24px; }
.teams-stat-num {
    font-size: 28px;
    font-weight: 900;
    color: #ff4d6d;
    line-height: 1;
}
.teams-stat-label {
    font-size: 12px;
    color: #94a3b8;
    margin-top: 4px;
}
.teams-stat-divider {
    width: 1px;
    height: 40px;
    background: rgba(255,255,255,.15);
}

/* ==================== TEAM CARDS ==================== */
.teams-cards-section {
    padding: 5px 0;
    background: #f8fafc;
}
.team-card {
   position: relative;
display: block;
    
    flex-direction: column;
    justify-content: space-between;
    border-radius: 18px;
    overflow: hidden;
    background: #fff;
    box-shadow: 0 4px 18px rgba(0,0,0,.06);
    transition: transform .3s ease, box-shadow .3s ease;
    position: relative;
    min-height: auto;
     justify-content: space-between;

}
.team-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 16px 40px rgba(0,0,0,.13);
}
.team-card-img {
    position: relative;
   
    overflow: hidden;
}
.team-card-img img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform .4s ease;
}
.team-card:hover .team-card-img img {
    transform: scale(1.06);
}
.team-card-overlay {
    position: absolute; inset: 0;
    display: flex; align-items: center; justify-content: center;
    opacity: 0;
    transition: opacity .3s ease;
}
.team-card--admin .team-card-overlay   { background: rgba(30,58,95,.6); }
.team-card--medical .team-card-overlay { background: rgba(196,30,58,.6); }
.team-card--therapy .team-card-overlay { background: rgba(6,78,59,.6); }
.team-card:hover .team-card-overlay { opacity: 1; }
.team-card-arrow {
    color: white;
    font-size: 28px;
    transform: translateX(10px);
    transition: transform .3s ease;
}
.team-card:hover .team-card-arrow { transform: translateX(0); }

.team-card-body {
    padding: 24px;
    position: relative;
}
.team-card-icon-wrap {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: white;
    position: absolute;
    top: -26px;
    left: 50%;
    transform: translateX(-50%);
    box-shadow: 0 8px 20px rgba(0,0,0,.18);
    border: 3px solid #fff;
}
.admin-icon   { background: linear-gradient(135deg,#1e3a5f,#2d5986); }
.medical-icon { background: linear-gradient(135deg,#9b1530,#C41E3A); }
.therapy-icon { background: linear-gradient(135deg,#065f46,#059669); }

.team-card-title {
    font-size: 20px;
    font-weight: 900;
    color: #0f172a;
    margin-top: 16px;
    margin-bottom: 10px;
}
.team-card-desc {
    font-size: 14px;
    color: #64748b;
    line-height: 1.7;
    margin-bottom: 20px;
}
.team-card-footer {
    padding-top: 16px;
    border-top: 1px solid #f1f5f9;
}
.team-card-link {
    font-size: 10px;
    
    font-weight: 700;
    transition: gap .2s;
}
.team-card--admin   .team-card-link { color: #2d5986; }
.team-card--medical .team-card-link { color: #C41E3A; }
.team-card--therapy .team-card-link { color: #059669; }

/* ==================== CTA ==================== */
.teams-cta {
    padding: 60px 0;
    background: linear-gradient(135deg, #0a0f23, #1a0a10);
}
.teams-cta-inner {
    text-align: center;
    color: white;
}
.teams-cta-icon {
    width: 70px; height: 70px;
    background: rgba(196,30,58,.2);
    border: 1px solid rgba(196,30,58,.4);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 28px;
    color: #ff4d6d;
    margin: 0 auto 24px;
}
.teams-cta h2 {
    font-size: 28px;
    font-weight: 900;
    margin-bottom: 12px;
}
.teams-cta p {
    color: #94a3b8;
    font-size: 15px;
    margin-bottom: 28px;
}
@media (max-width: 991px) {

    .teams-hero {
        min-height: auto;
        padding: 100px 0 60px;
    }
.teams-cards-section {
    padding: 1px;
    background: #f8fafc;
    
}
    .teams-hero-stats {
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        flex-wrap: nowrap;
        padding: 14px 10px;
        width: 100%;
        max-width: 100%;
        gap: 0;
    }

    .teams-stat {
        flex: 1;
        padding: 0 8px;
    }

    .teams-stat-num {
        font-size: 22px;
    }

    .teams-stat-label {
        font-size: 11px;
    }

    .teams-stat-divider {
        width: 1px;
        height: 35px;
        margin: 0;
    }

    .teams-cards-section .row {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -6px;
    }

    .teams-cards-section .col-lg-4 {
        width: 50%;
        padding: 0 6px;
        margin-bottom: 12px;
    }
    .team-card {
        border-radius: 14px;
        overflow: hidden;
    }

    .team-card-img {
        height: 105px;
    }

   .team-card-body {
        padding: 14px 10px 12px;
        padding-bottom: 10px;
    }

    .team-card-title {
        font-size: 13px;
        line-height: 1.4;
        text-align: center;
        margin-top: 18px;
        margin-bottom: 6px;
    }
 .team-card-desc {
        font-size: 10px;
        line-height: 1.5;
        text-align: center;
        margin-bottom: 4px;

        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

     .team-card-footer {
           padding-top: 4px;
        margin-top: 6px;
         border-top: 1px solid #f1f5f9;
        text-align: center;
    }

     .team-card-link {
            font-size: 10px;
        line-height: 1.2;
    }

     .team-card-icon-wrap {
        width: 40px;
        height: 40px;
        font-size: 14px;
        top: -20px;
        left: 50%;
        transform: translateX(-50%);
        border-radius: 50%;
        border: 2px solid #fff;
    }
}
/* ==================== MOBILE ==================== */
@media (max-width: 768px) {

    .teams-hero {
        min-height: auto;
        padding: 100px 0 60px;
    }
.teams-cards-section {
    padding: 1px;
    background: #f8fafc;
    
}
    .teams-hero-stats {
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        flex-wrap: nowrap;
        padding: 14px 10px;
        width: 100%;
        max-width: 100%;
        gap: 0;
    }

    .teams-stat {
        flex: 1;
        padding: 0 8px;
    }

    .teams-stat-num {
        font-size: 22px;
    }

    .teams-stat-label {
        font-size: 11px;
    }

    .teams-stat-divider {
        width: 1px;
        height: 35px;
        margin: 0;
    }

    .teams-cards-section .row {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -6px;
    }

    .teams-cards-section .col-lg-4 {
        width: 50%;
        padding: 0 6px;
        margin-bottom: 12px;
    }
    .team-card {
        border-radius: 14px;
        overflow: hidden;
    }

    .team-card-img {
        height: 105px;
    }

   .team-card-body {
        padding: 14px 10px 12px;
        padding-bottom: 10px;
    }

    .team-card-title {
        font-size: 13px;
        line-height: 1.4;
        text-align: center;
        margin-top: 18px;
        margin-bottom: 6px;
    }
 .team-card-desc {
        font-size: 10px;
        line-height: 1.5;
        text-align: center;
        margin-bottom: 4px;

        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

     .team-card-footer {
           padding-top: 4px;
        margin-top: 6px;
         border-top: 1px solid #f1f5f9;
        text-align: center;
    }

     .team-card-link {
            font-size: 10px;
        line-height: 1.2;
    }

     .team-card-icon-wrap {
        width: 40px;
        height: 40px;
        font-size: 14px;
        top: -20px;
        left: 50%;
        transform: translateX(-50%);
        border-radius: 50%;
        border: 2px solid #fff;
    }
}
</style>
<?php include 'includes/footer_scripts.php'; ?>
</body>
