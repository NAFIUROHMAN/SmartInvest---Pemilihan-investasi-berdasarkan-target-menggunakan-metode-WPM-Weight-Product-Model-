<?php
require_once 'config/database.php';

if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    if (empty($nama) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = 'Semua field harus diisi!';
    } elseif ($password !== $confirm_password) {
        $error = 'Password dan konfirmasi password tidak cocok!';
    } else {
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT id_user FROM user WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->fetch()) {
            $error = 'Email sudah terdaftar!';
        } else {
            // Insert new user
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO user (nama, email, password) VALUES (?, ?, ?)");
            
            if ($stmt->execute([$nama, $email, $hashed_password])) {
                $success = 'Pendaftaran berhasil! Silakan login.';
                header('Refresh: 2; URL=login.php');
            } else {
                $error = 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.';
            }
        }
    }
}

$title = 'Register';
include 'includes/header.php';
?>

<script src="https://cdn.tailwindcss.com"></script>

<div class="max-w-md mx-auto p-8 rounded-2xl mt-10">
    
<svg xmlns="assets/image/loginicon.png" class="h-12 w-12 mx-auto text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4" />
            </svg>
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-1">Selamat Datang</h1>
        <h2 class="text-lg text-gray-500">Buat Akun Anda</h2>
    </div>
    
    <?php if ($error): ?>
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
    
    <?php if ($success): ?>
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6">
            <?php echo $success; ?>
        </div>
    <?php else: ?>
        <div class="bg-white py-8 px-6 shadow-lg rounded-2xl">
            <form method="POST" class="space-y-5">
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" required 
                        class="w-full px-5 py-3 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300"
                        placeholder="example name">
                    </div>
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" id="email" name="email" required 
                        class="w-full px-5 py-3 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300"
                        placeholder="Email@example.com">
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input type="password" id="password" name="password" required 
                        class="w-full px-5 py-3 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300"
                        placeholder="••••••••">
                </div>
                
                <div>
                    <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required 
                        class="w-full px-5 py-3 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300"
                        placeholder="••••••••">
                </div>
                
                <button type="submit" class="w-full bg-blue-600 text-white py-3 px-4 rounded-full hover:bg-blue-700 transition duration-300 font-medium text-lg shadow-md hover:shadow-lg">
                    Daftar
                </button>
            </form>
        </div>
        
        <div class="mt-6 text-center">
            <p class="text-gray-500 text-sm">Sudah punya akun? <a href="login.php" class="text-blue-600 hover:text-blue-800 font-medium transition duration-300">Login disini</a></p>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>