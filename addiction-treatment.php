<?php
require_once 'config/settings.php';
?>
<?php
$pageTitle = "علاج الإدمان | أفضل مركز لعلاج الإدمان في قويسنا والمنوفية - مركز المشفى";
$pageDescription = "مركز المشفى أفضل مركز لعلاج الإدمان في قويسنا والمنوفية. برامج علاجية متكاملة بإشراف أطباء نفسيين متخصصين. سرية تامة، دعم 24 ساعة، نسب نجاح عالية. اتصل الآن.";
try {
    $services = $pdo->query("SELECT * FROM services WHERE is_active = 1")->fetchAll();
} catch(PDOException $e) {
    $services = [];
}
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
      "name": "علاج الإدمان",
      "item": "https://www.elmashfa.com/addiction-treatment.php"
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

<a href="https://wa.me/<?php echo $whatsapp; ?>?text=<?php echo rawurlencode('السلام عليكم، أريد الاستفسار عن علاج الإدمان في مركز المشفى'); ?>" class="whatsapp-float" target="_blank">
    <i class="fab fa-whatsapp fa-2x"></i>
</a>

<div class="chat-float" id="chatToggle"><i class="fas fa-comment-medical fa-2x"></i></div>
<div class="chat-box" id="chatBox">
    <div class="chat-header"><h6><i class="fas fa-comment-medical me-2"></i>استشارة سريعة</h6><i class="fas fa-times" id="chatClose"></i></div>
    <div class="chat-body"><div class="chat-message bot-message"><p>مرحباً بك في مركز المشفى. كيف يمكننا مساعدتك اليوم؟</p></div></div>
    <div class="chat-footer"><input type="text" class="form-control" placeholder="اكتب رسالتك هنا..."><button class="btn btn-send"><i class="fas fa-paper-plane"></i></button></div>
</div>

<?php include 'includes/navbar.php'; ?>

<!-- ==================== HERO ==================== -->
<section class="hero-section" id="home">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <div class="container">
            <div class="row align-items-center min-vh-100">
                <div class="col-lg-8 mx-auto text-center">
                    <div class="hero-badge" data-aos="fade-down" data-aos-duration="1000">
                        <span>🏥 مركز المشفى - قويسنا، المنوفية</span>
                    </div>
                 <h1 class="hero-title">
    أفضل برنامج علاج إدمان في قويسنا والمنوفية<br>
    <span class="text-gradient">بسرية تامة وإشراف طبي 24 ساعة</span>
</h1>
                    
                    <p class="hero-subtitle" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                        مركز المشفى بقويسنا المنوفية — أول وأكبر مركز متخصص في علاج إدمان المخدرات والكحول والألعاب الإلكترونية. برامج علاجية متكاملة بإشراف نخبة من أمهر الأطباء النفسيين.
                    </p>
                    <div class="hero-features" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="600">
                        <div class="hero-feature-item"><i class="fas fa-shield-alt"></i><span>سرية تامة 100%</span></div>
                        <div class="hero-feature-item"><i class="fas fa-user-md"></i><span>أطباء نفسيين متخصصين</span></div>
                        <div class="hero-feature-item"><i class="fas fa-clock"></i><span>متاح 24/7</span></div>
                        <div class="hero-feature-item"><i class="fas fa-map-marker-alt"></i><span>قويسنا - المنوفية</span></div>
                    </div>
                    <div class="hero-buttons" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="800">
                        <a href="booking.php" class="btn btn-primary-custom btn-lg">
                            <i class="fas fa-calendar-check me-2"></i>احجز استشارة مجانية
                        </a>
                        <a href="tel:<?php echo $phone; ?>" class="btn btn-outline-custom btn-lg">
                            <i class="fas fa-phone-alt me-2"></i>اتصل بنا الآن
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-wave">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#ffffff" fill-opacity="1" d="M0,160L48,176C96,192,192,224,288,213.3C384,203,480,149,576,138.7C672,128,768,160,864,181.3C960,203,1056,213,1152,197.3C1248,181,1344,139,1392,117.3L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </div>
</section>

<!-- ==================== ما هو الإدمان ==================== -->
<section style="padding: 80px 0; background: #fff;">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <span class="section-badge">فهم الإدمان</span>
                <h2 class="section-title mt-3">ما هو <span class="text-primary-custom">الإدمان</span> وكيف يحدث؟</h2>
                <p style="color:#555; line-height:1.9; font-size:16px; margin-top:20px;">
                    الإدمان مرض مزمن يصيب الدماغ ويؤثر على سلوك الإنسان وقراراته. لا يدل على ضعف في الإرادة، بل هو اضطراب طبي حقيقي يحتاج علاجاً متخصصاً. مركز المشفى بقويسنا يقدم برامج علاجية مبنية على أحدث الأبحاث الطبية.
                </p>
                <ul style="list-style:none; padding:0; margin-top:20px;">
                    <li style="padding:10px 0; border-bottom:1px solid #f0f0f0; color:#444;"><i class="fas fa-check-circle text-danger me-2"></i> إدمان المخدرات والحشيش</li>
                    <li style="padding:10px 0; border-bottom:1px solid #f0f0f0; color:#444;"><i class="fas fa-check-circle text-danger me-2"></i> إدمان الكحول والمواد الأفيونية</li>
                    <li style="padding:10px 0; border-bottom:1px solid #f0f0f0; color:#444;"><i class="fas fa-check-circle text-danger me-2"></i> إدمان الأدوية والمهدئات</li>
                    <li style="padding:10px 0; border-bottom:1px solid #f0f0f0; color:#444;"><i class="fas fa-check-circle text-danger me-2"></i> الإدمان السلوكي (الألعاب - الإنترنت)</li>
                    <li style="padding:10px 0; color:#444;"><i class="fas fa-check-circle text-danger me-2"></i> الإدمان المزدوج مع اضطرابات نفسية</li>
                </ul>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div style="background: linear-gradient(135deg, #d32f2f10, #d32f2f05); border-radius:20px; padding:40px; border: 1px solid #d32f2f20;">
                    <h4 style="color:#d32f2f; margin-bottom:25px; font-weight:700;">⚠️ علامات تدل على وجود إدمان</h4>
                    <?php
                    $signs = [
                        ['icon'=>'fa-brain','text'=>'الرغبة الشديدة في التعاطي والتفكير الدائم فيه'],
                        ['icon'=>'fa-times-circle','text'=>'عدم القدرة على الإقلاع رغم محاولات متعددة'],
                        ['icon'=>'fa-users-slash','text'=>'العزلة عن الأسرة والأصدقاء وتغير الشخصية'],
                        ['icon'=>'fa-briefcase','text'=>'التأثير السلبي على العمل والدراسة والحياة اليومية'],
                        ['icon'=>'fa-exclamation-triangle','text'=>'أعراض الانسحاب عند التوقف كالقلق والتعرق'],
                    ];
                    foreach($signs as $s): ?>
                    <div style="display:flex; align-items:flex-start; gap:15px; margin-bottom:18px;">
                        <div style="background:#d32f2f; color:white; width:38px; height:38px; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                            <i class="fas <?php echo $s['icon']; ?>" style="font-size:14px;"></i>
                        </div>
                        <p style="margin:0; color:#444; line-height:1.7; padding-top:8px;"><?php echo $s['text']; ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==================== خطوات البرنامج العلاجي ==================== -->
<section style="padding: 80px 0; background: #f8f9fa;">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="section-badge">البرنامج العلاجي</span>
            <h2 class="section-title mt-3">خطوات رحلة <span class="text-primary-custom">التعافي</span></h2>
            <p class="section-subtitle">برنامج علاجي متكامل ومدروس بعناية لضمان تعافٍ حقيقي ودائم</p>
        </div>
        <div class="row g-4 mt-4">
            <?php
            $steps = [
                ['num'=>'01','title'=>'التقييم الشامل','desc'=>'يبدأ برنامجنا بتقييم طبي ونفسي شامل لتحديد نوع الإدمان ودرجته وأي اضطرابات مصاحبة لوضع خطة علاجية مخصصة لكل حالة.','icon'=>'fa-clipboard-list'],
                ['num'=>'02','title'=>'سحب السموم الطبي','desc'=>'مرحلة سحب السموم تحت إشراف طبي كامل 24 ساعة لضمان سلامة المريض والتعامل مع أعراض الانسحاب بأمان تام.','icon'=>'fa-hospital'],
                ['num'=>'03','title'=>'العلاج النفسي','desc'=>'جلسات علاج نفسي فردية وجماعية باستخدام أحدث التقنيات العلاجية كالعلاج المعرفي السلوكي لفهم أسباب الإدمان والوقاية من الانتكاسة.','icon'=>'fa-brain'],
                ['num'=>'04','title'=>'التأهيل والدمج','desc'=>'برنامج تأهيل متكامل يساعد المريض على إعادة بناء حياته الاجتماعية والمهنية واكتساب مهارات التعامل مع ضغوط الحياة بدون إدمان.','icon'=>'fa-hands-helping'],
                ['num'=>'05','title'=>'المتابعة بعد العلاج','desc'=>'لا ينتهي دورنا عند الخروج، بل نتابع مع المريض وأسرته لفترة ما بعد العلاج لمنع الانتكاسة وضمان استمرار التعافي.','icon'=>'fa-heart'],
                ['num'=>'06','title'=>'الدعم الأسري','desc'=>'الأسرة جزء أساسي من العلاج. نقدم جلسات إرشاد أسري لمساعدة العائلة على فهم المرض ودعم المريض بالطريقة الصحيحة.','icon'=>'fa-users'],
            ];
            foreach($steps as $step): ?>
            <div class="col-lg-4 col-md-6" data-aos="fade-up">
                <div class="service-card" style="height:100%;">
                    <div style="display:flex; align-items:center; gap:15px; margin-bottom:15px;">
                        <span style="font-size:32px; font-weight:900; color:#d32f2f20;"><?php echo $step['num']; ?></span>
                        <div class="service-icon" style="margin:0;"><i class="fas <?php echo $step['icon']; ?>"></i></div>
                    </div>
                    <h4><?php echo $step['title']; ?></h4>
                    <p><?php echo $step['desc']; ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ==================== CTA وسط الصفحة ==================== -->
<section class="cta-banner" data-aos="fade-up">
    <div class="container text-center">
        <h2>هل تعاني أنت أو أحد أفراد عائلتك من الإدمان؟</h2>
        <p>لا تتردد — التواصل معنا سري تماماً ومجاني. فريقنا متواجد الآن للمساعدة</p>
        <div class="cta-buttons">
            <a href="tel:<?php echo $phone; ?>" class="btn btn-primary-custom btn-lg">
                <i class="fas fa-phone-alt me-2"></i>اتصل الآن - <?php echo $phone; ?>
            </a>
            <a href="https://wa.me/<?php echo $whatsapp; ?>?text=<?php echo rawurlencode('أريد الاستفسار عن علاج الإدمان'); ?>" class="btn btn-outline-custom btn-lg" target="_blank">
                <i class="fab fa-whatsapp me-2"></i>واتساب
            </a>
        </div>
    </div>
</section>

<!-- ==================== لماذا مركز المشفى ==================== -->
<section style="padding: 80px 0; background:#fff;">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="section-badge">لماذا نحن؟</span>
            <h2 class="section-title mt-3">لماذا يختار أهل <span class="text-primary-custom">المنوفية وقويسنا</span> مركز المشفى؟</h2>
        </div>
        <div class="row g-4 mt-4">
            <?php
            $reasons = [
                ['icon'=>'fa-map-marker-alt','title'=>'الموقع المتميز','desc'=>'نقع في قلب قويسنا، شارع التحرير برج التيسير، سهل الوصول من كل أنحاء المنوفية وما حولها.'],
                ['icon'=>'fa-user-shield','title'=>'سرية تامة مضمونة','desc'=>'نفهم حساسية الموضوع. هويتك وبياناتك محمية 100% ولا يعلم بوجودك عندنا إلا من تختار إخباره.'],
                ['icon'=>'fa-certificate','title'=>'أطباء معتمدون','desc'=>'فريقنا من أفضل الأطباء النفسيين والمعالجين المتخصصين في علاج الإدمان بخبرات تمتد لسنوات.'],
                ['icon'=>'fa-home','title'=>'إقامة مريحة وآمنة','desc'=>'بيئة علاجية هادئة وآمنة توفر الراحة النفسية اللازمة لرحلة التعافي بعيداً عن ضغوط الحياة.'],
                ['icon'=>'fa-clock','title'=>'دعم على مدار الساعة','desc'=>'فريقنا متواجد 24 ساعة طوال أيام الأسبوع للرد على استفساراتك وتقديم المساعدة فوراً.'],
                ['icon'=>'fa-chart-line','title'=>'نسب نجاح مرتفعة','desc'=>'سجلنا الحافل بالحالات الناجحة وشهادات المتعافين يتكلم عن نفسه. نفتخر بكل حالة تعافت معنا.'],
            ];
            foreach($reasons as $r): ?>
            <div class="col-lg-4 col-md-6" data-aos="fade-up">
                <div class="service-card" style="text-align:center;">
                    <div class="service-icon"><i class="fas <?php echo $r['icon']; ?>"></i></div>
                    <h4><?php echo $r['title']; ?></h4>
                    <p><?php echo $r['desc']; ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ==================== FAQ - أسئلة شائعة ==================== -->
<section style="padding: 80px 0; background:#f8f9fa;">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="section-badge">أسئلة شائعة</span>
            <h2 class="section-title mt-3">أسئلة عن <span class="text-primary-custom">علاج الإدمان</span></h2>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-lg-8">
                <div class="accordion" id="faqAccordion" data-aos="fade-up">
                    <?php
                    $faqs = [
                        ['q'=>'هل علاج الإدمان في مركز المشفى سري؟','a'=>'نعم، السرية التامة هي أولويتنا الأولى. لا نشارك أي معلومات عن المريض مع أي جهة خارجية. زيارتك لنا وعلاجك عندنا يظل بينك وبيننا فقط.'],
                        ['q'=>'كم مدة برنامج علاج الإدمان؟','a'=>'تختلف المدة حسب كل حالة. في الغالب تتراوح بين 28 يوماً للبرامج المكثفة، وتمتد لـ 90 يوماً أو أكثر للحالات التي تحتاج تأهيلاً شاملاً. طبيبنا يحدد المدة المناسبة بعد التقييم.'],
                        ['q'=>'هل يمكن الزيارة الأسرية أثناء العلاج؟','a'=>'نعم، نشجع على الدعم الأسري لأنه جزء مهم من العلاج. نحدد مواعيد زيارات منظمة بما يخدم العملية العلاجية ويدعم المريض نفسياً.'],
                        ['q'=>'ما هي تكلفة علاج الإدمان في مركز المشفى؟','a'=>'تختلف التكلفة حسب نوع البرنامج ومدته. نقدم استشارة أولية مجانية لتقييم الحالة وتحديد البرنامج المناسب وتكلفته. تواصل معنا الآن للاستفسار.'],
                        ['q'=>'هل يمكن علاج الإدمان بدون إقامة داخلية؟','a'=>'نعم، نقدم برامج العيادات الخارجية للحالات التي لا تستلزم الإقامة الداخلية. الطبيب هو من يقرر البرنامج الأنسب بعد التقييم الأولي.'],
                        ['q'=>'كيف أساعد أحد أفراد عائلتي المدمن؟','a'=>'الخطوة الأولى هي التواصل معنا. سنقدم لك إرشادات عملية للتعامل مع الحالة وكيفية إقناع المريض بالعلاج. لا تتأخر — كلما تأخر العلاج كلما صعبت الحالة.'],
                    ];
                    foreach($faqs as $idx => $faq): ?>
                    <div class="accordion-item" style="border:none; margin-bottom:12px; border-radius:12px; overflow:hidden; box-shadow:0 2px 10px rgba(0,0,0,0.06);">
                        <h2 class="accordion-header">
                            <button class="accordion-button <?php echo $idx > 0 ? 'collapsed' : ''; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#faq<?php echo $idx; ?>" style="font-weight:600; background:white; color:#333;">
                                <?php echo $faq['q']; ?>
                            </button>
                        </h2>
                        <div id="faq<?php echo $idx; ?>" class="accordion-collapse collapse <?php echo $idx === 0 ? 'show' : ''; ?>" data-bs-parent="#faqAccordion">
                            <div class="accordion-body" style="color:#555; line-height:1.8;">
                                <?php echo $faq['a']; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==================== CTA النهائي ==================== -->
<section class="cta-banner" data-aos="fade-up">
    <div class="container text-center">
        <h2>ابدأ رحلة التعافي اليوم</h2>
        <p>مركز المشفى — قويسنا، شارع التحرير، برج التيسير، المنوفية<br>متاح 24 ساعة / 7 أيام / الاتصال والاستشارة مجانية وسرية</p>
        <div class="cta-buttons">
            <a href="booking.php" class="btn btn-primary-custom btn-lg">
                <i class="fas fa-calendar-check me-2"></i>احجز الآن مجاناً
            </a>
            <a href="tel:<?php echo $phone; ?>" class="btn btn-outline-custom btn-lg">
                <i class="fas fa-phone-alt me-2"></i><?php echo $phone; ?>
            </a>
        </div>
    </div>
</section>

<!-- Schema FAQ -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {"@type":"Question","name":"هل علاج الإدمان في مركز المشفى سري؟","acceptedAnswer":{"@type":"Answer","text":"نعم، السرية التامة هي أولويتنا الأولى. لا نشارك أي معلومات عن المريض مع أي جهة خارجية."}},
    {"@type":"Question","name":"كم مدة برنامج علاج الإدمان؟","acceptedAnswer":{"@type":"Answer","text":"تتراوح بين 28 يوماً وتمتد لـ 90 يوماً أو أكثر حسب كل حالة. الطبيب يحدد المدة المناسبة بعد التقييم."}},
    {"@type":"Question","name":"ما هي تكلفة علاج الإدمان في مركز المشفى؟","acceptedAnswer":{"@type":"Answer","text":"تختلف التكلفة حسب البرنامج ومدته. نقدم استشارة أولية مجانية لتحديد البرنامج المناسب وتكلفته."}},
    {"@type":"Question","name":"هل يمكن علاج الإدمان بدون إقامة داخلية؟","acceptedAnswer":{"@type":"Answer","text":"نعم، نقدم برامج العيادات الخارجية للحالات التي لا تستلزم الإقامة الداخلية."}}
  ]
}
</script>

<?php include 'includes/footer.php'; ?>
<?php include 'includes/footer_scripts.php'; ?>
</body>
