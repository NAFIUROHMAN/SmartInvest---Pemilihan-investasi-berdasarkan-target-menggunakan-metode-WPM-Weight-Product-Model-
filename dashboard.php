<?php
require_once 'includes/auth_check.php';
require_once 'config/database.php'; // Make sure this file exists and connects to smartinvest DB
$title = 'Dashboard';
include 'includes/header.php';

// Get user's comparison history with pagination (limit to 5)
try {
    $stmt = $pdo->prepare("
        SELECT * FROM perbandingan 
        WHERE id_user = ?
        ORDER BY tanggal DESC
        LIMIT 5
    ");
    $stmt->execute([$user_id]);
    $history = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    $history = [];
}
?>

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?> | Cermatinvest</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>


    <script>
  tailwind.config = {
    theme: {
      extend: {
        fontFamily: {
          rubik: ['Rubik'],
        }
      }
    }
  }
</script>
</head>
<body class="font-rubik bg-gray-50">
    <div class="min-h-screen flex flex-col">
        <!-- Main Content -->
        <main class="flex-grow p-6 md:p-8">
            <div class="max-w-7xl mx-auto">
                <!-- Welcome Section -->
                <section class="mb-10">
                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-[2.5rem] p-8 shadow-lg">
                        <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">Halo, <?php echo htmlspecialchars($user['nama']); ?>!</h1>
                        <p class="text-blue-100 text-lg max-w-2xl">Selamat datang di dashboard CermatInvest. Mulai bandingkan investasi Anda sekarang menggunakan metode WPM (Weighted Product Model) .</p>
                    </div>
                </section>

                <!-- Quick Actions Grid -->
                <section class="mb-10">
                    <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-2 gap-10">
                        
                        <a href="cari_investasi.php" class="bg-white p-6 rounded-[2rem] shadow-sm hover:shadow-md transition duration-300 border border-gray-100 hover:border-blue-200 flex flex-col items-center text-center">
                            <div class="bg-purple-100 p-4 rounded-full mb-4 w-16 h-16 flex items-center justify-center">
                                <i class="fas fa-search text-purple-600 text-2xl"></i>
                            </div>
                            <h3 class="font-bold text-lg text-gray-800 mb-2">Cari Investasi</h3>
                            <p class="text-gray-600 text-sm">Temukan informasi berbagai jenis investasi</p>
                        </a>

                        <a href="input_kriteria.php" class="bg-white p-6 rounded-[2rem] shadow-sm hover:shadow-md transition duration-300 border border-gray-100 hover:border-blue-200 flex flex-col items-center text-center">
                            <div class="bg-blue-100 p-4 rounded-full mb-4 w-16 h-16 flex items-center justify-center">
                                <i class="fas fa-balance-scale text-blue-600 text-2xl"></i>
                            </div>
                            <h3 class="font-bold text-lg text-gray-800 mb-2">Bandingkan</h3>
                            <p class="text-gray-600 text-sm">Bandingkan dua investasi menggunakan metode WPM</p>
                        </a>
                    </div>
                </section>

                <!-- Recent Comparison Section -->
                <section>
                    <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl md:text-2xl font-bold text-gray-800">Histori Perbandingan Terakhir</h2>
                            <a href="histori.php?id_user=<?php echo $user_id; ?>" class="text-sm text-blue-600 hover:text-blue-800 font-medium flex items-center gap-1">
    Lihat Semua <i class="fas fa-chevron-right text-xs"></i>
</a>
                        </div>
                        
                        <?php if (count($history) > 0): ?>
                            <div class="overflow-x-auto rounded-xl border border-gray-100">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tl-xl">Investasi</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hasil</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tr-xl">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-100">
                                        <?php foreach ($history as $item): ?>
                                            <tr class="hover:bg-gray-50 transition duration-150">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center gap-3">
                                                        <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                            <i class="fas fa-chart-line text-blue-600"></i>
                                                        </div>
                                                        <div>
                                                            <div class="font-medium text-gray-900"><?php echo htmlspecialchars($item['nama_investasi_1']); ?></div>
                                                            <div class="text-sm text-gray-500">vs <?php echo htmlspecialchars($item['nama_investasi_2']); ?></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900 font-medium"><?php echo date('d M Y', strtotime($item['tanggal'])); ?></div>
                                                    <div class="text-xs text-gray-500"><?php echo date('H:i', strtotime($item['tanggal'])); ?></div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gradient-to-r from-green-100 to-green-50 text-green-800 border border-green-200">
                                                        <?php echo htmlspecialchars($item['winner']); ?> Menang
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                                    <a href="detail_hasil.php?id=<?php echo $item['id']; ?>" class="text-blue-600 hover:text-blue-900 font-medium text-sm inline-flex items-center gap-1">
                                                        Detail <i class="fas fa-external-link-alt text-xs"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-12 rounded-xl border-2 border-dashed border-gray-200">
                                <div class="mx-auto h-24 w-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-history text-3xl text-gray-400"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-1">Belum ada riwayat</h3>
                                <p class="text-gray-500 max-w-md mx-auto mb-4">Anda belum melakukan perbandingan investasi.</p>
                                <a href="input_kriteria.php" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-full shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">
                                    Mulai Perbandingan Pertama
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>
            </div>
        </main>

        <?php include 'includes/footer.php'; ?>
    </div>
</body>
</html>