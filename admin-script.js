


// ==================== SIDEBAR TOGGLE ====================
function toggleSidebar() {
    const sidebar = document.getElementById('adminSidebar');
    const main = document.getElementById('adminMain');
    
    if (window.innerWidth <= 991) {
        sidebar.classList.toggle('mobile-show');
    } else {
        sidebar.classList.toggle('collapsed');
        main.classList.toggle('expanded');
    }
}

// ==================== PAGE NAVIGATION ====================
document.addEventListener('DOMContentLoaded', function() {
    const navItems = document.querySelectorAll('.nav-item');
    const contentPages = document.querySelectorAll('.content-page');
    const pageTitle = document.getElementById('pageTitle');
    
    const pageTitles = {
        'dashboard': 'لوحة التحكم',
        'appointments': 'الحجوزات',
        'doctors': 'الأطباء',
        'services': 'الخدمات',
        'blog': 'المقالات',
        'payments': 'المدفوعات',
        'messages': 'الرسائل',
        'settings': 'الإعدادات'
    };

    navItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active from all
            navItems.forEach(n => n.classList.remove('active'));
            // Add active to clicked
            this.classList.add('active');
            
            // Get page name
            const page = this.getAttribute('data-page');
            
            // Hide all pages
            contentPages.forEach(p => p.classList.remove('active'));
            // Show target page
            const targetPage = document.getElementById(page + '-page');
            if (targetPage) {
                targetPage.classList.add('active');
            }
            
            // Update page title
            if (pageTitles[page]) {
                pageTitle.textContent = pageTitles[page];
            }
            
            // Close mobile sidebar
            if (window.innerWidth <= 991) {
                document.getElementById('adminSidebar').classList.remove('mobile-show');
            }
        });
    });
});

// ==================== MODAL HANDLER ====================
function openModal(modalId) {
    const modal = new bootstrap.Modal(document.getElementById(modalId));
    modal.show();
}

// ==================== TOAST NOTIFICATION ====================
// ==================== TOAST NOTIFICATION (مضبوط) ====================
let toastTimeout;

function showToast(message = 'تمت العملية بنجاح!', type = 'success') {
    const toast = document.getElementById('adminToast');
    
    // لو فيه timeout شغال، نلغيه
    if (toastTimeout) {
        clearTimeout(toastTimeout);
        toastTimeout = null;
    }
    
    // نشيل show لو كانت موجودة
    toast.classList.remove('show');
    
    // نضبط الرسالة واللون
    toast.querySelector('span').textContent = message;
    
    if (type === 'success') {
        toast.style.background = '#28A745';
        toast.querySelector('i').className = 'fas fa-check-circle';
    } else if (type === 'error') {
        toast.style.background = '#DC3545';
        toast.querySelector('i').className = 'fas fa-times-circle';
    } else if (type === 'warning') {
        toast.style.background = '#FFC107';
        toast.querySelector('i').className = 'fas fa-exclamation-triangle';
    }
    
    // نظهره
    toast.classList.add('show');
    
    // نخفيه بعد 3 ثواني
    toastTimeout = setTimeout(() => {
        toast.classList.remove('show');
        toastTimeout = null;
    }, 3000);
    
    // نخفيه لو المستخدم ضغط عليه
    toast.onclick = function() {
        toast.classList.remove('show');
        if (toastTimeout) {
            clearTimeout(toastTimeout);
            toastTimeout = null;
        }
    };
}
// ==================== SHOW PAGE FUNCTION ====================
function showPage(pageName) {
    const navItem = document.querySelector(`.nav-item[data-page="${pageName}"]`);
    if (navItem) {
        navItem.click();
    }
}

// ==================== CLOSE MOBILE SIDEBAR ON CLICK OUTSIDE ====================
document.addEventListener('click', function(e) {
    const sidebar = document.getElementById('adminSidebar');
    const toggleBtn = document.querySelector('.btn-menu');
    const sidebarToggle = document.querySelector('.sidebar-toggle');
    
    if (window.innerWidth <= 991 && 
        sidebar.classList.contains('mobile-show') &&
        !sidebar.contains(e.target) &&
        e.target !== toggleBtn &&
        !toggleBtn.contains(e.target) &&
        e.target !== sidebarToggle &&
        !sidebarToggle.contains(e.target)) {
        sidebar.classList.remove('mobile-show');
    }
});

// ==================== SIMULATED ACTIONS ====================
document.querySelectorAll('.btn-outline-success, .btn-success').forEach(btn => {
    btn.addEventListener('click', function(e) {
        if (this.closest('td') || this.closest('.doctor-admin-actions') || this.closest('.message-actions')) {
            e.preventDefault();
            showToast('تم تأكيد العملية بنجاح!');
        }
    });
});

document.querySelectorAll('.btn-outline-danger, .btn-danger').forEach(btn => {
    btn.addEventListener('click', function(e) {
        if (this.closest('td') || this.closest('.doctor-admin-actions') || this.closest('.message-actions')) {
            if (confirm('هل أنت متأكد من الحذف؟')) {
                e.preventDefault();
                this.closest('tr')?.remove();
                this.closest('.doctor-admin-card')?.remove();
                this.closest('.message-item')?.remove();
                showToast('تم الحذف بنجاح!');
            }
        }
    });
});

// ==================== SEARCH FUNCTIONALITY ====================
document.querySelector('.search-admin input')?.addEventListener('input', function(e) {
    const query = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('.admin-table tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(query) ? '' : 'none';
    });
});
// ==================== VIEW APPOINTMENT ====================
let currentViewAppointmentId = null;

function viewAppointment(id) {
    currentViewAppointmentId = id;
    
    // فتح المودال
    const modal = new bootstrap.Modal(document.getElementById('viewAppointmentModal'));
    modal.show();
    
    // إظهار اللودينج
    document.getElementById('viewAppointmentContent').innerHTML = `
        <div class="text-center py-4">
            <i class="fas fa-spinner fa-spin fa-2x"></i>
            <p class="mt-2">جاري تحميل التفاصيل...</p>
        </div>
    `;
    
    // إخفاء أزرار التأكيد والإلغاء مؤقتاً
    document.getElementById('viewConfirmBtn').style.display = 'none';
    document.getElementById('viewCancelBtn').style.display = 'none';
    
    // جلب البيانات من API
    fetch(`api/get_appointment.php?id=${id}`)
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                const app = result.data;
                
                // تحديث عنوان المودال
                document.getElementById('viewBookingNumber').textContent = app.booking_number;
                
                // بناء محتوى المودال
                let html = `
                    <div class="row g-3">
                        <!-- حالة الحجز -->
                        <div class="col-12 text-center mb-3">
                            <span class="badge fs-6 px-4 py-2 bg-${app.status === 'confirmed' ? 'success' : app.status === 'pending' ? 'warning' : app.status === 'cancelled' ? 'danger' : 'info'}">
                                ${app.status_text}
                            </span>
                        </div>
                        
                        <!-- بيانات المريض -->
                        <div class="col-md-6">
                            <div class="info-box">
                                <label><i class="fas fa-user me-1"></i> اسم المريض</label>
                                <p>${app.patient_name || 'غير محدد'}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <label><i class="fas fa-phone me-1"></i> رقم الهاتف</label>
                                <p><a href="tel:${app.patient_phone}">${app.patient_phone || 'غير محدد'}</a></p>
                            </div>
                        </div>
                        
                        <!-- بيانات الخدمة والطبيب -->
                        <div class="col-md-6">
                            <div class="info-box">
                                <label><i class="fas fa-capsules me-1"></i> الخدمة</label>
                                <p>${app.service_name || 'غير محددة'}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <label><i class="fas fa-user-md me-1"></i> الطبيب</label>
                                <p>${app.doctor_name || 'لم يتم التحديد'} ${app.doctor_specialty ? `<br><small class="text-muted">${app.doctor_specialty}</small>` : ''}</p>
                            </div>
                        </div>
                        
                        <!-- الموعد -->
                        <div class="col-md-6">
                            <div class="info-box">
                                <label><i class="fas fa-calendar me-1"></i> التاريخ</label>
                                <p>${app.formatted_date}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <label><i class="fas fa-clock me-1"></i> الوقت</label>
                                <p>${app.appointment_time}</p>
                            </div>
                        </div>
                        
                        <!-- نوع الاستشارة والدفع -->
                        <div class="col-md-6">
                            <div class="info-box">
                                <label><i class="fas fa-video me-1"></i> نوع الاستشارة</label>
                                <p>${app.consultation_text}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <label><i class="fas fa-money-bill me-1"></i> طريقة الدفع</label>
                                <p>${app.payment_text}</p>
                            </div>
                        </div>
                        
                        ${app.payment_receipt ? `
                        <div class="col-12">
                            <div class="info-box">
                                <label><i class="fas fa-receipt me-1"></i> إيصال الدفع</label>
                                <a href="../${app.payment_receipt}" target="_blank" class="btn btn-sm btn-outline-primary mt-1">
                                    <i class="fas fa-eye me-1"></i> عرض الإيصال
                                </a>
                            </div>
                        </div>
                        ` : ''}
                        
                        ${app.notes ? `
                        <div class="col-12">
                            <div class="info-box">
                                <label><i class="fas fa-sticky-note me-1"></i> ملاحظات</label>
                                <p>${app.notes}</p>
                            </div>
                        </div>
                        ` : ''}
                        
                        <!-- تاريخ الإنشاء -->
                        <div class="col-12">
                            <small class="text-muted">
                                <i class="fas fa-clock me-1"></i> تم إنشاء الحجز: ${app.formatted_created}
                            </small>
                        </div>
                    </div>
                `;
                
                document.getElementById('viewAppointmentContent').innerHTML = html;
                
                // إظهار أزرار التأكيد والإلغاء للحجوزات المعلقة
                if (app.status === 'pending') {
                    document.getElementById('viewConfirmBtn').style.display = 'inline-block';
                    document.getElementById('viewCancelBtn').style.display = 'inline-block';
                }
            } else {
                document.getElementById('viewAppointmentContent').innerHTML = `
                    <div class="text-center py-4 text-danger">
                        <i class="fas fa-exclamation-circle fa-2x"></i>
                        <p class="mt-2">${result.error || 'حدث خطأ في تحميل البيانات'}</p>
                    </div>
                `;
            }
        })
        .catch(error => {
            document.getElementById('viewAppointmentContent').innerHTML = `
                <div class="text-center py-4 text-danger">
                    <i class="fas fa-exclamation-triangle fa-2x"></i>
                    <p class="mt-2">فشل الاتصال بالخادم</p>
                </div>
            `;
        });
}

// تأكيد الحجز من داخل المودال
function confirmFromModal() {
    if (currentViewAppointmentId) {
        updateStatus(currentViewAppointmentId, 'confirmed');
        // إغلاق المودال
        bootstrap.Modal.getInstance(document.getElementById('viewAppointmentModal')).hide();
    }
}

// إلغاء الحجز من داخل المودال
function cancelFromModal() {
    if (currentViewAppointmentId) {
        updateStatus(currentViewAppointmentId, 'cancelled');
        // إغلاق المودال
        bootstrap.Modal.getInstance(document.getElementById('viewAppointmentModal')).hide();
    }
}
// ==================== TOGGLE NOTIFICATIONS ====================
function toggleNotifications() {
    const dropdown = document.getElementById('notificationsDropdown');
    if (dropdown) {
        if (dropdown.style.display === 'none' || dropdown.style.display === '') {
            dropdown.style.display = 'block';
        } else {
            dropdown.style.display = 'none';
        }
    }
}

// إغلاق الإشعارات عند الضغط خارجها
document.addEventListener('click', function(e) {
    const dropdown = document.getElementById('notificationsDropdown');
    const bell = document.querySelector('.topbar-notifications');
    
    if (dropdown && bell && !bell.contains(e.target)) {
        dropdown.style.display = 'none';
    }
});
// ==================== TOAST FIX كامل ====================
(function() {
    const toast = document.getElementById('adminToast');
    
    // نخفيه فوراً لو كان ظاهر
    if (toast) {
        toast.classList.remove('show');
        toast.style.opacity = '0';
        toast.style.visibility = 'hidden';
        toast.style.transform = 'translateX(-120%)';
    }
    
    // دالة إظهار toast جديدة
    window.showToast = function(message, type) {
        if (!toast) return;
        
        // نلغي أي timeout قديم
        if (window._toastTimer) clearTimeout(window._toastTimer);
        
        // نوقف أي animation حالية
        toast.style.transition = 'none';
        toast.classList.remove('show');
        toast.style.opacity = '0';
        toast.style.visibility = 'hidden';
        toast.style.transform = 'translateX(-120%)';
        
        // نضبط الرسالة
        toast.querySelector('span').textContent = message || 'تمت العملية بنجاح!';
        
        // نضبط اللون
        if (type === 'error') {
            toast.style.background = '#DC3545';
            toast.querySelector('i').className = 'fas fa-times-circle';
        } else if (type === 'warning') {
            toast.style.background = '#FFC107';
            toast.querySelector('i').className = 'fas fa-exclamation-triangle';
        } else {
            toast.style.background = '#28A745';
            toast.querySelector('i').className = 'fas fa-check-circle';
        }
        
        // نرجع الـ transition ونظهره
        setTimeout(function() {
            toast.style.transition = 'all 0.4s ease';
            toast.classList.add('show');
            toast.style.opacity = '1';
            toast.style.visibility = 'visible';
            toast.style.transform = 'translateX(0)';
        }, 50);
        
        // نخفيه بعد 3 ثواني
        window._toastTimer = setTimeout(function() {
            toast.classList.remove('show');
            toast.style.opacity = '0';
            toast.style.visibility = 'hidden';
            toast.style.transform = 'translateX(-120%)';
        }, 3000);
    };
    
    // نخفيه عند الضغط عليه
    toast.onclick = function() {
        toast.classList.remove('show');
        toast.style.opacity = '0';
        toast.style.visibility = 'hidden';
        toast.style.transform = 'translateX(-120%)';
        if (window._toastTimer) clearTimeout(window._toastTimer);
    };
})();

// ==================== ADMIN MOBILE FIXES ====================
document.addEventListener('DOMContentLoaded', function() {

    // ===== Overlay للسايدبار على الموبايل =====
    // إنشاء overlay element
    let sidebarOverlay = document.getElementById('sidebarOverlay');
    if (!sidebarOverlay) {
        sidebarOverlay = document.createElement('div');
        sidebarOverlay.id = 'sidebarOverlay';
        sidebarOverlay.style.cssText = `
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 998;
            transition: opacity 0.3s ease;
        `;
        document.body.appendChild(sidebarOverlay);
    }

    // Override toggleSidebar لإضافة الـ overlay
    window.toggleSidebar = function() {
        const sidebar = document.getElementById('adminSidebar');
        const main = document.getElementById('adminMain');

        if (window.innerWidth <= 991) {
            const isOpen = sidebar.classList.contains('mobile-show');
            if (isOpen) {
                sidebar.classList.remove('mobile-show');
                sidebarOverlay.style.display = 'none';
            } else {
                sidebar.classList.add('mobile-show');
                sidebarOverlay.style.display = 'block';
            }
        } else {
            sidebar.classList.toggle('collapsed');
            main.classList.toggle('expanded');
        }
    };

    // إغلاق السايدبار لما تضغط على الـ overlay
    sidebarOverlay.addEventListener('click', function() {
        const sidebar = document.getElementById('adminSidebar');
        sidebar.classList.remove('mobile-show');
        sidebarOverlay.style.display = 'none';
    });

    // إغلاق السايدبار بعد الضغط على nav item على الموبايل
    document.querySelectorAll('.nav-item').forEach(function(item) {
        item.addEventListener('click', function() {
            if (window.innerWidth <= 991) {
                const sidebar = document.getElementById('adminSidebar');
                sidebar.classList.remove('mobile-show');
                sidebarOverlay.style.display = 'none';
            }
        });
    });

    // ===== منع Zoom على inputs في iOS =====
    document.querySelectorAll('input, select, textarea').forEach(function(el) {
        if (parseFloat(window.getComputedStyle(el).fontSize) < 16) {
            el.style.fontSize = '16px';
        }
    });

    // ===== Table horizontal scroll indicator =====
    document.querySelectorAll('.table-responsive').forEach(function(wrapper) {
        if (wrapper.scrollWidth > wrapper.clientWidth) {
            wrapper.style.position = 'relative';
        }
    });

    // ===== Toast position fix على الموبايل =====
    const toastContainer = document.querySelector('.toast-container');
    if (toastContainer && window.innerWidth <= 768) {
        toastContainer.style.left = '10px';
        toastContainer.style.right = '10px';
        toastContainer.style.bottom = '15px';
    }

    // ===== Responsive resize handler =====
    window.addEventListener('resize', function() {
        const sidebar = document.getElementById('adminSidebar');
        if (sidebar && window.innerWidth > 991) {
            sidebar.classList.remove('mobile-show');
            sidebarOverlay.style.display = 'none';
        }
    });
});


