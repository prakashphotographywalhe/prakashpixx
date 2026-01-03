<?php
/** * PRAKASH STUDIO - PHOTO REMOVAL LOGIC
 * This script handles database deletion and file unlinking
 */
require_once 'db.php';
session_start();

// 1. SECURITY HANDSHAKE: Ensure only Admin can delete art
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// 2. TRIGGER LOGIC
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['photo_id'])) {
    $photo_id = $_POST['photo_id'];

    try {
        // Fetch the photo details to find the file path
        $stmt = $pdo->prepare("SELECT image_url FROM photos WHERE id = ?");
        $stmt->execute([$photo_id]);
        $photo = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($photo) {
            $imagePath = $photo['image_url'];

            // Delete from Database
            $deleteStmt = $pdo->prepare("DELETE FROM photos WHERE id = ?");
            $deleteStmt->execute([$photo_id]);

            // Delete the physical file from the server folder
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            // SUCCESS TRIGGER: Send message back to admin.php
            header("Location: admin.php?msg=Masterpiece Removed Successfully&type=delete");
            exit();
        } else {
            header("Location: admin.php?error=Photo not found in gallery");
            exit();
        }
    } catch (PDOException $e) {
        header("Location: admin.php?error=System Error: " . urlencode($e->getMessage()));
        exit();
    }
}

// Default redirect if accessed incorrectly
header("Location: admin.php");
exit();
?>