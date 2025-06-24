<?php
require_once 'includes/auth_check.php';
require_once 'config/database.php';
include 'includes/header.php'; 

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Investasi Saham - Panduan Lengkap</title>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Rubik', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <div class="flex justify-between items-center mb-8">
            <a href="cari_investasi.php" class="flex items-center text-blue-600 hover:text-blue-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Kembali ke Daftar Investasi
            </a>
            <a href="dashboard.php" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-300">
                Kembali ke Dashboard
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
            <div class="p-6 sm:p-8">
                <div class="flex items-center mb-6">
                    <div class="bg-blue-100 p-3 rounded-lg mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-800">Investasi Saham</h1>
                </div>
                <p class="text-lg text-gray-600 mb-6">Saham merupakan bukti kepemilikan nilai sebuah perusahaan atau bukti penyertaan modal. Pemegang saham memiliki hak untuk mendapatkan dividen sesuai dengan jumlah saham yang dimilikinya.</p>
                
                <div class="flex flex-wrap gap-2 mb-8">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">Capital Gain</span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">Dividen</span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">High Risk</span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">Likuid</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Keuntungan Investasi Saham</h2>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-700">Potensi keuntungan tinggi dalam bentuk capital gain dan dividen</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-700">Likuiditas tinggi karena dapat diperjualbelikan kapan saja di pasar sekunder</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-700">Diversifikasi portofolio investasi</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-gray-700">Hak suara dalam RUPS (Rapat Umum Pemegang Saham)</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Risiko Investasi Saham</h2>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <svg class="h-5 w-5 text-red-500 mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            <span class="text-gray-700">Fluktuasi harga yang tinggi (volatilitas)</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="h-5 w-5 text-red-500 mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            <span class="text-gray-700">Risiko likuiditas jika saham tidak aktif diperdagangkan</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="h-5 w-5 text-red-500 mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            <span class="text-gray-700">Risiko perusahaan bangkrut (delisting)</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="h-5 w-5 text-red-500 mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            <span class="text-gray-700">Dividen tidak dijamin dan tergantung kinerja perusahaan</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Cara Memulai Investasi Saham</h2>
                <div class="space-y-6">
                    <div class="flex flex-col md:flex-row gap-6">
                        <div class="flex-shrink-0 bg-blue-100 rounded-lg p-4 w-16 h-16 flex items-center justify-center">
                            <span class="text-blue-600 font-bold text-xl">1</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Buka Rekening Saham</h3>
                            <p class="text-gray-600">Pilih sekuritas yang terdaftar di OJK dan buka rekening efek. Prosesnya meliputi pengisian formulir, verifikasi identitas, dan penandatanganan perjanjian.</p>
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row gap-6">
                        <div class="flex-shrink-0 bg-blue-100 rounded-lg p-4 w-16 h-16 flex items-center justify-center">
                            <span class="text-blue-600 font-bold text-xl">2</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Setor Dana Awal</h3>
                            <p class="text-gray-600">Transfer dana ke rekening dana nasabah (RDN) yang terhubung dengan rekening efek Anda. Minimal dana awal bervariasi tergantung kebijakan sekuritas.</p>
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row gap-6">
                        <div class="flex-shrink-0 bg-blue-100 rounded-lg p-4 w-16 h-16 flex items-center justify-center">
                            <span class="text-blue-600 font-bold text-xl">3</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Pelajari Analisis Saham</h3>
                            <p class="text-gray-600">Pelajari analisis fundamental (kinerja perusahaan) dan teknikal (pergerakan harga) untuk memilih saham yang tepat. Gunakan laporan keuangan dan berita terkini.</p>
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row gap-6">
                        <div class="flex-shrink-0 bg-blue-100 rounded-lg p-4 w-16 h-16 flex items-center justify-center">
                            <span class="text-blue-600 font-bold text-xl">4</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Lakukan Pembelian Saham</h3>
                            <p class="text-gray-600">Masukkan order beli melalui aplikasi trading atau platform online dari sekuritas Anda. Tentukan jumlah lot (1 lot = 100 lembar saham) dan harga yang diinginkan.</p>
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row gap-6">
                        <div class="flex-shrink-0 bg-blue-100 rounded-lg p-4 w-16 h-16 flex items-center justify-center">
                            <span class="text-blue-600 font-bold text-xl">5</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Monitor dan Kelola Portofolio</h3>
                            <p class="text-gray-600">Pantau perkembangan saham secara rutin, lakukan diversifikasi, dan sesuaikan strategi sesuai kondisi pasar dan tujuan investasi Anda.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Tips Investasi Saham untuk Pemula</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-blue-50 rounded-lg p-5">
                        <h3 class="text-lg font-semibold text-blue-800 mb-2">Mulai dengan Modal Kecil</h3>
                        <p class="text-gray-700">Tidak perlu langsung menginvestasikan dana besar. Mulailah dengan jumlah yang nyaman untuk Anda, sambil mempelajari karakteristik pasar saham.</p>
                    </div>
                    <div class="bg-green-50 rounded-lg p-5">
                        <h3 class="text-lg font-semibold text-green-800 mb-2">Diversifikasi Portofolio</h3>
                        <p class="text-gray-700">Jangan menaruh semua dana di satu saham. Sebarkan investasi ke berbagai sektor untuk mengurangi risiko.</p>
                    </div>
                    <div class="bg-yellow-50 rounded-lg p-5">
                        <h3 class="text-lg font-semibold text-yellow-800 mb-2">Investasi Jangka Panjang</h3>
                        <p class="text-gray-700">Saham cocok untuk investasi jangka menengah-panjang (minimal 3-5 tahun) untuk mengurangi dampak volatilitas jangka pendek.</p>
                    </div>
                    <div class="bg-purple-50 rounded-lg p-5">
                        <h3 class="text-lg font-semibold text-purple-800 mb-2">Gunakan Sistem Dollar Cost Averaging</h3>
                        <p class="text-gray-700">Investasi secara berkala dengan jumlah tetap untuk mendapatkan harga rata-rata yang baik dan mengurangi timing risk.</p>
                    </div>
                    <div class="bg-red-50 rounded-lg p-5">
                        <h3 class="text-lg font-semibold text-red-800 mb-2">Kendalikan Emosi</h3>
                        <p class="text-gray-700">Jangan panik saat harga turun atau terlalu euforia saat harga naik. Buat keputusan berdasarkan analisis, bukan emosi sesaat.</p>
                    </div>
                    <div class="bg-indigo-50 rounded-lg p-5">
                        <h3 class="text-lg font-semibold text-indigo-800 mb-2">Terus Belajar</h3>
                        <p class="text-gray-700">Ikuti perkembangan pasar, baca laporan keuangan perusahaan, dan tingkatkan terus pengetahuan Anda tentang investasi saham.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Faktor yang Mempengaruhi Harga Saham</h2>
                <div class="space-y-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">1. Faktor Fundamental Perusahaan</h3>
                        <p class="text-gray-600 ml-6">Kinerja keuangan (laba/rugi), prospek bisnis, manajemen, dividen, dan kebijakan perusahaan sangat mempengaruhi harga saham. Laporan keuangan triwulanan dan tahunan menjadi acuan penting.</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">2. Kondisi Industri dan Sektor</h3>
                        <p class="text-gray-600 ml-6">Perkembangan industri tempat perusahaan beroperasi. Misalnya, saham perbankan dipengaruhi suku bunga BI, saham komoditas dipengaruhi harga komoditas global.</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">3. Kondisi Makroekonomi</h3>
                        <p class="text-gray-600 ml-6">Pertumbuhan ekonomi, inflasi, suku bunga, nilai tukar, kebijakan fiskal dan moneter pemerintah berpengaruh terhadap pasar saham secara keseluruhan.</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">4. Faktor Politik dan Regulasi</h3>
                        <p class="text-gray-600 ml-6">Stabilitas politik, kebijakan pemerintah, perubahan regulasi, dan hubungan internasional dapat mempengaruhi iklim investasi dan sentimen pasar.</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">5. Sentimen Pasar</h3>
                        <p class="text-gray-600 ml-6">Psikologi investor, rumor, berita media, dan tren pasar seringkali menyebabkan fluktuasi harga jangka pendek yang tidak selalu berkorelasi dengan fundamental perusahaan.</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">6. Faktor Global</h3>
                        <p class="text-gray-600 ml-6">Perekonomian global, harga komoditas internasional, pasar saham luar negeri (terutama AS), dan geopolitik global mempengaruhi IHSG dan saham-saham tertentu.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'includes/footer.php';?>
</body>
</html>