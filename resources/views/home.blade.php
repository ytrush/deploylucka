<!DOCTYPE html>
<html lang="en">

<head>
    <title>EduLearn</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="pt-20 bg-gradient-to-r from-purple-50 to-yellow-50">

    <x-navbar />

    <x-heroSection />

    <x-learning-path-section />

    <x-career-section />

    <x-course-card />

    <x-mentor-section />

    <x-platform-section />

    <x-testimonial-section />

    <x-footer-section />
</body>

</html>
