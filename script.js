document.addEventListener('DOMContentLoaded', function() {
    AOS.init({
        duration: 1000,
        once: true
    });
});
document.addEventListener('DOMContentLoaded', () => {
initAOS();
initNavbar();
initActiveNav();
initCounters();
initSmoothScroll();
initChat();
initHeroFixes();
initMobileFixes();
initRippleEffect();
initScrollProgress();
});
function initAOS() {
if (typeof AOS === 'undefined') return;
AOS.init({
duration: 800,
easing: 'ease-in-out',
once: true,
disable: window.innerWidth <= 767
});
}
function initNavbar() {
const navbar = document.getElementById('mainNav');
if (!navbar) return;
const handleNavbar = () => {
if (window.scrollY > 50 || window.innerWidth <= 768) {
navbar.classList.add('scrolled');
} else {
navbar.classList.remove('scrolled');
}
};
handleNavbar();
window.addEventListener('scroll', handleNavbar);
window.addEventListener('resize', handleNavbar);
}
function initSmoothScroll() {
const navbar = document.getElementById('mainNav');
const navbarHeight = navbar ? navbar.offsetHeight : 80;
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
anchor.addEventListener('click', function (e) {
const href = this.getAttribute('href');
if (href === '#') return;
const target = document.querySelector(href);
if (!target) return;
e.preventDefault();
const targetPosition =
target.getBoundingClientRect().top +
window.pageYOffset -
navbarHeight;
window.scrollTo({
top: targetPosition,
behavior: 'smooth'
});
const navbarCollapse = document.querySelector('.navbar-collapse');
if (navbarCollapse?.classList.contains('show')) {
const toggler = document.querySelector('.navbar-toggler');
if (toggler) toggler.click();
}
});
});
}
window.addEventListener('load', () => {
const preloader = document.getElementById('preloader');
if (preloader) {
setTimeout(() => {
preloader.classList.add('fade-out');
}, 800);
}
});
window.addEventListener('load', function() {
const preloader = document.getElementById('preloader');
preloader.classList.add('fade-out');
setTimeout(() => {
preloader.style.display = 'none';
}, 600);
});
function initActiveNav() {
const sections = document.querySelectorAll('section[id]');
const navLinks = document.querySelectorAll('.nav-link');
if (!sections.length || !navLinks.length) return;
const handleActiveNav = () => {
let current = '';
sections.forEach(section => {
const sectionTop = section.offsetTop - 120;
const sectionHeight = section.offsetHeight;
if (
window.scrollY >= sectionTop &&
window.scrollY < sectionTop + sectionHeight
) {
current = section.getAttribute('id');
}
});
navLinks.forEach(link => {
link.classList.remove('active');
if (link.getAttribute('href') === `#${current}`) {
link.classList.add('active');
}
});
};
handleActiveNav();
window.addEventListener('scroll', handleActiveNav);
}
function initCounters() {
const counters = document.querySelectorAll('.counter');
const speed = 200;
const runCounter = (counter) => {
const target = +counter.getAttribute('data-target');
const updateCount = () => {
const count = +counter.innerText;
const increment = target / speed;
if (count < target) {
counter.innerText = Math.ceil(count + increment);
setTimeout(updateCount, 10);
} else {
counter.innerText = target;
}
};
updateCount();
};
const observer = new IntersectionObserver((entries) => {
entries.forEach(entry => {
if (entry.isIntersecting) {
runCounter(entry.target);
observer.unobserve(entry.target);
}
});
}, { threshold: 0.5 });
counters.forEach(counter => observer.observe(counter));
}
function initChat() {
const chatToggle = document.getElementById('chatToggle');
const chatBox = document.getElementById('chatBox');
const chatClose = document.getElementById('chatClose');
const chatInput = document.querySelector('.chat-footer input');
const chatBtn = document.querySelector('.chat-footer .btn-send');
const chatBody = document.querySelector('.chat-body');
if (chatToggle && chatBox) {
chatToggle.addEventListener('click', () => {
chatBox.classList.toggle('show');
});
}
if (chatClose && chatBox) {
chatClose.addEventListener('click', () => {
chatBox.classList.remove('show');
});
}
const sendMessage = () => {
if (!chatInput || !chatBody) return;
const message = chatInput.value.trim();
if (message === '') return;
const userMsg = document.createElement('div');
userMsg.className = 'chat-message';
userMsg.style.cssText =
'background:#CC0000;color:white;margin-right:auto;text-align:left;';
userMsg.textContent = message;
chatBody.appendChild(userMsg);
chatInput.value = '';
chatBody.scrollTop = chatBody.scrollHeight;
setTimeout(() => {
const botMsg = document.createElement('div');
botMsg.className = 'chat-message bot-message';
let response = '';
const userMessage = message.toLowerCase();
if (
userMessage.includes('حجز') ||
userMessage.includes('احجز')
) {
response = 'سيتم التواصل معك لإتمام الحجز في أسرع وقت.';
}
else if (
userMessage.includes('سعر') ||
userMessage.includes('تكلفة')
) {
response = 'سيقوم الفريق المختص بتوضيح الأسعار المناسبة للحالة.';
}
else if (
userMessage.includes('عنوان') ||
userMessage.includes('مكان')
) {
response = 'سيتم إرسال عنوان المشفى والموقع بالتفصيل.';
}
else if (
userMessage.includes('ادمان')
) {
response = 'لدينا برامج متخصصة لعلاج الإدمان بإشراف طبي كامل.';
}
else if (
userMessage.includes('قلق')
) {
response = 'نوفر برامج علاج نفسي متخصصة للقلق والتوتر.';
}
else if (
userMessage.includes('واتساب') ||
userMessage.includes('رقم')
) {
response = 'يمكنك التواصل معنا مباشرة عبر أرقام المشفى الظاهرة بالموقع.';
}
else {
response = 'شكراً لتواصلك معنا، سيتم الرد عليك قريباً.';
}
botMsg.textContent = response;
chatBody.appendChild(botMsg);
chatBody.scrollTop = chatBody.scrollHeight;
}, 800);
};
if (chatBtn) {
chatBtn.addEventListener('click', sendMessage);
}
if (chatInput) {
chatInput.addEventListener('keypress', (e) => {
if (e.key === 'Enter') {
sendMessage();
}
});
}
}
function initHeroFixes() {
const heroSection = document.querySelector('.hero-section');
if (heroSection) {
heroSection.style.overflow = 'hidden';
heroSection.style.position = 'relative';
const heroContent = heroSection.querySelector('.hero-content');
if (heroContent) {
heroContent.style.position = 'relative';
heroContent.style.zIndex = '5';
}
}
const heroButtons = document.querySelectorAll('.hero-section .btn');
heroButtons.forEach(button => {
button.style.position = 'relative';
button.style.zIndex = '10';
button.style.pointerEvents = 'auto';
});
const pageHeroes = document.querySelectorAll('.page-hero');
pageHeroes.forEach(hero => {
hero.style.position = 'relative';
hero.style.overflow = 'hidden';
});
}
function initMobileFixes() {
const chatBox = document.getElementById('chatBox');
function handleChatBox() {
if (!chatBox) return;
if (window.innerWidth <= 768) {
chatBox.style.width = 'calc(100% - 20px)';
chatBox.style.right = '10px';
chatBox.style.left = '10px';
chatBox.style.bottom = '90px';
} else {
chatBox.style.width = '370px';
chatBox.style.right = '30px';
chatBox.style.left = 'auto';
chatBox.style.bottom = '100px';
}
}
handleChatBox();
window.addEventListener('resize', handleChatBox);
const inputs = document.querySelectorAll('input, textarea, select');
inputs.forEach(input => {
const fontSize = parseFloat(
window.getComputedStyle(input).fontSize
);
if (fontSize < 16) {
input.style.fontSize = '16px';
}
});
document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
link.addEventListener('click', () => {
const navbarCollapse =
document.querySelector('.navbar-collapse');
if (navbarCollapse?.classList.contains('show')) {
const toggler =
document.querySelector('.navbar-toggler');
if (toggler) toggler.click();
}
});
});
document.body.style.overflowX = 'hidden';
}
function initRippleEffect() {
const buttons = document.querySelectorAll('.btn');
if (!buttons.length) return;
buttons.forEach(button => {
button.addEventListener('click', function(e) {
const ripple = document.createElement('span');
ripple.className = 'ripple';
const rect = this.getBoundingClientRect();
ripple.style.left = `${e.clientX - rect.left}px`;
ripple.style.top = `${e.clientY - rect.top}px`;
this.appendChild(ripple);
setTimeout(() => {
ripple.remove();
}, 500);
});
});
}
function initScrollProgress() {
const progressBar = document.querySelector('.scroll-progress');
if (!progressBar) return;
const handleScrollProgress = () => {
const windowHeight =
document.documentElement.scrollHeight -
document.documentElement.clientHeight;
const progress =
(window.scrollY / windowHeight) * 100;
progressBar.style.width = `${progress}%`;
};
window.addEventListener('scroll', handleScrollProgress);
}
console.log('📱 Mobile fixes applied successfully! Elgazar :)');