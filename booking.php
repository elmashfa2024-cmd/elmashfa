<?php
// أضف دول في أول الملف
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * صفحة الحجز - مركز المشفى للطب النفسي وعلاج الإدمان
 */
session_start();
require_once 'config/csrf.php';
require_once 'config/settings.php';
require_once 'config/database.php';  // <-- هل السطر ده موجود؟
$csrf_token = csrf_generate();

// باقي الكود...
// جلب الخدمات من قاعدة البيانات
$services = $pdo->query("SELECT * FROM services WHERE is_active = 1")->fetchAll();

// جلب الأطباء من قاعدة البيانات
$doctors = $pdo->query("SELECT * FROM doctors WHERE is_active = 1")->fetchAll();

// جلب إعدادات التواصل

?>
<?php
$pageTitle = "الحجز - مركز المشفى";
$pageDescription = "احجز موعدك الآن في مركز المشفى. استشارة طبية نفسية سرية مع أفضل الأطباء المتخصصين. اختر الموعد المناسب لك واحصل على تقييم مجاني. احجز فوراً.";;
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

    <!-- Navigation -->
    <!-- ==================== Navebar SECTION Elgazar ==================== -->
 <?php include 'includes/navbar.php'; ?>

 <section class="hero-section" id="home">

    <!-- Background -->
    <div class="hero-overlay"></div>

    <!-- Content -->
    <div class="hero-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <span class="section-badge bg-white bg-opacity-25 text-white"> حجز واستشارات بسرية تامة</span>
                    <h1 class="page-hero-title">الحجز في سرية تامة
<span class="text-gradient">بأمان وخصوصية كاملة
</span></h1>
                    <p class="page-hero-subtitle">مركز المشفى للطب النفسي وعلاج الإدمان يقدم رعاية نفسية متكاملة تحت إشراف نخبة من أفضل الأطباء المتخصصين في مصر والوطن العربي.

</p>
                </div>
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

    <!-- Page Hero -->
 

    <!-- Booking Section -->
	<form id="booking-form">
		<input type="hidden" id="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
    <section class="booking-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    
                    <!-- Stepper -->
                    <div class="stepper" data-aos="fade-up">
                        <div class="step-indicator active" data-step="1">
                            <div class="step-circle"><i class="fas fa-clipboard-list"></i></div>
                            <span>اختيار الخدمة</span>
                        </div>
                        <div class="step-line" data-line="1"></div>
                        <div class="step-indicator" data-step="2">
                            <div class="step-circle"><i class="fas fa-user-md"></i></div>
                            <span>اختيار الطبيب</span>
                        </div>
                        <div class="step-line" data-line="2"></div>
                        <div class="step-indicator" data-step="3">
                            <div class="step-circle"><i class="fas fa-calendar-alt"></i></div>
                            <span>تحديد الموعد</span>
                        </div>
                        <div class="step-line" data-line="3"></div>
                        <div class="step-indicator" data-step="4">
                            <div class="step-circle"><i class="fas fa-credit-card"></i></div>
                            <span>تأكيد الحجز</span>
                        </div>
                    </div>

                    <!-- Booking Card -->
                    <div class="booking-card" data-aos="fade-up" data-aos-delay="200">
                        
                        <!-- Step 1: Select Service -->
                        <div class="booking-step active" id="step1">
                            <h3 class="step-title"><i class="fas fa-clipboard-list me-2"></i>اختر الخدمة المناسبة</h3>
                            <p class="step-desc">حدد نوع الاستشارة التي تحتاجها لنساعدك بشكل أفضل</p>
                            
                            <div class="service-options">
                                <?php foreach ($services as $service): ?>
                                <div class="service-option-card" onclick="selectService(<?php echo $service['id']; ?>, '<?php echo htmlspecialchars($service['title']); ?>', this)">
                                    <div class="option-icon"><i class="fas <?php echo $service['icon'] ?? 'fa-capsules'; ?>"></i></div>
                                    <h5><?php echo htmlspecialchars($service['title']); ?></h5>
                                    <p><?php echo htmlspecialchars($service['description']); ?></p>
                                    <span class="option-check"><i class="fas fa-check"></i></span>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            
                            <div class="step-navigation">
                                <!-- شيل الـ href -->
<button type="button" class="btn btn-primary-custom btn-lg" onclick="nextStep(2)" id="step1Next" disabled>
    التالي <i class="fas fa-arrow-left ms-2"></i>
</button>
                                  
                                </button>
                            </div>
                        </div>

                        <!-- Step 2: Select Doctor -->
                        <div class="booking-step" id="step2">
                            <h3 class="step-title"><i class="fas fa-user-md me-2"></i>اختر الطبيب المعالج</h3>
                            <p class="step-desc">يمكنك اختيار الطبيب الذي تفضله أو ترك الخيار لنا</p>
                            
                            <div class="doctor-options">
                                <?php foreach ($doctors as $doctor): ?>
                                <div class="doctor-option-card" onclick="selectDoctor(<?php echo $doctor['id']; ?>, '<?php echo htmlspecialchars($doctor['name']); ?>', this)">
                                    <img src="<?php echo $doctor['image'] ?: 'https://placehold.co/100x100/e8e8e8/333333?text=Dr'; ?>" loading="lazy" alt="<?php echo htmlspecialchars($doctor['name']); ?>">
                                    <div class="doctor-info">
                                        <h6><?php echo htmlspecialchars($doctor['name']); ?></h6>
                                        <span><?php echo htmlspecialchars($doctor['specialty']); ?></span>
                                        <div class="doctor-rating">
                                            <?php 
                                            $rating = round($doctor['rating']);
                                            echo str_repeat('⭐', $rating);
                                            ?>
                                        </div>
                                    </div>
                                    <span class="option-check"><i class="fas fa-check"></i></span>
                                </div>
                                <?php endforeach; ?>
                                <div class="doctor-option-card" onclick="selectDoctor(0, 'سيتم اختيار طبيب مناسب', this)">
                                    <img src="https://placehold.co/100x100/f8f9fa/6c757d?text=Any" alt="أي طبيب" loading="lazy">
                                    <div class="doctor-info">
                                        <h6>لا أفضل طبيب معين</h6>
                                        <span>سيقوم المركز باختيار الطبيب الأنسب</span>
                                    </div>
                                    <span class="option-check"><i class="fas fa-check"></i></span>
                                </div>
                            </div>

                            <div class="confidential-option mt-4">
                                <label class="confidential-check">
                                    <input type="checkbox" id="confidentialBooking">
                                    <span class="checkmark"></span>
                                    <div>
                                        <strong>حجز سري تماماً</strong>
                                        <p class="mb-0 text-muted">سيتم التعامل مع حجزك بسرية تامة</p>
                                    </div>
                                </label>
                            </div>

                            <div class="step-navigation">
                                <button class="btn btn-outline-secondary btn-lg" onclick="prevStep(1)">
                                    <i class="fas fa-arrow-right me-2"></i> السابق
                                </button>
                               <button type="button" class="btn btn-primary-custom btn-lg" onclick="nextStep(3)" id="step2Next" disabled>
    التالي <i class="fas fa-arrow-left ms-2"></i>
</button>
                            </div>
                        </div>

                        <!-- Step 3: Date & Time -->
                        <div class="booking-step" id="step3">
                            <h3 class="step-title"><i class="fas fa-calendar-alt me-2"></i>حدد الموعد المناسب</h3>
                            <p class="step-desc">اختر التاريخ والوقت الذي يناسبك للاستشارة</p>
                            
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">التاريخ</label>
                                    <input type="date" class="form-control form-control-lg" id="bookingDate" min="<?php echo date('Y-m-d'); ?>" onchange="updateSummary()">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">الوقت</label>
                                    <select class="form-select form-select-lg" id="bookingTime" onchange="updateSummary()">
                                        <option value="">اختر الوقت</option>
                                        <?php
                                        $times = ['9:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00'];
                                        foreach ($times as $time): ?>
                                        <option value="<?php echo $time; ?>"><?php echo $time; ?> <?php echo ($time < '12:00') ? 'صباحاً' : (($time < '17:00') ? 'ظهراً' : 'مساءً'); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12">
                                    <label class="form-label fw-bold">طريقة الاستشارة</label>
                                    <div class="consultation-types">
                                        <label class="consultation-card">
                                            <input type="radio" name="consultType" value="online" checked onchange="updateSummary()">
                                            <div class="consult-card-content">
                                                <i class="fas fa-video"></i>
                                                <h6>استشارة أونلاين</h6>
                                                <span>عبر تطبيق آمن ومشفر</span>
                                            </div>
                                        </label>
                                        <label class="consultation-card">
                                            <input type="radio" name="consultType" value="center" onchange="updateSummary()">
                                            <div class="consult-card-content">
                                                <i class="fas fa-hospital"></i>
                                                <h6>زيارة المركز</h6>
                                                <span>في مقر المركز بالقاهرة</span>
                                            </div>
                                        </label>
                                        <label class="consultation-card">
                                            <input type="radio" name="consultType" value="phone" onchange="updateSummary()">
                                            <div class="consult-card-content">
                                                <i class="fas fa-phone-alt"></i>
                                                <h6>استشارة هاتفية</h6>
                                                <span>مكالمة صوتية خاصة</span>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="step-navigation">
                                <button class="btn btn-outline-secondary btn-lg" onclick="prevStep(2)">
                                    <i class="fas fa-arrow-right me-2"></i> السابق
                                </button>
                             <button type="button" class="btn btn-primary-custom btn-lg" onclick="nextStep(4)" id="step3Next" disabled>
    التالي <i class="fas fa-arrow-left ms-2"></i>
</button>
                            </div>
                        </div>

                        <!-- Step 4: Payment & Confirmation -->
                        <div class="booking-step" id="step4">
                            <h3 class="step-title"><i class="fas fa-credit-card me-2"></i>تأكيد الحجز والدفع</h3>
                            <p class="step-desc">راجع بيانات الحجز وقم بإتمام عملية الدفع لتأكيد الموعد</p>
                            
                            <!-- Booking Summary -->
                            <div class="booking-summary">
                                <h6><i class="fas fa-receipt me-2"></i>ملخص الحجز</h6>
                                <div class="summary-grid">
                                    <div class="summary-item">
                                        <span class="summary-label">الخدمة:</span>
                                        <span class="summary-value" id="summaryService">-</span>
                                    </div>
                                    <div class="summary-item">
                                        <span class="summary-label">الطبيب:</span>
                                        <span class="summary-value" id="summaryDoctor">-</span>
                                    </div>
                                    <div class="summary-item">
                                        <span class="summary-label">التاريخ:</span>
                                        <span class="summary-value" id="summaryDate">-</span>
                                    </div>
                                    <div class="summary-item">
                                        <span class="summary-label">الوقت:</span>
                                        <span class="summary-value" id="summaryTime">-</span>
                                    </div>
                                    <div class="summary-item">
                                        <span class="summary-label">نوع الاستشارة:</span>
                                        <span class="summary-value" id="summaryConsultType">-</span>
                                    </div>
                                    <div class="summary-item">
                                        <span class="summary-label">التكلفة التقديرية:</span>
                                        <span class="summary-value text-primary-custom fw-bold">500 ج.م</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Personal Info -->
                            <div class="row g-3 mt-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">الاسم الكامل</label>
                                    <input type="text" class="form-control form-control-lg" id="patientName" placeholder="الاسم (اختياري للسرية)">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">رقم الهاتف <span class="text-danger">*</span></label>
                                    <!-- السطر الصحيح -->
<input type="tel" name="patient_phone" class="form-control form-control-lg" id="patientPhone" placeholder="01xxxxxxxxx">
                                </div>
                            </div>

                            <!-- Payment Method -->
                            <div class="payment-section mt-4">
                                <h6><i class="fas fa-money-bill-wave me-2"></i>طريقة الدفع</h6>
                                <div class="payment-methods">
                                    <label class="payment-card" onclick="selectPayment('vodafone')">
                                        <input type="radio" name="paymentMethod" value="vodafone">
                                        <div class="payment-card-content">
                                            <span>📱 فودافون كاش</span>
                                        </div>
                                    </label>
                                    <label class="payment-card" onclick="selectPayment('bank')">
                                        <input type="radio" name="paymentMethod" value="bank">
                                        <div class="payment-card-content">
                                            <span>🏦 تحويل بنكي</span>
                                        </div>
                                    </label>
                                    <label class="payment-card" onclick="selectPayment('cash')">
                                        <input type="radio" name="paymentMethod" value="cash">
                                        <div class="payment-card-content">
                                            <span>💵 دفع في المركز</span>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Upload Receipt -->
                            <div class="upload-section mt-4" id="uploadSection" style="display:none;">
                                <h6><i class="fas fa-upload me-2"></i>رفع إيصال الدفع</h6>
                                <div class="upload-area" id="uploadArea">
                                    <input type="file" id="receiptUpload" accept="image/*,.pdf" hidden onchange="handleUpload(this)">
                                    <div class="upload-placeholder">
                                        <i class="fas fa-cloud-upload-alt fa-3x"></i>
                                        <p>اسحب وأفلت صورة الإيصال هنا</p>
                                        <span>أو</span>
                                        <button type="button" class="btn btn-outline-custom-sm" onclick="document.getElementById('receiptUpload').click()">تصفح الملفات</button>
                                        <small class="text-muted d-block mt-2">الصيغ المدعومة: JPG, PNG, PDF</small>
                                    </div>
                                    <div class="upload-preview" id="uploadPreview" style="display:none;">
                                        <img id="previewImg" src="" alt="Preview" loading="lazy">
                                        <button type="button" class="btn btn-sm btn-danger" onclick="removeUpload()">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Agreement -->
                            <div class="agreement-section mt-4">
                                <label class="agreement-check">
                                    <input type="checkbox" id="agreeTerms">
                                    <span class="checkmark"></span>
                                    <span>أوافق على سياسة الخصوصية وأؤكد أن جميع البيانات صحيحة</span>
                                </label>
                            </div>

                            <div class="step-navigation">
                                <button class="btn btn-outline-secondary btn-lg" onclick="prevStep(3)">
                                    <i class="fas fa-arrow-right me-2"></i> السابق
                                </button>
                                <button class="btn btn-success btn-lg" onclick="confirmBooking()" id="confirmBtn" disabled>
                                    <i class="fas fa-check-circle me-2"></i>تأكيد الحجز
                                </button>
                            </div>
                            <div id="bookingMessage" class="mt-3"></div>
                        </div>

                        <!-- Success Step -->
                        <div class="booking-step text-center" id="successStep">
                            <div class="success-animation">
                                <i class="fas fa-check-circle fa-5x text-success"></i>
                            </div>
                            <h3 class="mt-4">تم تأكيد حجزك بنجاح!</h3>
                            <p>تم استلام طلبك وسيتم التواصل معك قريباً. رقم الحجز الخاص بك هو:</p>
                            <div class="booking-number" id="bookingNumber">-</div>
                            <p class="text-muted mt-3">احتفظ بهذا الرقم للمراجعة. جميع بياناتك محمية وسرية.</p>
                            <div class="mt-4">
                                <a href="index.php" class="btn btn-primary-custom">العودة للرئيسية</a>
                                <a href="tel:<?php echo $phone; ?>" class="btn btn-outline-custom-sm ms-2">
                                    <i class="fas fa-phone-alt me-1"></i>اتصل بنا
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
	</form>

 <?php include 'includes/footer.php'; ?>

    <!-- Booking JavaScript -->
    <script>
        // حالة الحجز
        let bookingState = {
            service_id: 0,
            service_name: '',
            doctor_id: 0,
            doctor_name: '',
            date: '',
            time: '',
            consultType: 'online',
            payment: '',
            currentStep: 1
        };

        // اختيار الخدمة
        function selectService(id, name, element) {
            document.querySelectorAll('.service-option-card').forEach(c => c.classList.remove('selected'));
            element.classList.add('selected');
            bookingState.service_id = id;
            bookingState.service_name = name;
            document.getElementById('step1Next').disabled = false;
            updateSummary();
        }

        // اختيار الطبيب
        function selectDoctor(id, name, element) {
            document.querySelectorAll('.doctor-option-card').forEach(c => c.classList.remove('selected'));
            element.classList.add('selected');
            bookingState.doctor_id = id;
            bookingState.doctor_name = name;
            document.getElementById('step2Next').disabled = false;
            updateSummary();
        }

        // اختيار طريقة الدفع
        function selectPayment(method) {
            document.querySelectorAll('.payment-card').forEach(c => c.classList.remove('selected'));
            event.currentTarget.classList.add('selected');
            bookingState.payment = method;
            
            if (method === 'vodafone' || method === 'bank') {
                document.getElementById('uploadSection').style.display = 'block';
            } else {
                document.getElementById('uploadSection').style.display = 'none';
                document.getElementById('confirmBtn').disabled = false;
            }
            checkConfirmReady();
        }

        // تحديث الملخص
        function updateSummary() {
            document.getElementById('summaryService').textContent = bookingState.service_name || '-';
            document.getElementById('summaryDoctor').textContent = bookingState.doctor_name || '-';
            
            bookingState.date = document.getElementById('bookingDate').value;
            bookingState.time = document.getElementById('bookingTime').value;
            document.getElementById('summaryDate').textContent = bookingState.date || '-';
            document.getElementById('summaryTime').textContent = bookingState.time || '-';
            
            const consultType = document.querySelector('input[name="consultType"]:checked');
            if (consultType) {
                bookingState.consultType = consultType.value;
                const typeNames = { 'online': 'استشارة أونلاين', 'center': 'زيارة المركز', 'phone': 'استشارة هاتفية' };
                document.getElementById('summaryConsultType').textContent = typeNames[consultType.value];
            }

            const step3Next = document.getElementById('step3Next');
            if (step3Next) {
                step3Next.disabled = !(bookingState.date && bookingState.time);
            }
        }

        // رفع الملف
        function handleUpload(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewImg').src = e.target.result;
                    document.getElementById('uploadPreview').style.display = 'block';
                    document.querySelector('.upload-placeholder').style.display = 'none';
                    checkConfirmReady();
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function removeUpload() {
            document.getElementById('receiptUpload').value = '';
            document.getElementById('uploadPreview').style.display = 'none';
            document.querySelector('.upload-placeholder').style.display = 'block';
            checkConfirmReady();
        }

        // التحقق من جاهزية التأكيد
        function checkConfirmReady() {
            const agreeTerms = document.getElementById('agreeTerms').checked;
            const phone = document.getElementById('patientPhone').value.trim();
            const hasReceipt = bookingState.payment === 'cash' || 
                               (document.getElementById('uploadPreview').style.display === 'block');
            
            document.getElementById('confirmBtn').disabled = !(agreeTerms && phone && hasReceipt);
        }

        // مراقبة التغييرات
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('agreeTerms').addEventListener('change', checkConfirmReady);
            document.getElementById('patientPhone').addEventListener('input', checkConfirmReady);
            
            // السحب والإفلات
            const uploadArea = document.getElementById('uploadArea');
            uploadArea.addEventListener('dragover', (e) => {
                e.preventDefault();
                uploadArea.classList.add('drag-over');
            });
            uploadArea.addEventListener('dragleave', () => {
                uploadArea.classList.remove('drag-over');
            });
            uploadArea.addEventListener('drop', (e) => {
                e.preventDefault();
                uploadArea.classList.remove('drag-over');
                const file = e.dataTransfer.files[0];
                if (file) {
                    document.getElementById('receiptUpload').files = e.dataTransfer.files;
                    handleUpload(document.getElementById('receiptUpload'));
                }
            });
        });

        // التنقل بين الخطوات
     function nextStep(step) {
    // منع أي سلوك افتراضي
    if (event) {
        event.preventDefault();
    }
    
    // إخفاء كل الخطوات
    document.querySelectorAll('.booking-step').forEach(s => 
        s.classList.remove('active')
    );
    
    // إظهار الخطوة الجديدة
    document.getElementById('step' + step).classList.add('active');
    
    // تحديث الحالة
    bookingState.currentStep = step;
    
    // تحديث الـ stepper
    updateStepper(step);
    
    // التمرير إلى الفورم الجديد (الأهم)
    setTimeout(function() {
        const newStep = document.getElementById('step' + step);
        const bookingCard = document.querySelector('.booking-card');
        const navbar = document.querySelector('.navbar');
        
        // حساب المسافة من أعلى الصفحة
        let offset = 0;
        if (newStep) {
            const rect = newStep.getBoundingClientRect();
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            offset = rect.top + scrollTop;
            
            // خصم ارتفاع الـ navbar لو موجود
            if (navbar) {
                offset -= navbar.offsetHeight + 20;
            }
        }
        
        // تمرير سلس
        window.scrollTo({
            top: offset,
            behavior: 'smooth'
        });
    }, 100); // تأخير 100ms عشان يضمن إن DOM اكتمل
    
    // للجوال - حل إضافي
    if (window.innerWidth <= 768) {
        setTimeout(() => {
            const formTop = document.querySelector('.booking-step.active');
            if (formTop) {
                formTop.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'start',
                    inline: 'nearest'
                });
            }
        }, 150);
    }
}
      function prevStep(step) {
    if (event) {
        event.preventDefault();
    }
    
    document.querySelectorAll('.booking-step').forEach(s => 
        s.classList.remove('active')
    );
    
    document.getElementById('step' + step).classList.add('active');
    bookingState.currentStep = step;
    updateStepper(step);
    
    // تمرير للخطوة السابقة
    setTimeout(function() {
        const stepElement = document.getElementById('step' + step);
        const navbar = document.querySelector('.navbar');
        
        if (stepElement) {
            let offset = stepElement.offsetTop;
            if (navbar) {
                offset -= navbar.offsetHeight + 20;
            }
            window.scrollTo({
                top: offset,
                behavior: 'smooth'
            });
        }
    }, 100);
}
        function updateStepper(step) {
            document.querySelectorAll('.step-indicator').forEach(ind => {
                const s = parseInt(ind.getAttribute('data-step'));
                ind.classList.remove('active', 'completed');
                if (s < step) ind.classList.add('completed');
                if (s === step) ind.classList.add('active');
            });
            document.querySelectorAll('.step-line').forEach(line => {
                const l = parseInt(line.getAttribute('data-line'));
                line.classList.remove('completed');
                if (l < step) line.classList.add('completed');
            });
        }

        // تأكيد الحجز - إرسال للخادم
        function confirmBooking() {
            const btn = document.getElementById('confirmBtn');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>جاري الحجز...';
            
            // تجهيز البيانات
            const formData = new FormData();
            formData.append('service_id', bookingState.service_id);
            formData.append('doctor_id', bookingState.doctor_id);
            formData.append('patient_name', document.getElementById('patientName').value);
            formData.append('patient_phone', document.getElementById('patientPhone').value);
            formData.append('appointment_date', bookingState.date);
            formData.append('appointment_time', bookingState.time);
            formData.append('consultation_type', bookingState.consultType);
            formData.append('payment_method', bookingState.payment);
            formData.append('is_confidential', document.getElementById('confidentialBooking')?.checked ? 1 : 0);
            formData.append('csrf_token', document.getElementById('csrf_token').value);
			
            
            // إضافة صورة الإيصال لو موجودة
            const receiptFile = document.getElementById('receiptUpload').files[0];
            if (receiptFile) {
                formData.append('receipt', receiptFile);
            }
            
            // إرسال الطلب للخادم
            fetch('api/submit_booking.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // عرض رقم الحجز
                    document.getElementById('bookingNumber').textContent = data.booking_number;
                    fetch('api/send_notification.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                patient_name: document.getElementById('patientName').value || 'عميل',
                patient_phone: document.getElementById('patientPhone').value,
                booking_number: data.booking_number,
                service_name: bookingState.service_name,
                date: bookingState.date,
                time: bookingState.time
            })
        });
                    // الانتقال لخطوة النجاح
                    document.querySelectorAll('.booking-step').forEach(s => s.classList.remove('active'));
                    document.getElementById('successStep').classList.add('active');
                    
                    // تحديث الـ stepper
                    document.querySelectorAll('.step-indicator').forEach(ind => {
                        ind.classList.remove('active');
                        ind.classList.add('completed');
                    });
                    document.querySelectorAll('.step-line').forEach(line => line.classList.add('completed'));
                    
                    document.getElementById('successStep').scrollIntoView({ behavior: 'smooth' });
                } else {
                    alert('❌ ' + data.message);
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-check-circle me-2"></i>تأكيد الحجز';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('❌ حدث خطأ في الاتصال. حاول مرة أخرى.');
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-check-circle me-2"></i>تأكيد الحجز';
            });
        }

        // تهيئة
        document.getElementById('step1Next').disabled = true;
        document.getElementById('step2Next').disabled = true;
    </script>
	
    <?php include 'includes/footer_scripts.php'; ?>
    <!-- Schema Markup for Local Business -->
</body>
</html>