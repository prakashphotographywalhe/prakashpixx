<?php 
/** * 1. LOGIC FIRST: Handle Account Creation */
require_once 'db.php'; 

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = "Security keys do not match.";
    } else {
        $checkEmail = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $checkEmail->execute([$email]);
        
        if ($checkEmail->rowCount() > 0) {
            $error = "This identity is already registered.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $role = 'user'; 

            try {
                $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
                $stmt->execute([$name, $email, $hashed_password, $role]);
                $success = "Identity Verified. You may now enter the studio.";
            } catch (PDOException $e) {
                $error = "Node sync failed. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Collective | Prakash Photography & Graphics</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&family=Syncopate:wght@700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #050505; }
        .logo-font { font-family: 'Syncopate', sans-serif; }

        .reveal {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.8s cubic-bezier(0.2, 1, 0.2, 1) forwards;
        }
        @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }

        /* Enhanced Visibility Blocks */
        .glass-input {
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(15px);
            transition: all 0.3s ease;
        }
        .glass-input:focus-within {
            border-color: #3b82f6; /* Blue focus for signup */
            background: rgba(255, 255, 255, 0.12);
            box-shadow: 0 0 25px rgba(59, 130, 246, 0.2);
        }

        .shimmer {
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            background-size: 200% 100%;
            animation: shimmer 3s infinite;
        }
        @keyframes shimmer { 0% { background-position: -200% 0; } 100% { background-position: 200% 0; } }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center relative py-10">

    <div class="fixed inset-0 z-0">
        <img src="assets/images/images.jpg" alt="Background" class="w-full h-full object-cover opacity-40">
        <div class="absolute inset-0 bg-gradient-to-br from-black via-black/90 to-blue-900/40"></div>
    </div>

    <main class="relative z-10 w-full max-w-xl px-6">
        
        <div class="text-center mb-10 reveal">
            <h2 class="logo-font text-white text-2xl tracking-tighter uppercase leading-none">Prakash</h2>
            <p class="text-blue-500 text-[9px] font-black uppercase tracking-[0.5em] mt-2 italic">Photography & Graphics</p>
        </div>

        <div class="bg-white/10 backdrop-blur-3xl rounded-[4rem] p-10 md:p-14 shadow-[0_50px_100px_-20px_rgba(0,0,0,0.5)] border border-white/10 reveal">
            
            <div class="text-center mb-10">
                <h1 class="text-4xl font-black text-white uppercase tracking-tighter italic">Join Us.</h1>
                <p class="text-gray-400 text-[10px] font-black uppercase tracking-[0.3em] mt-2">Create your creative footprint</p>
            </div>

            <?php if ($error): ?>
                <div class="bg-red-500/20 border border-red-500/40 text-red-200 text-[10px] font-black uppercase tracking-widest py-4 px-6 rounded-2xl mb-8 text-center animate-pulse">
                    <i class="fas fa-exclamation-circle mr-2"></i> <?= $error ?>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="bg-green-500/20 border border-green-500/40 text-green-200 text-[10px] font-black uppercase tracking-widest py-4 px-6 rounded-2xl mb-8 text-center">
                    <i class="fas fa-check-circle mr-2"></i> <?= $success ?>
                    <a href="login.php" class="block mt-2 underline italic">Proceed to Login</a>
                </div>
            <?php endif; ?>

            <form action="" method="POST" class="space-y-6">
                <div class="space-y-2 reveal" style="animation-delay: 0.1s">
                    <label class="text-[9px] font-black text-gray-500 uppercase tracking-[0.4em] ml-4">Full Identity</label>
                    <div class="relative glass-input rounded-[2.5rem]">
                        <i class="far fa-user absolute left-6 top-1/2 -translate-y-1/2 text-gray-500"></i>
                        <input type="text" name="name" required placeholder="Your Name"
                               class="w-full pl-16 pr-8 py-5 bg-transparent text-white outline-none font-bold placeholder:text-gray-700">
                    </div>
                </div>

                <div class="space-y-2 reveal" style="animation-delay: 0.2s">
                    <label class="text-[9px] font-black text-gray-500 uppercase tracking-[0.4em] ml-4">Digital Mail</label>
                    <div class="relative glass-input rounded-[2.5rem]">
                        <i class="far fa-envelope absolute left-6 top-1/2 -translate-y-1/2 text-gray-500"></i>
                        <input type="email" name="email" required placeholder="email@example.com"
                               class="w-full pl-16 pr-8 py-5 bg-transparent text-white outline-none font-bold placeholder:text-gray-700">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2 reveal" style="animation-delay: 0.3s">
                        <label class="text-[9px] font-black text-gray-500 uppercase tracking-[0.4em] ml-4">Security Key</label>
                        <div class="relative glass-input rounded-[2.5rem]">
                            <input type="password" name="password" required placeholder="••••••••"
                                   class="w-full px-8 py-5 bg-transparent text-white outline-none font-bold placeholder:text-gray-700">
                        </div>
                    </div>
                    <div class="space-y-2 reveal" style="animation-delay: 0.4s">
                        <label class="text-[9px] font-black text-gray-500 uppercase tracking-[0.4em] ml-4">Confirm Key</label>
                        <div class="relative glass-input rounded-[2.5rem]">
                            <input type="password" name="confirm_password" required placeholder="••••••••"
                                   class="w-full px-8 py-5 bg-transparent text-white outline-none font-bold placeholder:text-gray-700">
                        </div>
                    </div>
                </div>

                <button type="submit" 
                        class="group relative w-full bg-white text-black font-black py-7 rounded-[2.5rem] shadow-2xl overflow-hidden transition-all active:scale-95 mt-4">
                    <span class="relative z-10 uppercase tracking-[0.5em] text-[10px]">Initialize Identity</span>
                    <div class="absolute inset-0 bg-blue-600 translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                </button>
            </form>

            <div class="mt-12 text-center border-t border-white/10 pt-10 reveal" style="animation-delay: 0.5s">
                <p class="text-gray-500 text-[10px] font-black uppercase tracking-widest">
                    Already a member? 
                    <a href="login.php" class="text-green-500 hover:text-white transition-colors ml-2 italic underline underline-offset-4">Sign In</a>
                </p>
                <a href="index.php" class="inline-block mt-8 text-[8px] text-gray-600 hover:text-white uppercase tracking-[1em] transition-all">
                    <i class="fas fa-arrow-left mr-2"></i> Exit to Home
                </a>
            </div>
        </div>
    </div>
</main>
</body>
</html>