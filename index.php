<?php
require_once 'config/database.php';
$title = 'Home';
include 'includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?> | Cermatinvest</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>


    <script>
      tailwind.config = {
        theme: {
          extend: {
            fontFamily: {
              rubik: ['Rubik', 'sans-serif'],
            },
            colors: {
              primary: {
                50: '#f0f9ff',
                100: '#e0f2fe',
                500: '#3b82f6',
                600: '#2563eb',
                700: '#1d4ed8',
              }
            }
          }
        }
      }
    </script>

    <style>
        html {
            scroll-behavior: smooth;
        }
        body {
            font-family: 'Rubik', sans-serif;
        }
        .transition-smooth {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">
    <!-- Hero Section -->
    <section class="py-24 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16" data-aos="fade-down" data-aos-duration="800">
                <h1 class="text-4xl md:text-5xl font-bold mb-6 leading-tight">
                Solusi Tepat Untuk Menentukan <br>
                    <span class="text-primary-600">Pilihan Investasimu</span>
                </h1>
                <p class="text-lg md:text-xl text-gray-600 max-w-2xl mx-auto">
                    Sistem rekomendasi investasi berbasis Weighted Product Model untuk membantu Anda memilih dengan lebih objektif.
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                <!-- Feature Card 1 -->
                <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 card-hover"
                     data-aos="fade-right" data-aos-delay="100">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 rounded-lg bg-primary-100 flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold">Investasi yang Tepat</h2>
                    </div>
                    <p class="text-gray-600 mb-6">
                        Temukan instrumen investasi yang sesuai dengan profil risiko dan tujuan finansial Anda.
                    </p>
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-primary-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-600">Analisis berbasis data</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-primary-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-600">Perbandingan objektif</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-primary-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-600">Rekomendasi personal</span>
                        </div>
                    </div>
                </div>

                <!-- Feature Card 2 -->
                <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 card-hover"
                     data-aos="fade-left" data-aos-delay="100">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 rounded-lg bg-primary-100 flex items-center justify-center mr-4">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold">Mulai Sekarang</h2>
                    </div>
                    <p class="text-gray-600 mb-6">
                        Cukup tentukan prioritas Anda dan dapatkan rekomendasi investasi terbaik dalam hitungan menit.
                    </p>
                    
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="dashboard.php" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-full shadow-sm text-white bg-primary-600 hover:bg-primary-700 transition-smooth">
                            Dashboard Saya
                            <svg class="ml-2 -mr-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    <?php else: ?>
                        <a href="register.php" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-full shadow-sm text-white bg-primary-600 hover:bg-primary-700 transition-smooth">
                            Daftar Gratis
                            <svg class="ml-2 -mr-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- WPM Method Section -->
    <section class="py-16 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl font-bold mb-4">Metode Weighted Product</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Metode Weighted Product Model (WPM) adalah salah satu metode dalam pengambilan keputusan multikriteria yang menggunakan perkalian antar kriteria, di mana setiap nilai kriteria diberi bobot sesuai tingkat kepentingannya. Dalam WPM, setiap alternatif dihitung dengan cara mengalikan semua nilai kriteria yang telah dipangkatkan dengan bobotnya masing-masing. Metode ini efektif untuk membandingkan alternatif secara proporsional dan mempertimbangkan tingkat kepentingan setiap kriteria.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="bg-gray-50 p-6 rounded-lg" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-12 h-12 rounded-full bg-primary-600 text-white flex items-center justify-center mb-4 font-bold">
                        1
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Tentukan Bobot</h3>
                    <p class="text-gray-600">
                        Beri nilai penting untuk setiap kriteria (return, risiko, likuiditas) sesuai preferensi Anda.
                    </p>
                </div>
                
                <!-- Step 2 -->
                <div class="bg-gray-50 p-6 rounded-lg" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-12 h-12 rounded-full bg-primary-600 text-white flex items-center justify-center mb-4 font-bold">
                        2
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Pilih Instrumen</h3>
                    <p class="text-gray-600">
                        Pilih dari berbagai instrumen investasi yang ingin Anda bandingkan.
                    </p>
                </div>
                
                <!-- Step 3 -->
                <div class="bg-gray-50 p-6 rounded-lg" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-12 h-12 rounded-full bg-primary-600 text-white flex items-center justify-center mb-4 font-bold">
                        3
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Dapatkan Hasil</h3>
                    <p class="text-gray-600">
                        Sistem menghitung dan memberikan rekomendasi terbaik berdasarkan input Anda.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-3xl font-bold mb-4">Mengapa Memilih Cermatinvest?</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Solusi investasi berbasis data untuk membantu Anda membuat keputusan lebih baik.
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white p-8 rounded-xl shadow-sm card-hover" data-aos="fade-right" data-aos-delay="100">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-lg bg-primary-100 text-primary-600 flex items-center justify-center mr-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold mb-3">Analisis Komprehensif</h3>
                            <p class="text-gray-600">
                                Kami mempertimbangkan berbagai faktor penting dalam investasi untuk memberikan rekomendasi yang holistik.
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Feature 2 -->
                <div class="bg-white p-8 rounded-xl shadow-sm card-hover" data-aos="fade-left" data-aos-delay="100">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-lg bg-primary-100 text-primary-600 flex items-center justify-center mr-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold mb-3">Perbandingan Visual</h3>
                            <p class="text-gray-600">
                                Data disajikan dalam bentuk visual yang mudah dipahami untuk membantu Anda membandingkan dengan jelas.
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Feature 3 -->
                <div class="bg-white p-8 rounded-xl shadow-sm card-hover" data-aos="fade-right" data-aos-delay="200">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-lg bg-primary-100 text-primary-600 flex items-center justify-center mr-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold mb-3">Simulasi Investasi</h3>
                            <p class="text-gray-600">
                                Uji berbagai skenario investasi sebelum memutuskan untuk memilih yang paling sesuai.
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Feature 4 -->
                <div class="bg-white p-8 rounded-xl shadow-sm card-hover" data-aos="fade-left" data-aos-delay="200">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-lg bg-primary-100 text-primary-600 flex items-center justify-center mr-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold mb-3">Keamanan Data</h3>
                            <p class="text-gray-600">
                                Informasi dan data pribadi Anda terlindungi dengan standar keamanan tinggi.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20" data-aos="fade-up">
        <div class="bg-white mx-8 p-10 text-center rounded-[2rem] px-4 sm:px-6 lg:px-8 shadow-[0_0_10px_rgba(0,0,0,0.2)]">
            <h2 class="text-3xl font-bold text-black mb-6">Siap Memulai Investasi yang Lebih Cerdas?</h2>
            <p class="text-lg text-black mb-8 max-w-2xl mx-auto">
                Bergabunglah dengan komunitas investor yang menggunakan pendekatan berbasis data untuk pengambilan keputusan.
            </p>
            
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="dashboard.php" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-full shadow-sm text-white bg-blue-600 hover:bg-gray-600 hover:border-2 transition-smooth">
                    Buka Dashboard
                    <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            <?php else: ?>
                <a href="register.php" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-full shadow-sm text-white bg-blue-600 hover:bg-gray-600 hover:border-2 transition-smooth">
                    Daftar Sekarang - Gratis
                    <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            <?php endif; ?>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
    
    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS with more scroll-based animations
        AOS.init({
            duration: 600,
            easing: 'ease-in-out',
        });

        // Add scroll event listener for additional effects
        window.addEventListener('scroll', function() {
            const scrollPosition = window.scrollY;
            const elements = document.querySelectorAll('[data-aos]');
            
            elements.forEach(element => {
                const elementPosition = element.getBoundingClientRect().top + scrollPosition;
                const elementHeight = element.offsetHeight;
                
                // Calculate distance from viewport center
                const distanceFromViewportCenter = Math.abs((scrollPosition + window.innerHeight/2) - (elementPosition + elementHeight/2));
                
                // Adjust animation based on scroll position
                if (distanceFromViewportCenter < window.innerHeight) {
                    const progress = 1 - (distanceFromViewportCenter / window.innerHeight);
                    element.style.opacity = progress;
                    element.style.transform = `translateY(${(1 - progress) * 20}px)`;
                }
            });
        });
    </script>
</body>
</html>