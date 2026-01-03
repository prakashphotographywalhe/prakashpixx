<?php 
require_once 'db.php'; 
// Filter only Graphics category
$stmt = $pdo->query("SELECT * FROM photos WHERE category = 'Graphics' ORDER BY id DESC");
$designs = $stmt->fetchAll();
include 'includes/header.php'; 
?>

<style>
    /* Custom Cinematic Animations */
    @keyframes scrollReveal {
        from { opacity: 0; transform: translateY(40px) scale(0.95); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    .reveal-card {
        opacity: 0;
        animation: scrollReveal 1s cubic-bezier(0.2, 1, 0.2, 1) forwards;
    }

    .text-shimmer {
        background: linear-gradient(90deg, #3b82f6, #06b6d4, #6366f1, #3b82f6);
        background-size: 200% auto;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: shimmer 4s linear infinite;
    }

    @keyframes shimmer {
        to { background-position: 200% center; }
    }

    /* Lightbox Styles */
    #graphics-lightbox {
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        backdrop-filter: blur(20px) saturate(180%);
    }

    .zoom-img {
        transition: transform 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
</style>

<main class="min-h-screen bg-[#050505] text-white pb-32 selection:bg-blue-500/30">
    <div class="relative pt-48 pb-32 px-6 overflow-hidden">
        <div class="container mx-auto relative z-10 text-center md:text-left">
            <div class="inline-flex items-center space-x-3 px-5 py-2 bg-blue-500/5 backdrop-blur-3xl text-blue-400 rounded-full border border-blue-500/20 mb-10 reveal-card">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                </span>
                <span class="text-[10px] font-black uppercase tracking-[0.5em]">Design & Identity Studio</span>
            </div>
            
            <h1 class="text-6xl md:text-9xl font-black uppercase tracking-tighter leading-[0.85] mb-10 reveal-card">
                CREATIVE <br>
                <span class="text-shimmer italic">CANVAS.</span>
            </h1>
            
            <p class="text-gray-500 text-lg md:text-xl font-light italic max-w-2xl leading-relaxed reveal-card" style="animation-delay: 0.2s">
                Forging iconic brand legacies through precision vector art and cinematic motion graphics. 
                Where logic meets high-end aesthetics.
            </p>
        </div>

        <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-blue-600/10 rounded-full filter blur-[150px] -mr-64 -mt-64 animate-pulse"></div>
        <div class="absolute bottom-0 left-1/4 w-[400px] h-[400px] bg-indigo-600/5 rounded-full filter blur-[120px]"></div>
    </div>

    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
            <?php if (empty($designs)): ?>
                <div class="col-span-full py-40 text-center border-2 border-dashed border-gray-900 rounded-[4rem] reveal-card">
                    <div class="w-20 h-20 bg-gray-900 rounded-3xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-layer-group text-3xl text-gray-700"></i>
                    </div>
                    <p class="text-gray-600 uppercase tracking-[0.4em] text-[10px] font-black italic">Collection currently in curation</p>
                </div>
            <?php endif; ?>

            <?php foreach ($designs as $index => $work): ?>
                <div class="reveal-card group relative bg-[#0a0a0a] rounded-[3.5rem] overflow-hidden border border-white/5 hover:border-blue-500/40 transition-all duration-700 shadow-2xl cursor-pointer" 
                     style="animation-delay: <?= 0.1 * ($index % 6) ?>s"
                     onclick="openGraphicsLightbox('uploads/<?= $work['image_path'] ?>', '<?= addslashes($work['title']) ?>')">
                    
                    <div class="aspect-[4/5] overflow-hidden">
                        <img src="uploads/<?= htmlspecialchars($work['image_path']) ?>" 
                             alt="<?= htmlspecialchars($work['title']) ?>" 
                             class="w-full h-full object-cover transform group-hover:scale-110 group-hover:rotate-1 transition-transform duration-[1.5s] opacity-60 group-hover:opacity-100">
                    </div>

                    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex flex-col justify-end p-12">
                        <div class="translate-y-8 group-hover:translate-y-0 transition-transform duration-500">
                            <span class="text-[9px] font-black text-blue-400 uppercase tracking-[0.4em] mb-4 block">Asset // 0<?= $work['id'] ?></span>
                            <h3 class="text-4xl font-black uppercase italic tracking-tighter text-white mb-6"><?= htmlspecialchars($work['title']) ?></h3>
                            
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center backdrop-blur-md">
                                    <i class="fas fa-expand text-[10px]"></i>
                                </div>
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">View Masterpiece</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="absolute top-8 left-8 px-5 py-2 bg-black/60 backdrop-blur-xl rounded-2xl border border-white/10 opacity-0 group-hover:opacity-100 transition-all duration-500">
                         <span class="text-[9px] font-black uppercase tracking-widest text-blue-400">Digital Identity</span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="mt-40 relative group reveal-card">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600/20 to-indigo-600/20 rounded-[5rem] blur-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-1000"></div>
            <div class="relative bg-[#080808] rounded-[5rem] p-20 md:p-32 text-center border border-white/5 overflow-hidden">
                <div class="relative z-10">
                    <h2 class="text-5xl md:text-7xl font-black uppercase tracking-tighter text-white mb-8">
                        Ready to <span class="text-shimmer">Evolve?</span>
                    </h2>
                    <p class="text-gray-500 mb-14 max-w-xl mx-auto font-light leading-relaxed text-lg italic">
                        Transform your business into a visual landmark. Custom logos, high-end branding, and premium digital assets.
                    </p>
                    <a href="booking.php" class="inline-flex items-center bg-blue-600 text-white px-14 py-6 rounded-3xl font-black text-xs uppercase tracking-[0.4em] hover:bg-white hover:text-black transition-all transform hover:-translate-y-2 shadow-2xl">
                        Start Your Project <i class="fas fa-chevron-right ml-4 text-[10px]"></i>
                    </a>
                </div>
                <i class="fas fa-pen-nib absolute -bottom-16 -right-16 text-[25rem] text-white/[0.02] -rotate-12 transition-transform duration-1000 group-hover:rotate-0"></i>
            </div>
        </div>
    </div>
</main>

<div id="graphics-lightbox" class="fixed inset-0 z-[200] hidden bg-black/95 flex flex-col items-center justify-center p-6 opacity-0">
    <button onclick="closeGraphicsLightbox()" class="absolute top-10 right-10 w-16 h-16 rounded-full bg-white/5 text-white flex items-center justify-center hover:bg-white hover:text-black transition-all">
        <i class="fas fa-times text-2xl"></i>
    </button>
    
    <div class="max-w-6xl w-full flex flex-col items-center">
        <div class="relative group">
            <img id="lb-img" src="" class="zoom-img max-h-[75vh] w-auto rounded-[2.5rem] shadow-[0_0_100px_rgba(59,130,246,0.2)] border border-white/10">
            <div class="absolute bottom-8 left-8 right-8 p-8 bg-black/60 backdrop-blur-2xl rounded-3xl border border-white/5">
                <h3 id="lb-title" class="text-3xl font-black uppercase italic tracking-tighter text-white"></h3>
                <p class="text-blue-500 text-[10px] font-black uppercase tracking-[0.4em] mt-2">© Prakash Photography & Graphics</p>
            </div>
        </div>
    </div>
</div>

<script>
    function openGraphicsLightbox(src, title) {
        const lb = document.getElementById('graphics-lightbox');
        const img = document.getElementById('lb-img');
        const titleText = document.getElementById('lb-title');

        img.src = src;
        titleText.innerText = title;
        
        lb.classList.remove('hidden');
        lb.classList.add('flex');
        
        // Staggered trigger for opacity and zoom
        setTimeout(() => {
            lb.classList.add('opacity-100');
            img.style.transform = 'scale(1)';
        }, 50);
    }

    function closeGraphicsLightbox() {
        const lb = document.getElementById('graphics-lightbox');
        const img = document.getElementById('lb-img');
        
        lb.classList.remove('opacity-100');
        img.style.transform = 'scale(0.9)';
        
        setTimeout(() => {
            lb.classList.add('hidden');
            lb.classList.remove('flex');
        }, 500);
    }

    // Intersection Observer for extra smooth entry on scroll
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('reveal-card');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.reveal-card').forEach(card => observer.observe(card));
</script>

<?php include 'includes/footer.php'; ?>