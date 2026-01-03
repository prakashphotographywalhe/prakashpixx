<?php 
require_once 'db.php'; 

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role']; 
        $_SESSION['user_name'] = $user['name'];

        if ($user['role'] === 'admin') {
            header("Location: admin.php");
        } else {
            header("Location: index.php");
        }
        exit();
    } else {
        $error = "Access Denied: Invalid credentials.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Access | Prakash Photography & Graphics</title>
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

        /* Ensuring inputs are visible against the image */
        .glass-input {
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
        }
        .glass-input:focus-within {
            border-color: #22c55e;
            background: rgba(255, 255, 255, 0.12);
            box-shadow: 0 0 20px rgba(34, 197, 94, 0.2);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center relative">

    <div class="fixed inset-0 z-0">
        <img src="assets/images/images.jpg" alt="Background" class="w-full h-full object-cover opacity-50">
        <div class="absolute inset-0 bg-gradient-to-tr from-black via-black/80 to-transparent"></div>
    </div>

    <main class="relative z-10 w-full max-w-lg px-6">
        
        <div class="text-center mb-10 reveal">
            <h2 class="logo-font text-white text-2xl tracking-tighter uppercase leading-none">Prakash</h2>
            <p class="text-blue-500 text-[9px] font-black uppercase tracking-[0.5em] mt-2 italic">Photography & Graphics</p>
        </div>

        <div class="bg-white/10 backdrop-blur-3xl rounded-[3.5rem] p-10 md:p-16 shadow-2xl border border-white/10 reveal">
            
            <div class="text-center mb-12">
                <h1 class="text-4xl font-black text-white uppercase tracking-tighter italic">Studio Access</h1>
                <p class="text-gray-400 text-sm mt-3 font-light">Sign in to your creative dashboard.</p>
            </div>

            <?php if ($error): ?>
                <div class="bg-red-500/20 border border-red-500/40 text-red-200 text-xs py-4 px-6 rounded-2xl mb-8 text-center">
                    <i class="fas fa-lock mr-2"></i> <?= $error ?>
                </div>
            <?php endif; ?>

            <form action="login.php" method="POST" class="space-y-8">
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] ml-2">Email Address</label>
                    <div class="relative glass-input rounded-[2rem] transition-all">
                        <i class="far fa-envelope absolute left-6 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="email" name="email" required placeholder="name@email.com"
                               class="w-full pl-16 pr-8 py-6 bg-transparent text-white outline-none font-bold placeholder:text-gray-600">
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="flex justify-between items-center ml-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em]">Password</label>
                        <a href="javascript:void(0)" onclick="openForgot()" class="text-gray-500 text-[9px] font-bold uppercase hover:text-blue-400 transition-colors">Forgot?</a>
                    </div>
                    <div class="relative glass-input rounded-[2rem] transition-all">
                        <i class="fas fa-shield-alt absolute left-6 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="password" name="password" required placeholder="••••••••"
                               class="w-full pl-16 pr-8 py-6 bg-transparent text-white outline-none font-bold placeholder:text-gray-600">
                    </div>
                </div>

                <button type="submit" 
                        class="group relative w-full bg-white text-black font-black py-7 rounded-[2.5rem] shadow-2xl overflow-hidden transition-all active:scale-95">
                    <span class="relative z-10 uppercase tracking-[0.4em] text-[10px]">Unlock Dashboard</span>
                    <div class="absolute inset-0 bg-green-500 translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                </button>
            </form>

            <div class="mt-12 text-center border-t border-white/10 pt-10">
                <p class="text-gray-500 text-xs">
                    New here? 
                    <a href="signup.php" class="text-blue-500 font-black hover:text-white transition-colors ml-2 uppercase tracking-widest italic">Join Collective</a>
                </p>
            </div>
        </div>
    </main>

    <div id="forgotModal" class="fixed inset-0 z-[150] hidden items-center justify-center p-6 bg-black/90 backdrop-blur-3xl opacity-0 transition-all duration-500">
        <div class="w-full max-w-md bg-[#0a0a0a] rounded-[3.5rem] p-12 border border-white/10 shadow-2xl scale-90 transition-all" id="modalContainer">
            <h2 class="text-2xl font-black text-white uppercase italic text-center mb-6">Reset Key</h2>
            <input type="email" placeholder="Your Email" class="w-full px-8 py-5 bg-white/5 rounded-2xl border border-white/10 text-white font-bold outline-none mb-6">
            <button type="button" onclick="closeForgot()" class="w-full py-5 bg-blue-600 text-white rounded-2xl font-black uppercase tracking-widest text-[10px]">Send Request</button>
            <button onclick="closeForgot()" class="w-full mt-4 text-[9px] text-gray-500 uppercase font-black">Close</button>
        </div>
    </div>

    <script>
        function openForgot() {
            const modal = document.getElementById('forgotModal');
            const container = document.getElementById('modalContainer');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.classList.add('opacity-100');
                container.classList.remove('scale-90');
                container.classList.add('scale-100');
            }, 10);
        }
        function closeForgot() {
            const modal = document.getElementById('forgotModal');
            modal.classList.remove('opacity-100');
            setTimeout(() => { modal.classList.add('hidden'); }, 500);
        }
    </script>
</body>
</html>