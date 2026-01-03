<?php 
require_once 'db.php'; 
include 'includes/header.php'; 
?>

<style>
    /* smooth scroll for better experience */
    html { scroll-behavior: smooth; }

    /* Cinematic Reveal Animation */
    .reveal {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.8s cubic-bezier(0.2, 1, 0.2, 1);
    }

    .reveal.active {
        opacity: 1;
        transform: translateY(0);
    }

    /* Shimmer Text Effect */
    .shimmer-text {
        background: linear-gradient(90deg, #4ade80, #3b82f6, #a855f7, #4ade80);
        background-size: 200% auto;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: shimmer 5s linear infinite;
    }

    @keyframes shimmer {
        to { background-position: 200% center; }
    }

    /* Floating Shapes for Background */
    .shape-blob {
        position: absolute;
        filter: blur(80px);
        opacity: 0.15;
        z-index: 0;
        animation: float 20s infinite alternate;
    }

    @keyframes float {
        from { transform: translate(0, 0) scale(1); }
        to { transform: translate(100px, 50px) scale(1.2); }
    }
</style>

<main class="min-h-screen bg-white overflow-hidden pt-20">
    
    <section class="relative min-h-[90vh] flex items-center justify-center bg-[#0a0a0a] overflow-hidden">
        <div class="shape-blob w-96 h-96 bg-blue-600 top-0 -left-20"></div>
        <div class="shape-blob w-96 h-96 bg-purple-600 bottom-0 -right-20" style="animation-delay: -5s;"></div>

        <div class="container mx-auto px-6 relative z-10 text-center">
            <div class="inline-flex items-center space-x-3 px-5 py-2 bg-white/5 backdrop-blur-2xl text-white rounded-full border border-white/10 mb-8 reveal active">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                </span>
                <span class="text-[10px] font-black uppercase tracking-[0.4em]">Available for Bookings 2026</span>
            </div>
            
            <h1 class="text-5xl md:text-9xl font-black text-white leading-[0.9] tracking-tighter uppercase mb-8 reveal active" style="transition-delay: 200ms">
                VISUAL <br>
                <span class="shimmer-text">PERFECTION.</span>
            </h1>
            
            <p class="text-gray-400 text-lg md:text-xl font-light max-w-2xl mx-auto leading-relaxed mb-12 reveal active" style="transition-delay: 400ms">
                From high-end Sony 4K cinematography to precision brand identity. We craft visual legacies for those who demand excellence.
            </p>
            
            <div class="flex flex-col sm:flex-row justify-center gap-6 reveal active" style="transition-delay: 600ms">
                <a href="booking.php" class="group relative bg-white text-black px-12 py-5 rounded-2xl font-black overflow-hidden transition-all active:scale-95">
                    <span class="relative z-10 uppercase tracking-widest text-xs">Start Your Project</span>
                    <div class="absolute inset-0 bg-blue-500 translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                </a>
                <a href="gallery.php" class="group relative bg-white text-black px-12 py-5 rounded-2xl font-black overflow-hidden transition-all active:scale-95">
                    <span class="relative z-10 uppercase tracking-widest text-xs">View Portfolio</span>
                    <div class="absolute inset-0 bg-blue-500 translate-y-full group-hover:translate-y-0 transition-transform duration-500"></div>
                </a>
            </div>
        </div>

        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 flex flex-col items-center space-y-2 opacity-30">
            <div class="w-[1px] h-16 bg-gradient-to-b from-white to-transparent"></div>
        </div>
    </section>

    <section class="py-32 bg-gray-50 relative overflow-hidden">
        <div class="container mx-auto px-6">
            <div class="flex flex-col items-center text-center mb-20 reveal">
                <div class="max-w-2xl">
                    <h2 class="text-5xl md:text-6xl font-black text-gray-900 uppercase tracking-tighter italic mb-4">
                        Our Discipline
                    </h2>
                    <div class="w-24 h-1 bg-blue-600 mx-auto mb-6"></div> 
                    <p class="text-gray-500 italic text-lg">Blending art with technical precision.</p>
                </div>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="group bg-white p-10 rounded-[3rem] shadow-xl shadow-gray-200/50 hover:shadow-2xl hover:-translate-y-4 transition-all duration-700 reveal scale-95 opacity-0" 
                     style="transition-delay: 100ms">
                    <div class="w-16 h-16 bg-blue-600 text-white rounded-2xl flex items-center justify-center mb-8 text-xl shadow-lg shadow-blue-200 group-hover:rotate-12 transition-transform duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-black uppercase mb-4 group-hover:text-blue-600 transition-colors">Sony 4K Portraits</h3>
                    <p class="text-gray-500 leading-relaxed font-light">Crystal clear precision for weddings and nature photography with cinematic grading.</p>
                </div>

                <div class="group bg-white p-10 rounded-[3rem] shadow-xl shadow-gray-200/50 hover:shadow-2xl hover:-translate-y-4 transition-all duration-700 reveal scale-95 opacity-0" 
                     style="transition-delay: 300ms">
                    <div class="w-16 h-16 bg-purple-600 text-white rounded-2xl flex items-center justify-center mb-8 text-xl shadow-lg shadow-purple-200 group-hover:rotate-12 transition-transform duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-black uppercase mb-4 group-hover:text-purple-600 transition-colors">Brand Graphics</h3>
                    <p class="text-gray-500 leading-relaxed font-light">Identity design and social media aesthetics that turn viewers into loyal customers.</p>
                </div>

                <div class="group bg-white p-10 rounded-[3rem] shadow-xl shadow-gray-200/50 hover:shadow-2xl hover:-translate-y-4 transition-all duration-700 reveal scale-95 opacity-0" 
                     style="transition-delay: 500ms">
                    <div class="w-16 h-16 bg-emerald-600 text-white rounded-2xl flex items-center justify-center mb-8 text-xl shadow-lg shadow-emerald-200 group-hover:rotate-12 transition-transform duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 00-2 2z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-black uppercase mb-4 group-hover:text-emerald-600 transition-colors">Visual Motion</h3>
                    <p class="text-gray-500 leading-relaxed font-light">Dynamic storytelling and video editing for commercial and personal legacies.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-white">
        <div class="container mx-auto px-6">
            <div class="relative bg-[#0a0a0a] rounded-[4rem] p-12 md:p-24 text-center overflow-hidden reveal">
                <div class="relative z-10">
                    <h2 class="text-4xl md:text-6xl font-black text-white uppercase tracking-tighter mb-6">
                        The Minds Behind <br><span class="shimmer-text">The Vision.</span>
                    </h2>
                    <p class="text-gray-500 max-w-xl mx-auto mb-12 font-light text-lg">
                        Meet the experts dedicated to perfecting your brand aesthetics and personal memories.
                    </p>
                    <a href="team.php" class="inline-flex items-center space-x-4 bg-white text-black px-10 py-5 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-blue-500 hover:text-white transition-all">
                        <span>Meet Our Team</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full bg-blue-600/10 blur-[120px]"></div>
            </div>
        </div>
    </section>
</main>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const observerOptions = { 
            threshold: 0.1, 
            rootMargin: '0px 0px -50px 0px' 
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Apply standard reveal
                    entry.target.classList.add('active');
                    
                    // Apply specific scale/opacity transitions for the grid cards
                    if (entry.target.classList.contains('opacity-0')) {
                        entry.target.classList.remove('opacity-0', 'scale-95');
                        entry.target.classList.add('opacity-100', 'scale-100');
                    }
                }
            });
        }, observerOptions);

        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
    });
</script>

<?php include 'includes/footer.php'; ?>