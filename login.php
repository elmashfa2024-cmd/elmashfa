<?php
session_start();

// لو المستخدم مسجل دخول بالفعل، نحوله للوحة التحكم
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../config/csrf.php';
    require_once '../config/rate_limit.php';
    require_once '../config/database.php';

    // CSRF
    csrf_verify();

    // Rate Limiting: 5 محاولات كل 15 دقيقة
    rate_limit_check('admin_login', 5, 900);

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!empty($username) && !empty($password)) {
        // جلب المستخدم بدون مقارنة كلمة السر في الـ SQL (أمان أفضل)
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = :username AND is_active = 1");
        $stmt->execute(['username' => $username]);
        $admin = $stmt->fetch();

        // التحقق: password_hash أولاً، ثم MD5 للتوافق مع الحسابات القديمة
        $valid = false;
        if ($admin) {
            if (password_verify($password, $admin['password'])) {
                $valid = true;
            } elseif ($admin['password'] === md5($password)) {
                // حساب قديم بـ MD5 → نحدّثه تلقائياً لـ password_hash
                $newHash = password_hash($password, PASSWORD_BCRYPT);
                $pdo->prepare("UPDATE admins SET password = ? WHERE id = ?")->execute([$newHash, $admin['id']]);
                $valid = true;
            }
        }

        if ($valid) {
            // تجديد session ID بعد تسجيل الدخول (Session Fixation protection)
            session_regenerate_id(true);
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id']        = $admin['id'];
            $_SESSION['admin_username']  = $admin['username'];
            $_SESSION['admin_email']     = $admin['email'];

            header('Location: index.php');
            exit;
        } else {
            $error = 'اسم المستخدم أو كلمة المرور غير صحيحة';
        }
    } else {
        $error = 'يرجى إدخال اسم المستخدم وكلمة المرور';
    }
}
require_once '../config/csrf.php';
$csrf_token = csrf_generate();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>تسجيل الدخول - مركز المشفى</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="admin-style.css">
</head>
<body class="login-page">

    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="login-logo">
                    <i class="fas fa-heartbeat"></i>
                </div>
                <h3>مركز <span>المشفى</span></h3>
                <p>لوحة التحكم الإدارية</p>
            </div>

            <?php if ($error): ?>
            <div class="alert alert-danger text-center"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form class="login-form" method="POST" action="">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
                <div class="form-group mb-3">
                    <label class="form-label"><i class="fas fa-user me-2"></i>اسم المستخدم</label>
                    <input type="text" class="form-control form-control-lg" name="username" placeholder="أدخل اسم المستخدم" required autocomplete="username">
                </div>
                <div class="form-group mb-3">
                    <label class="form-label"><i class="fas fa-lock me-2"></i>كلمة المرور</label>
                    <div class="password-wrapper">
                        <input type="password" class="form-control form-control-lg" name="password" id="password" placeholder="أدخل كلمة المرور" required autocomplete="current-password">
                        <i class="fas fa-eye toggle-password" onclick="togglePassword()"></i>
                    </div>
                </div>
                <button type="submit" class="btn btn-login btn-lg w-100">
                    <i class="fas fa-sign-in-alt me-2"></i>تسجيل الدخول
                </button>
            </form>

            <div class="login-footer">
                <p>© <?php echo date('Y'); ?> مركز المشفى. جميع الحقوق محفوظة.</p>
         <a href="../control" target="_blank" class="btn btn-sm btn-outline-primary me-2" title="معاينة الموقع">
                    <i class="fas fa-external-link-alt">  لوحه تحكم المرضي </i>
                </a>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const pwd = document.getElementById('password');
            const icon = document.querySelector('.toggle-password');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                pwd.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>
</html>
