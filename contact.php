<?php 
require_once 'db.php'; 
include 'includes/header.php'; 
?>

<style>
    /* Premium Animation Keyframes */
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }
    
    .stagger-reveal {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.8s cubic-bezier(0.2, 1, 0.2, 1);
    }
    
    .stagger-reveal.active {
        opacity: 1;
        transform: translateY(0);
    }

    .input-group:focus-within label {
        color: #166534;
        transform: translateX(5px);
    }

    .glass-sidebar {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.4);
    }

    .pulse-green {
        box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.4);
        animation: pulse-green 2s infinite;
    }
    @keyframes pulse-green {
        0% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.4); }
        70% { box-shadow: 0 0 0 15px rgba(34, 197, 94, 0); }
        100% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
    }
</style>

<main class="min-h-screen bg-[#fcfcfc] pb-24 overflow-hidden">
    <div class="bg-[#0a0a0a] pt-44 pb-40 px-6 text-center relative overflow-hidden">
        <div class="relative z-10">
            <span class="inline-block px-4 py-1.5 bg-white/5 border border-white/10 text-blue-400 text-[10px] font-black uppercase tracking-[0.4em] rounded-full mb-6 stagger-reveal">
                Available for Worldwide Commissions
            </span>
            <h1 class="text-5xl md:text-8xl font-black text-white mb-6 uppercase tracking-tighter italic leading-none stagger-reveal" style="transition-delay: 100ms">
                Let's <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-400 via-blue-500 to-indigo-500">Connect.</span>
            </h1>
            <p class="text-gray-500 font-light italic max-w-2xl mx-auto text-lg stagger-reveal" style="transition-delay: 200ms">
                Whether it's a cinematic wedding shoot or a high-fidelity brand identity, your journey starts with a single message.
            </p>
        </div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-green-600/10 rounded-full filter blur-[120px] animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-600/10 rounded-full filter blur-[100px]"></div>
    </div>

    <div class="container mx-auto px-6 -mt-24 relative z-20">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col lg:flex-row gap-8">
                
                <div class="lg:w-1/3 space-y-6 stagger-reveal" style="transition-delay: 300ms">
                    <a href="https://wa.me/919665135730" class="block bg-white p-8 rounded-[3rem] shadow-2xl border border-gray-100 group transition-all hover:border-green-500">
                        <div class="flex items-center justify-between mb-8">
                            <div class="w-14 h-14 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center pulse-green group-hover:bg-green-600 group-hover:text-white transition-all duration-500">
                                <i class="fab fa-whatsapp text-2xl"></i>
                            </div>
                            <i class="fas fa-external-link-alt text-gray-200 text-xs group-hover:text-green-500"></i>
                        </div>
                        <h3 class="text-gray-400 text-[9px] font-black uppercase tracking-widest mb-1">Direct Line</h3>
                        <p class="text-2xl font-black text-gray-900 tracking-tighter italic">+91 9665135730</p>
                    </a>

                    <div class="bg-white p-8 rounded-[3rem] shadow-2xl border border-gray-100 group transition-all hover:border-blue-500">
                        <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-blue-600 group-hover:text-white transition-all duration-500">
                            <i class="far fa-envelope text-2xl"></i>
                        </div>
                        <h3 class="text-gray-400 text-[9px] font-black uppercase tracking-widest mb-1">Email Studio</h3>
                        <p class="text-lg font-black text-gray-900 break-all italic">prakashphotography45@gmail.com</p>
                    </div>

                    <div class="bg-[#0a0a0a] p-10 rounded-[3.5rem] shadow-2xl text-white relative overflow-hidden group">
                        <h3 class="text-gray-600 text-[9px] font-black uppercase tracking-[0.4em] mb-10 text-center">Digital Footprint</h3>
                        <div class="flex justify-around items-center relative z-10">
                            <a href="https://www.instagram.com/prakash_photography_8" class="text-2xl hover:text-pink-500 transition-all hover:-translate-y-2"><i class="fab fa-instagram"></i></a>
                            <a href="https://www.facebook.com/share/1BBpeg26ED/" class="text-2xl hover:text-blue-600 transition-all hover:-translate-y-2"><i class="fab fa-facebook-f"></i></a>
                            <a href="https://x.com/ganraj_dharkar" class="text-2xl hover:text-white transition-all hover:-translate-y-2"><i class="fab fa-x-twitter"></i></a>
                        </div>
                        <i class="fas fa-camera absolute -bottom-6 -right-6 text-7xl text-white/[0.03] rotate-12"></i>
                    </div>
                </div>

                <div class="lg:w-2/3 bg-white p-10 lg:p-20 rounded-[4rem] shadow-[0_50px_100px_-20px_rgba(0,0,0,0.1)] border border-white stagger-reveal" style="transition-delay: 400ms">
                    <form action="send_message.php" method="POST" class="space-y-10">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            <div class="space-y-3 input-group">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4 transition-all">Identity</label>
                                <input type="text" name="name" required placeholder="Full Name" 
                                       class="w-full px-8 py-6 bg-gray-50 border-none rounded-[2rem] focus:ring-4 focus:ring-green-500/5 outline-none transition-all font-bold text-gray-800 placeholder:text-gray-300">
                            </div>
                            <div class="space-y-3 input-group">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4 transition-all">Digital Mail</label>
                                <input type="email" name="email" required placeholder="Email Address" 
                                       class="w-full px-8 py-6 bg-gray-50 border-none rounded-[2rem] focus:ring-4 focus:ring-blue-500/5 outline-none transition-all font-bold text-gray-800 placeholder:text-gray-300">
                            </div>
                        </div>

                        <div class="space-y-3 input-group">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4 transition-all">Context</label>
                            <input type="text" name="subject" placeholder="What are we creating?" 
                                   class="w-full px-8 py-6 bg-gray-50 border-none rounded-[2rem] focus:ring-4 focus:ring-green-500/5 outline-none transition-all font-bold text-gray-800 placeholder:text-gray-300">
                        </div>

                        <div class="space-y-3 input-group">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4 transition-all">The Brief</label>
                            <textarea name="message" rows="5" required placeholder="Tell me your story or project requirements..." 
                                      class="w-full px-8 py-6 bg-gray-50 border-none rounded-[2.5rem] focus:ring-4 focus:ring-green-500/5 outline-none transition-all font-bold text-gray-800 placeholder:text-gray-300"></textarea>
                        </div>

                        <button type="submit" 
                                class="group relative w-full bg-gray-900 text-white font-black py-8 rounded-[2.5rem] shadow-2xl overflow-hidden transition-all active:scale-95">
                            <span class="relative z-10 flex items-center justify-center uppercase tracking-[0.4em] text-[10px]">
                                Dispatch Inquiry <i class="far fa-paper-plane ml-3 transition-transform group-hover:translate-x-2 group-hover:-translate-y-1"></i>
                            </span>
                            <div class="absolute inset-0 bg-gradient-to-r from-green-600 via-blue-600 to-indigo-600 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</main>

<script>
    // Reveal Observer for staggered animations
    document.addEventListener("DOMContentLoaded", () => {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.stagger-reveal').forEach(el => observer.observe(el));
    });
</script>

<?php include 'includes/footer.php'; ?>