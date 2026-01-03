<?php
/** * 1. SESSION & DATABASE SECURITY 
 * Prakash Photography & Graphics - Admin Logic Node
 */
session_start();
require_once 'db.php';

// Access Control: Only Admin can access the command logic
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

/**
 * 2. ACTION PROCESSING LOGIC
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appointment_id = $_POST['appointment_id'] ?? null;
    $action = $_POST['action'] ?? null;
    
    // Capture the agreed-upon price
    $final_price = $_POST['price'] ?? 0;

    if ($appointment_id && in_array($action, ['approve', 'reject'])) {
        try {
            // A subtle artificial delay to allow the Admin UI to show a "Syncing" state
            // usleep(500000); // 0.5 seconds of "Server Thinking" time

            if ($action === 'approve') {
                /**
                 * UPDATE: Establish Project Pipeline
                 * We set status to Approved and lock in the negotiated price.
                 */
                $stmt = $pdo->prepare("
                    UPDATE appointments 
                    SET status = 'Approved', 
                        price = :price 
                    WHERE id = :id AND status = 'Pending'
                ");
                $stmt->execute([
                    'price' => $final_price,
                    'id' => $appointment_id
                ]);
                
                $status_msg = "Project Node established at ₹" . number_format($final_price);
                $type = "success";

            } elseif ($action === 'reject') {
                /**
                 * DELETE: Terminate Request
                 * Removes the inquiry from the database to keep the pipeline clean.
                 */
                $stmt = $pdo->prepare("DELETE FROM appointments WHERE id = :id");
                $stmt->execute(['id' => $appointment_id]);
                
                $status_msg = "Inquiry Terminated & Archived";
                $type = "warning"; 
            }
            
            // REDIRECT: Returns to Admin Hub with visual trigger parameters
            header("Location: admin.php?msg=" . urlencode($status_msg) . "&type=" . $type . "&trigger=vibrate");
            exit();

        } catch (PDOException $e) {
            header("Location: admin.php?msg=" . urlencode("Critical Sync Failure") . "&type=error");
            exit();
        }
    } else {
        header("Location: admin.php?msg=" . urlencode("Protocol Error: Missing ID") . "&type=error");
        exit();
    }
}

// Security Fallback
header("Location: admin.php");
exit();