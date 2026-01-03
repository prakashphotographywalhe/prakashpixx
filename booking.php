<?php 
require_once 'db.php'; 
if (session_status() === PHP_SESSION_NONE) { session_start(); }

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'includes/header.php'; 

$photographyPrices = [
    "Wedding Photography & Videography" => 35000,
    "Wedding Photography" => 18000,
    "Pre-Wedding Photography & Videography" => 15000,
    "Pre-Wedding Photography" => 10000,
    "Birthday Shoot" => 5000,
    "Babyshoot" => 4000
];

$graphicsPrices = [
    "Brand Logo Design" => 1000,
    "Social Media Branding" => 500,
    "Business Stationery" => 500,
    "Motion Graphics/Intro" => 1000
];
?>

<style>
    /* Premium Animations */
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .floating-label {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    input:focus + .floating-label,
    input:not(:placeholder-shown) + .floating-label {
        transform: translateY(-2.5rem) scale(0.85);
        color: #2563eb;
    }

    @keyframes pulse-ring {
        0% { transform: scale(0.33); }
        80%, 100% { opacity: 0; }
    }
    
    .status-pulse {
        position: relative;
    }
    .status-pulse::before {
        content: ''; position: absolute; inset: -8px;
        border-radius: 9999px; background: #22c55e;
        animation: pulse-ring 1.25s cubic-bezier(0.455, 0.03, 0.515, 0.955) infinite;
    }

    .shimmer {
        background: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,0.2) 50%, rgba(255,255,255,0) 100%);
        background-size: 200% 100%;
        animation: shimmer 2s infinite;
    }
    @keyframes shimmer { 0% { background-position: -200% 0; } 100% { background-position: 200% 0; } }
</style>

<main class="min-h-screen bg-[#f8fafc] pb-24">
    <div class="bg-[#0f172a] pt-40 pb-32 px-6 relative overflow-hidden">
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-0 -left-20 w-96 h-96 bg-blue-500 rounded-full mix-blend-screen filter blur-[100px] animate-pulse"></div>
            <div class="absolute bottom-0 -right-20 w-96 h-96 bg-green-500 rounded-full mix-blend-screen filter blur-[100px]"></div>
        </div>
        
        <div class="container mx-auto relative z-10 text-center">
            <div class="inline-flex items-center space-x-3 px-4 py-2 bg-white/5 backdrop-blur-md rounded-full border border-white/10 mb-8 stagger-1">
                <span class="status-pulse w-2 h-2 rounded-full bg-green-500"></span>
                <span class="text-[10px] font-black uppercase tracking-[0.4em] text-blue-200">Creative Booking Engine</span>
            </div>
            <h1 class="text-5xl md:text-7xl font-black text-white uppercase tracking-tighter italic leading-none mb-6">
                Start a <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-green-400">Collaboration.</span>
            </h1>
            <p class="text-gray-400 text-lg font-light italic max-w-2xl mx-auto">Photography excellence & high-fidelity graphics. Propose your budget to begin.</p>
        </div>
    </div>

    <div class="container mx-auto px-6 -mt-20 relative z-20">
        <div class="max-w-4xl mx-auto">
            
            <div class="flex bg-white/80 backdrop-blur-md p-2 rounded-[2.5rem] shadow-2xl mb-12 border border-white">
                <button onclick="switchTab('photo')" id="tab-photo" class="flex-1 py-5 rounded-[2rem] font-black text-[11px] uppercase tracking-widest transition-all duration-500 bg-gray-900 text-white shadow-2xl">
                    <i class="fas fa-camera-retro mr-3"></i> Photography
                </button>
                <button onclick="switchTab('graphics')" id="tab-graphics" class="flex-1 py-5 rounded-[2rem] font-black text-[11px] uppercase tracking-widest transition-all duration-500 text-gray-400 hover:text-blue-600">
                    <i class="fas fa-signature mr-3"></i> Graphic Design
                </button>
            </div>

            <div class="glass-card rounded-[4rem] shadow-[0_50px_100px_-20px_rgba(0,0,0,0.15)] overflow-hidden p-10 md:p-24 relative">
                
                <form action="process_booking.php" method="POST" id="bookingForm" class="space-y-16">
                    <input type="hidden" name="booking_type" id="bookingType" value="Photography">

                    <div class="space-y-6">
                        <div class="flex items-center space-x-4 mb-2">
                            <span class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center font-black text-xs">01</span>
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.4em]">Select Service</label>
                        </div>
                        <div class="relative group">
                            <select name="service" id="serviceSelect" required onchange="handleServiceChange()"
                                    class="w-full px-10 py-7 bg-gray-50/50 border border-gray-100 rounded-[2.5rem] focus:ring-4 focus:ring-blue-500/5 outline-none transition-all font-black text-xl text-gray-800 appearance-none cursor-pointer">
                                <option value="" disabled selected>Select from our menu...</option>
                                <optgroup label="Photography" id="opt-photo" class="text-sm">
                                    <?php foreach($photographyPrices as $name => $price): ?>
                                        <option value="<?= $name ?>" data-secret="<?= $price ?>"><?= $name ?></option>
                                    <?php endforeach; ?>
                                </optgroup>
                                <optgroup label="Graphic Design" id="opt-graphics" class="hidden text-sm">
                                    <?php foreach($graphicsPrices as $name => $price): ?>
                                        <option value="<?= $name ?>" data-secret="<?= $price ?>"><?= $name ?></option>
                                    <?php endforeach; ?>
                                </optgroup>
                            </select>
                            <div class="absolute right-10 top-1/2 -translate-y-1/2 pointer-events-none text-blue-500">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                    </div>

                    <div id="brandNameSection" class="hidden space-y-4 animate-fade-in">
                         <div class="flex items-center space-x-4 mb-2">
                            <span class="w-8 h-8 rounded-full bg-purple-600 text-white flex items-center justify-center font-black text-xs">02</span>
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.4em]">Brand Identity</label>
                        </div>
                        <input type="text" name="brand_name" placeholder="Name of your brand/company" 
                               class="w-full px-10 py-7 bg-gray-50 border border-gray-100 rounded-[2.5rem] font-bold text-gray-800 outline-none focus:bg-white transition-all shadow-inner">
                    </div>

                    <div id="budgetSection" class="hidden space-y-8 animate-fade-in">
                        <div class="flex items-center space-x-4">
                            <span class="w-8 h-8 rounded-full bg-green-600 text-white flex items-center justify-center font-black text-xs">03</span>
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-[0.4em]">Proposed Investment (₹)</label>
                        </div>
                        <div class="relative">
                            <span class="absolute left-10 top-1/2 -translate-y-1/2 text-4xl font-black text-gray-200 italic">₹</span>
                            <input type="number" name="client_offer" id="clientOffer" required oninput="startAiNegotiation()" 
                                   placeholder="0.00" 
                                   class="w-full pl-20 pr-10 py-10 bg-gray-50/50 border-none rounded-[3rem] font-black text-5xl text-gray-900 outline-none focus:ring-8 focus:ring-blue-500/5 transition-all">
                        </div>

                        <div id="aiFeedbackBox" class="hidden p-10 rounded-[3rem] border border-gray-100 relative overflow-hidden transition-all duration-700">
                            <div id="shimmer" class="absolute inset-0 shimmer hidden"></div>
                            <div class="flex items-center space-x-8 relative z-10">
                                <div id="aiIcon" class="w-20 h-20 rounded-[2rem] flex items-center justify-center shrink-0 text-white shadow-2xl transition-all duration-500"></div>
                                <div>
                                    <h4 id="aiStatus" class="text-[10px] font-black uppercase tracking-[0.5em] mb-2"></h4>
                                    <p id="aiMessage" class="text-lg font-medium italic text-gray-600 leading-relaxed"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="finalSection" class="hidden space-y-12 animate-fade-in">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-4">
                                <label id="dateLabel" class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4">Expected Date</label>
                                <input type="date" name="date" required class="w-full px-10 py-7 bg-gray-50 border border-gray-100 rounded-[2.5rem] font-black text-gray-800 outline-none">
                            </div>
                            <div class="space-y-4">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4">Creative Brief</label>
                                <textarea name="description" rows="1" placeholder="Describe your vision..." class="w-full px-10 py-7 bg-gray-50 border border-gray-200 rounded-[2.5rem] font-bold text-gray-800 outline-none focus:ring-4 focus:ring-blue-500/5 transition-all"></textarea>
                            </div>
                        </div>

                        <input type="hidden" name="base_price" id="secretPriceInput">
                        
                        <button type="submit" id="submitBtn" class="group relative w-full bg-gray-900 text-white font-black py-10 rounded-[3rem] shadow-[0_20px_50px_rgba(0,0,0,0.2)] hover:bg-blue-600 transition-all duration-700 overflow-hidden">
                            <span class="relative z-10 uppercase tracking-[0.5em] text-xs">Confirm Collaboration Request</span>
                            <div class="absolute inset-0 translate-y-full group-hover:translate-y-0 bg-gradient-to-r from-blue-600 via-indigo-600 to-blue-700 transition-transform duration-700"></div>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</main>

<script>
let negotiationTimeout;

function switchTab(type) {
    const photoTab = document.getElementById('tab-photo');
    const graphicsTab = document.getElementById('tab-graphics');
    const bookingType = document.getElementById('bookingType');
    const photoGroup = document.getElementById('opt-photo');
    const graphicsGroup = document.getElementById('opt-graphics');
    const brandSection = document.getElementById('brandNameSection');
    const dateLabel = document.getElementById('dateLabel');
    const select = document.getElementById('serviceSelect');

    select.selectedIndex = 0;
    document.getElementById('budgetSection').classList.add('hidden');
    document.getElementById('finalSection').classList.add('hidden');

    if (type === 'photo') {
        photoTab.className = "flex-1 py-5 rounded-[2rem] font-black text-[11px] uppercase tracking-widest transition-all bg-gray-900 text-white shadow-2xl";
        graphicsTab.className = "flex-1 py-5 rounded-[2rem] font-black text-[11px] uppercase tracking-widest transition-all text-gray-400 hover:text-blue-600";
        photoGroup.classList.remove('hidden');
        graphicsGroup.classList.add('hidden');
        brandSection.classList.add('hidden');
        bookingType.value = "Photography";
        dateLabel.innerText = "Target Shoot Date";
    } else {
        graphicsTab.className = "flex-1 py-5 rounded-[2rem] font-black text-[11px] uppercase tracking-widest transition-all bg-gray-900 text-white shadow-2xl";
        photoTab.className = "flex-1 py-5 rounded-[2rem] font-black text-[11px] uppercase tracking-widest transition-all text-gray-400 hover:text-blue-600";
        graphicsGroup.classList.remove('hidden');
        photoGroup.classList.add('hidden');
        brandSection.classList.remove('hidden');
        bookingType.value = "Graphics";
        dateLabel.innerText = "Completion Deadline";
    }
}

function handleServiceChange() {
    const select = document.getElementById('serviceSelect');
    const secretPrice = select.options[select.selectedIndex].getAttribute('data-secret');
    document.getElementById('secretPriceInput').value = secretPrice;
    document.getElementById('budgetSection').classList.remove('hidden');
    document.getElementById('clientOffer').value = '';
    document.getElementById('aiFeedbackBox').classList.add('hidden');
    document.getElementById('finalSection').classList.add('hidden');
}

function startAiNegotiation() {
    clearTimeout(negotiationTimeout);
    const feedbackBox = document.getElementById('aiFeedbackBox');
    const shimmer = document.getElementById('shimmer');
    const aiStatus = document.getElementById('aiStatus');
    const aiMessage = document.getElementById('aiMessage');
    const aiIcon = document.getElementById('aiIcon');
    const finalSection = document.getElementById('finalSection');

    feedbackBox.classList.remove('hidden');
    shimmer.classList.remove('hidden');
    aiStatus.innerText = "Consulting System...";
    aiMessage.innerText = "Analyzing project complexity vs proposed investment...";
    aiIcon.className = "w-20 h-20 rounded-[2rem] flex items-center justify-center shrink-0 bg-gray-100 text-gray-400";
    aiIcon.innerHTML = "<i class='fas fa-sync fa-spin text-2xl'></i>";
    finalSection.classList.add('hidden');

    negotiationTimeout = setTimeout(validateSecretPrice, 1500);
}

function validateSecretPrice() {
    const secretLimit = parseFloat(document.getElementById('secretPriceInput').value);
    const clientOffer = parseFloat(document.getElementById('clientOffer').value);
    const feedbackBox = document.getElementById('aiFeedbackBox');
    const shimmer = document.getElementById('shimmer');
    const aiMessage = document.getElementById('aiMessage');
    const aiStatus = document.getElementById('aiStatus');
    const aiIcon = document.getElementById('aiIcon');
    const finalSection = document.getElementById('finalSection');

    shimmer.classList.add('hidden');

    if (!clientOffer) { feedbackBox.classList.add('hidden'); return; }

    if (clientOffer < secretLimit) {
        feedbackBox.className = "p-10 rounded-[3rem] border-2 border-red-50 bg-red-50/50 text-red-700 animate-shake relative overflow-hidden";
        aiIcon.className = "w-20 h-20 bg-red-600 rounded-[2.5rem] flex items-center justify-center shrink-0 text-white shadow-xl rotate-12";
        aiIcon.innerHTML = "<i class='fas fa-robot text-3xl'></i>";
        aiStatus.innerText = "Efficiency Alert";
        aiMessage.innerHTML = "To maintain our studio's high-fidelity output, we cannot accept projects below this tier. Please adjust your proposal.";
    } else {
        finalSection.classList.remove('hidden');
        feedbackBox.className = "p-10 rounded-[3rem] border-2 border-green-50 bg-green-50/50 text-green-700 relative overflow-hidden";
        aiIcon.className = "w-20 h-20 bg-green-500 rounded-[2.5rem] flex items-center justify-center shrink-0 text-white shadow-xl -rotate-6";
        aiIcon.innerHTML = "<i class='fas fa-check-circle text-3xl'></i>";
        aiStatus.innerText = "Value Match";
        aiMessage.innerHTML = "This aligns with our creative standards. Proceed to finalize your briefing.";
    }
}
</script>

<style>
@keyframes shake { 0%, 100% {transform: translateX(0);} 25% {transform: translateX(-10px);} 75% {transform: translateX(10px);} }
.animate-shake { animation: shake 0.5s ease-in-out; }
.animate-fade-in { animation: fadeIn 0.8s ease-out forwards; }
@keyframes fadeIn { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
</style>

<?php include 'includes/footer.php'; ?>