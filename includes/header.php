
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Cermatinvest - <?php echo $title ?? 'Investment Comparison Tool'; ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#2563EB',
            dark: '#1E293B',
          },
        },

        theme: {
      extend: {
        fontFamily: {
          rubik: ['Rubik', 'sans-serif'],
        }
      }
    }
      },
    }
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js" defer></script>
</head>
<body class="bg-gray-50 text-gray-900">

<nav class="font-rubik sticky top-0 bg-white shadow-md border-b border-gray-200 z-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between h-16 items-center">
      <a href="index.php" class="flex items-center space-x-2 text-primary font-bold text-xl">
        <span>Cermatinvest</span>
      </a>
      <div class="hidden md:flex items-center gap-2 z-50">
        <?php if (isset($_SESSION['user_id'])): ?>
          <a href="dashboard.php" class="text-gray-700 px-4 py-2 rounded-full hover:text-white hover:bg-blue-600 transition duration-300">Dashboard</a>
          <a href="input_kriteria.php" class="text-gray-700 px-4 py-2 rounded-full hover:text-white hover:bg-blue-600 transition duration-300">Bandingkan</a>
          <a href="logout.php" class="text-gray-700 px-4 py-2 rounded-full hover:bg-red-500 hover:text-white transition duration-300">Logout</a>
        <?php else: ?>
          <a href="./login.php" class="text-gray-700 px-4 py-2 rounded-full hover:text-white hover:bg-blue-600 transition duration-300">Login</a>
          <a href="./register.php" class="text-gray-700 px-4 py-2 rounded-full hover:text-white hover:bg-blue-600 transition duration-300">Register</a>
        <?php endif; ?>
      </div>

      <!-- Mobile menu button -->
      <div class="md:hidden">
        <button id="mobileMenuButton" class="text-gray-700 focus:outline-none">
          <i class="fas fa-bars text-xl"></i>
        </button>
      </div>
    </div>
  </div>

  <!-- Mobile menu -->
  <div id="mobileMenu" class="md:hidden hidden px-4 pb-4">
    <div class="flex flex-col space-y-2">
      <?php if (isset($_SESSION['user_id'])): ?>
        <a href="dashboard.php" class="text-gray-700 px-4 py-2 rounded-full hover:text-white hover:bg-blue-600 transition duration-300">Dashboard</a>
        <a href="input_kriteria.php" class="text-gray-700 px-4 py-2 rounded-full hover:text-white hover:bg-blue-600 transition duration-300">Bandingkan</a>
        <a href="logout.php" class="text-gray-700 px-4 py-2 rounded-full hover:bg-red-500 hover:text-white transition duration-300">Logout</a>
      <?php else: ?>
        <a href="./login.php" class="text-gray-700 px-4 py-2 rounded-full hover:text-white hover:bg-blue-600 hover:border-1 transition duration-300">Login</a>
        <a href="./register.php" class="text-gray-700 px-4 py-2 rounded-full hover:text-white hover:bg-blue-600 hover:border-1 transition duration-300">Register</a>
      <?php endif; ?>
    </div>
  </div>
</nav>

<script>
  const menuBtn = document.getElementById('mobileMenuButton');
  const menu = document.getElementById('mobileMenu');

  menuBtn.addEventListener('click', () => {
    menu.classList.toggle('hidden');
  });
</script>
