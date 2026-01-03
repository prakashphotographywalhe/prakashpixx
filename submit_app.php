<?php
require_once 'db.php';

// CSS for the Loading/Success Screen
echo '
<style>
    @import url("https://fonts.googleapis.com/css2?family=Syncopate:wght@700&family=Plus+Jakarta+Sans:wght@400;800&display=swap");
    body { 
        background: #000; 
        color: white; 
        font-family: "Plus Jakarta Sans", sans-serif; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        height: 100vh; 
        margin: 0; 
        overflow: hidden;
    }
    .processing-container {
        text-align: center;
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(20px);
        padding: 3rem;
        border-radius: 3rem;
        border: 1px solid rgba(255, 255, 255, 0.1);
        max-width: 400px;
        animation: pulse 2s infinite ease-in-out;
    }
    .loader-circle {
        width: 60px;
        height: 60px;
        border: 4px solid rgba(37, 99, 235, 0.1);
        border-top: 4px solid #2563eb;
        border-radius: 50%;
        margin: 0 auto 20px;
        animation: spin 1s linear infinite;
    }
    .logo-font { font-family: "Syncopate", sans-serif; letter-spacing: -1px; }
    @keyframes spin { to { transform: rotate(360deg); } }
    @keyframes pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.02); } }
</style>
<div class="processing-container" id="feedback">
    <div class="loader-circle"></div>
    <h2 class="logo-font" style="font-size: 14px; color: #2563eb;">UPLOADING ASSET</h2>
    <p style="font-size: 10px; text-transform: uppercase; letter-spacing: 2px; color: #666;">Synchronizing with Creative Cloud...</p>
</div>';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = htmlspecialchars($_POST['name']);
    $skill = htmlspecialchars($_POST['skill']);
    $bio   = htmlspecialchars($_POST['bio']);
    
    $target_dir = "assets/uploads/team/";
    if (!is_dir($target_dir)) { mkdir($target_dir, 0755, true); }

    $file_ext = strtolower(pathinfo($_FILES["profile_img"]["name"], PATHINFO_EXTENSION));
    $new_filename = uniqid('node_', true) . '.' . $file_ext;
    $target_file = $target_dir . $new_filename;
    
    $allowed_types = ['jpg', 'jpeg', 'png', 'webp'];
    $check = getimagesize($_FILES["profile_img"]["tmp_name"]);

    if ($check !== false && in_array($file_ext, $allowed_types) && $_FILES["profile_img"]["size"] < 5000000) {
        if (move_uploaded_file($_FILES["profile_img"]["tmp_name"], $target_file)) {
            
            try {
                $sql = "INSERT INTO applications (name, skill, bio, image_path, status) VALUES (?, ?, ?, ?, 'pending')";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$name, $skill, $bio, $target_file]);

                // Success Message with Premium Animation Redirect
                echo "
                <script>
                    document.getElementById('feedback').innerHTML = `
                        <div style='color: #059669; font-size: 40px; margin-bottom: 20px;'><i class='fas fa-check-circle'></i></div>
                        <h2 class='logo-font' style='font-size: 14px; color: #059669;'>UPLOAD COMPLETE</h2>
                        <p style='font-size: 10px; color: #888;'>NODE INITIALIZED SUCCESSFULLY</p>
                    `;
                    setTimeout(() => { window.location.href='index.php'; }, 2000);
                </script>";
            } catch (PDOException $e) {
                error_log("DB Error: " . $e->getMessage());
                die("<div class='logo-font'>DATABASE REJECTION</div>");
            }
        } else {
            die("<div class='logo-font'>DISK WRITE ERROR</div>");
        }
    } else {
        die("<div class='logo-font'>SECURITY ALERT: INVALID FILE</div>");
    }
}
?>