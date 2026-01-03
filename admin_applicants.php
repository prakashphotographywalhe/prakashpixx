<?php
// 1. DATABASE & SECURITY ENGINE
require_once 'db.php'; 

// Ensure only authorized admin nodes can access this terminal
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// 2. APPROVAL/REJECTION LOGIC
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $app_id = (int)$_POST['app_id'];
    $status = ($_POST['action'] === 'approve') ? 'approved' : 'rejected';
    
    try {
        $stmt = $pdo->prepare("UPDATE applications SET status = ? WHERE id = ?");
        $stmt->execute([$status, $app_id]);
        header("Location: admin_applicants.php?msg=Node Status Updated&type=success");
        exit();
    } catch (PDOException $e) {
        error_log("Approval Error: " . $e->getMessage());
    }
}

// 3. FETCH PENDING NODES
$pending_apps = $pdo->query("SELECT * FROM applications WHERE status = 'pending' ORDER BY created_at DESC")->fetchAll();

include 'includes/header.php'; 
?>

<style>
    body { background: #050505; color: white; }
    .glass-card {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.4s cubic-bezier(0.2, 1, 0.2, 1);
    }
    .glass-card:hover { 
        border-color: #2563eb; 
        transform: translateY(-5px); 
        background: rgba(255, 255, 255, 0.05);
    }
    .btn-approve { background: rgba(16, 185, 129, 0.1); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.2); }
    .btn-approve:hover { background: #10b981; color: white; }
    .btn-reject { background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); }
    .btn-reject:hover { background: #ef4444; color: white; }
</style>

<main class="min-h-screen pt-40 pb-20 px-6">
    <div class="container mx-auto">
        <header class="mb-16 stagger-item">
            <h1 class="logo-font text-4xl font-bold bg-gradient-to-r from-blue-500 to-emerald-400 bg-clip-text text-transparent inline-block">
                TALENT NODES
            </h1>
            <p class="text-[10px] font-black text-gray-500 uppercase tracking-[0.5em] mt-4 italic">Reviewing Incoming Creative Intelligence</p>
        </header>

        <?php if (empty($pending_apps)): ?>
            <div class="glass-card p-20 text-center rounded-[3rem]">
                <i class="fas fa-satellite-dish text-5xl text-gray-800 mb-6 animate-pulse"></i>
                <p class="text-xs font-black text-gray-500 uppercase tracking-widest">No pending applications detected in current cycle.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($pending_apps as $app): ?>
                    <div class="glass-card p-8 rounded-[3rem] flex flex-col h-full">
                        <div class="relative mb-6 group overflow-hidden rounded-2xl">
                            <img src="<?= htmlspecialchars($app['image_path']) ?>" 
                                 class="w-full h-64 object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute top-4 right-4 px-4 py-1 bg-black/50 backdrop-blur-md rounded-full">
                                <span class="text-[8px] font-black uppercase text-white tracking-widest"><?= $app['skill'] ?></span>
                            </div>
                        </div>
                        
                        <h3 class="text-2xl font-black uppercase tracking-tighter mb-2"><?= htmlspecialchars($app['name']) ?></h3>
                        <p class="text-gray-500 text-sm mb-6 flex-grow italic leading-relaxed">"<?= htmlspecialchars($app['bio']) ?>"</p>

                        <div class="grid grid-cols-2 gap-4 mt-auto">
                            <form method="POST">
                                <input type="hidden" name="app_id" value="<?= $app['id'] ?>">
                                <button name="action" value="approve" class="w-full py-4 rounded-xl text-[10px] font-black uppercase tracking-widest btn-approve transition-all">
                                    Approve
                                </button>
                            </form>
                            <form method="POST">
                                <input type="hidden" name="app_id" value="<?= $app['id'] ?>">
                                <button name="action" value="reject" class="w-full py-4 rounded-xl text-[10px] font-black uppercase tracking-widest btn-reject transition-all">
                                    Reject
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>