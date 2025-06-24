<?php
require_once 'includes/auth_check.php';
require_once 'config/database.php';
$title = 'Hasil Perbandingan Investasi';
include 'includes/header.php';

$saveSuccess = false;
$savedId = null; 

// Aktifkan error reporting untuk debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Fungsi untuk memvalidasi dan membersihkan input
function sanitizeInput($data) {
    if (is_array($data)) {
        return array_map('sanitizeInput', $data);
    }
    return htmlspecialchars(strip_tags(trim($data)));
}

// Fungsi untuk menyimpan perbandingan ke database dengan transaction
function saveComparisonToDatabase($pdo, $userId, $investasi1, $investasi2, $winner, $purpose, $percentage1, $percentage2) {
    try {
        $pdo->beginTransaction();
        
        // Simpan data utama perbandingan
        $stmt = $pdo->prepare("INSERT INTO perbandingan 
                             (id_user, nama_investasi_1, nama_investasi_2, winner, 
                              persentase_1, persentase_2, tujuan_investasi, tanggal) 
                             VALUES (:user_id, :investasi1, :investasi2, :winner, 
                                     :percentage1, :percentage2, :purpose, NOW())");
        
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':investasi1', $investasi1, PDO::PARAM_STR);
        $stmt->bindParam(':investasi2', $investasi2, PDO::PARAM_STR);
        $stmt->bindParam(':winner', $winner, PDO::PARAM_STR);
        $stmt->bindParam(':percentage1', $percentage1, PDO::PARAM_STR);
        $stmt->bindParam(':percentage2', $percentage2, PDO::PARAM_STR);
        $stmt->bindParam(':purpose', $purpose, PDO::PARAM_STR);
        
        $stmt->execute();
        $comparisonId = $pdo->lastInsertId();
        
        // Simpan detail kriteria untuk audit trail
        $stmtDetails = $pdo->prepare("INSERT INTO perbandingan_detail 
                                     (id_perbandingan, kriteria, bobot, 
                                      nilai_investasi1, nilai_investasi2, tipe_kriteria)
                                     VALUES (:comparison_id, :criteria, :weight, 
                                             :value1, :value2, :type)");
        
        // Data kriteria yang akan disimpan
        $criteriaData = [
            'return' => [
                'weight' => $_POST['bobot']['return'],
                'value1' => $_POST['nilai']['return'][1],
                'value2' => $_POST['nilai']['return'][2],
                'type' => 'benefit'
            ],
            'risk' => [
                'weight' => $_POST['bobot']['risk'],
                'value1' => $_POST['nilai']['risk'][1],
                'value2' => $_POST['nilai']['risk'][2],
                'type' => ($_POST['investment_purpose'] == 'cold_money') ? 'benefit' : 'cost'
            ],
            'liquidity' => [
                'weight' => $_POST['bobot']['liquidity'],
                'value1' => $_POST['nilai']['liquidity'][1],
                'value2' => $_POST['nilai']['liquidity'][2],
                'type' => ($_POST['investment_purpose'] == 'cold_money') ? 'cost' : 'benefit'
            ]
        ];
        
        foreach ($criteriaData as $criteria => $data) {
            $stmtDetails->execute([
                ':comparison_id' => $comparisonId,
                ':criteria' => $criteria,
                ':weight' => $data['weight'],
                ':value1' => $data['value1'],
                ':value2' => $data['value2'],
                ':type' => $data['type']
            ]);
        }
        
        $pdo->commit();
        return $comparisonId;
    } catch(PDOException $e) {
        $pdo->rollBack();
        error_log("Database exception: " . $e->getMessage());
        return false;
    }
}

// Proses data dari POST atau dari session jika ada redirect
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_GET['success'])) {
    // Sanitize semua input
    $_POST = sanitizeInput($_POST);
    
    // Simpan data penting di session untuk recovery jika diperlukan
    $_SESSION['comparison_data'] = [
        'post_data' => $_POST,
        'timestamp' => time()
    ];
    
    // Validasi data yang diperlukan
    $requiredFields = [
        'investment_purpose', 
        'investasi1', 
        'investasi2',
        'bobot' => ['return', 'risk', 'liquidity'],
        'nilai' => [
            'return' => [1, 2],
            'risk' => [1, 2],
            'liquidity' => [1, 2]
        ]
    ];
    
    $isValid = true;
    foreach ($requiredFields as $key => $value) {
        if (is_array($value)) {
            foreach ($value as $subKey => $subValue) {
                if (is_array($subValue)) {
                    foreach ($subValue as $index) {
                        if (!isset($_POST[$key][$subKey][$index])) {
                            $isValid = false;
                            break 3;
                        }
                    }
                } else {
                    if (!isset($_POST[$key][$subValue])) {
                        $isValid = false;
                        break 2;
                    }
                }
            }
        } else {
            if (!isset($_POST[$value])) {
                $isValid = false;
                break;
            }
        }
    }
    
    if (!$isValid) {
        die("Data input tidak lengkap. Silakan kembali ke halaman sebelumnya.");
    }
    
    // Ekstrak data dari POST
    $purpose = $_POST['investment_purpose'];
    $investasi1 = $_POST['investasi1'];
    $investasi2 = $_POST['investasi2'];
    
    $weights = [
        'return' => (float)$_POST['bobot']['return'],
        'risk' => (float)$_POST['bobot']['risk'],
        'liquidity' => (float)$_POST['bobot']['liquidity']
    ];
    
    $values = [
        'investasi1' => [
            'return' => (float)$_POST['nilai']['return'][1],
            'risk' => (float)$_POST['nilai']['risk'][1],
            'liquidity' => (int)$_POST['nilai']['liquidity'][1]
        ],
        'investasi2' => [
            'return' => (float)$_POST['nilai']['return'][2],
            'risk' => (float)$_POST['nilai']['risk'][2],
            'liquidity' => (int)$_POST['nilai']['liquidity'][2]
        ]
    ];
    
    // Hitung hasil perbandingan
    $criteriaTypes = [
        'future' => [
            'return' => 'benefit',
            'risk' => 'cost',
            'liquidity' => 'benefit'
        ],
        'cold_money' => [
            'return' => 'benefit',
            'risk' => 'benefit',
            'liquidity' => 'cost'
        ],
        'inflation' => [
            'return' => 'benefit',
            'risk' => 'cost',
            'liquidity' => 'benefit'
        ]
    ];
    
    $criteriaTypes = $criteriaTypes[$purpose] ?? $criteriaTypes['future'];
    
    function normalizeValue($value, $type) {
        if ($type === 'cost') {
            return 1 / max($value, 0.0001);
        }
        return $value;
    }
    
    $wpm1 = 1;
    $wpm2 = 1;
    
    foreach ($weights as $criterion => $weight) {
        $type = $criteriaTypes[$criterion];
        $norm1 = normalizeValue($values['investasi1'][$criterion], $type);
        $norm2 = normalizeValue($values['investasi2'][$criterion], $type);
        $wpm1 *= pow($norm1, $weight);
        $wpm2 *= pow($norm2, $weight);
    }
    
    $total = $wpm1 + $wpm2;
    $percentage1 = ($total < 0.0000001) ? 50 : ($wpm1 / $total) * 100;
    $percentage2 = ($total < 0.0000001) ? 50 : ($wpm2 / $total) * 100;
    
    $winner = $percentage1 > $percentage2 ? $investasi1 : $investasi2;
    
    // Simpan hasil di session untuk digunakan setelah redirect
    $_SESSION['comparison_result'] = [
        'purpose' => $purpose,
        'investasi1' => $investasi1,
        'investasi2' => $investasi2,
        'winner' => $winner,
        'percentage1' => $percentage1,
        'percentage2' => $percentage2,
        'values' => $values,
        'weights' => $weights,
        'criteria_types' => $criteriaTypes
    ];
    
    // Jika ada request untuk menyimpan, proses penyimpanan
    if (isset($_POST['save_comparison'])) {
        $userId = $_SESSION['user_id'];
        $insertId = saveComparisonToDatabase(
            $pdo, 
            $userId, 
            $investasi1, 
            $investasi2, 
            $winner,
            $purpose,
            $percentage1,
            $percentage2
        );
        
        if ($insertId) {
            $saveSuccess = true; // Tambahkan variabel flag
            $savedId = $insertId; // Simpan ID langsung di variabel
        }
    }
} elseif (isset($_SESSION['comparison_result'])) {
    // Gunakan data dari session jika ada redirect
    $result = $_SESSION['comparison_result'];
    $purpose = $result['purpose'];
    $investasi1 = $result['investasi1'];
    $investasi2 = $result['investasi2'];
    $winner = $result['winner'];
    $percentage1 = $result['percentage1'];
    $percentage2 = $result['percentage2'];
    $values = $result['values'];
    $weights = $result['weights'];
    $criteriaTypes = $result['criteria_types'];
    
    // Hitung ulang WPM untuk memastikan konsistensi
    $wpm1 = 1;
    $wpm2 = 1;
    
    foreach ($weights as $criterion => $weight) {
        $type = $criteriaTypes[$criterion];
        $norm1 = normalizeValue($values['investasi1'][$criterion], $type);
        $norm2 = normalizeValue($values['investasi2'][$criterion], $type);
        $wpm1 *= pow($norm1, $weight);
        $wpm2 *= pow($norm2, $weight);
    }
} else {
    // Default values jika tidak ada data
    $purpose = 'future';
    $investasi1 = 'Investasi 1';
    $investasi2 = 'Investasi 2';
    $winner = $investasi1;
    $percentage1 = 50;
    $percentage2 = 50;
    $values = [
        'investasi1' => ['return' => 0, 'risk' => 0, 'liquidity' => 0],
        'investasi2' => ['return' => 0, 'risk' => 0, 'liquidity' => 0]
    ];
    $weights = ['return' => 0.4, 'risk' => 0.3, 'liquidity' => 0.3];
    $criteriaTypes = ['return' => 'benefit', 'risk' => 'cost', 'liquidity' => 'benefit'];
}

$purposeDescriptions = [
    'future' => 'Kebutuhan Masa Depan',
    'cold_money' => 'Investasi Uang Dingin',
    'inflation' => 'Melawan Inflasi'
];

$purposeText = $purposeDescriptions[$purpose] ?? 'Kebutuhan Masa Depan';
?>

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?> | Cermatinvest</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .gradient-card {
            background: linear-gradient(135deg, #f6f7f9 0%, #e9ecf1 100%);
            border-radius: 1.25rem;
            box-shadow: 0 10px 20px -5px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        .gradient-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 25px -5px rgba(0,0,0,0.1);
        }
        .winner-badge {
            background: linear-gradient(135deg, #fcec70 0%, #f7b42c 100%);
            box-shadow: 0 4px 15px rgba(247, 180, 44, 0.3);
        }
        .criteria-badge-benefit {
            background: linear-gradient(135deg, #a1ffce 0%, #12d8fa 100%);
        }
        .criteria-badge-cost {
            background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);
        }
        .progress-bar {
            height: 8px;
            border-radius: 4px;
            background: #e0e6ed;
        }
        .progress-fill {
            height: 100%;
            border-radius: 4px;
            background: linear-gradient(90deg, #3b82f6 0%, #6366f1 100%);
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    <div class="min-h-screen flex flex-col">
        <!-- Main Content -->
        <main class="flex-grow p-4 md:p-8">
            <div class="max-w-6xl mx-auto">

                <!-- Header Section -->
                <section class="mb-8">
                    <div class="bg-gradient-to-r from-indigo-600 to-blue-500 rounded-2xl p-8 shadow-xl text-white">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                            <div>
                                <h1 class="text-3xl font-bold mb-2">Hasil Analisis Investasi</h1>
                                <p class="text-blue-100 opacity-90">Tujuan Investasi: <?php echo $purposeText; ?></p>
                            </div>
                            <button id="downloadBtn" class="mt-4 md:mt-0 bg-white text-indigo-600 hover:bg-gray-100 px-6 py-2 rounded-full font-medium transition-all duration-300 shadow-md flex items-center">
                                <i class="fas fa-download mr-2"></i> Download PDF
                            </button>
                        </div>
                    </div>
                </section>

                <!-- Pesan Status -->
                <?php if ($saveSuccess): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                        <i class="fas fa-check-circle mr-2"></i>
                        Selamat, datamu sudah tersimpan!
                    </div>
                <?php endif; ?>

                <!-- Result Section -->
                <section id="resultContent">
                    <!-- Winner Announcement -->
                    <div class="mb-10 text-center bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                        <div class="winner-badge inline-flex items-center py-2 px-6 rounded-full text-yellow-800 font-medium mb-6">
                            <i class="fas fa-trophy mr-2"></i>Rekomendasi Terbaik
                        </div>
                        <h2 class="text-3xl font-bold text-gray-800 mb-3"><?php echo $winner; ?></h2>
                        <div class="max-w-md mx-auto">
                            <div class="progress-bar mt-4 mb-2">
                                <div class="progress-fill" style="width: <?php echo max($percentage1, $percentage2); ?>%"></div>
                            </div>
                            <p class="text-gray-600">Skor preferensi <span class="font-bold text-indigo-600 text-xl"><?php echo round(max($percentage1, $percentage2), 2); ?>%</span></p>
                        </div>
                    </div>
                    
                    <!-- Comparison Results -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
                        <!-- Investment 1 -->
                        <div class="gradient-card p-6 relative <?php echo $winner === $investasi1 ? 'ring-2 ring-yellow-400' : ''; ?>">
                            <h3 class="font-bold text-gray-800 text-xl mb-4 flex items-center">
                                <?php if ($winner === $investasi1): ?>
                                    <span class="winner-badge text-xs py-1 px-2 rounded mr-2">WINNER</span>
                                <?php endif; ?>
                                <?php echo $investasi1; ?>
                            </h3>
                            <div class="space-y-4">
                                <div class="grid grid-cols-3 gap-4">
                                    <div class="bg-white p-3 rounded-lg shadow-xs text-center">
                                        <p class="text-sm text-gray-500">Return</p>
                                        <p class="font-bold text-blue-600"><?php echo $values['investasi1']['return']; ?>%</p>
                                    </div>
                                    <div class="bg-white p-3 rounded-lg shadow-xs text-center">
                                        <p class="text-sm text-gray-500">Risiko</p>
                                        <p class="font-bold <?php echo $values['investasi1']['risk'] < 50 ? 'text-green-600' : 'text-red-600'; ?>"><?php echo $values['investasi1']['risk']; ?>%</p>
                                    </div>
                                    <div class="bg-white p-3 rounded-lg shadow-xs text-center">
                                        <p class="text-sm text-gray-500">Likuiditas</p>
                                        <p class="font-bold text-purple-600"><?php echo $values['investasi1']['liquidity']; ?></p>
                                    </div>
                                </div>
                                <div class="pt-4 border-t border-gray-200 mt-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-gray-600 font-medium">Skor WPM:</span>
                                        <span class="font-bold text-gray-800"><?php echo round($wpm1, 4); ?></span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600 font-medium">Persentase:</span>
                                        <span class="font-bold text-indigo-600 text-lg"><?php echo round($percentage1, 2); ?>%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Investment 2 -->
                        <div class="gradient-card p-6 relative <?php echo $winner === $investasi2 ? 'ring-2 ring-yellow-400' : ''; ?>">
                            <h3 class="font-bold text-gray-800 text-xl mb-4 flex items-center">
                                <?php if ($winner === $investasi2): ?>
                                    <span class="winner-badge text-xs py-1 px-2 rounded mr-2">WINNER</span>
                                <?php endif; ?>
                                <?php echo $investasi2; ?>
                            </h3>
                            <div class="space-y-4">
                                <div class="grid grid-cols-3 gap-4">
                                    <div class="bg-white p-3 rounded-lg shadow-xs text-center">
                                        <p class="text-sm text-gray-500">Return</p>
                                        <p class="font-bold text-blue-600"><?php echo $values['investasi2']['return']; ?>%</p>
                                    </div>
                                    <div class="bg-white p-3 rounded-lg shadow-xs text-center">
                                        <p class="text-sm text-gray-500">Risiko</p>
                                        <p class="font-bold <?php echo $values['investasi2']['risk'] < 50 ? 'text-green-600' : 'text-red-600'; ?>"><?php echo $values['investasi2']['risk']; ?>%</p>
                                    </div>
                                    <div class="bg-white p-3 rounded-lg shadow-xs text-center">
                                        <p class="text-sm text-gray-500">Likuiditas</p>
                                        <p class="font-bold text-purple-600"><?php echo $values['investasi2']['liquidity']; ?></p>
                                    </div>
                                </div>
                                <div class="pt-4 border-t border-gray-200 mt-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-gray-600 font-medium">Skor WPM:</span>
                                        <span class="font-bold text-gray-800"><?php echo round($wpm2, 4); ?></span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600 font-medium">Persentase:</span>
                                        <span class="font-bold text-indigo-600 text-lg"><?php echo round($percentage2, 2); ?>%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Criteria Types -->
                    <div class="mb-8 bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-800 text-xl mb-5">Kriteria Analisis</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-gray-50 p-4 rounded-xl">
                                <div class="flex items-center mb-3">
                                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                        <i class="fas fa-chart-line text-blue-600"></i>
                                    </div>
                                    <h4 class="font-semibold text-gray-800">Return</h4>
                                </div>
                                <span class="text-xs px-3 py-1 rounded-full criteria-badge-benefit text-gray-800">Benefit</span>
                                <p class="text-sm text-gray-600 mt-2">Nilai return yang lebih tinggi lebih baik</p>
                            </div>
                            
                            <div class="bg-gray-50 p-4 rounded-xl">
                                <div class="flex items-center mb-3">
                                    <div class="w-10 h-10 rounded-full <?php echo $criteriaTypes['risk'] === 'benefit' ? 'bg-green-100' : 'bg-red-100'; ?> flex items-center justify-center mr-3">
                                        <i class="<?php echo $criteriaTypes['risk'] === 'benefit' ? 'fas fa-shield-alt text-green-600' : 'fas fa-exclamation-triangle text-red-600'; ?>"></i>
                                    </div>
                                    <h4 class="font-semibold text-gray-800">Risiko</h4>
                                </div>
                                <span class="text-xs px-3 py-1 rounded-full <?php echo $criteriaTypes['risk'] === 'benefit' ? 'criteria-badge-benefit' : 'criteria-badge-cost'; ?> text-gray-800">
                                    <?php echo ucfirst($criteriaTypes['risk']); ?>
                                </span>
                                <p class="text-sm text-gray-600 mt-2">
                                    <?php echo $criteriaTypes['risk'] === 'benefit' ? 'Risiko rendah lebih baik' : 'Risiko tinggi kurang baik'; ?>
                                </p>
                            </div>
                            
                            <div class="bg-gray-50 p-4 rounded-xl">
                                <div class="flex items-center mb-3">
                                    <div class="w-10 h-10 rounded-full <?php echo $criteriaTypes['liquidity'] === 'benefit' ? 'bg-green-100' : 'bg-red-100'; ?> flex items-center justify-center mr-3">
                                        <i class="<?php echo $criteriaTypes['liquidity'] === 'benefit' ? 'fas fa-coins text-green-600' : 'fas fa-lock text-red-600'; ?>"></i>
                                    </div>
                                    <h4 class="font-semibold text-gray-800">Likuiditas</h4>
                                </div>
                                <span class="text-xs px-3 py-1 rounded-full <?php echo $criteriaTypes['liquidity'] === 'benefit' ? 'criteria-badge-benefit' : 'criteria-badge-cost'; ?> text-gray-800">
                                    <?php echo ucfirst($criteriaTypes['liquidity']); ?>
                                </span>
                                <p class="text-sm text-gray-600 mt-2">
                                    <?php echo $criteriaTypes['liquidity'] === 'benefit' ? 'Likuiditas tinggi lebih baik' : 'Likuiditas rendah lebih baik'; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </section>
                
                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row justify-center gap-4 pt-6">
                    <!-- Bandingkan Lagi Button -->
                    <a href="input_kriteria.php" class="flex-1 sm:flex-none bg-gray-200 hover:bg-gray-300 text-gray-800 py-3 px-6 rounded-full transition duration-300 font-medium text-center flex items-center justify-center">
                        <i class="fas fa-redo mr-2"></i> Bandingkan Lagi
                    </a>
                    
                    <!-- Simpan Data Button -->
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                        <input type="hidden" name="save_comparison" value="1">
                        <input type="hidden" name="investment_purpose" value="<?php echo htmlspecialchars($purpose); ?>">
                        <input type="hidden" name="investasi1" value="<?php echo htmlspecialchars($investasi1); ?>">
                        <input type="hidden" name="investasi2" value="<?php echo htmlspecialchars($investasi2); ?>">
                        <input type="hidden" name="bobot[return]" value="<?php echo htmlspecialchars($weights['return']); ?>">
                        <input type="hidden" name="bobot[risk]" value="<?php echo htmlspecialchars($weights['risk']); ?>">
                        <input type="hidden" name="bobot[liquidity]" value="<?php echo htmlspecialchars($weights['liquidity']); ?>">
                        <input type="hidden" name="nilai[return][1]" value="<?php echo htmlspecialchars($values['investasi1']['return']); ?>">
                        <input type="hidden" name="nilai[return][2]" value="<?php echo htmlspecialchars($values['investasi2']['return']); ?>">
                        <input type="hidden" name="nilai[risk][1]" value="<?php echo htmlspecialchars($values['investasi1']['risk']); ?>">
                        <input type="hidden" name="nilai[risk][2]" value="<?php echo htmlspecialchars($values['investasi2']['risk']); ?>">
                        <input type="hidden" name="nilai[liquidity][1]" value="<?php echo htmlspecialchars($values['investasi1']['liquidity']); ?>">
                        <input type="hidden" name="nilai[liquidity][2]" value="<?php echo htmlspecialchars($values['investasi2']['liquidity']); ?>">
                        
                        <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white py-3 px-6 rounded-full hover:from-blue-600 hover:to-blue-700 transition duration-300 shadow-md flex items-center justify-center">
                            <i class="fas fa-save mr-2"></i>Simpan Perbandingan
                        </button>
                    </form>
                    
                    <!-- Kembali ke Dashboard Button -->
                    <a href="dashboard.php" class="flex-1 sm:flex-none bg-gray-800 hover:bg-gray-900 text-white py-3 px-6 rounded-full transition duration-300 font-medium text-center flex items-center justify-center">
                        <i class="fas fa-home mr-2"></i> Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </main>

        <?php include 'includes/footer.php'; ?>
    </div>

    <script>
        document.getElementById('downloadBtn').addEventListener('click', function() {
            const element = document.getElementById('resultContent');
            const opt = {
                margin: 10,
                filename: 'Hasil_Analisis_Investasi_<?php echo $winner; ?>.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };
            
            // Show loading indicator
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Membuat PDF...';
            
            // Generate PDF
            html2pdf().from(element).set(opt).save().then(() => {
                this.innerHTML = originalText;
            });
        });
    </script>
</body>
</html>