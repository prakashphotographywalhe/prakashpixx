<?php include 'includes/header.php'; ?>

<main class="min-h-screen bg-white overflow-hidden">
    <section class="relative py-24 md:py-32 overflow-hidden">
        <div class="absolute top-20 left-10 w-64 h-64 bg-blue-200/30 rounded-full filter blur-3xl animate-pulse"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-purple-200/20 rounded-full filter blur-3xl"></div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="flex flex-col md:flex-row items-center gap-16 lg:gap-24">
                
                <div class="md:w-1/2 relative reveal-left">
                    <div class="absolute -top-6 -left-6 w-32 h-32 border-l-4 border-t-4 border-blue-600/30 rounded-tl-3xl"></div>
                    <div class="absolute -bottom-6 -right-6 w-32 h-32 border-r-4 border-b-4 border-purple-600/30 rounded-br-3xl"></div>
                    
                    <div class="relative overflow-hidden rounded-[3rem] shadow-2xl group">
                        <img src="assets/images/images.jpg" alt="Prakash - Photographer & Designer" 
                             class="w-full h-full object-cover transform scale-105 group-hover:scale-110 transition-transform duration-1000">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end p-10">
                            <p class="text-white text-sm font-light italic">"Precision in every pixel, emotion in every frame."</p>
                        </div>
                    </div>
                </div>

                <div class="md:w-1/2 space-y-8 reveal-right">
                    <div class="inline-flex items-center space-x-3 px-4 py-2 bg-gray-100 rounded-full">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                        </span>
                        <span class="text-[10px] font-black uppercase tracking-[0.4em] text-gray-500">Creative Director</span>
                    </div>
                    
                    <h1 class="text-5xl md:text-7xl font-black text-gray-900 leading-[0.9] tracking-tighter uppercase italic">
                        Visual <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-purple-600 to-emerald-600">Alchemist.</span>
                    </h1>
                    
                    <p class="text-gray-600 text-lg leading-relaxed font-light">
                        Hi, I'm <span class="font-bold text-gray-900 uppercase tracking-tighter">Ganraj (Lead Photographer & Owner)</span>. I bridge the gap between <span class="text-blue-600 font-semibold italic uppercase tracking-tighter">Cinematic Photography</span> and <span class="text-purple-600 font-semibold italic uppercase tracking-tighter">Modern Graphic Design</span>. At <span class="text-gray-900 font-black italic">PRAKASH PIX</span>, we don't just take photos; we build brand identities.
                    </p>
                    
                    <div class="grid grid-cols-2 gap-4 pt-4">
                        <div class="p-6 bg-white border border-gray-100 rounded-3xl shadow-xl shadow-gray-100/50 transform hover:-translate-y-2 transition-transform">
                            <h3 class="text-3xl font-black text-gray-900">500<span class="text-blue-500">+</span></h3>
                            <p class="text-[9px] text-gray-400 font-black uppercase tracking-widest mt-1">Master Shoots</p>
                        </div>
                        <div class="p-6 bg-white border border-gray-100 rounded-3xl shadow-xl shadow-gray-100/50 transform hover:-translate-y-2 transition-transform">
                            <h3 class="text-3xl font-black text-gray-900">10<span class="text-purple-500">+</span></h3>
                            <p class="text-[9px] text-gray-400 font-black uppercase tracking-widest mt-1">Years Crafting</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-[#0a0a0a] py-24 md:py-32 relative overflow-hidden">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full bg-blue-600/5 blur-[120px]"></div>
        <i class="fas fa-camera absolute top-20 left-10 text-white/[0.02] text-[15rem] -rotate-12"></i>
        <i class="fas fa-pen-nib absolute bottom-20 right-10 text-white/[0.02] text-[15rem] rotate-12"></i>

        <div class="container mx-auto px-6 relative z-10 text-center">
            <h2 class="text-xs font-black text-blue-500 uppercase tracking-[0.5em] mb-4 reveal-up">Our DNA</h2>
            <h3 class="text-4xl md:text-5xl font-black text-white uppercase tracking-tighter italic mb-20 reveal-up">Creative Philosophy</h3>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="group p-10 bg-white/[0.02] backdrop-blur-xl rounded-[3rem] border border-white/5 hover:border-blue-500/30 transition-all duration-500 reveal-up" style="transition-delay: 0.1s">
                    <div class="w-16 h-16 bg-blue-500/10 rounded-2xl flex items-center justify-center mb-8 mx-auto group-hover:scale-110 group-hover:rotate-6 transition-transform">
                        <i class="fas fa-leaf text-2xl text-blue-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-4 uppercase tracking-widest italic">Natural Soul</h3>
                    <p class="text-gray-500 text-sm leading-relaxed font-light italic">Authentic emotions captured with minimal interference through the lens of PRAKASH PIX.</p>
                </div>
                
                <div class="group p-10 bg-white/[0.02] backdrop-blur-xl rounded-[3rem] border border-white/5 hover:border-purple-500/30 transition-all duration-500 reveal-up" style="transition-delay: 0.2s">
                    <div class="w-16 h-16 bg-purple-500/10 rounded-2xl flex items-center justify-center mb-8 mx-auto group-hover:scale-110 group-hover:-rotate-6 transition-transform">
                        <i class="fas fa-fingerprint text-2xl text-purple-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-4 uppercase tracking-widest italic">Brand Logic</h3>
                    <p class="text-gray-500 text-sm leading-relaxed font-light italic">Creating scalable and modern visual identities that define your professional legacy.</p>
                </div>
                
                <div class="group p-10 bg-white/[0.02] backdrop-blur-xl rounded-[3rem] border border-white/5 hover:border-emerald-500/30 transition-all duration-500 reveal-up" style="transition-delay: 0.3s">
                    <div class="w-16 h-16 bg-emerald-500/10 rounded-2xl flex items-center justify-center mb-8 mx-auto group-hover:scale-110 group-hover:rotate-6 transition-transform">
                        <i class="fas fa-microchip text-2xl text-emerald-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-4 uppercase tracking-widest italic">Hybrid Flow</h3>
                    <p class="text-gray-500 text-sm leading-relaxed font-light italic">The perfect intersection of high-end cinematography and technical graphic precision.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24 bg-gray-50 relative overflow-hidden">
        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center mb-16 reveal-up">
                <h2 class="text-xs font-black text-blue-600 uppercase tracking-[0.5em] mb-4">Voices of Excellence</h2>
                <h3 class="text-4xl md:text-5xl font-black text-gray-900 uppercase tracking-tighter italic">Client Stories</h3>
            </div>

            <div class="max-w-4xl mx-auto">
                <div class="relative bg-white p-10 md:p-16 rounded-[4rem] shadow-2xl shadow-gray-200/50 border border-gray-100 reveal-up">
                    <i class="fas fa-quote-left absolute top-10 left-10 text-5xl text-gray-100"></i>
                    
                    <div id="testimonial-container" class="relative z-10 text-center transition-opacity duration-300">
                        <p id="testimonial-text" class="text-xl md:text-2xl text-gray-600 font-light italic leading-relaxed mb-8">
                            "Prakash Pix transformed our brand identity into something truly cinematic. The attention to detail is unmatched."
                        </p>
                        <h4 id="testimonial-author" class="text-lg font-black text-gray-900 uppercase tracking-widest italic">Anjali Sharma</h4>
                        <p id="testimonial-role" class="text-[10px] text-blue-500 font-bold uppercase tracking-[0.3em]">Creative Lead, Nexus Media</p>
                    </div>

                    <div class="flex justify-center space-x-3 mt-10">
                        <button onclick="changeTestimonial(0)" class="w-3 h-3 rounded-full bg-blue-600 transition-all" id="dot-0"></button>
                        <button onclick="changeTestimonial(1)" class="w-3 h-3 rounded-full bg-gray-200 transition-all" id="dot-1"></button>
                        <button onclick="changeTestimonial(2)" class="w-3 h-3 rounded-full bg-gray-200 transition-all" id="dot-2"></button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <button id="backToTop" class="fixed bottom-10 right-10 w-14 h-14 bg-black text-white rounded-2xl shadow-2xl flex items-center justify-center translate-y-24 opacity-0 transition-all duration-500 hover:bg-blue-600 z-[90]">
        <i class="fas fa-arrow-up"></i>
    </button>
</main>

<script>
    // Animations
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) entry.target.classList.add('active');
        });
    }, { threshold: 0.15 });

    document.querySelectorAll('.reveal-left, .reveal-right, .reveal-up').forEach(el => observer.observe(el));

    // Testimonials
    const testimonials = [
        { text: "Prakash Pix transformed our brand identity into something truly cinematic. The attention to detail is unmatched.", author: "Shivanjali Gaikwad-Nigade", role: "Bride" },
        { text: "The wedding shots captured the soul of our special day. Every frame felt like a movie still.", author: "Rahul DeAvinash Rathod", role: "Groom & IT Expert" },
        { text: "Reliable, technical, and artistic. They delivered a complete branding package that put our startup on the map.", author: "SWorabh Pawar", role: "Farmer" }
    ];

    function changeTestimonial(index) {
        const textEl = document.getElementById('testimonial-text');
        const authorEl = document.getElementById('testimonial-author');
        const roleEl = document.getElementById('testimonial-role');
        const container = document.getElementById('testimonial-container');
        
        container.style.opacity = 0;
        setTimeout(() => {
            textEl.innerText = `"${testimonials[index].text}"`;
            authorEl.innerText = testimonials[index].author;
            roleEl.innerText = testimonials[index].role;
            container.style.opacity = 1;
            for (let i = 0; i < 3; i++) document.getElementById(`dot-${i}`).classList.replace('bg-blue-600', 'bg-gray-200');
            document.getElementById(`dot-${index}`).classList.replace('bg-gray-200', 'bg-blue-600');
        }, 300);
    }

    // Scroll Logic
    const btt = document.getElementById('backToTop');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 500) btt.classList.remove('translate-y-24', 'opacity-0');
        else btt.classList.add('translate-y-24', 'opacity-0');
    });
    btt.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
</script>

<style>
    html { scroll-behavior: smooth; }
    .reveal-left { opacity: 0; transform: translateX(-50px); transition: all 1s cubic-bezier(0.16, 1, 0.3, 1); }
    .reveal-right { opacity: 0; transform: translateX(50px); transition: all 1s cubic-bezier(0.16, 1, 0.3, 1); }
    .reveal-up { opacity: 0; transform: translateY(50px); transition: all 1s cubic-bezier(0.16, 1, 0.3, 1); }
    .active { opacity: 1 !important; transform: translate(0) !important; }
</style>

<?php include 'includes/footer.php'; ?>