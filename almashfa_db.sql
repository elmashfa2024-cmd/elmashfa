-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 19 مايو 2026 الساعة 18:37
-- إصدار الخادم: 8.0.17
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `almashfa_db`
--

-- --------------------------------------------------------

--
-- بنية الجدول `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- إرجاع أو استيراد بيانات الجدول `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `email`, `is_active`, `created_at`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 'admin@almashfa.com', 1, '2026-05-13 17:40:26');

-- --------------------------------------------------------

--
-- بنية الجدول `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `booking_number` varchar(20) NOT NULL,
  `patient_name` varchar(100) DEFAULT NULL,
  `patient_phone` varchar(20) DEFAULT NULL,
  `patient_email` varchar(100) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `appointment_date` date DEFAULT NULL,
  `appointment_time` varchar(20) DEFAULT NULL,
  `consultation_type` varchar(20) DEFAULT 'online',
  `payment_method` varchar(20) DEFAULT 'cash',
  `payment_receipt` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT '500.00',
  `status` varchar(20) DEFAULT 'pending',
  `is_confidential` tinyint(1) DEFAULT '0',
  `notes` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `content` text,
  `excerpt` varchar(500) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `views` int(11) DEFAULT '0',
  `is_published` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- إرجاع أو استيراد بيانات الجدول `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `title`, `content`, `excerpt`, `image`, `category`, `author_id`, `views`, `is_published`, `created_at`) VALUES
(3, 'القلق: إيه هو وازاي نتحكم فيه؟', 'نصايح عملية:\n\nخليك مركز على النفس: خد نفس عميق ٣ مرات لما تحس توتر.\nنظم يومك واعمل جدول صغير.\nاكتب اللي مضايقك، الكتابة بتهدي.', 'القلق شعور طبيعي بس لو طول الوقت بيضايقك وبيخلي اليوم صعب، يبقى محتاج تتحكم فيه.', 'photos/file_000000007158720a8d65df5693c32c7a.png', 'القلق', NULL, 2, 1, '2026-05-17 19:19:08'),
(4, 'الإدمان: أول خطوة للتعافي', 'الإدمان مش عيب، ومفيش حد بيحب يكون مدمِن. أول خطوة هي الاعتراف بالمشكلة، وبعدها تطلب دعم. الطريق صعب شوية، بس ممكن تتخطاه خطوة خطوة. اللي حواليك لازم يكونوا داعمين، والابتعاد عن أي محفزات للإدمان حاجة مهمة جداً.\n\nنصايح عملية:\n\nاتواصل مع مركز علاج أو طبيب متخصص.\nابتعد عن الأماكن أو الناس اللي بتشجع الإدمان.\nشارك رحلتك مع حد يساندك.\nاحتفل بأي نجاح صغير توصل له.', 'الإدمان مش عيب، ومفيش حد بيحب يكون مدمِن.', 'photos/file_0000000080d07243980bd5d12565dff5.png', 'الإدمان', NULL, 0, 1, '2026-05-17 19:21:01'),
(5, 'إزاي تعرف لو الاكتئاب مأثر عليك؟', 'الاكتئاب مش بس حزن بييجي فجأة، ساعات بيكون في حاجات صغيرة: كل حاجة بتبقى تعبانة، النوم متلخبط، ومفيش رغبة تعمل أي حاجة بتحبها. ممكن تحس كمان إنك عايش حياتك بالروتين ومفيش طاقة. لو حسيت بحاجة من دي، متكسفش تطلب مساعدة. التحدث مع حد تثق فيه أو مع طبيب نفسي ممكن يفرق معاك كتير.\n\nنصايح عملية:\n\nكل يوم حاول تعمل حاجة بسيطة تحبها حتى لو صغيرة.\nاخرج مشي نص ساعة أو حتى خد نفس في الشارع.\nشارك اللي بتحس بيه مع حد من أهلك أو أصحابك.\nلو الاكتئاب شديد، اتواصل مع طبيب نفسي فوراً.', 'الاكتئاب مش بس حزن بييجي فجأة', 'photos/file_00000000c28c720aa9a73b99f685ad13.png', 'الاكتئاب', NULL, 0, 1, '2026-05-17 19:22:49'),
(6, 'نصايح بسيطة لصحتك النفسية', 'مفيش وصفة سحرية، بس شوية حاجات بسيطة كل يوم ممكن تحافظ على صحتك النفسية: نوم منتظم، أكل صحي، شوية حركة، ووقت مع الناس اللي بتحبهم. كمان مهم تتكلم مع حد لما تحس بضغط.\n\nنصايح عملية:\n\nنظم نومك وحاول تنام في نفس الميعاد كل يوم.\nاعمل رياضة أو مشي نص ساعة يومياً.\nكل وجبات متوازنة وحاول تقلل السكر والدُهنيات.\nاقضي وقت مع حد بتحبه أو تواصل مع أصحابك.\nلو حاسس بضيق شديد، اطلب مساعدة من متخصص.', 'مفيش وصفة سحرية، بس شوية حاجات بسيطة كل يوم', 'photos/file_00000000a0547246802e3163c707308b.png', 'عام', NULL, 0, 1, '2026-05-17 19:23:43'),
(7, 'التعافي مش هدف.. رحلة يوم بيوم', 'التعافي من الإدمان أو المشاكل النفسية مش حاجة بتحصل بين يوم وليلة.\n كل يوم صغير بتعمل فيه خطوة للأمام بيحسب. السر هو الاستمرارية والصبر على النفس.بعد التعافي، حياتك محتاجة روتين جديد يساعدك تحافظ على حالتك النفسية والجسدية. \nالروتين ده بيخليك متوازن ومتحكم أكتر في حياتك.\nالوعي بنفسك وبمشاعرك بيخليك تعرف إمتى تحتاج مساعدة أو استراحة. ده عنصر أساسي في رحلة التعافي الطويلة.مفيش حد بيتعافى لوحده بالكامل، الدعم الاجتماعي من الأسرة والأصدقاء والمجموعات العلاجية بيعمل فرق كبير.\nنصايح عملية:\n\nخلي يومك مليان أنشطة صحية: رياضة، هوايات، قراءة، أو أي حاجة بتحبها.\nكل أسبوع، قيّم تقدمك وحسّن الخطط لو في حاجة مش ماشية.\nحافظ على علاقات صحية وداعمة، وتجنب الضغوط اللي ممكن تسبب عودة العادات القديمة.\nدايماً اتذكر: الانتكاسة مش فشل، هي فرصة تتعلم وتستمر.', 'التعافي من الإدمان أو المشاكل النفسية مش حاجة بتحصل بين يوم وليلة.', 'photos/image-2.jpg', 'تعافي', NULL, 10, 1, '2026-05-17 19:27:29');

-- --------------------------------------------------------

--
-- بنية الجدول `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `specialty` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `bio` text,
  `cv` text,
  `rating` decimal(2,1) DEFAULT '0.0',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- إرجاع أو استيراد بيانات الجدول `doctors`
--

INSERT INTO `doctors` (`id`, `name`, `specialty`, `email`, `phone`, `image`, `bio`, `cv`, `rating`, `is_active`, `created_at`) VALUES
(1, 'ا / هيثم جوده الشافعي', 'مدير الفريق العلاجي', 'haytham@almashfa.com', '010 99803903', 'https://i.ibb.co/Jj47SQJj/IMG-20260218-WA0011.jpg', 'متخصص في علاج الادمان والتأهيل النفسي\n', NULL, '5.0', 2, '2026-05-13 17:40:26'),
(8, 'د. محمد عبدالحميد', 'المدير الاداري والتنفيذي', 'medo@elmashfa.com', '010 69555446', 'photos/medo.png', 'المدير الاداري والمؤسس', NULL, '5.0', 2, '2026-05-14 16:25:08');

-- --------------------------------------------------------

--
-- بنية الجدول `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `message` text,
  `is_read` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `appointment_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `method` varchar(20) DEFAULT NULL,
  `receipt_image` varchar(255) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'pending',
  `confirmed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text,
  `icon` varchar(50) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- إرجاع أو استيراد بيانات الجدول `services`
--

INSERT INTO `services` (`id`, `title`, `description`, `icon`, `image`, `is_active`, `created_at`) VALUES
(1, 'علاج الإدمان', 'برنامج شامل لعلاج جميع أنواع الإدمان', 'fa-capsules', 'photos/file_0000000039787246b2899610bf1e1b1c.png', 1, '2026-05-13 17:40:26'),
(2, 'علاج الاكتئاب', 'تشخيص وعلاج الاكتئاب بجميع درجاته', 'fa-brain', 'photos/file_00000000c28c720aa9a73b99f685ad13.png', 1, '2026-05-13 17:40:26'),
(3, 'علاج القلق والتوتر', 'برامج متخصصة لاضطرابات القلق', 'fa-heartbeat', 'photos/file_000000007158720a8d65df5693c32c7a.png', 1, '2026-05-13 17:40:26'),
(4, 'العلاج السلوكي', 'جلسات علاج سلوكي معرفي', 'fa-users', 'photos/file_000000001994720abb285d25918d7cd2.png', 1, '2026-05-13 17:40:26'),
(5, 'العلاج الأسري', 'برامج دعم وإرشاد أسري', 'fa-home', 'photos/image-1.jpg', 1, '2026-05-13 17:40:26');

-- --------------------------------------------------------

--
-- بنية الجدول `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(50) NOT NULL,
  `setting_value` text,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- إرجاع أو استيراد بيانات الجدول `settings`
--

INSERT INTO `settings` (`id`, `setting_key`, `setting_value`) VALUES
(1, 'site_name', 'مركز المشفى للطب النفسي وعلاج الإدمان'),
(2, 'phone', '01069555446'),
(3, 'email', 'info@almashfa.com'),
(4, 'address', 'القاهرة-المنوفيه-قويسنا'),
(5, 'whatsapp', '01099803903'),
(31, 'phone2', '01099803903'),
(32, 'whatsapp2', '01069555446');

-- --------------------------------------------------------

--
-- بنية الجدول `staff`
--

CREATE TABLE `staff` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `specialty` varchar(100) DEFAULT NULL,
  `bio` text,
  `team` varchar(20) NOT NULL DEFAULT 'therapy',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `rating` decimal(3,1) NOT NULL DEFAULT '5.0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- إرجاع أو استيراد بيانات الجدول `staff`
--

INSERT INTO `staff` (`id`, `name`, `photo`, `specialty`, `bio`, `team`, `is_active`, `rating`, `created_at`) VALUES
(13, 'ا/ اسلام عبدالمنعم رخا', 'staff/eslamrakha.jpeg', 'اخصائي علاج ادمان وتأهيل سلوكي', '#متخصص في علاج الإدمان والتأهيل النفسي والسلوكي . \n#مدرب على أحدث البرامج العلاجية (CBT، MI، ST) .\n#إحنا بنمشي معاك الطريق من أول خطوة لغاية ما ترجع لحياتك أقوى من زمان 🤍\n', 'therapy', 1, '5.0', '2026-05-19 16:36:44'),
(14, 'ا/ وليد الدريني', 'staff/WhatsApp Image 2026-05-19 at 5.15.31 PM.jpeg', 'اخصائي علاج ادمان وتأهيل سلوكي', '#متخصص في علاج الإدمان والتأهيل النفسي والسلوكي . \n#مدرب على أحدث البرامج العلاجية (CBT، MI، ST) .\n#إحنا بنمشي معاك الطريق من أول خطوة لغاية ما ترجع لحياتك أقوى من زمان 🤍', 'therapy', 1, '5.0', '2026-05-19 16:39:02'),
(15, 'ا/ احمد طه السيد', 'staff/WhatsApp Image 2026-05-19 at 7.39.10 PM.jpeg', 'اخصائي علاج ادمان وتأهيل سلوكي', '#متخصص في علاج الإدمان والتأهيل النفسي والسلوكي . \n#مدرب على أحدث البرامج العلاجية (CBT، MI، ST) .\n#إحنا بنمشي معاك الطريق من أول خطوة لغاية ما ترجع لحياتك أقوى من زمان 🤍', 'therapy', 1, '5.0', '2026-05-19 16:46:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `booking_number` (`booking_number`);

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
