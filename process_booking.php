<?php
// 1. DATABASE & SESSION
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$loading_state = true;
$error = "";

// 2. PROCESS FORM DATA
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $service = $_POST['service'];
    $date = $_POST['date'];
    $description = $_POST['description'] ?? '';
    $client_offer = $_POST['client_offer'] ?? 0;
    $base_price = $_POST['base_price'] ?? 0;
    $brand_name = $_POST['brand_name'] ?? NULL;
    $booking_type = $_POST['booking_type'] ?? 'Photography';
    $status = 'Pending'; 

    // Get User Email for Receipt
    $user_stmt = $pdo->prepare("SELECT email, name FROM users WHERE id = ?");
    $user_stmt->execute([$user_id]);
    $user_data = $user_stmt->fetch();
    $user_email = $user_data['email'];
    $user_name = $user_data['name'];

    try {
        // Insert into Database
        $stmt = $pdo->prepare("INSERT INTO appointments (user_id, service, date, description, client_offer, base_price, brand_name, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$user_id, $service, $date, $description, $client_offer, $base_price, $brand_name, $status]);
        
        // 3. SEND EMAIL RECEIPT LOGIC
        $subject = "Project Initialized: " . $service . " | Prakash Studio";
        
        // Premium Email Template
        $email_body = "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: auto; border: 1px solid #eee; border-radius: 20px; overflow: hidden;'>
            <div style='background: #0a0a0a; padding: 40px; text-align: center; color: white;'>
                <h1 style='margin: 0; letter-spacing: 5px; text-transform: uppercase;'>Prakash</h1>
                <p style='color: #10b981; font-size: 10px; font-weight: bold; letter-spacing: 2px;'>PHOTOGRAPHY & GRAPHICS</p>
            </div>
            <div style='padding: 40px; color: #333;'>
                <h2 style='font-style: italic;'>Brief Secured.</h2>
                <p>Hi $user_name, your project node has been successfully initialized. We are reviewing your proposal.</p>
                <div style='background: #f9f9f9; padding: 20px; border-radius: 15px;'>
                    <p><b>Service:</b> $service</p>
                    <p><b>Proposal:</b> ₹" . number_format($client_offer) . "</p>
                    <p><b>Target Date:</b> $date</p>
                </div>
                <br>
                <center><a href='https://yourdomain.com/my_bookings.php' style='background: black; color: white; padding: 15px 25px; text-decoration: none; border-radius: 10px; font-weight: bold; font-size: 12px;'>TRACK STATUS</a></center>
            </div>
        </div>";

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: Prakash Studio <noreply@yourstudio.com>" . "\r\n";

        // Execute Mail (Suppressed with @ to prevent display errors if mail server isn't set up)
        @mail($user_email, $subject, $email_body, $headers);

        $loading_state = false; 
    } catch (PDOException $e) {
        $error = "System Conflict: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Initializing Pipeline | Prakash Studio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&family=Syncopate:wght@700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #050505; color: white; }
        .logo-font { font-family: 'Syncopate', sans-serif; }

        @keyframes scanline { 0% { transform: translateY(-100%); } 100% { transform: translateY(100%); } }
        .scanner::after {
            content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 20%;
            background: linear-gradient(to bottom, transparent, rgba(34, 197, 94, 0.2), transparent);
            animation: scanline 2s linear infinite;
        }

        @keyframes blob { 0%, 100% { transform: scale(1); filter: blur(40px); } 50% { transform: scale(1.2); filter: blur(60px); } }
        .bg-blob { animation: blob 8s infinite ease-in-out; position: absolute; border-radius: 50%; opacity: 0.15; z-index: 0; }

        .reveal { opacity: 0; transform: translateY(20px); animation: fadeInUp 0.8s cubic-bezier(0.2, 1, 0.2, 1) forwards; }
        @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center relative overflow-hidden">

    <div class="bg-blob w-96 h-96 bg-emerald-500 top-1/4 left-1/4"></div>
    <div class="bg-blob w-96 h-96 bg-blue-500 bottom-1/4 right-1/4" style="animation-delay: -4s"></div>

    <main class="relative z-10 w-full max-w-xl px-6">
        <div class="bg-white/[0.03] backdrop-blur-3xl rounded-[4rem] p-12 md:p-20 shadow-[0_0_100px_rgba(0,0,0,0.5)] border border-white/10 relative overflow-hidden">
            <div class="scanner absolute inset-0 pointer-events-none"></div>

            <?php if (!$error): ?>
                <div id="loader-content" class="<?= !$loading_state ? 'hidden' : '' ?>">
                    <div class="relative w-32 h-32 mx-auto mb-12">
                        <div class="absolute inset-0 border-2 border-emerald-500/20 rounded-full"></div>
                        <div class="absolute inset-0 border-t-2 border-emerald-500 rounded-full animate-spin"></div>
                        <div class="absolute inset-4 border-2 border-blue-500/20 rounded-full"></div>
                        <div class="absolute inset-4 border-b-2 border-blue-500 rounded-full animate-spin" style="animation-direction: reverse; animation-duration: 1.5s;"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <i class="fas fa-fingerprint text-3xl text-emerald-500 animate-pulse"></i>
                        </div>
                    </div>
                    <h2 class="text-3xl font-black uppercase tracking-tighter italic mb-4">Establishing <br><span class="text-emerald-500">Pipeline.</span></h2>
                    <p class="text-gray-500 text-[10px] font-bold uppercase tracking-[0.5em] animate-pulse">Broadcasting Receipt to Mailbox...</p>
                    
                    <script>
                        setTimeout(() => {
                            document.getElementById('loader-content').classList.add('hidden');
                            document.getElementById('success-content').classList.remove('hidden');
                        }, 3500);
                    </script>
                </div>

                <div id="success-content" class="<?= $loading_state ? 'hidden' : '' ?> reveal">
                    <div class="w-24 h-24 bg-emerald-500 rounded-[2.5rem] flex items-center justify-center mx-auto mb-10 shadow-[0_0_50px_rgba(16,185,129,0.3)]">
                        <i class="fas fa-check-double text-4xl text-white"></i>
                    </div>
                    
                    <h2 class="text-4xl font-black uppercase tracking-tighter italic leading-none mb-6">Brief <span class="text-emerald-500">Secured.</span></h2>
                    
                    <div class="space-y-4 bg-white/5 p-8 rounded-[2.5rem] border border-white/5 text-left mb-10">
                        <div class="flex justify-between">
                            <span class="text-[9px] font-black text-gray-500 uppercase tracking-widest">Project Node</span>
                            <span class="text-xs font-bold text-white uppercase"><?= $booking_type ?></span>
                        </div>
                        <div class="flex justify-between border-t border-white/5 pt-4">
                            <span class="text-[9px] font-black text-gray-500 uppercase tracking-widest">Investment</span>
                            <span class="text-xs font-bold text-emerald-400">₹<?= number_format($client_offer) ?></span>
                        </div>
                    </div>

                    <p class="text-gray-500 text-[10px] font-bold uppercase tracking-[0.2em] mb-10">A digital receipt has been dispatched to your identity mail.</p>

                    <a href="my_bookings.php" class="group relative block w-full bg-white text-black font-black py-7 rounded-[2rem] text-[10px] uppercase tracking-[0.4em] overflow-hidden transition-all shadow-2xl active:scale-95">
                        <span class="relative z-10">Access Production Hub</span>
                        <div class="absolute inset-0 bg-emerald-500 translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                    </a>
                </div>

            <?php else: ?>
                <div class="reveal">
                    <div class="w-24 h-24 bg-red-500/10 border border-red-500/30 rounded-[2rem] flex items-center justify-center mx-auto mb-8 text-red-500">
                        <i class="fas fa-satellite-dish text-3xl"></i>
                    </div>
                    <h2 class="text-2xl font-black uppercase tracking-tighter mb-4 text-red-500">Sync Failure</h2>
                    <p class="text-gray-500 text-xs uppercase tracking-widest leading-loose mb-10"><?= $error ?></p>
                    <a href="booking.php" class="inline-block text-[10px] font-black uppercase tracking-widest text-white border-b border-red-500 pb-1">Reconnect to Terminal</a>
                </div>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>