<?php
/**
 * 1. SESSION DESTRUCTION FIRST
 * We handle the logic immediately so the user is technically logged out
 * while the animation plays.
 */
require_once 'db.php'; 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Clear all session variables
$_SESSION = array();

// Destroy the session cookie if it exists
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disconnecting... | Prakash Photography & Graphics</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;800&family=Syncopate:wght@700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #050505; color: white; overflow: hidden; }
        .logo-font { font-family: 'Syncopate', sans-serif; }

        /* Cinematic Exit Sequence */
        @keyframes containerBlurOut {
            0% { filter: blur(0px); opacity: 1; transform: scale(1); }
            100% { filter: blur(20px); opacity: 0; transform: scale(1.1); }
        }

        @keyframes progressLine {
            0% { width: 0%; left: 0; }
            50% { width: 100%; left: 0; }
            100% { width: 0%; left: 100%; }
        }

        .animate-exit {
            animation: containerBlurOut 1s ease forwards;
            animation-delay: 2s;
        }

        .progress-bar {
            height: 1px;
            background: linear-gradient(90deg, #10b981, #3b82f6);
            position: absolute;
            bottom: 0;
            animation: progressLine 2s cubic-bezier(0.65, 0, 0.35, 1) infinite;
        }

        .glitch-text {
            position: relative;
            display: inline-block;
        }

        /* Scanline effect */
        .scanline {
            width: 100%;
            height: 100px;
            z-index: 5;
            background: linear-gradient(0deg, rgba(0,0,0,0) 0%, rgba(255,255,255,0.02) 50%, rgba(0,0,0,0) 100%);
            opacity: 0.1;
            position: absolute;
            bottom: 100%;
            animation: scanline 4s linear infinite;
        }

        @keyframes scanline {
            0% { bottom: 100%; }
            100% { bottom: -100%; }
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center relative">

    <div class="scanline"></div>

    <div class="fixed inset-0 z-0">
        <img src="assets/images/images.jpg" alt="Background" class="w-full h-full object-cover opacity-10 grayscale scale-110">
        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/90 to-black"></div>
    </div>

    <main class="relative z-10 text-center animate-exit">
        <div class="mb-16 opacity-50">
            <h2 class="logo-font text-white text-xl tracking-tighter uppercase mb-1">Prakash</h2>
            <p class="text-emerald-500 text-[8px] font-black uppercase tracking-[0.6em] italic">Photography & Graphics</p>
        </div>

        <div class="space-y-6">
            <div class="flex justify-center mb-10">
                <div class="relative w-16 h-16">
                    <div class="absolute inset-0 border-2 border-emerald-500/20 rounded-full"></div>
                    <div class="absolute inset-0 border-t-2 border-emerald-500 rounded-full animate-spin"></div>
                </div>
            </div>
            
            <h1 class="text-3xl md:text-5xl font-black text-white uppercase tracking-tighter italic leading-none">
                Session <span class="text-gray-600 font-light">Closed.</span>
            </h1>
            
            <div class="flex flex-col items-center space-y-4">
                <p class="text-gray-500 text-[10px] font-black uppercase tracking-[0.5em] mt-4">Terminating Encrypted Node...</p>
                <div class="w-48 h-[1px] bg-white/5 relative overflow-hidden rounded-full">
                    <div class="progress-bar"></div>
                </div>
            </div>
        </div>

        <div class="mt-24 text-[8px] font-black text-white/10 uppercase tracking-[1em]">
            Syncing Creative State // Exit Code 0x0
        </div>
    </main>

    <script>
        // Redirect the user to login.php after 2.6 seconds
        setTimeout(function() {
            window.location.href = 'login.php';
        }, 2600);
    </script>
</body>
</html>