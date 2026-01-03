<?php 
require_once 'db.php'; 
include 'includes/header.php'; 

$baseDir = "assets/gallery/";
if (!is_dir($baseDir)) { mkdir($baseDir, 0777, true); }

// 1. GET ALL SUB-FOLDERS (Events/Weddings)
$folders = array_filter(glob($baseDir . '*'), 'is_dir');

// 2. GET CURRENT SELECTED CATEGORY
$selectedFolder = $_GET['event'] ?? 'all';
?>

<style>
    /* Cinematic Masonry Entry */
    .masonry-item {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.8s cubic-bezier(0.2, 1, 0.2, 1);
    }
    .masonry-item.show {
        opacity: 1;
        transform: translateY(0);
    }

    /* Gradient Shine Effect on Hover */
    .image-container::after {
        content: ''; position: absolute; top: 0; left: -100%; width: 50%; height: 100%;
        background: linear-gradient(to right, transparent, rgba(255,255,255,0.2), transparent);
        transform: skewX(-25deg); transition: 0.75s;
    }
    .image-container:hover::after { left: 125%; }

    /* Custom Scrollbar for Filters */
    .hide-scroll::-webkit-scrollbar { display: none; }
    .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<main class="min-h-screen bg-[#fcfcfc] pb-24">
    <div class="bg-[#0a0a0a] pt-44 pb-40 px-6 text-center relative overflow-hidden">
        <div class="relative z-10">
            <span class="inline-block px-4 py-1.5 bg-white/5 border border-white/10 text-green-400 text-[10px] font-black uppercase tracking-[0.4em] rounded-full mb-6">
                Cinematic Portfolios
            </span>
            <h1 class="text-5xl md:text-8xl font-black text-white mb-6 uppercase tracking-tighter italic leading-none">
                Wedding <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-blue-500">Diaries.</span>
            </h1>
            <p class="text-gray-500 font-light italic max-w-2xl mx-auto text-lg lowercase first-letter:uppercase">
                Capturing raw emotions and timeless elegance in 4K high-fidelity.
            </p>
        </div>
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-green-600/10 rounded-full filter blur-[120px]"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-blue-600/10 rounded-full filter blur-[120px]"></div>
    </div>

    <div class="container mx-auto px-6 -mt-10 relative z-20">
        <div class="flex justify-center overflow-x-auto hide-scroll pb-4">
            <div class="flex bg-white/80 backdrop-blur-xl p-2 rounded-[2.5rem] shadow-2xl border border-white/50">
                <a href="gallery.php" class="px-8 py-4 rounded-[2rem] text-[10px] font-black uppercase tracking-widest transition-all <?= $selectedFolder == 'all' ? 'bg-gray-900 text-white shadow-xl' : 'text-gray-400 hover:text-gray-900' ?>">
                    Everything
                </a>
                <?php foreach ($folders as $folder): 
                    $folderName = basename($folder);
                    $displayName = str_replace('_', ' & ', $folderName);
                ?>
                    <a href="gallery.php?event=<?= $folderName ?>" 
                       class="px-8 py-4 rounded-[2rem] text-[10px] font-black uppercase tracking-widest transition-all <?= $selectedFolder == $folderName ? 'bg-green-600 text-white shadow-xl' : 'text-gray-400 hover:text-green-600' ?>">
                        <?= $displayName ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <?php 
        if ($selectedFolder == 'all') {
            $images = glob($baseDir . "{*/,}*.{jpg,jpeg,png,webp}", GLOB_BRACE);
        } else {
            $images = glob($baseDir . $selectedFolder . "/*.{jpg,jpeg,png,webp}", GLOB_BRACE);
        }
        
        if (empty($images)): ?>
            <div class="bg-white p-32 rounded-[4rem] text-center shadow-2xl border border-gray-100 mt-12">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-camera-retro text-2xl text-gray-200"></i>
                </div>
                <p class="text-gray-400 italic uppercase tracking-[0.3em] text-[10px] font-black">Collection is being curated</p>
            </div>
        <?php else: ?>
            <div class="columns-1 md:columns-2 lg:columns-3 gap-10 space-y-10 mt-16">
                <?php foreach ($images as $index => $image): 
                    $event = basename(dirname($image));
                    $brideGroom = ($event == 'gallery') ? 'Studio Masterpiece' : str_replace('_', ' & ', $event);
                ?>
                    <div class="masonry-item group relative bg-white rounded-[3rem] overflow-hidden shadow-xl border border-gray-100 break-inside-avoid image-container cursor-pointer" 
                         onclick="openGalleryLightbox('<?= $image ?>', '<?= $brideGroom ?>')">
                        
                        <img src="<?= $image ?>" class="w-full h-auto object-cover transform group-hover:scale-110 transition-transform duration-1000">
                        
                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 p-10 flex flex-col justify-end">
                            <span class="text-green-400 text-[9px] font-black uppercase tracking-[0.4em] mb-2">Prakash Cinematic</span>
                            <h3 class="text-white text-2xl font-black uppercase tracking-tighter italic leading-none mb-6"><?= $brideGroom ?></h3>
                            
                            <div class="flex gap-4">
                                <span class="w-12 h-12 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center text-white hover:bg-green-600 transition-all">
                                    <i class="fas fa-expand-alt"></i>
                                </span>
                                <a href="<?= $image ?>" download class="w-12 h-12 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center text-white hover:bg-blue-600 transition-all" onclick="event.stopPropagation();">
                                    <i class="fas fa-download"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<div id="gallery-lightbox" class="fixed inset-0 z-[200] hidden bg-black/98 backdrop-blur-3xl flex flex-col items-center justify-center p-6 opacity-0 transition-all duration-500">
    <button onclick="closeGalleryLightbox()" class="absolute top-10 right-10 text-white/50 hover:text-white text-4xl transition-all hover:rotate-90">
        <i class="fas fa-times"></i>
    </button>
    
    <div class="max-w-6xl w-full flex flex-col items-center">
        <img id="lightbox-img" src="" class="max-h-[75vh] w-auto rounded-3xl shadow-2xl border border-white/10 scale-90 transition-transform duration-500">
        <h3 id="lightbox-title" class="mt-10 text-3xl font-black uppercase italic tracking-tighter text-green-400"></h3>
        <p class="text-gray-500 text-[10px] font-black uppercase tracking-[0.4em] mt-2">© Prakash Photography & Graphics</p>
    </div>
</div>

<script>
    // Staggered Entry Animation
    document.addEventListener("DOMContentLoaded", () => {
        const items = document.querySelectorAll('.masonry-item');
        items.forEach((item, index) => {
            setTimeout(() => {
                item.classList.add('show');
            }, index * 100);
        });
    });

    // Lightbox Logic
    function openGalleryLightbox(src, title) {
        const modal = document.getElementById('gallery-lightbox');
        const img = document.getElementById('lightbox-img');
        const titleEl = document.getElementById('lightbox-title');

        img.src = src;
        titleEl.innerText = title;
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        setTimeout(() => {
            modal.classList.add('opacity-100');
            img.classList.remove('scale-90');
            img.classList.add('scale-100');
        }, 10);
    }

    function closeGalleryLightbox() {
        const modal = document.getElementById('gallery-lightbox');
        const img = document.getElementById('lightbox-img');
        modal.classList.remove('opacity-100');
        img.classList.add('scale-90');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 500);
    }
</script>

<?php include 'includes/footer.php'; ?>