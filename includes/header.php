<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prakash Pix | Visual Perfection</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        body { font-family: 'Poppins', sans-serif; }

        /* Smooth Hide/Show for Mobile Menu */
        #mobile-menu {
            transition: all 0.5s cubic-bezier(0.77, 0, 0.175, 1);
            clip-path: circle(0% at 100% 0%);
        }
        #mobile-menu.active {
            clip-path: circle(150% at 100% 0%);
        }

        /* Hover effect for desktop links */
        .nav-link {
            position: relative;
            transition: color 0.3s;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -4px;
            left: 0;
            background: #fbbf24;
            transition: width 0.3s;
        }
        .nav-link:hover::after {
            width: 100%;
        }

        /* Glowing Button Effect */
        .btn-glow {
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.5);
            transition: 0.3s;
        }
        .btn-glow:hover {
            box-shadow: 0 0 25px rgba(59, 130, 246, 0.8);
            transform: translateY(-2px);
        }

        /* Staggered Mobile Link Animation */
        .mobile-link {
            opacity: 0;
            transform: translateY(20px);
            transition: 0.4s;
        }
        #mobile-menu.active .mobile-link {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="bg-gray-50">

<header class="fixed top-0 w-full z-[100] transition-all duration-300 bg-white/80 backdrop-blur-md border-b border-gray-200">
    <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
        <a href="index.php" class="flex items-center space-x-2 group">
            <span class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent group-hover:from-purple-600 group-hover:to-blue-600 transition duration-500">
                PRAKASH<span class="text-gray-800">PIX</span>
            </span>
        </a>

        <div class="hidden md:flex items-center space-x-8">
            <a href="index.php" class="nav-link text-gray-700 font-medium text-sm">HOME</a>
            <a href="gallery.php" class="nav-link text-gray-700 font-medium text-sm">GALLERY</a>
            <a href="about.php" class="nav-link text-gray-700 font-medium text-sm">ABOUT</a>
            <a href="booking.php" class="nav-link text-gray-700 font-medium text-sm">BOOKING</a>
            
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="flex items-center space-x-4 ml-4 pl-4 border-l border-gray-200">
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-tighter">Hi, <?= htmlspecialchars($_SESSION['user_name'] ?? 'User') ?></span>
                    <a href="logout.php" class="text-xs bg-red-50 text-red-600 px-3 py-1 rounded-full border border-red-100 hover:bg-red-600 hover:text-white transition">Logout</a>
                </div>
            <?php else: ?>
                <a href="login.php" class="text-sm font-semibold text-gray-700 hover:text-blue-600">LOGIN</a>
                <a href="register.php" class="btn-glow bg-blue-600 text-white px-5 py-2 rounded-full text-sm font-bold">JOIN</a>
            <?php endif; ?>
        </div>

        <button class="md:hidden z-[110] relative p-2" id="menu-toggle">
            <div id="line1" class="w-6 h-0.5 bg-gray-800 mb-1.5 transition-all"></div>
            <div id="line2" class="w-6 h-0.5 bg-gray-800 mb-1.5 transition-all"></div>
            <div id="line3" class="w-6 h-0.5 bg-gray-800 transition-all"></div>
        </button>
    </nav>

    <div id="mobile-menu" class="fixed inset-0 bg-blue-600 flex flex-col items-center justify-center text-center z-[105] md:hidden">
        <div class="space-y-8">
            <a href="index.php" class="mobile-link block text-3xl font-bold text-white delay-100">Home</a>
            <a href="gallery.php" class="mobile-link block text-3xl font-bold text-white delay-150">Gallery</a>
            <a href="about.php" class="mobile-link block text-3xl font-bold text-white delay-200">About</a>
            <a href="booking.php" class="mobile-link block text-3xl font-bold text-white delay-250">Book Now</a>
            <a href="my_bookings.php" class="mobile-link block text-3xl font-bold text-white delay-300">My Studio</a>
            
            <div class="mobile-link pt-8 delay-350">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="logout.php" class="bg-white text-blue-600 px-10 py-3 rounded-full font-bold shadow-xl">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="text-white border-b-2 border-white pb-1 mr-6">Login</a>
                    <a href="register.php" class="bg-yellow-400 text-blue-900 px-8 py-3 rounded-full font-bold">Sign Up</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>

<script>
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    const line1 = document.getElementById('line1');
    const line2 = document.getElementById('line2');
    const line3 = document.getElementById('line3');

    // Function to close menu
    function closeMenu() {
        mobileMenu.classList.remove('active');
        line1.style.transform = "none";
        line1.style.backgroundColor = "#1f2937";
        line2.style.opacity = "1";
        line3.style.transform = "none";
        line3.style.backgroundColor = "#1f2937";
        document.body.style.overflow = "auto";
    }

    // Function to open menu
    function openMenu() {
        mobileMenu.classList.add('active');
        line1.style.transform = "rotate(45deg) translate(5px, 6px)";
        line1.style.backgroundColor = "white";
        line2.style.opacity = "0";
        line3.style.transform = "rotate(-45deg) translate(5px, -6px)";
        line3.style.backgroundColor = "white";
        document.body.style.overflow = "hidden";
        
        // Push a state so back button closes menu instead of leaving page
        history.pushState({menuOpen: true}, "");
    }

    menuToggle.addEventListener('click', () => {
        const active = mobileMenu.classList.contains('active');
        if(!active) {
            openMenu();
        } else {
            closeMenu();
            // Optional: Remove the pushed state if closed manually
            if(history.state && history.state.menuOpen) {
                history.back();
            }
        }
    });

    // Handle back button specifically
    window.addEventListener('popstate', (event) => {
        if (mobileMenu.classList.contains('active')) {
            closeMenu();
        }
    });

    // Close menu when clicking on a link
    document.querySelectorAll('.mobile-link').forEach(link => {
        link.addEventListener('click', () => {
            closeMenu();
            if(history.state && history.state.menuOpen) {
                history.back();
            }
        });
    });
</script>