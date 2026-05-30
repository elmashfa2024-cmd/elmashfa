<?php
session_start();

// التحقق من تسجيل الدخول
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

require_once '../config/database.php';

// جلب الإحصائيات
$totalAppointments = $pdo->query("SELECT COUNT(*) FROM appointments")->fetchColumn();
$pendingAppointments = $pdo->query("SELECT COUNT(*) FROM appointments WHERE status='pending'")->fetchColumn();
$confirmedAppointments = $pdo->query("SELECT COUNT(*) FROM appointments WHERE status='confirmed'")->fetchColumn();
$totalDoctors = $pdo->query("SELECT COUNT(*) FROM doctors WHERE is_active=1")->fetchColumn();
$totaltherapy = $pdo->query("SELECT COUNT(*) FROM staff WHERE is_active=1")->fetchColumn();
$totalServices = $pdo->query("SELECT COUNT(*) FROM services WHERE is_active=1")->fetchColumn();
$totalRevenue = $pdo->query("SELECT COALESCE(SUM(amount), 0) FROM payments WHERE status='confirmed'")->fetchColumn();
$unreadMessages = $pdo->query("SELECT COUNT(*) FROM messages WHERE is_read=0")->fetchColumn();

// آخر الحجوزات
$recentAppointments = $pdo->query("
    SELECT a.*, s.title as service_name, d.name as doctor_name 
    FROM appointments a
    LEFT JOIN services s ON a.service_id = s.id
    LEFT JOIN doctors d ON a.doctor_id = d.id
    ORDER BY a.created_at DESC
    LIMIT 10
")->fetchAll();

// آخر الرسائل
$recentMessages = $pdo->query("SELECT * FROM messages WHERE is_read=0 ORDER BY created_at DESC LIMIT 5")->fetchAll();

// اسم الأدمن
$adminName = $_SESSION['admin_username'] ?? 'مدير النظام';
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>لوحة التحكم - مركز المشفى</title>
    <!-- Bootstrap RTL -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Admin Style -->
    <link rel="stylesheet" href="admin-style.css">
</head>
<body>
    
    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <i class="fas fa-heartbeat"></i>
                <span>مركز <strong>المشفى</strong></span>
            </div>
            <button class="sidebar-toggle" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        
        <div class="sidebar-user">
            <img src="https://placehold.co/50x50/cc0000/ffffff?text=A" alt="Admin" loading="lazy">
            <div>
                <strong><?php echo htmlspecialchars($adminName); ?></strong>
                <small><?php echo $_SESSION['admin_email'] ?? ''; ?></small>
            </div>
        </div>
        
        <nav class="sidebar-nav">
            <ul>
                <li><a href="#" class="nav-item active" data-page="dashboard"><i class="fas fa-tachometer-alt"></i><span>لوحة التحكم</span></a></li>
                <li><a href="#" class="nav-item" data-page="appointments"><i class="fas fa-calendar-check"></i><span>الحجوزات</span><span class="badge bg-danger" id="pendingBadge"><?php echo $pendingAppointments; ?></span></a></li>
                <li><a href="#" class="nav-item" data-page="doctors"><i class="fas fa-user-md"></i><span>الأطباء</span></a></li>
				<li><a href="#" class="nav-item" data-page="therapy"><i class="fas fa-user-md"></i><span>المعالجين والاخصائيين</span></a></li>
                <li><a href="#" class="nav-item" data-page="services"><i class="fas fa-capsules"></i><span>الخدمات</span></a></li>
                <li><a href="#" class="nav-item" data-page="blog"><i class="fas fa-newspaper"></i><span>المقالات</span></a></li>
                <li><a href="#" class="nav-item" data-page="payments"><i class="fas fa-money-bill-wave"></i><span>المدفوعات</span></a></li>
                <li><a href="#" class="nav-item" data-page="messages"><i class="fas fa-envelope"></i><span>الرسائل</span><span class="badge bg-info"><?php echo $unreadMessages; ?></span></a></li>
                <li><a href="#" class="nav-item" data-page="settings"><i class="fas fa-cog"></i><span>الإعدادات</span></a></li>
            </ul>
        </nav>
        
        <div class="sidebar-footer">
           <a href="logout.php" class="btn-logout">
                <i class="fas fa-sign-out-alt"></i>
                <span>تسجيل الخروج</span>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="admin-main" id="adminMain">
        <header class="admin-topbar">
            <div class="topbar-left">
                <button class="btn-menu" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
                <h4 class="page-title" id="pageTitle">لوحة التحكم</h4>
            </div>
            <div class="topbar-right">
                <a href="logout.php" class="btn btn-sm btn-outline-danger me-2" title="تسجيل الخروج">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
                
                <!-- الجرس - الإشعارات -->
                <div class="topbar-notifications" title="الإشعارات" onclick="toggleNotifications()" style="cursor:pointer; position:relative;">
                    <i class="fas fa-bell"></i>
                    <?php if ($pendingAppointments > 0): ?>
                        <span class="notif-dot"></span>
                        <span class="notif-count"><?php echo $pendingAppointments; ?></span>
                    <?php endif; ?>
                    
                    <div class="notifications-dropdown" id="notificationsDropdown" style="display:none;">
                        <div class="notif-header">
                            <h6>آخر الإشعارات</h6>
                            <small><?php echo $pendingAppointments; ?> حجوزات جديدة</small>
                        </div>
                        <div class="notif-body">
                            <?php
                            $latestPending = $pdo->query("
                                SELECT a.*, s.title as service_name 
                                FROM appointments a
                                LEFT JOIN services s ON a.service_id = s.id
                                WHERE a.status = 'pending'
                                ORDER BY a.created_at DESC
                                LIMIT 5
                            ")->fetchAll();
                            
                            if (!empty($latestPending)):
                                foreach ($latestPending as $notif):
                            ?>
                            <div class="notif-item" onclick="showPage('appointments')" style="cursor:pointer;">
                                <div class="notif-icon"><i class="fas fa-calendar-plus"></i></div>
                                <div class="notif-content">
                                    <p><strong>حجز جديد</strong> - <?php echo htmlspecialchars($notif['patient_name'] ?: 'مريض'); ?></p>
                                    <small><?php echo htmlspecialchars($notif['service_name']); ?> | <?php echo $notif['created_at']; ?></small>
                                </div>
                            </div>
                            <?php endforeach; else: ?>
                            <p class="text-center py-3 text-muted">لا توجد إشعارات جديدة</p>
                            <?php endif; ?>
                        </div>
                        <div class="notif-footer">
                            <a href="#" onclick="showPage('appointments')">عرض كل الحجوزات</a>
                        </div>
                    </div>
                </div>
                
                <div class="topbar-user">
                    <span><?php echo htmlspecialchars($adminName); ?></span>
                    <img src="https://placehold.co/40x40/cc0000/ffffff?text=A" alt="Admin" loading="lazy">
                </div>
                
                <a href="../index.php" target="_blank" class="btn btn-sm btn-outline-primary me-2" title="معاينة الموقع">
                    <i class="fas fa-external-link-alt"></i>
                </a>
            </div>
        </header>

        <div class="admin-content" id="adminContent">
            <!-- Dashboard Page -->
            <div class="content-page active" id="dashboard-page">
                <div class="row g-4 mb-4">
                    <div class="col-xl-3 col-md-6"><div class="stat-card-admin"><div class="stat-card-icon bg-primary-light"><i class="fas fa-calendar-check"></i></div><div class="stat-card-info"><h3><?php echo $totalAppointments; ?></h3><p>إجمالي الحجوزات</p></div></div></div>
                    <div class="col-xl-3 col-md-6"><div class="stat-card-admin"><div class="stat-card-icon bg-warning-light"><i class="fas fa-clock"></i></div><div class="stat-card-info"><h3><?php echo $pendingAppointments; ?></h3><p>حجوزات معلقة</p></div></div></div>
                    <div class="col-xl-3 col-md-6"><div class="stat-card-admin"><div class="stat-card-icon bg-success-light"><i class="fas fa-check-circle"></i></div><div class="stat-card-info"><h3><?php echo $confirmedAppointments; ?></h3><p>حجوزات مؤكدة</p></div></div></div>
                    <div class="col-xl-3 col-md-6"><div class="stat-card-admin"><div class="stat-card-icon bg-danger-light"><i class="fas fa-money-bill-wave"></i></div><div class="stat-card-info"><h3><?php echo number_format($totalRevenue); ?> ج.م</h3><p>إجمالي الإيرادات</p></div></div></div>
                </div>

                <div class="admin-card">
                    <div class="admin-card-header">
                        <h5><i class="fas fa-calendar-alt me-2"></i>آخر الحجوزات</h5>
                        <button class="btn btn-sm btn-primary-custom" onclick="showPage('appointments')">عرض الكل</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table admin-table">
                            <thead><tr><th>رقم الحجز</th><th>المريض</th><th>الخدمة</th><th>الطبيب</th><th>التاريخ</th><th>الحالة</th><th>إجراءات</th></tr></thead>
                            <tbody>
                                <?php if (!empty($recentAppointments)): foreach ($recentAppointments as $app): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($app['booking_number']); ?></td>
                                    <td><?php echo htmlspecialchars($app['patient_name'] ?: 'غير محدد'); ?></td>
                                    <td><?php echo htmlspecialchars($app['service_name'] ?: '-'); ?></td>
                                    <td><?php echo htmlspecialchars($app['doctor_name'] ?: '-'); ?></td>
                                    <td><?php echo $app['appointment_date']; ?></td>
                                    <td><span class="badge bg-<?php echo $app['status'] === 'confirmed' ? 'success' : ($app['status'] === 'pending' ? 'warning' : 'danger'); ?>"><?php echo $app['status'] === 'pending' ? 'معلق' : ($app['status'] === 'confirmed' ? 'مؤكد' : 'ملغي'); ?></span></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <?php if ($app['status'] === 'pending'): ?>
                                            <button class="btn btn-success" onclick="updateStatus(<?php echo $app['id']; ?>, 'confirmed')" title="تأكيد"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger" onclick="updateStatus(<?php echo $app['id']; ?>, 'cancelled')" title="إلغاء"><i class="fas fa-times"></i></button>
                                            <?php endif; ?>
                                            <button class="btn btn-outline-primary" onclick="viewAppointmentModal(<?php echo $app['id']; ?>)" title="عرض"><i class="fas fa-eye"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; else: ?>
                                <tr><td colspan="7" class="text-center">لا توجد حجوزات حتى الآن</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Appointments Page -->
            <div class="content-page" id="appointments-page">
                <div class="admin-card">
                    <div class="admin-card-header">
                        <h5><i class="fas fa-calendar-check me-2"></i>إدارة الحجوزات</h5>
                        <div class="header-actions">
                            <select class="form-select form-select-sm me-2" id="statusFilter" onchange="filterAppointmentsTable()" style="width:auto;">
                                <option value="all">جميع الحالات</option>
                                <option value="pending">معلق</option>
                                <option value="confirmed">مؤكد</option>
                                <option value="cancelled">ملغي</option>
                                <option value="completed">مكتمل</option>
                            </select>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table admin-table">
                            <thead><tr><th>رقم الحجز</th><th>المريض</th><th>الهاتف</th><th>الخدمة</th><th>الطبيب</th><th>التاريخ</th><th>الوقت</th><th>الحالة</th><th>إجراءات</th></tr></thead>
                            <tbody>
                                <?php
                                $allAppointments = $pdo->query("SELECT a.*, s.title as service_name, d.name as doctor_name FROM appointments a LEFT JOIN services s ON a.service_id = s.id LEFT JOIN doctors d ON a.doctor_id = d.id ORDER BY a.created_at DESC")->fetchAll();
                                if (!empty($allAppointments)): foreach ($allAppointments as $app):
                                ?>
                                <tr class="appointment-row" data-status="<?php echo $app['status']; ?>">
                                    <td><?php echo htmlspecialchars($app['booking_number']); ?></td>
                                    <td><?php echo htmlspecialchars($app['patient_name'] ?: '-'); ?></td>
                                    <td><?php echo htmlspecialchars($app['patient_phone'] ?: '-'); ?></td>
                                    <td><?php echo htmlspecialchars($app['service_name'] ?: '-'); ?></td>
                                    <td><?php echo htmlspecialchars($app['doctor_name'] ?: '-'); ?></td>
                                    <td><?php echo $app['appointment_date']; ?></td>
                                    <td><?php echo $app['appointment_time']; ?></td>
                                    <td><span class="badge bg-<?php echo $app['status'] === 'confirmed' ? 'success' : ($app['status'] === 'pending' ? 'warning' : 'danger'); ?>"><?php echo $app['status'] === 'pending' ? 'معلق' : ($app['status'] === 'confirmed' ? 'مؤكد' : 'ملغي'); ?></span></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <?php if ($app['status'] === 'pending'): ?>
                                            <button class="btn btn-success btn-sm" onclick="updateStatus(<?php echo $app['id']; ?>, 'confirmed')" title="تأكيد"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-danger btn-sm" onclick="updateStatus(<?php echo $app['id']; ?>, 'cancelled')" title="إلغاء"><i class="fas fa-times"></i></button>
                                            <?php endif; ?>
                                            <button class="btn btn-outline-primary btn-sm" onclick="viewAppointmentModal(<?php echo $app['id']; ?>)" title="عرض التفاصيل"><i class="fas fa-eye"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; else: ?>
                                <tr><td colspan="9" class="text-center">لا توجد حجوزات حتى الآن</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Doctors Page -->
            <div class="content-page" id="doctors-page">
                <div class="admin-card">
                    <div class="admin-card-header">
                        <h5><i class="fas fa-user-md me-2"></i>إدارة الأطباء (<?php echo $totalDoctors; ?>)</h5>
                        <button class="btn btn-sm btn-primary-custom" onclick="openModal('addDoctorModal')"><i class="fas fa-plus me-1"></i> إضافة طبيب</button>
                    </div>
                    <div class="row g-4 mt-2" id="doctorsGrid">
                        <?php foreach ($pdo->query("SELECT * FROM doctors ORDER BY rating DESC")->fetchAll() as $doc): ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="doctor-admin-card">
                                <img src="<?php echo $doc['image'] ?: 'https://placehold.co/200x200/e8e8e8/333333?text=Dr'; ?>" loading="lazy" alt="<?php echo htmlspecialchars($doc['name']); ?>">
                                <div class="doctor-admin-info">
                                    <h6><?php echo htmlspecialchars($doc['name']); ?></h6>
                                    <span><?php echo htmlspecialchars($doc['specialty']); ?></span>
                                    <div class="doctor-admin-rating"><?php echo str_repeat('⭐', round($doc['rating'])); ?> (<?php echo $doc['rating']; ?>)</div>
                                    <div class="doctor-admin-actions mt-2">
                                        <button class="btn btn-sm btn-outline-primary" onclick="editDoctor(<?php echo $doc['id']; ?>)"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-outline-danger" onclick="deleteDoctor(<?php echo $doc['id']; ?>)"><i class="fas fa-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="doctor-admin-card add-new-card" onclick="openModal('addDoctorModal')">
                                <div class="add-new-content"><i class="fas fa-plus-circle fa-3x"></i><p>إضافة طبيب جديد</p></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			  <!-- therapy Page -->
            <div class="content-page" id="therapy-page">
                <div class="admin-card">
                    <div class="admin-card-header">
                        <h5><i class="fas fa-user-md me-2"></i>اداره الاخصائيين والمعالجين (<?php echo $totaltherapy; ?>)</h5>
                        <button class="btn btn-sm btn-primary-custom" onclick="openModal('addtherapymodal')"><i class="fas fa-plus me-1"></i> اضافه اخصائي / معالج</button>
                    </div>
                    <div class="row g-4 mt-2" id="doctorsGrid">
                        <?php foreach ($pdo->query("SELECT * FROM staff ORDER BY rating DESC")->fetchAll() as $the): ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="doctor-admin-card">
                               <?php 
$imgUrl = $the['photo'] ?: 'https://placehold.co/200x200/e8e8e8/333333?text=Dr';
?>
<img src="<?php echo htmlspecialchars($imgUrl); ?>" 
     loading="lazy" 
     alt="<?php echo htmlspecialchars($the['name']); ?>">
                                <div class="doctor-admin-info">
                                    <h6><?php echo htmlspecialchars($the['name']); ?></h6>
                                    <span><?php echo htmlspecialchars($the['specialty']); ?></span>
                                    <div class="doctor-admin-rating"><?php echo str_repeat('⭐', round($the['rating'])); ?> (<?php echo $the['rating']; ?>)</div>
                                    <div class="doctor-admin-actions mt-2">
                                        <button class="btn btn-sm btn-outline-primary" onclick="edittherapy(<?php echo $the['id']; ?>)"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-outline-danger" onclick="deletetherapy(<?php echo $the['id']; ?>)"><i class="fas fa-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="doctor-admin-card add-new-card" onclick="openModal('addtherapymodal')">
                                <div class="add-new-content"><i class="fas fa-plus-circle fa-3x"></i><p>اضافه</p></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<!-- ========== SERVICES PAGE ========== -->
<div class="content-page" id="services-page">
    <div class="admin-card">
        <div class="admin-card-header">
            <h5><i class="fas fa-capsules me-2"></i>إدارة الخدمات</h5>
            <button class="btn btn-sm btn-primary-custom" onclick="openServiceModal()">
                <i class="fas fa-plus me-1"></i> إضافة خدمة
            </button>
        </div>
        <div class="table-responsive">
            <table class="table admin-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الأيقونة</th>
                        <th>اسم الخدمة</th>
                        <th>الوصف</th>
                        <th>الحالة</th>
                        <th>إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $allServices = $pdo->query("SELECT * FROM services ORDER BY id ASC")->fetchAll();
                    if (!empty($allServices)):
                        foreach ($allServices as $svc):
                    ?>
                    <tr>
                        <td><?php echo $svc['id']; ?></td>
                        <td><i class="fas <?php echo $svc['icon'] ?: 'fa-capsules'; ?> fa-lg" style="color: #C41E3A;"></i></td>
                        <td><?php echo htmlspecialchars($svc['title']); ?></td>
                        <td><?php echo htmlspecialchars(substr($svc['description'] ?? '', 0, 60)); ?>...</td>
                        <td>
                            <span class="badge bg-<?php echo $svc['is_active'] ? 'success' : 'secondary'; ?>">
                                <?php echo $svc['is_active'] ? 'نشط' : 'غير نشط'; ?>
                            </span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-primary btn-sm" onclick="editService(<?php echo $svc['id']; ?>)" title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-outline-danger btn-sm" onclick="deleteService(<?php echo $svc['id']; ?>)" title="حذف">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr><td colspan="6" class="text-center">لا توجد خدمات مضافة</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ========== BLOG PAGE ========== -->
<div class="content-page" id="blog-page">
    <div class="admin-card">
        <div class="admin-card-header">
            <h5><i class="fas fa-newspaper me-2"></i>إدارة المقالات</h5>
            <button class="btn btn-sm btn-primary-custom" onclick="openBlogModal()">
                <i class="fas fa-plus me-1"></i> مقال جديد
            </button>
        </div>
        <div class="table-responsive">
            <table class="table admin-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>العنوان</th>
                        <th>التصنيف</th>
                        <th>المشاهدات</th>
                        <th>التاريخ</th>
                        <th>الحالة</th>
                        <th>إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $allPosts = $pdo->query("SELECT * FROM blog_posts ORDER BY created_at DESC")->fetchAll();
                    if (!empty($allPosts)):
                        foreach ($allPosts as $post):
                    ?>
                    <tr>
                        <td><?php echo $post['id']; ?></td>
                        <td><?php echo htmlspecialchars($post['title']); ?></td>
                        <td><span class="badge bg-info"><?php echo htmlspecialchars($post['category'] ?? 'عام'); ?></span></td>
                        <td><?php echo $post['views']; ?></td>
                        <td><?php echo date('Y/m/d', strtotime($post['created_at'])); ?></td>
                        <td>
                            <span class="badge bg-<?php echo $post['is_published'] ? 'success' : 'warning'; ?>">
                                <?php echo $post['is_published'] ? 'منشور' : 'مسودة'; ?>
                            </span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-primary btn-sm" onclick="editBlog(<?php echo $post['id']; ?>)" title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-outline-danger btn-sm" onclick="deleteBlog(<?php echo $post['id']; ?>)" title="حذف">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr><td colspan="7" class="text-center">لا توجد مقالات مضافة</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ========== PAYMENTS PAGE ========== -->
<div class="content-page" id="payments-page">
    <div class="admin-card">
        <div class="admin-card-header">
            <h5><i class="fas fa-money-bill-wave me-2"></i>إدارة المدفوعات</h5>
            <div class="header-actions">
                <span class="me-3 fw-bold" style="color: #198754;">
                    الإجمالي: <?php echo number_format($totalRevenue); ?> ج.م
                </span>
                <select class="form-select form-select-sm" id="paymentStatusFilter" onchange="filterPayments()" style="width:auto;">
                    <option value="all">جميع الحالات</option>
                    <option value="pending">قيد المراجعة</option>
                    <option value="confirmed">مؤكد</option>
                    <option value="rejected">مرفوض</option>
                </select>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table admin-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>رقم الحجز</th>
                        <th>المريض</th>
                        <th>المبلغ</th>
                        <th>طريقة الدفع</th>
                        <th>التاريخ</th>
                        <th>الإيصال</th>
                        <th>الحالة</th>
                        <th>إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $allPayments = $pdo->query("
                        SELECT p.*, a.booking_number, a.patient_name, a.patient_phone
                        FROM payments p
                        LEFT JOIN appointments a ON p.appointment_id = a.id
                        ORDER BY p.created_at DESC
                    ")->fetchAll();
                    
                    if (!empty($allPayments)):
                        foreach ($allPayments as $pay):
                            $payStatusClass = [
                                'pending' => 'bg-warning',
                                'confirmed' => 'bg-success',
                                'rejected' => 'bg-danger'
                            ];
                            $payStatusText = [
                                'pending' => 'قيد المراجعة',
                                'confirmed' => 'مؤكد',
                                'rejected' => 'مرفوض'
                            ];
                            $payMethodText = [
                                'vodafone' => 'فودافون كاش',
                                'bank' => 'تحويل بنكي',
                                'cash' => 'نقدي'
                            ];
                    ?>
                    <tr class="payment-row" data-status="<?php echo $pay['status']; ?>">
                        <td><?php echo $pay['id']; ?></td>
                        <td><strong><?php echo htmlspecialchars($pay['booking_number'] ?? '-'); ?></strong></td>
                        <td>
                            <?php echo htmlspecialchars($pay['patient_name'] ?? '-'); ?>
                            <br><small class="text-muted"><?php echo htmlspecialchars($pay['patient_phone'] ?? ''); ?></small>
                        </td>
                        <td><strong><?php echo number_format($pay['amount'], 2); ?> ج.م</strong></td>
                        <td><?php echo $payMethodText[$pay['method']] ?? $pay['method']; ?></td>
                        <td><?php echo date('Y/m/d', strtotime($pay['created_at'])); ?></td>
                        <td>
                            <?php if (!empty($pay['receipt_image'])): ?>
                            <a href="../<?php echo $pay['receipt_image']; ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-image"></i> عرض
                            </a>
                            <?php else: ?>
                            <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="badge <?php echo $payStatusClass[$pay['status']] ?? 'bg-secondary'; ?>">
                                <?php echo $payStatusText[$pay['status']] ?? $pay['status']; ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($pay['status'] === 'pending'): ?>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-success btn-sm" onclick="updatePayment(<?php echo $pay['id']; ?>, 'confirmed')" title="تأكيد">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="updatePayment(<?php echo $pay['id']; ?>, 'rejected')" title="رفض">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <?php else: ?>
                            <small class="text-muted">تم</small>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr><td colspan="9" class="text-center">لا توجد مدفوعات حتى الآن</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

            <!-- Messages Page -->
            <!-- ========== MESSAGES PAGE ========== -->
<div class="content-page" id="messages-page">
    <div class="admin-card">
        <div class="admin-card-header">
            <h5><i class="fas fa-envelope me-2"></i>الرسائل الواردة (<?php echo $unreadMessages; ?> غير مقروءة)</h5>
        </div>
        <div class="messages-list" id="messagesList">
            <?php
            $allMessages = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC LIMIT 50")->fetchAll();
            if (!empty($allMessages)):
                foreach ($allMessages as $msg):
            ?>
            <div class="message-item <?php echo $msg['is_read'] ? '' : 'unread'; ?>" id="msg-<?php echo $msg['id']; ?>">
                <div class="message-avatar">
                    <img src="https://placehold.co/45x45/e8e8e8/333333?text=<?php echo mb_substr($msg['name'] ?? 'M', 0, 1); ?>" loading="lazy" alt="مرسل">
                </div>
                <div class="message-content" onclick="viewMessage(<?php echo $msg['id']; ?>)" style="cursor:pointer;">
                    <div class="message-header">
                        <strong><?php echo htmlspecialchars($msg['name'] ?: 'غير معروف'); ?></strong>
                        <small><?php echo date('d/m/Y H:i', strtotime($msg['created_at'])); ?></small>
                    </div>
                    <p class="message-subject"><?php echo htmlspecialchars($msg['subject']); ?></p>
                    <p class="message-preview"><?php echo htmlspecialchars(mb_substr($msg['message'], 0, 100)); ?>...</p>
                </div>
                <div class="message-actions">
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteMessage(<?php echo $msg['id']; ?>)" title="حذف">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            <?php endforeach; else: ?>
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <p>لا توجد رسائل حتى الآن</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

            <!-- Settings Page -->
            <div class="content-page" id="settings-page">
                <div class="admin-card">
                    <div class="admin-card-header"><h5><i class="fas fa-cog me-2"></i>إعدادات الموقع</h5></div>
                    <form class="settings-form" id="settingsForm">
                        <?php $settings = $pdo->query("SELECT * FROM settings")->fetchAll(); $settingsMap = []; foreach ($settings as $s) $settingsMap[$s['setting_key']] = $s['setting_value']; ?>
                        <div class="row g-3">
                            <div class="col-md-6"><label class="form-label fw-bold">اسم المركز</label><input type="text" class="form-control" name="site_name" value="<?php echo htmlspecialchars($settingsMap['site_name'] ?? ''); ?>"></div>
                            <div class="col-md-6"><label class="form-label fw-bold">رقم الهاتف</label><input type="tel" class="form-control" name="phone" value="<?php echo htmlspecialchars($settingsMap['phone'] ?? ''); ?>"></div>
							 <div class="col-md-6"><label class="form-label fw-bold"> رقم الهاتف التاني</label><input type="tel" class="form-control" name="phone2" value="<?php echo htmlspecialchars($settingsMap['phone2'] ?? ''); ?>"></div>
                            <div class="col-md-6"><label class="form-label fw-bold">البريد الإلكتروني</label><input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($settingsMap['email'] ?? ''); ?>"></div>
                            <div class="col-md-6"><label class="form-label fw-bold">رقم الواتساب</label><input type="tel" class="form-control" name="whatsapp" value="<?php echo htmlspecialchars($settingsMap['whatsapp'] ?? ''); ?>"></div>
							                 <div class="col-md-6"><label class="form-label fw-bold">رقم الواتساب التاني</label><input type="tel" class="form-control" name="whatsapp2" value="<?php echo htmlspecialchars($settingsMap['whatsapp2'] ?? ''); ?>"></div>
                            <div class="col-12"><label class="form-label fw-bold">العنوان</label><input type="text" class="form-control" name="address" value="<?php echo htmlspecialchars($settingsMap['address'] ?? ''); ?>"></div>
                            <div class="col-12"><button type="submit" class="btn btn-primary-custom btn-lg"><i class="fas fa-save me-2"></i>حفظ الإعدادات</button></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- View Appointment Modal -->
    <div class="modal fade" id="viewAppointmentModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #C41E3A, #8B0000); color: white;">
                    <h5 class="modal-title"><i class="fas fa-calendar-check me-2"></i>تفاصيل الحجز - <span id="viewBookingNumber">-</span></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="viewAppointmentContent">
                    <div class="text-center py-4"><div class="spinner-border text-danger"></div><p class="mt-2">جاري تحميل التفاصيل...</p></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                    <button type="button" class="btn btn-success" id="viewConfirmBtn" style="display:none;" onclick="confirmFromModal()"><i class="fas fa-check me-1"></i> تأكيد الحجز</button>
                    <button type="button" class="btn btn-danger" id="viewCancelBtn" style="display:none;" onclick="cancelFromModal()"><i class="fas fa-times me-1"></i> إلغاء الحجز</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast -->
    <div class="toast-container"><div class="toast-custom" id="adminToast"><i class="fas fa-check-circle"></i><span></span></div></div>

    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="admin-script.js"></script>
    <script>
        let currentViewId = null;

        // ==================== SIDEBAR ====================
        function toggleSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            const main = document.getElementById('adminMain');
            if (window.innerWidth <= 991) sidebar.classList.toggle('mobile-show');
            else { sidebar.classList.toggle('collapsed'); main.classList.toggle('expanded'); }
        }

        // ==================== PAGE NAVIGATION ====================
        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
                this.classList.add('active');
                document.querySelectorAll('.content-page').forEach(p => p.classList.remove('active'));
                const target = document.getElementById(this.getAttribute('data-page') + '-page');
                if (target) target.classList.add('active');
                document.getElementById('pageTitle').textContent = this.querySelector('span').textContent;
                if (window.innerWidth <= 991) document.getElementById('adminSidebar').classList.remove('mobile-show');
            });
        });

        function showPage(name) {
            document.querySelector(`.nav-item[data-page="${name}"]`)?.click();
        }

        // ==================== TOAST ====================
        function showToast(message, type = 'success') {
            const toast = document.getElementById('adminToast');
            toast.querySelector('span').textContent = message;
            toast.style.background = type === 'success' ? '#28A745' : '#DC3545';
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 3000);
        }

        // ==================== FILTER ====================
        function filterAppointmentsTable() {
            const status = document.getElementById('statusFilter').value;
            document.querySelectorAll('.appointment-row').forEach(row => {
                row.style.display = (status === 'all' || row.getAttribute('data-status') === status) ? '' : 'none';
            });
        }

        // ==================== UPDATE STATUS ====================
        function updateStatus(id, status) {
            if (!confirm(`هل أنت متأكد من ${status === 'confirmed' ? 'تأكيد' : 'إلغاء'} هذا الحجز؟`)) return;
            fetch('api/update_appointment.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id, status })
            })
            .then(res => res.json())
            .then(data => {
                showToast(data.message || 'تم تحديث الحالة', data.success ? 'success' : 'error');
                if (data.success) location.reload();
            })
            .catch(() => showToast('حدث خطأ', 'error'));
        }

        // ==================== VIEW MODAL ====================
        function viewAppointmentModal(id) {
            currentViewId = id;
            const modal = new bootstrap.Modal(document.getElementById('viewAppointmentModal'));
            modal.show();
            
            document.getElementById('viewAppointmentContent').innerHTML = `<div class="text-center py-4"><div class="spinner-border text-danger"></div><p class="mt-2">جاري تحميل التفاصيل...</p></div>`;
            document.getElementById('viewConfirmBtn').style.display = 'none';
            document.getElementById('viewCancelBtn').style.display = 'none';
            
            fetch(`api/get_appointment.php?id=${id}`)
                .then(res => res.json())
                .then(result => {
                    if (result.success) {
                        const app = result.data;
                        document.getElementById('viewBookingNumber').textContent = app.booking_number;
                        document.getElementById('viewAppointmentContent').innerHTML = `
                            <div class="row g-3">
                                <div class="col-12 text-center mb-3"><span class="badge fs-6 px-4 py-2 bg-${app.status === 'confirmed' ? 'success' : app.status === 'pending' ? 'warning' : 'danger'}">${app.status_text || app.status}</span></div>
                                <div class="col-md-6"><div class="info-box"><label>👤 اسم المريض</label><p>${app.patient_name || '-'}</p></div></div>
                                <div class="col-md-6"><div class="info-box"><label>📞 رقم الهاتف</label><p>${app.patient_phone || '-'}</p></div></div>
                                <div class="col-md-6"><div class="info-box"><label>🏥 الخدمة</label><p>${app.service_name || '-'}</p></div></div>
                                <div class="col-md-6"><div class="info-box"><label>👨‍⚕️ الطبيب</label><p>${app.doctor_name || '-'}</p></div></div>
                                <div class="col-md-6"><div class="info-box"><label>📅 التاريخ</label><p>${app.formatted_date || app.appointment_date}</p></div></div>
                                <div class="col-md-6"><div class="info-box"><label>⏰ الوقت</label><p>${app.appointment_time}</p></div></div>
                                <div class="col-md-6"><div class="info-box"><label>📹 نوع الاستشارة</label><p>${app.consultation_text || '-'}</p></div></div>
                                <div class="col-md-6"><div class="info-box"><label>💳 طريقة الدفع</label><p>${app.payment_text || '-'}</p></div></div>
                                ${app.notes ? `<div class="col-12"><div class="info-box"><label>📝 ملاحظات</label><p>${app.notes}</p></div></div>` : ''}
                                <div class="col-12"><small class="text-muted">📅 تاريخ الحجز: ${app.formatted_created || app.created_at}</small></div>
                            </div>`;
                        if (app.status === 'pending') {
                            document.getElementById('viewConfirmBtn').style.display = 'inline-block';
                            document.getElementById('viewCancelBtn').style.display = 'inline-block';
                        }
                    } else {
                        document.getElementById('viewAppointmentContent').innerHTML = `<div class="text-center py-4 text-danger"><i class="fas fa-exclamation-circle fa-3x"></i><p class="mt-3">تعذر تحميل التفاصيل</p></div>`;
                    }
                })
                .catch(() => {
                    document.getElementById('viewAppointmentContent').innerHTML = `<div class="text-center py-4 text-danger"><i class="fas fa-exclamation-triangle fa-3x"></i><p class="mt-3">فشل الاتصال بالخادم</p></div>`;
                });
        }

        function confirmFromModal() { if (currentViewId) { updateStatus(currentViewId, 'confirmed'); bootstrap.Modal.getInstance(document.getElementById('viewAppointmentModal')).hide(); } }
        function cancelFromModal() { if (currentViewId) { updateStatus(currentViewId, 'cancelled'); bootstrap.Modal.getInstance(document.getElementById('viewAppointmentModal')).hide(); } }

        // ==================== DOCTORS ====================
        function deleteDoctor(id) {
            if (!confirm('هل أنت متأكد من حذف هذا الطبيب؟')) return;
            fetch('api/delete_doctor.php', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ id }) })
                .then(res => res.json())
                .then(data => { showToast(data.message, data.success ? 'success' : 'error'); if (data.success) location.reload(); });
        }

        // ==================== MESSAGES ====================
        function deleteMessage(id) {
            if (!confirm('هل أنت متأكد من حذف هذه الرسالة؟')) return;
            fetch('api/delete_message.php', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ id }) })
                .then(res => res.json())
                .then(data => { showToast(data.message, data.success ? 'success' : 'error'); if (data.success) location.reload(); });
        }

        // ==================== SETTINGS ====================
        document.getElementById('settingsForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            fetch('api/save_settings.php', { method: 'POST', body: new FormData(this) })
                .then(res => res.json())
                .then(data => showToast(data.message, data.success ? 'success' : 'error'));
        });

        // ==================== NOTIFICATIONS ====================
        function toggleNotifications() {
            const d = document.getElementById('notificationsDropdown');
            if (d) d.style.display = (d.style.display === 'none' || d.style.display === '') ? 'block' : 'none';
        }
        document.addEventListener('click', function(e) {
            const n = document.getElementById('notificationsDropdown');
            const b = document.querySelector('.topbar-notifications');
            if (n && b && !b.contains(e.target)) n.style.display = 'none';
        });
    </script>
	<!-- ==================== ADD DOCTOR MODAL ==================== -->
<div class="modal fade" id="addDoctorModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #C41E3A, #8B0000); color: white;">
                <h5 class="modal-title"><i class="fas fa-user-plus me-2"></i>اضافه اخصائي او معالج جديد</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addDoctorForm">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">الاسم الكامل <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="addDoctorName" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">التخصص <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="addDoctorSpecialty" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">البريد الإلكتروني</label>
                            <input type="email" class="form-control" id="addDoctorEmail">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">رقم الهاتف</label>
                            <input type="tel" class="form-control" id="addDoctorPhone">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">التقييم</label>
                            <input type="number" class="form-control" id="addDoctorRating" value="5.0" min="0" max="5" step="0.1">
                        </div>
                        <div class="col-md-9">
                            <label class="form-label fw-bold">رابط الصورة</label>
                            <input type="text" class="form-control" id="addDoctorImage" placeholder="https://placehold.co/200x200/e8e8e8/333333?text=Dr">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">النبذة التعريفية</label>
                            <textarea class="form-control" id="addDoctorBio" rows="3"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-primary-custom" onclick="saveNewDoctor()">
                    <i class="fas fa-save me-1"></i> حفظ الطبيب
                </button>
            </div>
        </div>
    </div>
</div>
	<!-- ==================== ADD therapy MODAL ==================== -->
<div class="modal fade" id="addtherapymodal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #C41E3A, #8B0000); color: white;">
                <h5 class="modal-title"><i class="fas fa-user-plus me-2"></i>اضافه اخصائي / معالج</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addDoctorForm">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">الاسم الكامل <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="addtherapyName" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">التخصص <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="addtherapySpecialty" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">البريد الإلكتروني</label>
                            <input type="email" class="form-control" id="addtherapyEmail">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">رقم الهاتف</label>
                            <input type="tel" class="form-control" id="addtherapyPhone">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">التقييم</label>
                            <input type="number" class="form-control" id="addtherapyRating" value="5.0" min="0" max="5" step="0.1">
                        </div>
                        <div class="col-md-9">
                            <label class="form-label fw-bold">رابط الصورة</label>
                            <input type="text" class="form-control" id="addtherapyImage" placeholder="https://placehold.co/200x200/e8e8e8/333333?text=Dr">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">النبذة التعريفية</label>
                            <textarea class="form-control" id="addtherapyBio" rows="3"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-primary-custom" onclick="saveNewtherapy()">
                    <i class="fas fa-save me-1"></i>حفظ
                </button>
            </div>
        </div>
    </div>
</div>
	<!-- ==================== EDIT DOCTOR MODAL ==================== -->
<div class="modal fade" id="editDoctorModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #C41E3A, #8B0000); color: white;">
                <h5 class="modal-title"><i class="fas fa-user-edit me-2"></i>تعديل بيانات الطبيب</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editDoctorForm">
                    <input type="hidden" id="editDoctorId">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">الاسم الكامل</label>
                            <input type="text" class="form-control" id="editDoctorName" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">التخصص</label>
                            <input type="text" class="form-control" id="editDoctorSpecialty" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">البريد الإلكتروني</label>
                            <input type="email" class="form-control" id="editDoctorEmail">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">رقم الهاتف</label>
                            <input type="tel" class="form-control" id="editDoctorPhone">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">التقييم</label>
                            <input type="number" class="form-control" id="editDoctorRating" min="0" max="5" step="0.1">
                        </div>
                        <div class="col-md-9">
                            <label class="form-label fw-bold">رابط الصورة</label>
                            <input type="text" class="form-control" id="editDoctorImage">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">النبذة التعريفية</label>
                            <textarea class="form-control" id="editDoctorBio" rows="3"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-primary-custom" onclick="saveDoctorEdit()">
                    <i class="fas fa-save me-1"></i> حفظ التعديلات
                </button>
            </div>
        </div>
    </div>
</div>
	<!-- ==================== EDIT therapy MODAL ==================== -->
<div class="modal fade" id="edittherapyModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #C41E3A, #8B0000); color: white;">
                <h5 class="modal-title"><i class="fas fa-user-edit me-2"></i>تعديل بيانات اخصائي</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editDoctorForm">
                    <input type="hidden" id="edittherapyId">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">الاسم الكامل</label>
                            <input type="text" class="form-control" id="edittherapyName" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">التخصص</label>
                            <input type="text" class="form-control" id="edittherapySpecialty" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">البريد الإلكتروني</label>
                            <input type="email" class="form-control" id="edittherapyEmail">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">رقم الهاتف</label>
                            <input type="tel" class="form-control" id="edittherapyPhone">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">التقييم</label>
                            <input type="number" class="form-control" id="edittherapyRating" min="0" max="5" step="0.1">
                        </div>
                        <div class="col-md-9">
                            <label class="form-label fw-bold">رابط الصورة</label>
                            <input type="text" class="form-control" id="edittherapyImage">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">النبذة التعريفية</label>
                            <textarea class="form-control" id="edittherapyBio" rows="3"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-primary-custom" onclick="savetherapyEdit()">
                    <i class="fas fa-save me-1"></i> حفظ التعديلات
                </button>
            </div>
        </div>
    </div>
</div>
<script>
// ==================== EDIT DOCTOR ====================
function editDoctor(id) {
    // فتح المودال
    const modal = new bootstrap.Modal(document.getElementById('editDoctorModal'));
    modal.show();
    
    // جلب بيانات الطبيب
    fetch(`api/get_doctor.php?id=${id}`)
        .then(res => res.json())
        .then(result => {
            if (result.success) {
                const doc = result.data;
                document.getElementById('editDoctorId').value = doc.id;
                document.getElementById('editDoctorName').value = doc.name || '';
                document.getElementById('editDoctorSpecialty').value = doc.specialty || '';
                document.getElementById('editDoctorEmail').value = doc.email || '';
                document.getElementById('editDoctorPhone').value = doc.phone || '';
                document.getElementById('editDoctorRating').value = doc.rating || 0;
                document.getElementById('editDoctorImage').value = doc.image || '';
                document.getElementById('editDoctorBio').value = doc.bio || '';
            } else {
                alert('تعذر تحميل بيانات الطبيب');
                modal.hide();
            }
        })
        .catch(() => {
            alert('فشل الاتصال بالخادم');
            modal.hide();
        });
}

function saveDoctorEdit() {
    const data = {
        id: document.getElementById('editDoctorId').value,
        name: document.getElementById('editDoctorName').value,
        specialty: document.getElementById('editDoctorSpecialty').value,
        email: document.getElementById('editDoctorEmail').value,
        phone: document.getElementById('editDoctorPhone').value,
        rating: document.getElementById('editDoctorRating').value,
        image: document.getElementById('editDoctorImage').value,
        bio: document.getElementById('editDoctorBio').value
    };
    
    fetch('api/update_doctor.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(result => {
        if (result.success) {
            alert('تم حفظ التعديلات بنجاح');
            location.reload();
        } else {
            alert('فشل الحفظ: ' + result.message);
        }
    })
    .catch(() => alert('حدث خطأ في الاتصال'));
}
// تحديث عداد الحجوزات
function updateAppointmentBadge() {
    fetch('api/get_pending_count.php')
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const badge = document.querySelector('.nav-item[data-page="appointments"] .badge');
                if (badge) {
                    badge.textContent = data.count;
                    badge.style.display = data.count > 0 ? 'inline-block' : 'none';
                }
                
                // كمان نحدث النقطة الحمرا في الجرس
                const notifDot = document.querySelector('.notif-dot');
                const notifCount = document.querySelector('.notif-count');
                if (notifDot) notifDot.style.display = data.count > 0 ? 'block' : 'none';
                if (notifCount) {
                    notifCount.textContent = data.count;
                    notifCount.style.display = data.count > 0 ? 'flex' : 'none';
                }
            }
        });
}

// تحديث العداد كل 30 ثانية
setInterval(updateAppointmentBadge, 30000);

// أول تحميل
document.addEventListener('DOMContentLoaded', updateAppointmentBadge);

// ==================== ADD DOCTOR ====================
function openModal(modalId) {
    const modal = new bootstrap.Modal(document.getElementById(modalId));
    modal.show();
}

function saveNewDoctor() {
    const data = {
        name: document.getElementById('addDoctorName').value,
        specialty: document.getElementById('addDoctorSpecialty').value,
        email: document.getElementById('addDoctorEmail').value,
        phone: document.getElementById('addDoctorPhone').value,
        rating: document.getElementById('addDoctorRating').value || 5.0,
        image: document.getElementById('addDoctorImage').value || '',
        bio: document.getElementById('addDoctorBio').value || ''
    };
    
    if (!data.name || !data.specialty) {
        alert('يرجى ملء الحقول المطلوبة');
        return;
    }
    
    fetch('api/add_doctor.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(result => {
        if (result.success) {
            alert('تم إضافة الطبيب بنجاح');
            location.reload();
        } else {
            alert('فشل الإضافة: ' + result.message);
        }
    })
    .catch(() => alert('حدث خطأ في الاتصال'));
}
// ==================== SERVICES ====================
function openServiceModal() {
    document.getElementById('serviceId').value = '';
    document.getElementById('serviceTitle').value = '';
    document.getElementById('serviceIcon').value = 'fa-capsules';
    document.getElementById('serviceDescription').value = '';
    document.getElementById('serviceImage').value = '';
    document.getElementById('serviceStatus').value = '1';
    document.getElementById('serviceModalTitle').innerHTML = '<i class="fas fa-capsules me-2"></i>إضافة خدمة جديدة';
    new bootstrap.Modal(document.getElementById('serviceModal')).show();
}

function editService(id) {
    fetch(`api/get_service.php?id=${id}`)
        .then(res => res.json())
        .then(result => {
            if (result.success) {
                const s = result.data;
                document.getElementById('serviceId').value = s.id;
                document.getElementById('serviceTitle').value = s.title;
                document.getElementById('serviceIcon').value = s.icon || '';
                document.getElementById('serviceDescription').value = s.description || '';
                document.getElementById('serviceImage').value = s.image || '';
                document.getElementById('serviceStatus').value = s.is_active;
                document.getElementById('serviceModalTitle').innerHTML = '<i class="fas fa-edit me-2"></i>تعديل الخدمة';
                new bootstrap.Modal(document.getElementById('serviceModal')).show();
            }
        });
}

function saveService() {
    const data = {
        id: document.getElementById('serviceId').value,
        title: document.getElementById('serviceTitle').value,
        icon: document.getElementById('serviceIcon').value,
        description: document.getElementById('serviceDescription').value,
        image: document.getElementById('serviceImage').value,
        is_active: document.getElementById('serviceStatus').value
    };
    
    if (!data.title) { alert('يرجى إدخال اسم الخدمة'); return; }
    
    fetch('api/save_service.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(result => {
        if (result.success) {
            alert('تم حفظ الخدمة بنجاح');
            location.reload();
        } else {
            alert('فشل: ' + result.message);
        }
    });
}

function deleteService(id) {
    if (!confirm('هل أنت متأكد من حذف هذه الخدمة؟')) return;
    fetch('api/delete_service.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id })
    })
    .then(res => res.json())
    .then(result => {
        alert(result.message);
        if (result.success) location.reload();
    });
}
// ==================== BLOG ====================
function openBlogModal() {
    document.getElementById('blogId').value = '';
    document.getElementById('blogTitle').value = '';
    document.getElementById('blogCategory').value = 'عام';
    document.getElementById('blogStatus').value = '1';
    document.getElementById('blogExcerpt').value = '';
    document.getElementById('blogContent').value = '';
    document.getElementById('blogImage').value = '';
    document.getElementById('blogModalTitle').innerHTML = '<i class="fas fa-newspaper me-2"></i>مقال جديد';
    new bootstrap.Modal(document.getElementById('blogModal')).show();
}

function editBlog(id) {
    fetch(`api/get_blog.php?id=${id}`)
        .then(res => res.json())
        .then(result => {
            if (result.success) {
                const b = result.data;
                document.getElementById('blogId').value = b.id;
                document.getElementById('blogTitle').value = b.title;
                document.getElementById('blogCategory').value = b.category || 'عام';
                document.getElementById('blogStatus').value = b.is_published;
                document.getElementById('blogExcerpt').value = b.excerpt || '';
                document.getElementById('blogContent').value = b.content || '';
                document.getElementById('blogImage').value = b.image || '';
                document.getElementById('blogModalTitle').innerHTML = '<i class="fas fa-edit me-2"></i>تعديل المقال';
                new bootstrap.Modal(document.getElementById('blogModal')).show();
            }
        });
}

function saveBlog() {
    const data = {
        id: document.getElementById('blogId').value,
        title: document.getElementById('blogTitle').value,
        category: document.getElementById('blogCategory').value,
        is_published: document.getElementById('blogStatus').value,
        excerpt: document.getElementById('blogExcerpt').value,
        content: document.getElementById('blogContent').value,
        image: document.getElementById('blogImage').value
    };
    
    if (!data.title) { alert('يرجى إدخال عنوان المقال'); return; }
    
    fetch('api/save_blog.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(result => {
        if (result.success) {
            alert('تم حفظ المقال بنجاح');
            location.reload();
        } else {
            alert('فشل: ' + result.message);
        }
    });
}

function deleteBlog(id) {
    if (!confirm('هل أنت متأكد من حذف هذا المقال؟')) return;
    fetch('api/delete_blog.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id })
    })
    .then(res => res.json())
    .then(result => {
        alert(result.message);
        if (result.success) location.reload();
    });
}
// ==================== PAYMENTS ====================
function filterPayments() {
    const status = document.getElementById('paymentStatusFilter').value;
    document.querySelectorAll('.payment-row').forEach(row => {
        row.style.display = (status === 'all' || row.getAttribute('data-status') === status) ? '' : 'none';
    });
}

function updatePayment(id, status) {
    if (!confirm(`هل أنت متأكد من ${status === 'confirmed' ? 'تأكيد' : 'رفض'} هذه الدفعة؟`)) return;
    
    fetch('api/update_payment.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id, status })
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        if (data.success) location.reload();
    })
    .catch(() => alert('حدث خطأ'));
}

// ==================== MESSAGES ====================
let currentMessagePhone = '';

function viewMessage(id) {
    const modal = new bootstrap.Modal(document.getElementById('viewMessageModal'));
    modal.show();
    
    document.getElementById('viewMessageContent').innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border text-primary"></div>
            <p class="mt-2">جاري تحميل الرسالة...</p>
        </div>
    `;
    
    fetch(`api/get_message.php?id=${id}`)
        .then(res => res.json())
        .then(result => {
            if (result.success) {
                const msg = result.data;
                currentMessagePhone = msg.phone || '';
                
                document.getElementById('viewMessageSubject').textContent = msg.subject || 'رسالة';
                document.getElementById('viewMessageContent').innerHTML = `
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="info-box">
                                <label>👤 المرسل</label>
                                <p>${msg.name || 'غير معروف'}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <label>📞 الهاتف</label>
                                <p><a href="tel:${msg.phone}">${msg.phone || 'غير محدد'}</a></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <label>📧 البريد</label>
                                <p>${msg.email || 'غير محدد'}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <label>📅 التاريخ</label>
                                <p>${msg.created_at}</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="info-box">
                                <label>📝 الموضوع</label>
                                <p>${msg.subject || 'بدون موضوع'}</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="info-box" style="background: #fff; border: 1px solid #eee;">
                                <label>💬 الرسالة</label>
                                <p style="white-space: pre-wrap; line-height: 1.8;">${msg.message || 'لا يوجد محتوى'}</p>
                            </div>
                        </div>
                    </div>
                `;
                
                // تعليم الرسالة كمقروءة
                fetch(`api/mark_read.php?id=${id}`);
                
                // تحديث شكل الرسالة في القائمة
                const msgElement = document.getElementById('msg-' + id);
                if (msgElement) {
                    msgElement.classList.remove('unread');
                }
            } else {
                document.getElementById('viewMessageContent').innerHTML = `
                    <div class="text-center py-4 text-danger">
                        <i class="fas fa-exclamation-circle fa-3x"></i>
                        <p class="mt-3">تعذر تحميل الرسالة</p>
                    </div>
                `;
            }
        })
        .catch(() => {
            document.getElementById('viewMessageContent').innerHTML = `
                <div class="text-center py-4 text-danger">
                    <i class="fas fa-exclamation-triangle fa-3x"></i>
                    <p class="mt-3">فشل الاتصال</p>
                </div>
            `;
        });
}

function replyMessage() {
    if (currentMessagePhone) {
        window.open(`https://wa.me/2${currentMessagePhone}`, '_blank');
    } else {
        alert('لا يوجد رقم هاتف للرد');
    }
}

function deleteMessage(id) {
    if (!confirm('هل أنت متأكد من حذف هذه الرسالة؟')) return;
    
    fetch('api/delete_message.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            const msgElement = document.getElementById('msg-' + id);
            if (msgElement) {
                msgElement.style.transition = 'all 0.3s';
                msgElement.style.opacity = '0';
                msgElement.style.transform = 'translateX(-50px)';
                setTimeout(() => msgElement.remove(), 300);
            }
            showToast('تم حذف الرسالة');
        } else {
            alert(data.message);
        }
    });
}
function deleteDoctor(id) {
    if (!confirm('هل أنت متأكد من حذف هذا الطبيب؟')) return;
    
    fetch('api/delete_doctor.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: id })
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        if (data.success) {
            location.reload();
        }
    })
    .catch(() => alert('حدث خطأ في الاتصال'));
}
// ===================== therapy ==================
function deletetherapy(id) {
    if (!confirm('حذف الاخصائي ؟')) return;
    
    fetch('api/deletetherapy.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: id })
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        if (data.success) {
            location.reload();
        }
    })
    .catch(() => alert('حدث خطأ في الاتصال'));
}
function edittherapy(id) {
    // فتح المودال
    const modal = new bootstrap.Modal(document.getElementById('edittherapyModal'));
    modal.show();
    
    // جلب بيانات الطبيب
    fetch(`api/gettherapy.php?id=${id}`)
        .then(res => res.json())
        .then(result => {
            if (result.success) {
                const doc = result.data;
                document.getElementById('edittherapyId').value = doc.id;
                document.getElementById('edittherapyName').value = doc.name || '';
                document.getElementById('edittherapySpecialty').value = doc.specialty || '';
                document.getElementById('edittherapyEmail').value = doc.email || '';
                document.getElementById('edittherapyPhone').value = doc.phone || '';
                document.getElementById('edittherapyRating').value = doc.rating || 0;
                document.getElementById('edittherapyImage').value = doc.photo || '';
                document.getElementById('edittherapyBio').value = doc.bio || '';
            } else {
                alert('therapy تحميل بيانات الطبيب');
                modal.hide();
            }
        })
        .catch(() => {
            alert('فشل الاتصال بالخادم');
            modal.hide();
        });
}

function savetherapyEdit() {
    const data = {
        id: document.getElementById('edittherapyId').value,
        name: document.getElementById('edittherapyName').value,
        specialty: document.getElementById('edittherapySpecialty').value,
        email: document.getElementById('edittherapyEmail').value,
        phone: document.getElementById('edittherapyPhone').value,
        rating: document.getElementById('edittherapyRating').value,
        image: document.getElementById('edittherapyImage').value,
        bio: document.getElementById('edittherapyBio').value
    };
    
    fetch('api/updatetherapy.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(result => {
        if (result.success) {
            alert('تم حفظ التعديلات بنجاح');
            location.reload();
        } else {
            alert('فشل الحفظ: ' + result.message);
        }
    })
    .catch(() => alert('حدث خطأ في الاتصال'));
}
function saveNewtherapy() {
    const data = {
        name: document.getElementById('addtherapyName').value,
        specialty: document.getElementById('addtherapySpecialty').value,
        email: document.getElementById('addtherapyEmail').value,
        phone: document.getElementById('addtherapyPhone').value,
        rating: document.getElementById('addtherapyRating').value || 5.0,
        image: document.getElementById('addtherapyImage').value || '',
        bio: document.getElementById('addtherapyBio').value || ''
    };
    
    if (!data.name || !data.specialty) {
        alert('يرجى ملء الحقول المطلوبة');
        return;
    }
    
    fetch('api/addtherapy.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(result => {
        if (result.success) {
            alert('تم إضافة الطبيب بنجاح');
            location.reload();
        } else {
            alert('فشل الإضافة: ' + result.message);
        }
    })
    .catch(() => alert('حدث خطأ في الاتصال'));
}
</script>
<!-- ==================== SERVICE MODAL ==================== -->
<div class="modal fade" id="serviceModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #C41E3A, #8B0000); color: white;">
                <h5 class="modal-title" id="serviceModalTitle"><i class="fas fa-capsules me-2"></i>إضافة خدمة</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="serviceForm">
                    <input type="hidden" id="serviceId">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">اسم الخدمة *</label>
                            <input type="text" class="form-control" id="serviceTitle" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">أيقونة FA</label>
                            <input type="text" class="form-control" id="serviceIcon" placeholder="fa-capsules">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">الوصف</label>
                            <textarea class="form-control" id="serviceDescription" rows="3"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">رابط الصورة</label>
                            <input type="text" class="form-control" id="serviceImage">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">الحالة</label>
                            <select class="form-select" id="serviceStatus">
                                <option value="1">نشط</option>
                                <option value="0">غير نشط</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-primary-custom" onclick="saveService()">
                    <i class="fas fa-save me-1"></i> حفظ
                </button>
            </div>
        </div>
    </div>
</div>
<!-- ==================== BLOG MODAL ==================== -->
<div class="modal fade" id="blogModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #C41E3A, #8B0000); color: white;">
                <h5 class="modal-title" id="blogModalTitle"><i class="fas fa-newspaper me-2"></i>مقال جديد</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="blogForm">
                    <input type="hidden" id="blogId">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-bold">عنوان المقال *</label>
                            <input type="text" class="form-control" id="blogTitle" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">التصنيف</label>
                            <select class="form-select" id="blogCategory">
                                <option value="عام">عام</option>
                                <option value="الإدمان">الإدمان</option>
                                <option value="الاكتئاب">الاكتئاب</option>
                                <option value="القلق">القلق</option>
                                <option value="نصائح">نصائح</option>
                                <option value="تعافي">تعافي</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">الحالة</label>
                            <select class="form-select" id="blogStatus">
                                <option value="1">منشور</option>
                                <option value="0">مسودة</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">ملخص المقال</label>
                            <textarea class="form-control" id="blogExcerpt" rows="2" placeholder="نبذة مختصرة عن المقال..."></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">محتوى المقال</label>
                            <textarea class="form-control" id="blogContent" rows="5" placeholder="اكتب محتوى المقال هنا..."></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">رابط الصورة</label>
                            <input type="text" class="form-control" id="blogImage" placeholder="https://images.unsplash.com/...">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-primary-custom" onclick="saveBlog()">
                    <i class="fas fa-save me-1"></i> حفظ المقال
                </button>
            </div>
        </div>
    </div>
</div>
<!-- ==================== VIEW MESSAGE MODAL ==================== -->
<div class="modal fade" id="viewMessageModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #1A3A5C, #0D6EFD); color: white;">
                <h5 class="modal-title" id="viewMessageSubject"><i class="fas fa-envelope-open me-2"></i>عرض الرسالة</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="viewMessageContent">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary"></div>
                    <p class="mt-2">جاري تحميل الرسالة...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                <button type="button" class="btn btn-primary" onclick="replyMessage()">
                    <i class="fas fa-reply me-1"></i> رد
                </button>
            </div>
        </div>
    </div>
</div>
</body>
</html>