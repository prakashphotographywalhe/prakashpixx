<?php 
require_once 'db.php'; 
if (session_status() === PHP_SESSION_NONE) { session_start(); }

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM appointments WHERE user_id = ? ORDER BY date DESC");
$stmt->execute([$user_id]);
$my_shoots = $stmt->fetchAll();

include 'includes/header.php'; 
?>

<style>
    .stagger-item { opacity: 0; transform: translateY(30px); animation: slideUp 0.8s cubic-bezier(0.2, 1, 0.2, 1) forwards; }
    @keyframes slideUp { to { opacity: 1; transform: translateY(0); } }

    /* Pipeline Styling */
    .pipeline-dot { position: relative; z-index: 10; transition: all 0.5s ease; }
    .pipeline-line { position: absolute; top: 50%; left: 0; height: 2px; width: 100%; background: #e2e8f0; z-index: 1; transform: translateY(-50%); }
    .pipeline-progress { position: absolute; top: 50%; left: 0; height: 2px; background: linear-gradient(90deg, #22c55e, #3b82f6); z-index: 2; transform: translateY(-50%); transition: width 1s cubic-bezier(0.4, 0, 0.2, 1); }

    .countdown-ticker { font-family: 'Courier New', monospace; background: #000; color: #22c55e; padding: 2px 8px; border-radius: 4px; }
    
    /* Cloud Link Glow */
    .glow-blue { box-shadow: 0 0 20px rgba(59, 130, 246, 0.4); }
</style>

<main class="min-h-screen bg-[#fcfcfc] pb-32">
    <div class="bg-[#0a0a0a] pt-44 pb-40 px-6 relative overflow-hidden">
        <div class="container mx-auto relative z-10 text-center md:text-left">
            <h1 class="text-6xl md:text-8xl font-black text-white mb-4 uppercase tracking-tighter italic leading-none stagger-item">
                Project <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-blue-500">Flow.</span>
            </h1>
            <p class="text-gray-500 font-light text-xl italic stagger-item">Real-time tracking of your visual assets.</p>
        </div>
    </div>

    <div class="container mx-auto px-6 -mt-24 relative z-20">
        <div class="max-w-6xl mx-auto space-y-12">
            
            <?php foreach ($my_shoots as $index => $shoot): 
                $targetDate = strtotime($shoot['date']);
                $now = time();
                $isPast = $now > $targetDate;
                $isToday = date('Y-m-d', $now) == $shoot['date'];

                // Calculate Pipeline Progress %
                $progressWidth = "10%";
                $statusText = "Pre-Production";
                if ($isToday) { $progressWidth = "50%"; $statusText = "Live Capture"; }
                if ($isPast && !$isToday) { $progressWidth = "100%"; $statusText = "Final Curation"; }
            ?>
                <div class="stagger-item bg-white rounded-[4rem] shadow-2xl border border-gray-50 overflow-hidden p-10 md:p-16" style="animation-delay: <?= $index * 0.1 ?>s">
                    <div class="flex flex-col xl:flex-row justify-between gap-12">
                        
                        <div class="flex-1 space-y-10">
                            <div class="flex flex-wrap items-center gap-4">
                                <span class="px-5 py-2 bg-gray-900 text-white rounded-full text-[9px] font-black uppercase tracking-[0.3em]">
                                    #<?= str_pad($shoot['id'], 4, '0', STR_PAD_LEFT) ?>
                                </span>
                                <h2 class="text-4xl font-black text-gray-900 italic uppercase tracking-tighter"><?= htmlspecialchars($shoot['service']) ?></h2>
                            </div>

                            <div class="relative py-12 max-w-2xl">
                                <div class="pipeline-line"></div>
                                <div class="pipeline-progress" style="width: <?= $progressWidth ?>;"></div>
                                
                                <div class="flex justify-between relative">
                                    <div class="flex flex-col items-center">
                                        <div class="w-10 h-10 rounded-full border-4 border-white shadow-xl flex items-center justify-center pipeline-dot bg-green-500 text-white">
                                            <i class="fas fa-calendar-check text-xs"></i>
                                        </div>
                                        <span class="mt-4 text-[9px] font-black uppercase tracking-widest text-green-600">Briefing</span>
                                    </div>

                                    <div class="flex flex-col items-center">
                                        <div class="w-10 h-10 rounded-full border-4 border-white shadow-xl flex items-center justify-center pipeline-dot <?= ($progressWidth >= "50%") ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-400' ?>">
                                            <i class="fas fa-camera text-xs"></i>
                                        </div>
                                        <span class="mt-4 text-[9px] font-black uppercase tracking-widest <?= ($progressWidth >= "50%") ? 'text-blue-600' : 'text-gray-300' ?>">Capture</span>
                                    </div>

                                    <div class="flex flex-col items-center">
                                        <div class="w-10 h-10 rounded-full border-4 border-white shadow-xl flex items-center justify-center pipeline-dot <?= ($progressWidth == "100%") ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-400' ?>">
                                            <i class="fas fa-magic text-xs"></i>
                                        </div>
                                        <span class="mt-4 text-[9px] font-black uppercase tracking-widest <?= ($progressWidth == "100%") ? 'text-indigo-600' : 'text-gray-300' ?>">Curation</span>
                                    </div>
                                </div>
                            </div>

                            <?php if ($progressWidth == "100%"): ?>
                                <div class="p-8 rounded-[2.5rem] bg-blue-600 text-white flex flex-col md:flex-row items-center justify-between gap-6 glow-blue animate-bounce-subtle">
                                    <div class="flex items-center gap-6">
                                        <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center text-3xl">
                                            <i class="fas fa-cloud-download-alt"></i>
                                        </div>
                                        <div>
                                            <h4 class="text-xl font-black uppercase italic tracking-tighter">Assets Ready</h4>
                                            <p class="text-blue-100 text-[10px] font-bold uppercase tracking-widest">High-Resolution Digital Delivery</p>
                                        </div>
                                    </div>
                                    <?php if (!empty($shoot['cloud_link'])): ?>
                                        <a href="<?= $shoot['cloud_link'] ?>" target="_blank" class="px-10 py-4 bg-white text-blue-600 rounded-xl font-black uppercase tracking-widest text-[10px] hover:scale-105 transition-all shadow-xl">
                                            Download Now
                                        </a>
                                    <?php else: ?>
                                        <span class="text-[10px] font-black uppercase tracking-widest opacity-60 italic">Link coming soon...</span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <div class="flex items-center space-x-6 bg-gray-50 p-6 rounded-3xl w-fit">
                                <i class="fas fa-stopwatch text-gray-300"></i>
                                <div>
                                    <p class="text-[8px] font-black text-gray-400 uppercase tracking-widest mb-1">Status: <?= $statusText ?></p>
                                    <span class="countdown-ticker text-xs font-bold" data-target="<?= $targetDate ?>">Syncing...</span>
                                </div>
                            </div>
                        </div>

                        <?php if ($shoot['status'] === 'Approved'): ?>
                            <div class="w-full xl:w-80 bg-[#0a0a0a] rounded-[3.5rem] p-10 text-center relative overflow-hidden">
                                <p class="text-[9px] font-black text-gray-500 uppercase tracking-[0.4em] mb-8">Settlement Node</p>
                                <div class="bg-white p-4 rounded-3xl shadow-2xl mb-10 transform hover:scale-105 transition-transform duration-500">
                                    <img src="assets/images/pay.jpeg" class="w-full grayscale hover:grayscale-0 transition-all">
                                </div>
                                <a href="invoice.php?id=<?= $shoot['id'] ?>" class="text-blue-400 font-black text-[10px] uppercase tracking-widest hover:text-white transition-colors">
                                    <i class="fas fa-file-invoice mr-2"></i> View Statement
                                </a>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<script>
    function updateTickers() {
        document.querySelectorAll('.countdown-ticker').forEach(ticker => {
            const target = parseInt(ticker.dataset.target);
            const now = Math.floor(Date.now() / 1000);
            const diff = target - now;
            if (diff <= 0) {
                ticker.innerText = "SESSION LIVE / COMPLETED";
                ticker.style.color = "#3b82f6";
                return;
            }
            const d = Math.floor(diff / 86400);
            const h = Math.floor((diff % 86400) / 3600);
            const m = Math.floor((diff % 3600) / 60);
            ticker.innerText = `${d}D : ${h}H : ${m}M REMAINING`;
        });
    }
    setInterval(updateTickers, 1000);
    updateTickers();
</script>

<?php include 'includes/footer.php'; ?>