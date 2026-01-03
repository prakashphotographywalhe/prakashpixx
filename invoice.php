<?php 
require_once 'db.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$booking_id = $_GET['id'] ?? 0;
$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT a.*, u.name, u.email FROM appointments a JOIN users u ON a.user_id = u.id WHERE a.id = ? AND a.user_id = ?");
$stmt->execute([$booking_id, $user_id]);
$invoice = $stmt->fetch();

if (!$invoice) {
    die("Error: Invoice not found or access denied.");
}

// Determine if this is a Graphics or Photo project for styling
$isGraphics = !empty($invoice['brand_name']);
$themeColor = $isGraphics ? 'blue' : 'green';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #PPG-<?= $invoice['id'] ?> | Prakash Studio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&family=Syncopate:wght@700&display=swap');
        
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .logo-font { font-family: 'Syncopate', sans-serif; }

        @keyframes stampPop {
            0% { transform: scale(3); opacity: 0; }
            80% { transform: scale(0.9); opacity: 1; }
            100% { transform: scale(1); opacity: 1; rotate: -12deg; }
        }
        
        .paid-stamp {
            animation: stampPop 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
            animation-delay: 0.8s;
            opacity: 0;
        }

        .reveal {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.8s ease forwards;
        }
        @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }

        @media print {
            .no-print { display: none !important; }
            body { background: white !important; padding: 0; }
            .invoice-container { box-shadow: none !important; border: 1px solid #eee !important; margin: 0 !important; width: 100% !important; max-width: 100% !important; }
            .gradient-header { background: #000 !important; color: white !important; -webkit-print-color-adjust: exact; }
        }
    </style>
</head>
<body class="bg-slate-50 py-12 px-4 selection:bg-<?= $themeColor ?>-500/30">

    <div class="max-w-4xl mx-auto no-print flex justify-between items-center mb-10 reveal">
        <a href="my_bookings.php" class="flex items-center text-gray-400 hover:text-black font-bold text-[10px] uppercase tracking-[0.2em] transition-all">
            <i class="fas fa-chevron-left mr-3"></i> Return to Dashboard
        </a>
        <div class="flex items-center space-x-4">
            <button onclick="window.print()" class="bg-white border border-gray-200 text-black px-8 py-3 rounded-2xl font-black text-[10px] uppercase tracking-widest shadow-sm hover:bg-black hover:text-white transition-all">
                <i class="fas fa-file-pdf mr-2"></i> Export Document
            </button>
        </div>
    </div>

    <div class="max-w-4xl mx-auto bg-white rounded-[3.5rem] shadow-[0_50px_100px_-20px_rgba(0,0,0,0.1)] overflow-hidden invoice-container border border-gray-100 relative reveal" style="animation-delay: 0.2s">
        
        <div class="bg-black p-12 md:p-16 text-white flex flex-col md:flex-row justify-between items-start md:items-center relative overflow-hidden">
            <div class="relative z-10">
                <h2 class="logo-font text-2xl tracking-tighter mb-1 uppercase">Prakash</h2>
                <p class="text-<?= $themeColor ?>-400 text-[9px] font-black uppercase tracking-[0.4em]">Photography & Graphics</p>
            </div>
            
            <div class="text-left md:text-right mt-8 md:mt-0 relative z-10">
                <h1 class="text-4xl font-black uppercase tracking-tighter italic">Statement</h1>
                <p class="text-gray-500 text-[10px] font-bold mt-1 uppercase tracking-widest">Ref: PPG-<?= str_pad($invoice['id'], 4, '0', STR_PAD_LEFT) ?></p>
            </div>

            <i class="fas fa-<?= $isGraphics ? 'pen-nib' : 'camera' ?> absolute -right-10 -bottom-10 text-[15rem] text-white/[0.03] rotate-12"></i>
        </div>

        <div class="p-12 md:p-16 relative">
            <div class="absolute top-10 right-20 paid-stamp z-20 pointer-events-none">
                <div class="border-8 border-<?= $themeColor ?>-500/40 text-<?= $themeColor ?>-500/60 px-8 py-3 rounded-2xl font-black text-5xl tracking-tighter uppercase border-double">
                    Received
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-16 mb-20">
                <div class="reveal" style="animation-delay: 0.4s">
                    <h4 class="text-[10px] font-black text-gray-300 uppercase tracking-[0.3em] mb-6">Client Identity</h4>
                    <p class="text-3xl font-black text-gray-900 tracking-tighter italic uppercase"><?= htmlspecialchars($invoice['name']) ?></p>
                    <p class="text-gray-500 text-sm mt-2 font-medium"><?= htmlspecialchars($invoice['email']) ?></p>
                    
                    <?php if($isGraphics): ?>
                    <div class="mt-6 inline-flex items-center px-4 py-2 bg-blue-50 text-blue-600 rounded-xl border border-blue-100">
                        <i class="fas fa-briefcase text-[10px] mr-3"></i>
                        <span class="text-[10px] font-black uppercase tracking-widest"><?= htmlspecialchars($invoice['brand_name']) ?></span>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="text-left md:text-right reveal" style="animation-delay: 0.5s">
                    <h4 class="text-[10px] font-black text-gray-300 uppercase tracking-[0.3em] mb-6">Issued By</h4>
                    <p class="text-xl font-black text-gray-900 uppercase">Prakash Studio HQ</p>
                    <p class="text-gray-500 text-sm mt-1">Pune, Maharashtra, IND</p>
                    <p class="text-blue-600 font-black text-xs mt-3 tracking-widest">+91 96651 35730</p>
                </div>
            </div>

            <div class="reveal" style="animation-delay: 0.6s">
                <table class="w-full">
                    <thead>
                        <tr class="text-[9px] font-black text-gray-400 uppercase tracking-[0.4em] border-b-2 border-gray-50">
                            <th class="py-6 text-left">Description of Service</th>
                            <th class="py-6 text-center">Engagement Date</th>
                            <th class="py-6 text-right">Settlement</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <tr>
                            <td class="py-12">
                                <span class="text-xs font-black text-<?= $themeColor ?>-500 uppercase tracking-widest mb-2 block">
                                    <?= $isGraphics ? 'Digital Graphics' : 'Cinematic Photography' ?>
                                </span>
                                <p class="text-2xl font-black text-gray-800 tracking-tighter italic"><?= htmlspecialchars($invoice['service']) ?></p>
                                <p class="text-xs text-gray-400 mt-2 max-w-xs leading-relaxed font-medium">Includes high-fidelity processing, commercial licensing, and digital delivery.</p>
                            </td>
                            <td class="py-12 text-center">
                                <p class="font-black text-gray-800 text-sm uppercase"><?= date('D, d M Y', strtotime($invoice['date'])) ?></p>
                                <p class="text-[9px] text-gray-400 font-bold uppercase mt-1 tracking-widest italic">Confirmed Slot</p>
                            </td>
                            <td class="py-12 text-right">
                                <p class="text-2xl font-black text-gray-900 tracking-tighter">₹<?= number_format($invoice['price']) ?></p>
                                <p class="text-[9px] text-green-500 font-black uppercase mt-1">Transaction Success</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex flex-col items-end pt-12 border-t-2 border-gray-100 reveal" style="animation-delay: 0.7s">
                <div class="w-full max-w-xs space-y-4">
                    <div class="flex justify-between items-center bg-gray-50 p-6 rounded-3xl border border-gray-100">
                        <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Total Investment</span>
                        <span class="text-3xl font-black text-gray-900 italic tracking-tighter">₹<?= number_format($invoice['price']) ?></span>
                    </div>
                </div>
            </div>

            <div class="mt-24 grid grid-cols-1 md:grid-cols-2 gap-12 pt-12 border-t border-dashed border-gray-100 reveal" style="animation-delay: 0.8s">
                <div>
                    <h5 class="text-[9px] font-black text-gray-400 uppercase tracking-[0.3em] mb-4">Service Terms</h5>
                    <ul class="text-[9px] text-gray-400 font-bold space-y-2 uppercase tracking-widest leading-loose">
                        <li>• Assets delivered via cloud in 7-10 working days.</li>
                        <li>• Final deliverables protected under creative copyright.</li>
                    </ul>
                </div>
                <div class="text-left md:text-right flex flex-col items-start md:items-end justify-center">
                    <div class="w-32 h-1 bg-gradient-to-r from-<?= $themeColor ?>-500 to-indigo-600 mb-4"></div>
                    <p class="text-[10px] font-black text-gray-900 uppercase tracking-widest italic">Authorized Signature</p>
                    <p class="text-[9px] text-gray-400 font-medium mt-1 uppercase italic">Digital Verification System</p>
                </div>
            </div>

            <div class="mt-20 text-center opacity-20 reveal" style="animation-delay: 0.9s">
                <p class="text-[8px] font-black tracking-[1em] uppercase">Prakash Photography & Graphics • Visual Excellence</p>
            </div>
        </div>
    </div>
</body>
</html>