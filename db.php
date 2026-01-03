<?php
/**
 * PRAKASH PHOTOGRAPHY & GRAPHICS - CORE DATABASE ENGINE
 * Optimized for Render.com and local development.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. SMART CONFIGURATION
$database_url = getenv('DATABASE_URL'); 

if ($database_url) {
    // CLOUD SETTINGS
    $dbopts = parse_url($database_url);
    $host   = $dbopts["host"] ?? 'localhost';
    $port   = $dbopts["port"] ?? 5432;
    $user   = $dbopts["user"] ?? '';
    $password = $dbopts["pass"] ?? '';
    $dbname = isset($dbopts["path"]) ? ltrim($dbopts["path"], '/') : 'photography_db';
} else {
    // LOCAL SETTINGS (XAMPP/PostgreSQL)
    $host = 'localhost';
    $port = '5432';
    $dbname = 'photography_db';
    $user = 'postgres';
    $password = 'gg';
}

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;";
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    error_log("Connection failed: " . $e->getMessage());
    die("Terminal Connection Error: System is currently undergoing maintenance.");
}

/**
 * 2. SCHEMA AUTO-SYNC
 * Checks for core tables and creates them if missing.
 */
try {
    // Check if the fundamental 'users' table exists
    $checkStmt = $pdo->query("SELECT EXISTS (
        SELECT FROM information_schema.tables 
        WHERE table_schema = 'public' 
        AND table_name = 'users'
    )");

    if (!$checkStmt->fetchColumn()) {
        $pdo->exec("
            -- 1. USERS: Identity Nodes
            CREATE TABLE IF NOT EXISTS users (
                id SERIAL PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                email VARCHAR(100) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                role VARCHAR(20) DEFAULT 'user'
            );

            -- 2. APPOINTMENTS: Pipeline
            CREATE TABLE IF NOT EXISTS appointments (
                id SERIAL PRIMARY KEY,
                user_id INT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
                service VARCHAR(100) NOT NULL,
                date DATE NOT NULL,
                time TIME DEFAULT '00:00:00',
                description TEXT,
                client_offer NUMERIC(10, 2) DEFAULT 0,
                base_price NUMERIC(10, 2) DEFAULT 0,
                price NUMERIC(10, 2) DEFAULT 0,
                brand_name VARCHAR(255) DEFAULT NULL,
                cloud_link VARCHAR(500) DEFAULT NULL,
                status VARCHAR(20) DEFAULT 'Pending'
            );

            -- 3. PHOTOS: Creative Vault
            CREATE TABLE IF NOT EXISTS photos (
                id SERIAL PRIMARY KEY,
                title VARCHAR(255) NOT NULL,
                description TEXT,
                image_path VARCHAR(500) NOT NULL,
                category VARCHAR(50) DEFAULT 'Photography',
                uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );

            -- 4. MESSAGES: Communication
            CREATE TABLE IF NOT EXISTS messages (
                id SERIAL PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                email VARCHAR(100) NOT NULL,
                subject VARCHAR(255),
                message TEXT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );

            -- 5. NEW: APPLICATIONS (The Collective Recruitment Node)
            -- This fixes the 'relation applications does not exist' error.
            CREATE TABLE IF NOT EXISTS applications (
                id SERIAL PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                skill VARCHAR(50) NOT NULL,
                bio TEXT,
                portfolio_link VARCHAR(500),
                image_path VARCHAR(500),
                status VARCHAR(20) DEFAULT 'pending',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );
        ");
    } else {
        // If users exists, check specifically for the new applications table
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS applications (
                id SERIAL PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                skill VARCHAR(50) NOT NULL,
                bio TEXT,
                portfolio_link VARCHAR(500),
                image_path VARCHAR(500),
                status VARCHAR(20) DEFAULT 'pending',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );
        ");
    }
} catch (Exception $e) {
    error_log("Table Creation Failed: " . $e->getMessage());
}
?>