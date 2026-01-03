<?php 
// 1. DATABASE & SECURITY FIRST
require_once 'db.php'; 

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// 2. CATEGORY FILTER LOGIC
$filter = $_GET['category'] ?? 'All';

// 3. FETCH DATA & ANALYTICS
$total_photos = $pdo->query("SELECT count(*) FROM photos")->fetchColumn();
$pending_bookings = $pdo->query("SELECT count(*) FROM appointments WHERE status = 'Pending'")->fetchColumn();
$active_projects = $pdo->query("SELECT count(*) FROM appointments WHERE status = 'Approved'")->fetchColumn();

// NEW: Fetch Pending Applications for Recruitment Node
$pending_apps = $pdo->query("SELECT count(*) FROM applications WHERE status = 'pending'")->fetchColumn();

$revenue_query = $pdo->query("SELECT SUM(price) FROM appointments WHERE status = 'Approved'")->fetchColumn();
$total_revenue = $revenue_query ? $revenue_query : 0;

include 'includes/header.php'; 
?>

<style>
    /* Premium Admin Animations */
    @keyframes slideIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .stagger-item { opacity: 0; animation: slideIn 0.8s cubic-bezier(0.2, 1, 0.2, 1) forwards; }
    
    .glass-nav {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .admin-card { transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
    .admin-card:hover { transform: translateY(-5px); box-shadow: 0 40px 80px -20px rgba(0,0,0,0.1); }
</style>

<main class="min-h-screen bg-[#f8fafc] pb-32">
    <div class="bg-[#0a0a0a] pt-40 pb-44 px-6 relative overflow-hidden">
        <div class="container mx-auto relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-end gap-8">
                <div class="stagger-item" style="animation-delay: 0.1s">
                    <div class="flex items-center space-x-3 mb-6">
                        <span class="flex h-3 w-3 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                        </span>
                        <span class="text-[10px] font-black text-emerald-500 uppercase tracking-[0.5em]" id="live-clock">00:00:00 // SYSTEM ACTIVE</span>
                    </div>
                    <h1 class="text-6xl md:text-8xl font-black text-white uppercase tracking-tighter italic leading-none">
                        Studio <span class="text-blue-600">Command.</span>
                    </h1>
                </div>

                <div class="flex glass-nav p-1.5 rounded-[2rem] stagger-item" style="animation-delay: 0.2s">
                    <a href="admin.php?category=All" class="px-8 py-3 rounded-full text-[10px] font-black uppercase tracking-widest transition-all <?= $filter === 'All' ? 'bg-white text-black shadow-2xl' : 'text-gray-500 hover:text-white' ?>">All Briefs</a>
                    <a href="admin_applicants.php" class="px-8 py-3 rounded-full text-[10px] font-black uppercase tracking-widest transition-all text-emerald-400 hover:text-white flex items-center">
                        <i class="fas fa-user-plus mr-2"></i> Applicants (<?= $pending_apps ?>)
                    </a>
                </div>
            </div>
        </div>
        <i class="fas fa-terminal absolute -bottom-16 -right-16 text-[25rem] text-white/[0.02] rotate-12"></i>
    </div>

    <div class="container mx-auto px-6 -mt-24 relative z-20">
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 md:gap-8 mb-16">
            <div class="bg-white p-6 md:p-10 rounded-[2.5rem] md:rounded-[3rem] shadow-xl admin-card stagger-item" style="animation-delay: 0.3s">
                <p class="text-[7px] md:text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2">Revenue</p>
                <h3 class="text-xl md:text-4xl font-black text-gray-900 italic tracking-tighter">₹<?= number_format($total_revenue) ?></h3>
            </div>
            <div class="bg-white p-6 md:p-10 rounded-[2.5rem] md:rounded-[3rem] shadow-xl admin-card stagger-item" style="animation-delay: 0.4s">
                <p class="text-[7px] md:text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2">Deals</p>
                <h3 class="text-xl md:text-4xl font-black text-amber-500 italic tracking-tighter"><?= $pending_bookings ?></h3>
            </div>
            <div class="bg-white p-6 md:p-10 rounded-[2.5rem] md:rounded-[3rem] shadow-xl admin-card stagger-item" style="animation-delay: 0.5s">
                <p class="text-[7px] md:text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2">Shoots</p>
                <h3 class="text-xl md:text-4xl font-black text-blue-600 italic tracking-tighter"><?= $active_projects ?></h3>
            </div>
            <div class="bg-white p-6 md:p-10 rounded-[2.5rem] md:rounded-[3rem] shadow-xl admin-card stagger-item" style="animation-delay: 0.6s">
                <p class="text-[7px] md:text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2">Applicants</p>
                <h3 class="text-xl md:text-4xl font-black text-emerald-500 italic tracking-tighter"><?= $pending_apps ?></h3>
            </div>
            <div class="bg-white p-6 md:p-10 rounded-[2.5rem] md:rounded-[3rem] shadow-xl admin-card stagger-item" style="animation-delay: 0.7s">
                <p class="text-[7px] md:text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2">Assets</p>
                <h3 class="text-xl md:text-4xl font-black text-gray-900 italic tracking-tighter"><?= $total_photos ?></h3>
            </div>
        </div>

        <div class="grid lg:grid-cols-5 gap-12">
            <?php if ($pending_apps > 0): ?>
            <div class="lg:col-span-5 stagger-item" style="animation-delay: 0.2s">
                <div class="bg-gradient-to-r from-emerald-500 to-teal-600 p-8 rounded-[3rem] text-white flex justify-between items-center shadow-2xl">
                    <div>
                        <h4 class="font-black italic uppercase tracking-widest">Talent Node Alert</h4>
                        <p class="text-xs opacity-80"><?= $pending_apps ?> new creators are requesting to join the collective.</p>
                    </div>
                    <a href="admin_applicants.php" class="bg-white text-emerald-600 px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-xl hover:scale-105 transition-transform">Review Nodes</a>
                </div>
            </div>
            <?php endif; ?>

            <div class="lg:col-span-2 stagger-item" style="animation-delay: 0.8s">
                <section class="bg-white p-12 rounded-[4rem] shadow-2xl sticky top-32 border border-gray-50">
                    <h2 class="text-2xl font-black uppercase italic tracking-tighter mb-10"><i class="fas fa-cloud-upload-alt mr-3 text-blue-600"></i> Sync Assets</h2>
                    <form action="upload_photo.php" method="POST" enctype="multipart/form-data" class="space-y-8">
                        <div class="space-y-2">
                            <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest ml-4">Portfolio Title</label>
                            <input type="text" name="title" required class="w-full px-8 py-5 bg-gray-50 rounded-2xl border-none outline-none focus:ring-4 focus:ring-blue-500/10 font-bold">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[9px] font-black text-gray-400 uppercase tracking-widest ml-4">Classification</label>
                            <select name="category" class="w-full px-8 py-5 bg-gray-50 rounded-2xl border-none outline-none font-bold appearance-none">
                                <option value="Photography">Cinematic Photo</option>
                                <option value="Graphics">Visual Graphics</option>
                            </select>
                        </div>
                        <div class="relative py-14 border-2 border-dashed border-gray-100 rounded-[2.5rem] flex flex-col items-center justify-center group cursor-pointer hover:border-blue-500 transition-all">
                            <i class="fas fa-image text-3xl text-gray-200 group-hover:text-blue-500 mb-4"></i>
                            <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Drop Master File</span>
                            <input type="file" name="image" required class="absolute inset-0 opacity-0 cursor-pointer">
                        </div>
                        <button class="w-full py-6 bg-blue-600 text-white rounded-2xl font-black uppercase tracking-[0.4em] text-[10px] hover:bg-black transition-all shadow-xl">Push to Live</button>
                    </form>
                </section>
            </div>

            <div class="lg:col-span-3 space-y-16 stagger-item" style="animation-delay: 0.9s">
                <div>
                    <h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.5em] ml-6 mb-8 italic">Incoming Briefs</h3>
                    <div class="space-y-6">
                        <?php
                        $sql = "SELECT a.*, u.name, u.email FROM appointments a JOIN users u ON a.user_id = u.id WHERE status = 'Pending'";
                        if($filter === 'Photography') $sql .= " AND (brand_name IS NULL OR brand_name = '')";
                        elseif($filter === 'Graphics') $sql .= " AND brand_name IS NOT NULL AND brand_name != ''";
                        $sql .= " ORDER BY a.date ASC";
                        $bookings = $pdo->query($sql)->fetchAll();

                        if(empty($bookings)) echo '<p class="text-center py-10 text-gray-300 font-bold uppercase text-[10px] tracking-widest">No pending briefs found.</p>';

                        foreach($bookings as $book): ?>
                            <div class="bg-white p-10 rounded-[4rem] shadow-xl border border-gray-50 group transition-all">
                                <div class="flex flex-col xl:flex-row justify-between gap-8">
                                    <div class="flex-1">
                                        <span class="px-4 py-1 bg-<?= empty($book['brand_name']) ? 'green' : 'blue' ?>-50 text-<?= empty($book['brand_name']) ? 'green' : 'blue' ?>-600 rounded-full text-[8px] font-black uppercase tracking-widest mb-4 inline-block">
                                            <?= empty($book['brand_name']) ? 'Photography' : 'Graphic Identity' ?>
                                        </span>
                                        <h4 class="text-3xl font-black italic uppercase tracking-tighter text-gray-900 mb-2"><?= htmlspecialchars($book['name']) ?></h4>
                                        <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest"><i class="far fa-calendar-alt mr-2 text-blue-500"></i> <?= date('d M, Y', strtotime($book['date'])) ?> — <?= $book['service'] ?></p>
                                        <div class="mt-6 p-6 bg-gray-50 rounded-3xl text-sm italic text-gray-600 font-medium">"<?= htmlspecialchars($book['description']) ?>"</div>
                                    </div>

                                    <div class="w-full xl:w-72 space-y-4">
                                        <div class="p-6 bg-blue-50/50 rounded-3xl border border-blue-100">
                                            <p class="text-[9px] font-black text-blue-400 uppercase tracking-widest mb-3 italic text-center">Offer: ₹<?= number_format($book['client_offer']) ?></p>
                                            <form action="update_appointment.php" method="POST" class="space-y-3">
                                                <input type="number" name="price" value="<?= $book['client_offer'] ?>" class="w-full px-5 py-3 rounded-xl border-none outline-none font-black text-sm text-center">
                                                <input type="hidden" name="appointment_id" value="<?= $book['id'] ?>">
                                                <input type="hidden" name="action" value="approve">
                                                <button class="w-full py-4 bg-gray-900 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-emerald-600 transition-colors">Accept Deal</button>
                                                <button type="submit" name="action" value="reject" class="w-full py-2 text-red-500 font-black text-[9px] uppercase tracking-widest hover:text-red-700">Decline</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div>
                    <h3 class="text-xs font-black text-blue-500 uppercase tracking-[0.5em] ml-6 mb-8 italic">Delivery Node</h3>
                    <div class="space-y-4">
                        <?php
                        $active_stmt = $pdo->query("SELECT a.*, u.name FROM appointments a JOIN users u ON a.user_id = u.id WHERE status = 'Approved' ORDER BY date DESC");
                        while($active = $active_stmt->fetch()): ?>
                            <div class="bg-gray-900 p-8 rounded-[3rem] text-white flex flex-col md:flex-row justify-between items-center gap-8 shadow-2xl border border-white/5">
                                <div>
                                    <h4 class="text-xl font-black uppercase tracking-tighter italic leading-none mb-1"><?= $active['name'] ?></h4>
                                    <p class="text-gray-500 text-[8px] font-bold uppercase tracking-widest"><?= $active['service'] ?></p>
                                </div>
                                <form action="update_cloud_link.php" method="POST" class="flex-1 flex gap-4 w-full md:w-auto">
                                    <input type="hidden" name="id" value="<?= $active['id'] ?>">
                                    <div class="relative flex-1">
                                        <i class="fas fa-link absolute left-5 top-1/2 -translate-y-1/2 text-gray-600"></i>
                                        <input type="url" name="cloud_link" value="<?= $active['cloud_link'] ?>" placeholder="Paste Cloud Link..." 
                                               class="w-full pl-12 pr-6 py-4 bg-white/5 border border-white/10 rounded-2xl outline-none focus:border-blue-500 text-sm font-bold placeholder:text-gray-700">
                                    </div>
                                    <button class="px-8 py-4 bg-blue-600 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-white hover:text-black transition-all">Sync</button>
                                </form>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php if (isset($_GET['msg'])): ?>
<div id="toast-node" class="fixed bottom-10 right-10 z-[200] transform translate-y-20 opacity-0 transition-all duration-700">
    <div class="bg-black/90 backdrop-blur-2xl border border-white/10 p-6 rounded-[2.5rem] shadow-2xl flex items-center space-x-6">
        <div class="w-12 h-12 rounded-2xl flex items-center justify-center <?= $_GET['type'] === 'success' ? 'bg-emerald-500' : ($_GET['type'] === 'warning' ? 'bg-amber-500' : 'bg-red-500') ?> text-white shadow-lg">
            <i class="fas <?= $_GET['type'] === 'success' ? 'fa-check-double' : 'fa-exclamation-triangle' ?>"></i>
        </div>
        <div>
            <p class="text-[8px] font-black text-gray-500 uppercase tracking-[0.4em] mb-1">System Update</p>
            <p class="text-xs font-bold text-white italic"><?= htmlspecialchars($_GET['msg']) ?></p>
        </div>
        <button onclick="document.getElementById('toast-node').classList.add('opacity-0')" class="text-gray-600 hover:text-white transition-colors pl-4">
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>
<script>
    setTimeout(() => {
        const toast = document.getElementById('toast-node');
        toast.classList.remove('translate-y-20', 'opacity-0');
        toast.classList.add('translate-y-0', 'opacity-100');
        setTimeout(() => { toast.classList.add('opacity-0', 'translate-x-10'); }, 5000);
    }, 300);
</script>
<?php endif; ?>

<script>
    function updateClock() {
        const now = new Date();
        const time = now.getHours().toString().padStart(2, '0') + ":" + 
                     now.getMinutes().toString().padStart(2, '0') + ":" + 
                     now.getSeconds().toString().padStart(2, '0');
        document.getElementById('live-clock').innerText = time + " // SYSTEM ACTIVE";
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>

<?php include 'includes/footer.php'; ?>