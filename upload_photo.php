<?php
// 1. SESSION & DATABASE
session_start();
require_once 'db.php';

// Security: Only Admin can upload
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$message = "";
$maxFileSize = 25 * 1024 * 1024; // 15MB

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'assets/images/';
        
        // Sanitize filename to avoid errors
        $fileName = time() . '_' . basename($_FILES['image']['name']);
        $uploadFile = $uploadDir . $fileName;

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileType = mime_content_type($_FILES['image']['tmp_name']);
        $fileSize = $_FILES['image']['size'];

        if (!in_array($fileType, $allowedTypes)) {
            $message = ["type" => "error", "text" => "Invalid type. JPEG, PNG, GIF only."];
        } elseif ($fileSize > $maxFileSize) {
            $message = ["type" => "error", "text" => "File exceeds 15MB limit."];
        } else {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                $stmt = $pdo->prepare("INSERT INTO photos (title, description, image_url) VALUES (?, ?, ?)");
                $stmt->execute([$title, $description, $uploadFile]);
                $message = ["type" => "success", "text" => "Masterpiece added to gallery!"];
            } else {
                $message = ["type" => "error", "text" => "Error moving file to folder."];
            }
        }
    } else {
        $message = ["type" => "error", "text" => "No file selected or upload error."];
    }
}

include 'includes/header.php'; 
?>

<main class="min-h-screen bg-gray-50 pb-20">
    <div class="bg-gradient-to-br from-green-800 via-green-900 to-blue-900 pt-32 pb-32 px-6 relative z-0 overflow-hidden">
        <div class="container mx-auto relative z-10 text-center">
            <h1 class="text-5xl font-black text-white mb-2 uppercase tracking-tighter">Publish <span class="text-green-400">Art</span></h1>
            <p class="text-blue-200 font-light text-lg italic">Add a new masterpiece to the Prakash Studio Gallery.</p>
        </div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 -mr-20 -mt-20"></div>
    </div>

    <div class="container mx-auto px-6 -mt-20 relative z-10 flex justify-center">
        <div class="w-full max-w-2xl">
            
            <?php if ($message): ?>
                <div class="<?= $message['type'] === 'success' ? 'bg-green-600' : 'bg-red-600' ?> text-white p-6 rounded-[2rem] mb-8 shadow-xl flex items-center space-x-4 animate-bounce">
                    <i class="fas <?= $message['type'] === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle' ?> text-2xl"></i>
                    <span class="font-black uppercase tracking-widest text-xs"><?= $message['text'] ?></span>
                </div>
            <?php endif; ?>

            <div class="bg-white p-10 md:p-16 rounded-[3rem] shadow-2xl border border-gray-100">
                <form method="POST" enctype="multipart/form-data" class="space-y-8">
                    
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-2">Artwork Title</label>
                        <input type="text" name="title" required placeholder="Ex: Sunset in Mahabaleshwar"
                               class="w-full px-6 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-green-500/10 focus:border-green-600 outline-none transition-all font-medium">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-2">Description</label>
                        <textarea name="description" required rows="3" placeholder="Tell the story behind this shot..."
                                  class="w-full px-6 py-4 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-green-500/10 focus:border-green-600 outline-none transition-all font-medium"></textarea>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-2">Image File (Max 15MB)</label>
                        <label class="relative group cursor-pointer block">
                            <div class="w-full py-16 border-2 border-dashed border-gray-200 rounded-3xl flex flex-col items-center justify-center bg-gray-50/50 group-hover:bg-green-50/50 group-hover:border-green-500 transition-all">
                                <div class="w-16 h-16 bg-white rounded-2xl shadow-sm flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-cloud-upload-alt text-2xl text-gray-300 group-hover:text-green-600"></i>
                                </div>
                                <span class="text-xs font-black text-gray-400 uppercase tracking-widest">Click to browse or drop photo</span>
                            </div>
                            <input type="file" name="image" required class="hidden" accept="image/*">
                        </label>
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-green-700 to-blue-700 text-white font-black py-6 rounded-2xl shadow-xl hover:shadow-green-500/30 hover:-translate-y-1 transition-all uppercase tracking-[0.2em] text-xs">
                        Publish to Gallery
                    </button>
                </form>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>