<?php
require_once 'config/settings.php';
?>
<?php
$pageTitle = "علاج الطب النفسي في قويسنا المنوفية - مركز المشفى";
$pageDescription = "مركز المشفى أفضل مركز للطب النفسي في قويسنا والمنوفية. علاج الاكتئاب، الوسواس القهري، القلق، الفصام، واضطرابات الشخصية. أطباء نفسيون متخصصون، سرية تامة، دعم 24 ساعة.";
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
      "name": "الطب النفسى",
      "item": "https://www.elmashfa.com/psychiatric-treatment.php"
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

<a href="https://wa.me/<?php echo $whatsapp; ?>?text=<?php echo rawurlencode('السلام عليكم، أريد الاستفسار عن العلاج النفسي في مركز المشفى'); ?>" class="whatsapp-float" target="_blank">
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
                        <span>🧠 مركز المشفى - قويسنا، المنوفية</span>
                    </div>
                    <h1 class="hero-title" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                        الطب النفسي المتخصص<br>
                        <span class="text-gradient">بسرية وأمان تامين</span>
                    </h1>
                    <p class="hero-subtitle" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                        مركز المشفى بقويسنا المنوفية — مركز متخصص في الطب النفسي وعلاج الاضطرابات النفسية. فريق من أمهر الأطباء النفسيين يقدم رعاية متكاملة بأحدث الأساليب العلمية.
                    </p>
                    <div class="hero-features" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="600">
                        <div class="hero-feature-item"><i class="fas fa-shield-alt"></i><span>سرية تامة 100%</span></div>
                        <div class="hero-feature-item"><i class="fas fa-user-md"></i><span>أطباء نفسيون متخصصون</span></div>
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

<!-- ==================== الاضطرابات النفسية ==================== -->
<section style="padding: 80px 0; background: #fff;">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="section-badge">الاضطرابات التي نعالجها</span>
            <h2 class="section-title mt-3">الأمراض النفسية التي <span class="text-primary-custom">نتخصص في علاجها</span></h2>
            <p class="section-subtitle">نقدم رعاية طبية نفسية متكاملة لمجموعة واسعة من الاضطرابات النفسية بأحدث الأساليب العلمية</p>
        </div>
        <div class="row g-4 mt-4">
            <?php
            $disorders = [
                [
                    'icon' => 'fa-cloud-rain',
                    'title' => 'الاكتئاب',
                    'desc' => 'علاج جميع درجات الاكتئاب من الخفيف إلى الشديد باستخدام العلاج الدوائي والنفسي المتكامل. نساعدك على استعادة الحياة الطبيعية والتوقف عن الشعور بالحزن والإرهاق.',
                    'symptoms' => ['الحزن المستمر والإرهاق', 'فقدان الاهتمام بالحياة', 'اضطرابات النوم والشهية', 'الأفكار السلبية المتكررة']
                ],
                [
                    'icon' => 'fa-brain',
                    'title' => 'الوسواس القهري',
                    'desc' => 'علاج متخصص لاضطراب الوسواس القهري باستخدام العلاج السلوكي المعرفي والدواء المناسب. نساعدك على التحرر من الأفكار الوسواسية والسلوكيات القهرية.',
                    'symptoms' => ['أفكار متكررة لا يمكن إيقافها', 'سلوكيات قهرية متكررة', 'الخوف المبالغ من الأذى', 'الحاجة للتكرار والتحقق']
                ],
                [
                    'icon' => 'fa-heartbeat',
                    'title' => 'اضطرابات القلق',
                    'desc' => 'علاج القلق العام، نوبات الهلع، والرهاب الاجتماعي. نقدم برامج علاجية فعالة تساعدك على التحكم في القلق والعيش حياة طبيعية هادئة.',
                    'symptoms' => ['قلق مستمر ومفرط', 'نوبات هلع مفاجئة', 'الخوف من المواقف الاجتماعية', 'أعراض جسدية كالتعرق والخفقان']
                ],
                [
                    'icon' => 'fa-user-slash',
                    'title' => 'الفصام',
                    'desc' => 'علاج متكامل لمرض الفصام واضطرابات الذهان باستخدام أحدث الأدوية النفسية وبرامج التأهيل. نعمل مع المريض وأسرته لتحقيق أفضل جودة حياة ممكنة.',
                    'symptoms' => ['الهلوسة السمعية والبصرية', 'الأفكار الوهمية غير المنطقية', 'الانسحاب الاجتماعي', 'اضطراب التفكير والكلام']
                ],
                [
                    'icon' => 'fa-bolt',
                    'title' => 'اضطراب ثنائي القطب',
                    'desc' => 'علاج متخصص لاضطراب ثنائي القطب (الهوس والاكتئاب) بمتابعة طبية مستمرة وخطة علاجية دقيقة تضمن استقرار المزاج وجودة الحياة.',
                    'symptoms' => ['تقلبات حادة في المزاج', 'فترات هوس ونشاط مفرط', 'فترات اكتئاب شديد', 'قرارات متهورة في فترات الهوس']
                ],
                [
                    'icon' => 'fa-users',
                    'title' => 'الإرشاد الأسري والزوجي',
                    'desc' => 'جلسات إرشاد نفسي متخصصة للأزواج والأسر لحل النزاعات، تحسين التواصل، ودعم الصحة النفسية للأسرة كوحدة متكاملة.',
                    'symptoms' => ['مشاكل التواصل الزوجي', 'الخلافات الأسرية المستمرة', 'صعوبات التربية', 'الأزمات الأسرية']
                ],
            ];
            foreach($disorders as $d): ?>
            <div class="col-lg-4 col-md-6" data-aos="fade-up">
                <div class="service-card" style="height:100%;">
                    <div class="service-icon"><i class="fas <?php echo $d['icon']; ?>"></i></div>
                    <h4><?php echo $d['title']; ?></h4>
                    <p><?php echo $d['desc']; ?></p>
                    <div style="margin-top:15px; border-top:1px solid #f0f0f0; padding-top:15px;">
                        <small style="color:#888; font-weight:600; display:block; margin-bottom:8px;">الأعراض الشائعة:</small>
                        <?php foreach($d['symptoms'] as $s): ?>
                        <div style="display:flex; align-items:center; gap:8px; margin-bottom:5px;">
                            <i class="fas fa-circle" style="font-size:6px; color:#d32f2f;"></i>
                            <small style="color:#555;"><?php echo $s; ?></small>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ==================== CTA وسط ==================== -->
<section class="cta-banner" data-aos="fade-up">
    <div class="container text-center">
        <h2>هل تعاني من أي من هذه الأعراض؟</h2>
        <p>لا تتأخر في طلب المساعدة — الصحة النفسية بنفس أهمية الصحة الجسدية. تواصل معنا الآن بسرية تامة</p>
        <div class="cta-buttons">
            <a href="tel:<?php echo $phone; ?>" class="btn btn-primary-custom btn-lg">
                <i class="fas fa-phone-alt me-2"></i>اتصل الآن - <?php echo $phone; ?>
            </a>
            <a href="https://wa.me/<?php echo $whatsapp; ?>?text=<?php echo rawurlencode('أريد الاستفسار عن العلاج النفسي'); ?>" class="btn btn-outline-custom btn-lg" target="_blank">
                <i class="fab fa-whatsapp me-2"></i>واتساب
            </a>
        </div>
    </div>
</section>

<!-- ==================== منهجية العلاج ==================== -->
<section style="padding: 80px 0; background: #f8f9fa;">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="section-badge">منهجيتنا العلاجية</span>
            <h2 class="section-title mt-3">كيف <span class="text-primary-custom">نعالج</span> في مركز المشفى؟</h2>
            <p class="section-subtitle">نتبع منهجية علمية متكاملة مبنية على أحدث الأبحاث الطبية النفسية العالمية</p>
        </div>
        <div class="row g-4 mt-4">
            <?php
            $methods = [
                ['num'=>'01','icon'=>'fa-comments','title'=>'التقييم النفسي الشامل','desc'=>'نبدأ بتقييم نفسي شامل ودقيق لفهم الحالة من جميع جوانبها وتحديد أسباب المشكلة ووضع خطة علاجية مخصصة.'],
                ['num'=>'02','icon'=>'fa-pills','title'=>'العلاج الدوائي المتخصص','desc'=>'وصف الأدوية النفسية المناسبة بالجرعات الصحيحة ومتابعتها بشكل دوري لضمان الفعالية وتجنب الآثار الجانبية.'],
                ['num'=>'03','icon'=>'fa-brain','title'=>'العلاج النفسي السلوكي','desc'=>'جلسات علاج نفسي فردية باستخدام أحدث التقنيات كالعلاج المعرفي السلوكي لتغيير أنماط التفكير السلبية.'],
                ['num'=>'04','icon'=>'fa-users','title'=>'العلاج الجماعي والأسري','desc'=>'جلسات جماعية وأسرية تساعد المريض على التعامل مع المحيط وتعزز دعم الأسرة في رحلة التعافي.'],
                ['num'=>'05','icon'=>'fa-spa','title'=>'العلاج بالاسترخاء','desc'=>'تقنيات الاسترخاء والتأمل وإدارة الضغوط لمساعدة المريض على التحكم في الأعراض النفسية بشكل طبيعي.'],
                ['num'=>'06','icon'=>'fa-chart-line','title'=>'المتابعة المستمرة','desc'=>'متابعة دورية منتظمة بعد الجلسات لقياس التقدم وتعديل خطة العلاج لضمان الوصول لأفضل نتيجة.'],
            ];
            foreach($methods as $m): ?>
            <div class="col-lg-4 col-md-6" data-aos="fade-up">
                <div class="service-card" style="text-align:center;">
                    <div style="display:flex; align-items:center; justify-content:center; gap:15px; margin-bottom:15px;">
                        <span style="font-size:32px; font-weight:900; color:#d32f2f20;"><?php echo $m['num']; ?></span>
                        <div class="service-icon" style="margin:0;"><i class="fas <?php echo $m['icon']; ?>"></i></div>
                    </div>
                    <h4><?php echo $m['title']; ?></h4>
                    <p><?php echo $m['desc']; ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ==================== لماذا مركز المشفى ==================== -->
<section style="padding: 80px 0; background:#fff;">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <span class="section-badge">ميزتنا</span>
                <h2 class="section-title mt-3">لماذا نحن <span class="text-primary-custom">الخيار الأول</span> في قويسنا والمنوفية؟</h2>
                <p style="color:#555; line-height:1.9; margin-top:20px;">
                    مركز المشفى هو أول وأكبر مركز متخصص في الطب النفسي بمدينة قويسنا، المنوفية. نفخر بتقديم خدمة طبية نفسية على أعلى مستوى بأسعار مناسبة وبسرية تامة.
                </p>
                <div style="margin-top:25px;">
                    <?php
                    $reasons = [
                        ['icon'=>'fa-map-marker-alt','text'=>'الموقع المتميز في قويسنا — شارع التحرير، برج التيسير'],
                        ['icon'=>'fa-user-md','text'=>'فريق من أفضل الأطباء النفسيين في المنوفية'],
                        ['icon'=>'fa-shield-alt','text'=>'سرية تامة مضمونة — لا أحد يعلم بزيارتك'],
                        ['icon'=>'fa-clock','text'=>'متاحون 24 ساعة، 7 أيام في الأسبوع'],
                        ['icon'=>'fa-money-bill-wave','text'=>'أسعار مناسبة وجلسة تقييم مجانية'],
                        ['icon'=>'fa-home','text'=>'إقامة داخلية للحالات التي تحتاج متابعة مكثفة'],
                    ];
                    foreach($reasons as $r): ?>
                    <div style="display:flex; align-items:center; gap:15px; margin-bottom:16px;">
                        <div style="background:#d32f2f15; color:#d32f2f; width:42px; height:42px; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                            <i class="fas <?php echo $r['icon']; ?>"></i>
                        </div>
                        <p style="margin:0; color:#444; font-size:15px;"><?php echo $r['text']; ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div style="background: linear-gradient(135deg, #d32f2f08, #d32f2f03); border:1px solid #d32f2f15; border-radius:20px; padding:40px;">
                    <h4 style="color:#d32f2f; font-weight:700; margin-bottom:25px; text-align:center;">📊 أرقامنا تتكلم</h4>
                    <?php
                    $stats = [
                        ['num'=>$experience ?? '10','label'=>'سنوات خبرة في الطب النفسي','icon'=>'fa-calendar-alt'],
                        ['num'=>'+1000','label'=>'حالة تم علاجها بنجاح','icon'=>'fa-user-check'],
                        ['num'=>'95%','label'=>'نسبة رضا المرضى وذويهم','icon'=>'fa-star'],
                        ['num'=>'24/7','label'=>'ساعة دعم ومتابعة','icon'=>'fa-clock'],
                    ];
                    foreach($stats as $s): ?>
                    <div style="display:flex; align-items:center; gap:20px; margin-bottom:20px; background:white; padding:16px 20px; border-radius:12px; box-shadow:0 2px 10px rgba(0,0,0,0.04);">
                        <div style="background:#d32f2f; color:white; width:46px; height:46px; border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                            <i class="fas <?php echo $s['icon']; ?>"></i>
                        </div>
                        <div>
                            <div style="font-size:24px; font-weight:900; color:#d32f2f;"><?php echo $s['num']; ?></div>
                            <div style="font-size:13px; color:#666;"><?php echo $s['label']; ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==================== FAQ ==================== -->
<section style="padding: 80px 0; background: #f8f9fa;">
    <div class="container">
        <div class="section-header text-center" data-aos="fade-up">
            <span class="section-badge">أسئلة شائعة</span>
            <h2 class="section-title mt-3">أسئلة عن <span class="text-primary-custom">العلاج النفسي</span></h2>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-lg-8">
                <div class="accordion" id="faqAccordion" data-aos="fade-up">
                    <?php
                    $faqs = [
                        ['q'=>'هل زيارة الطبيب النفسي تعني إني "مجنون"؟','a'=>'بالطبع لا. الطب النفسي مثله مثل أي تخصص طبي آخر. كثير من الناس يزورون الطبيب النفسي للتعامل مع الضغوط، الاكتئاب، القلق، أو مشاكل الحياة العادية. طلب المساعدة هو علامة قوة وليس ضعف.'],
                        ['q'=>'هل العلاج النفسي سري؟','a'=>'نعم، السرية التامة مضمونة 100%. لن نشارك أي معلومات عنك مع أي شخص. يمكنك زيارتنا بثقة كاملة دون أن يعلم أحد.'],
                        ['q'=>'كم تكلفة الجلسة النفسية في مركز المشفى؟','a'=>'نقدم جلسة تقييم أولية مجانية. أسعار الجلسات مناسبة ومعقولة مقارنة بجودة الخدمة المقدمة. تواصل معنا لمعرفة التفاصيل.'],
                        ['q'=>'كم عدد الجلسات التي أحتاجها؟','a'=>'يختلف عدد الجلسات من حالة لأخرى. بعض الحالات تتحسن في جلسات قليلة، وبعضها يحتاج متابعة أطول. الطبيب يحدد عدد الجلسات المناسب بعد التقييم.'],
                        ['q'=>'هل يمكنني التوقف عن الأدوية النفسية فجأة؟','a'=>'لا، يجب عدم التوقف عن أي دواء نفسي دون استشارة الطبيب. التوقف المفاجئ قد يسبب أعراض انسحاب خطيرة. دائماً استشر طبيبك قبل أي تغيير.'],
                        ['q'=>'هل يمكن علاج الاكتئاب بدون أدوية؟','a'=>'في بعض الحالات الخفيفة، العلاج النفسي وحده يكون كافياً. في حالات أخرى، الجمع بين الدواء والعلاج النفسي يعطي أفضل نتيجة. الطبيب هو من يقرر الخطة المناسبة.'],
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
        <h2>ابدأ رحلتك نحو الصحة النفسية اليوم</h2>
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

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {"@type":"Question","name":"هل زيارة الطبيب النفسي تعني إني مجنون؟","acceptedAnswer":{"@type":"Answer","text":"بالطبع لا. الطب النفسي مثله مثل أي تخصص طبي آخر. طلب المساعدة هو علامة قوة وليس ضعف."}},
   
   {"@type":"Question","name":"كم عدد الجلسات النفسية المطلوبة للتحسن؟","acceptedAnswer":{"@type":"Answer","text":"يختلف عدد الجلسات حسب الحالة. بعض الحالات تتحسن في 8 إلى 12 جلسة، وحالات أخرى تحتاج متابعة أطول. الطبيب يحدد الخطة العلاجية بعد التقييم الأول."}},
    
    {"@type":"Question","name":"كم تكلفة الجلسة النفسية في مركز المشفى؟","acceptedAnswer":{"@type":"Answer","text":"نقدم جلسة تقييم أولية مجانية. أسعار الجلسات مناسبة ومعقولة. تواصل معنا لمعرفة التفاصيل."}},
    {"@type":"Question","name":"هل يمكن علاج الاكتئاب بدون أدوية؟","acceptedAnswer":{"@type":"Answer","text":"في بعض الحالات الخفيفة العلاج النفسي وحده كافٍ. في حالات أخرى الجمع بين الدواء والعلاج النفسي يعطي أفضل نتيجة."}}
  ]
}
</script>

<?php include 'includes/footer.php'; ?>
<?php include 'includes/footer_scripts.php'; ?>
</body>