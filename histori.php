<?php
// Aktifkan error reporting untuk debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'includes/auth_check.php';
require_once 'config/database.php';
$title = 'Riwayat Perbandingan';
include 'includes/header.php';

// Pastikan user_id tersedia - HAPUS session_start() karena sudah ada di auth_check.php
if (!isset($_SESSION['user_id'])) {
    die("User tidak terautentikasi");
}
$user_id = $_SESSION['user_id'];

// Pagination setup
$perPage = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1);
$offset = ($page - 1) * $perPage;

try {
    // Get total count
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM perbandingan WHERE id_user = ?");
    $stmt->execute([$user_id]);
    $total = $stmt->fetchColumn();
    $totalPages = ceil($total / $perPage);

    // Get history data - PERBAIKI query dengan parameter yang konsisten
    $stmt = $pdo->prepare("
        SELECT 
            id,
            nama_investasi_1,
            nama_investasi_2,
            winner,
            tanggal
        FROM perbandingan 
        WHERE id_user = :user_id
        ORDER BY tanggal DESC
        LIMIT :limit OFFSET :offset
    ");
    
    // Bind parameter dengan nama yang konsisten
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    
    $history = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    echo "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4'>";
    echo "Database Error: " . $e->getMessage();
    echo "</div>";
    $history = [];
    $total = 0;
    $totalPages = 0;
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
                <!-- Header Section -->
                <div class="m4-8">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">Riwayat Perbandingan</h1>
                    <p class="text-gray-600">Semua perbandingan investasi yang pernah Anda lakukan</p>
                </div>

                
            <div class="mt-4 mb-4">
                <a href="dashboard.php" 
                class="inline-flex items-center bg-white text-blue-600 px-6 py-3 rounded-full font-medium hover:bg-blue-50 transition duration-300 border border-blue-100 shadow-sm">
                    <i class="fas fa-arrow-left mr-2"></i> 
                    <span>Kembali ke Dashboard</span>
                </a>
            </div>

                <!-- History Table -->
                <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm">
                    <?php if (!empty($history)): ?>
                        <div class="overflow-x-auto rounded-xl border border-gray-100 mb-6">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tl-xl">Investasi</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tr-xl">Hasil</th>
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

                        <!-- Pagination -->
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-500">
                                Menampilkan <?php echo ($offset + 1); ?>-<?php echo min($offset + $perPage, $total); ?> dari <?php echo $total; ?> hasil
                            </div>
                            <div class="flex space-x-2">
                                <?php if ($page > 1): ?>
                                    <a href="?page=<?php echo $page - 1; ?>" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                                        Sebelumnya
                                    </a>
                                <?php endif; ?>
                                
                                <?php if ($page < $totalPages): ?>
                                    <a href="?page=<?php echo $page + 1; ?>" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                                        Selanjutnya
                                    </a>
                                <?php endif; ?>
                            </div>
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
            </div>
        </main>

        <?php include 'includes/footer.php'; ?>
    </div>
</body>
</html>