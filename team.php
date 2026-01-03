<?php 
require_once 'db.php'; 
include 'includes/header.php'; 

// DYNAMIC DATA FETCH: Pull all approved collective members
$stmt = $pdo->query("SELECT * FROM applications WHERE status = 'approved' ORDER BY created_at DESC");
$approved_members = $stmt->fetchAll();
?>

<style>
    /* Global Smooth Scroll */
    html { scroll-behavior: smooth; }

    /* Cinematic Entry Animations */
    .reveal-card {
        opacity: 0;
        transform: translateY(40px);
        transition: all 0.8s cubic-bezier(0.2, 1, 0.2, 1);
    }
    .reveal-card.active {
        opacity: 1;
        transform: translateY(0);
    }

    /* Team Card Interactive Logic */
    .team-card {
        background: white;
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(0,0,0,0.05);
    }
    .team-card:hover {
        transform: translateY(-15px);
        box-shadow: 0 40px 80px -20px rgba(0,0,0,0.15);
        border-color: rgba(59, 130, 246, 0.2);
    }
    
    .social-link {
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
        border-radius: 12px;
        color: white;
        transition: all 0.3s;
    }
    .social-link:hover {
        background: #e1306c; /* Instagram Brand Color */
        transform: scale(1.1) rotate(5deg);
    }

    .shimmer-text {
        background: linear-gradient(90deg, #3b82f6, #10b981, #3b82f6);
        background-size: 200% auto;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: shimmer 4s linear infinite;
    }
    @keyframes shimmer { to { background-position: 200% center; } }
</style>

<main class="min-h-screen bg-[#fcfcfc] pb-32 overflow-hidden">
    
    <div class="bg-[#0a0a0a] pt-32 md:pt-48 pb-40 md:pb-56 px-6 relative overflow-hidden">
        <div class="container mx-auto relative z-10 text-center">
            <span class="inline-block px-4 py-1.5 bg-white/5 border border-white/10 text-blue-400 text-[10px] font-black uppercase tracking-[0.5em] rounded-full mb-8 reveal-card">
                The Creative Collective
            </span>
            <h1 class="text-5xl md:text-8xl font-black text-white mb-6 uppercase tracking-tighter italic leading-none reveal-card" style="transition-delay: 100ms">
                Meet the <span class="shimmer-text">Visionaries.</span>
            </h1>
            <p class="text-gray-500 font-light italic max-w-2xl mx-auto text-base md:text-lg reveal-card" style="transition-delay: 200ms">
                Combining high-fidelity optics with precision graphic architecture to build timeless brand legacies at Prakash Pix.
            </p>
        </div>
        <div class="absolute top-0 right-0 w-[300px] md:w-[500px] h-[300px] md:h-[500px] bg-blue-600/10 rounded-full filter blur-[120px] animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-[250px] md:w-[400px] h-[250px] md:h-[400px] bg-emerald-600/10 rounded-full filter blur-[100px]"></div>
    </div>

    <div class="container mx-auto px-6 -mt-20 md:-mt-32 relative z-20">
        
        <div class="flex justify-center mb-24 md:mb-40">
            <div class="reveal-card team-card group w-full max-w-sm rounded-[3rem] md:rounded-[4rem] overflow-hidden shadow-2xl">
                <div class="relative h-[28rem] md:h-[32rem] overflow-hidden">
                    <img src="assets/images/team1.jpg" alt="Founder" class="w-full h-full object-cover object-center transition-transform duration-[1.5s] group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end p-10 md:p-12">
                        <div class="flex space-x-3">
                            <a href="https://www.instagram.com/prakash_photography_8?igsh=ZDNlZDc0MzIxNw==" target="_blank" class="social-link"><i class="fa-brands fa-instagram"></i></a>
                        </div>
                    </div>
                    <div class="absolute top-8 right-8 px-5 py-2 bg-white/10 backdrop-blur-xl rounded-full border border-white/20">
                         <span class="text-[9px] font-black uppercase tracking-widest text-emerald-400">Founder</span>
                    </div>
                </div>
                <div class="p-8 md:p-10 text-center bg-white">
                    <h3 class="text-2xl md:text-3xl font-black text-gray-900 tracking-tighter uppercase italic leading-none mb-3">Lt. Prakash Pawar</h3>
                    <p class="text-gray-400 text-sm font-light leading-relaxed italic">"The art of nature is the ultimate inspiration."</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            
            <div class="reveal-card team-card group rounded-[3rem] overflow-hidden shadow-xl">
                <div class="relative h-80 md:h-96 overflow-hidden bg-gray-100">
                    <img src="assets/images/team2.jpg" alt="Ganraj" class="w-full h-full object-cover object-center transition-transform duration-1000 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end p-8">
                        <div class="flex space-x-3">
                            <a href="https://www.instagram.com/ganraj_pawar_dharkar?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank" class="social-link"><i class="fa-brands fa-instagram"></i></a>
                        </div>
                    </div>
                    <div class="absolute top-6 right-6 px-4 py-1.5 bg-blue-600 rounded-full shadow-lg">
                         <span class="text-[8px] font-black uppercase tracking-widest text-white">Hybrid Master</span>
                    </div>
                </div>
                <div class="p-8 text-center bg-white border-t border-gray-50">
                    <h4 class="text-xl font-black text-gray-900 tracking-tighter uppercase mb-1">Ganraj Pawar</h4>
                    <p class="text-blue-600 text-[9px] font-black uppercase tracking-widest mb-4 italic">Lead Photographer & Designer</p>
                </div>
            </div>

            <div class="reveal-card team-card group rounded-[3rem] overflow-hidden shadow-xl" style="transition-delay: 100ms">
                <div class="relative h-80 md:h-96 overflow-hidden bg-gray-100">
                    <img src="assets/images/team3.jpg" alt="Sahil Date" class="w-full h-full object-cover object-center transition-transform duration-1000 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end p-8">
                        <div class="flex space-x-3">
                            <a href="https://www.instagram.com/gurudatta_advertising96?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank" class="social-link"><i class="fa-brands fa-instagram"></i></a>
                        </div>
                    </div>
                    <div class="absolute top-6 right-6 px-4 py-1.5 bg-rose-600 rounded-full shadow-lg">
                         <span class="text-[8px] font-black uppercase tracking-widest text-white">Design Maverick</span>
                    </div>
                </div>
                <div class="p-8 text-center bg-white border-t border-gray-50">
                    <h4 class="text-xl font-black text-gray-900 tracking-tighter uppercase mb-1">Sahil Date</h4>
                    <p class="text-rose-600 text-[9px] font-black uppercase tracking-widest mb-4 italic">Graphics Designer</p>
                </div>
            </div>

            <div class="reveal-card team-card group rounded-[3rem] overflow-hidden shadow-xl" style="transition-delay: 200ms">
                <div class="relative h-80 md:h-96 overflow-hidden bg-gray-100">
                    <img src="assets/images/team4.jpg" alt="Sujal Nigade" class="w-full h-full object-cover object-center transition-transform duration-1000 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end p-8">
                        <div class="flex space-x-3">
                            <a href="https://www.instagram.com/sujal_graphics_designer?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank" class="social-link"><i class="fa-brands fa-instagram"></i></a>
                        </div>
                    </div>
                    <div class="absolute top-6 right-6 px-4 py-1.5 bg-amber-500 rounded-full shadow-lg">
                         <span class="text-[8px] font-black uppercase tracking-widest text-white">Creative Architect</span>
                    </div>
                </div>
                <div class="p-8 text-center bg-white border-t border-gray-50">
                    <h4 class="text-xl font-black text-gray-900 tracking-tighter uppercase mb-1">Sujal Nigade</h4>
                    <p class="text-amber-500 text-[9px] font-black uppercase tracking-widest mb-4 italic">Graphics Designer</p>
                </div>
            </div>

            <?php foreach($approved_members as $index => $member): ?>
            <div class="reveal-card team-card group rounded-[3rem] overflow-hidden shadow-xl" style="transition-delay: <?= ($index + 3) * 100 ?>ms">
                <div class="relative h-80 md:h-96 overflow-hidden bg-gray-100">
                    <img src="<?= htmlspecialchars($member['image_path']) ?>" class="w-full h-full object-cover object-center transition-transform duration-1000 group-hover:scale-110">
                    <div class="absolute top-6 right-6 px-4 py-1.5 bg-black rounded-full">
                         <span class="text-[8px] font-black uppercase tracking-widest text-white"><?= htmlspecialchars($member['skill']) ?></span>
                    </div>
                </div>
                <div class="p-8 text-center bg-white border-t border-gray-50">
                    <h4 class="text-xl font-black text-gray-900 tracking-tighter uppercase mb-1"><?= htmlspecialchars($member['name']) ?></h4>
                    <p class="text-indigo-600 text-[9px] font-black uppercase tracking-widest mb-4 italic"><?= htmlspecialchars($member['skill']) ?></p>
                </div>
            </div>
            <?php endforeach; ?>

            <a href="join_collective.php" class="reveal-card flex flex-col items-center justify-center p-8 rounded-[3rem] border-2 border-dashed border-gray-200 group hover:border-blue-500 transition-all cursor-pointer bg-white/50" style="transition-delay: 400ms">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-6 group-hover:bg-blue-50 group-hover:scale-110 transition-all">
                    <i class="fas fa-plus text-gray-300 group-hover:text-blue-500"></i>
                </div>
                <p class="text-[10px] font-black uppercase tracking-widest text-gray-400">Join the Collective</p>
            </a>
        </div>
    </div>
</main>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Intersection Observer for card reveals
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.reveal-card').forEach(el => observer.observe(el));
    });
</script>

<?php include 'includes/footer.php'; ?>