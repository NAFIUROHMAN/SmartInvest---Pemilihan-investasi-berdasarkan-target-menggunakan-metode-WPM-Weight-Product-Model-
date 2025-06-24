<?php
require_once 'includes/auth_check.php';
$title = 'Bandingkan Investasi';
include 'includes/header.php';
?>

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?> | Cermatinvest</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex flex-col">
        
        <!-- Main Content -->
        <main class="flex-grow p-6 md:p-8">
            
            <div class="max-w-4xl mx-auto">
            <div class="mt-6 mb-4">
                <a href="dashboard.php" 
                class="inline-flex items-center bg-white text-blue-600 px-6 py-3 rounded-full font-medium hover:bg-blue-50 transition duration-300 border border-blue-100 shadow-sm">
                    <i class="fas fa-arrow-left mr-2"></i> 
                    <span>Kembali ke Dashboard</span>
                </a>
            </div>
                <!-- Header Section -->
                <section class="mb-10">
                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-[2rem] p-8 shadow-lg">
                        <h1 class="text-3xl font-bold text-white mb-2">Bandingkan Investasi</h1>
                        <p class="text-blue-100">Pilih tujuan investasi dan kriteria untuk membandingkan dua jenis investasi menggunakan metode WPM.</p>
                    </div>
                </section>

                <!-- Comparison Form -->
                <section>
                    <div class="bg-white p-6 md:p-8 rounded-[1.5rem] shadow-sm">
                        <form id="comparisonForm" method="POST" action="hasil.php">
                            <input type="hidden" name="action" value="calculate">
                            
                            <!-- Investment Purpose -->
                            <div class="mb-10">
                                <h2 class="text-xl font-bold text-gray-800 mb-6 pb-2 border-b border-gray-100">Tujuan Investasi</h2>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <input type="radio" name="investment_purpose" id="purpose_future" value="future" class="hidden peer" checked>
                                        <label for="purpose_future" class="flex flex-col items-center justify-center p-6 border-2 border-gray-200 rounded-[2rem] cursor-pointer bg-white hover:bg-blue-50 peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:ring-2 peer-checked:ring-blue-200 transition-all duration-200">
                                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mb-3">
                                                <i class="fas fa-piggy-bank text-blue-600 text-xl"></i>
                                            </div>
                                            <h3 class="font-bold text-gray-800 text-center">Kebutuhan Masa Depan</h3>
                                            <p class="text-sm text-gray-500 text-center mt-1">(Return: Benefit, Risiko: Cost, Likuiditas: Benefit)</p>
                                        </label>
                                    </div>
                                    
                                    <div>
                                        <input type="radio" name="investment_purpose" id="purpose_cold_money" value="cold_money" class="hidden peer">
                                        <label for="purpose_cold_money" class="flex flex-col items-center justify-center p-6 border-2 border-gray-200 rounded-[2rem] cursor-pointer bg-white hover:bg-blue-50 peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:ring-2 peer-checked:ring-blue-200 transition-all duration-200">
                                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mb-3">
                                                <i class="fas fa-snowflake text-blue-600 text-xl"></i>
                                            </div>
                                            <h3 class="font-bold text-gray-800 text-center">Investasi Uang Dingin</h3>
                                            <p class="text-sm text-gray-500 text-center mt-1">(Return: Benefit, Risiko: Benefit, Likuiditas: Cost)</p>
                                        </label>
                                    </div>
                                    
                                    <div>
                                        <input type="radio" name="investment_purpose" id="purpose_inflation" value="inflation" class="hidden peer">
                                        <label for="purpose_inflation" class="flex flex-col items-center justify-center p-6 border-2 border-gray-200 rounded-[2rem] cursor-pointer bg-white hover:bg-blue-50 peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:ring-2 peer-checked:ring-blue-200 transition-all duration-200">
                                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mb-3">
                                                <i class="fas fa-chart-line text-blue-600 text-xl"></i>
                                            </div>
                                            <h3 class="font-bold text-gray-800 text-center">Melawan Inflasi</h3>
                                            <p class="text-sm text-gray-500 text-center mt-1">(Return: Benefit, Risiko: Cost, Likuiditas: Benefit)</p>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Investment Names -->
                            <div class="mb-10">
                                <h2 class="text-xl font-bold text-gray-800 mb-6 pb-2 border-b border-gray-100">Nama Investasi</h2>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="investasi1" class="block text-gray-700 mb-2 font-medium">Investasi 1</label>
                                        <div class="relative">
                                            <input type="text" id="investasi1" name="investasi1" required 
                                                   class="w-full px-4 py-3 border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                                   placeholder="Contoh: Reksadana Pasar Uang">
                                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                <i class="fas fa-chart-line text-gray-400"></i>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <label for="investasi2" class="block text-gray-700 mb-2 font-medium">Investasi 2</label>
                                        <div class="relative">
                                            <input type="text" id="investasi2" name="investasi2" required 
                                                   class="w-full px-4 py-3 border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                                   placeholder="Contoh: Emas Fisik">
                                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                <i class="fas fa-chart-line text-gray-400"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Criteria Section -->
                            <div class="mb-10">
                                <h2 class="text-xl font-bold text-gray-800 mb-6 pb-2 border-b border-gray-100">Kriteria Investasi</h2>
                                
                                <div id="criteriaContainer" class="space-y-6">
                                    <!-- Return Criteria -->
                                    <div class="p-6 border border-gray-100 rounded-[2rem] bg-gray-50">
                                        <div class="flex justify-between items-center mb-4">
                                            <h3 class="font-bold text-gray-800 flex items-center">
                                                <i class="fas fa-arrow-up text-green-600 mr-2"></i>
                                                Return (Per Tahun)
                                            </h3>
                                            <span id="returnType" class="text-sm px-3 py-1 rounded-full bg-green-100 text-green-800">
                                                Benefit
                                            </span>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label class="block text-gray-700 mb-2">Bobot (0-1)</label>
                                            <input type="number" name="bobot[return]" 
                                                   value="0.40" min="0" max="1" step="0.01" required
                                                   class="w-full px-4 py-2 border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        </div>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div>
                                                <label class="block text-gray-700 mb-2">Investasi 1 - Return (%)</label>
                                                <div class="relative">
                                                    <input type="number" name="nilai[return][1]" 
                                                           min="0" max="100" step="0.01" required
                                                           class="w-full px-4 py-2 border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                           placeholder="Contoh: 5.25">
                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                        <span class="text-gray-500">%</span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div>
                                                <label class="block text-gray-700 mb-2">Investasi 2 - Return (%)</label>
                                                <div class="relative">
                                                    <input type="number" name="nilai[return][2]" 
                                                           min="0" max="100" step="0.01" required
                                                           class="w-full px-4 py-2 border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                           placeholder="Contoh: 7.50">
                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                        <span class="text-gray-500">%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Risk Criteria -->
                                    <div class="p-6 border border-gray-100 rounded-[2rem] bg-gray-50">
                                        <div class="flex justify-between items-center mb-4">
                                            <h3 class="font-bold text-gray-800 flex items-center">
                                                <i class="fas fa-exclamation-triangle text-red-600 mr-2"></i>
                                                Risiko (% Potensi Kerugian)
                                            </h3>
                                            <span id="riskType" class="text-sm px-3 py-1 rounded-full bg-red-100 text-red-800">
                                                Cost
                                            </span>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label class="block text-gray-700 mb-2">Bobot (0-1)</label>
                                            <input type="number" name="bobot[risk]" 
                                                   value="0.35" min="0" max="1" step="0.01" required
                                                   class="w-full px-4 py-2 border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        </div>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div>
                                                <label class="block text-gray-700 mb-2">Investasi 1 - Risiko (%)</label>
                                                <div class="relative">
                                                    <input type="number" name="nilai[risk][1]" 
                                                           min="0" max="100" step="0.1" required
                                                           class="w-full px-4 py-2 border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                           placeholder="Contoh: 10.5">
                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                        <span class="text-gray-500">%</span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div>
                                                <label class="block text-gray-700 mb-2">Investasi 2 - Risiko (%)</label>
                                                <div class="relative">
                                                    <input type="number" name="nilai[risk][2]" 
                                                           min="0" max="100" step="0.1" required
                                                           class="w-full px-4 py-2 border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                           placeholder="Contoh: 15.0">
                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                        <span class="text-gray-500">%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Liquidity Criteria -->
                                    <div class="p-6 border border-gray-100 rounded-[2rem] bg-gray-50">
                                        <div class="flex justify-between items-center mb-4">
                                            <h3 class="font-bold text-gray-800 flex items-center">
                                                <i class="fas fa-exchange-alt text-blue-600 mr-2"></i>
                                                Likuiditas (Skor 1-5)
                                            </h3>
                                            <span id="liquidityType" class="text-sm px-3 py-1 rounded-full bg-green-100 text-green-800">
                                                Benefit
                                            </span>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label class="block text-gray-700 mb-2">Bobot (0-1)</label>
                                            <input type="number" name="bobot[liquidity]" 
                                                   value="0.25" min="0" max="1" step="0.01" required
                                                   class="w-full px-4 py-2 border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        </div>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div>
                                                <label class="block text-gray-700 mb-2">Investasi 1 - Likuiditas (1-5)</label>
                                                <select name="nilai[liquidity][1]" 
                                                        class="w-full px-4 py-2 border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                    <option value="1">1 - Sangat Rendah </option>
                                                    <option value="2">2 - Rendah</option>
                                                    <option value="3">3 - Sedang </option>
                                                    <option value="4">4 - Tinggi </option>
                                                    <option value="5">5 - Sangat Tinggi </option>
                                                </select>
                                            </div>
                                            
                                            <div>
                                                <label class="block text-gray-700 mb-2">Investasi 2 - Likuiditas (1-5)</label>
                                                <select name="nilai[liquidity][2]" 
                                                        class="w-full px-4 py-2 border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                    <option value="1">1 - Sangat Rendah</option>
                                                    <option value="2">2 - Rendah</option>
                                                    <option value="3">3 - Sedang </option>
                                                    <option value="4">4 - Tinggi </option>
                                                    <option value="5">5 - Sangat Tinggi </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Form Actions -->
                            <div class="flex flex-col sm:flex-row justify-end gap-4 mt-8 pt-6 border-t border-gray-100">
                                <button type="reset" class="flex-1 sm:flex-none bg-gray-200 text-gray-700 py-3 px-6 rounded-full hover:bg-gray-300 transition duration-300 font-medium">
                                    <i class="fas fa-redo mr-2"></i>Reset Form
                                </button>
                                <button type="submit" class="flex-1 sm:flex-none bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3 px-6 rounded-full hover:from-blue-700 hover:to-indigo-700 transition duration-300 font-medium shadow-md">
                                    </i>Hitung Perbandingan</a>
                               
                                </button>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </main>

        <?php include 'includes/footer.php'; ?>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Update criteria types based on investment purpose
        function updateCriteriaTypes() {
            const purpose = document.querySelector('input[name="investment_purpose"]:checked').value;
            
            const returnType = document.getElementById('returnType');
            const riskType = document.getElementById('riskType');
            const liquidityType = document.getElementById('liquidityType');
            
            // Default is "future needs" (return: benefit, risk: cost, liquidity: benefit)
            let returnClass = 'bg-green-100 text-green-800';
            let riskClass = 'bg-red-100 text-red-800';
            let liquidityClass = 'bg-green-100 text-green-800';
            let riskText = 'Cost';
            let liquidityText = 'Benefit';
            
            if (purpose === 'cold_money') {
                // For cold money: risk becomes benefit, liquidity becomes cost
                riskClass = 'bg-green-100 text-green-800';
                riskText = 'Benefit';
                liquidityClass = 'bg-red-100 text-red-800';
                liquidityText = 'Cost';
            } else if (purpose === 'inflation') {
                // For inflation: same as future needs
                // (no changes needed)
            }
            
            // Update risk criteria
            riskType.className = `text-sm px-3 py-1 rounded-full ${riskClass}`;
            riskType.textContent = riskText;
            
            // Update liquidity criteria
            liquidityType.className = `text-sm px-3 py-1 rounded-full ${liquidityClass}`;
            liquidityType.textContent = liquidityText;
        }
        
        // Listen for changes in investment purpose
        document.querySelectorAll('input[name="investment_purpose"]').forEach(radio => {
            radio.addEventListener('change', updateCriteriaTypes);
        });
        
        // Validate form before submission
        document.getElementById('comparisonForm').addEventListener('submit', function(e) {
            // Check if total weight is 1
            let totalWeight = 0;
            document.querySelectorAll('input[name^="bobot["]').forEach(input => {
                totalWeight += parseFloat(input.value) || 0;
            });
            
            if (Math.abs(totalWeight - 1) > 0.01) { // Allow for floating point imprecision
                e.preventDefault();
                alert('Total bobot semua kriteria harus sama dengan 1 (100%). Saat ini total bobot: ' + totalWeight.toFixed(2));
                return false;
            }
            
            // Validate liquidity scores
            const liquidity1 = parseInt(document.querySelector('select[name="nilai[liquidity][1]"]').value);
            const liquidity2 = parseInt(document.querySelector('select[name="nilai[liquidity][2]"]').value);
            
            if (liquidity1 < 1 || liquidity1 > 5 || liquidity2 < 1 || liquidity2 > 5) {
                e.preventDefault();
                alert('Nilai likuiditas harus antara 1 sampai 5');
                return false;
            }
            
            return true;
        });
    });
    </script>
</body>
</html>