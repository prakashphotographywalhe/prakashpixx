<?php 
require_once 'db.php'; 
include 'includes/header.php'; 
?>

<link href="https://fonts.googleapis.com/css2?family=Syncopate:wght@700&family=Plus+Jakarta+Sans:wght@300;400;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    :root {
        --ai-blue: #2563eb;
        --ai-emerald: #059669;
        --dark-bg: #050505;
    }

    body {
        background-color: var(--dark-bg);
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: white;
        margin: 0;
        overflow-x: hidden;
    }

    /* Stable Background Grid */
    .cyber-grid {
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background-image: 
            linear-gradient(rgba(37, 99, 235, 0.05) 1px, transparent 1px),
            linear-gradient(90deg, rgba(37, 99, 235, 0.05) 1px, transparent 1px);
        background-size: 50px 50px;
        z-index: -1;
        mask-image: radial-gradient(circle at center, black, transparent 80%);
    }

    /* Fixed Centered Container */
    .form-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        position: relative;
    }

    /* The Glow Layer - This rotates BEHIND the form */
    .rotating-border-bg {
        position: absolute;
        width: 620px; /* Slightly larger than form */
        height: 820px;
        background: conic-gradient(from 0deg, transparent, var(--ai-blue), var(--ai-emerald), transparent);
        animation: rotateGlow 6s linear infinite;
        border-radius: 3rem;
        filter: blur(10px);
        z-index: 1;
    }

    @keyframes rotateGlow {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    /* THE ACTUAL FORM - STABLE & STILL */
    .ai-card-stable {
        background: rgba(10, 10, 10, 0.9);
        backdrop-filter: blur(30px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 2.5rem;
        padding: 3.5rem;
        width: 100%;
        max-width: 550px;
        position: relative;
        z-index: 10; /* Sits above the rotating glow */
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
    }

    /* Scanning Line Effect (Internal to form) */
    .ai-card-stable::after {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 2px;
        background: linear-gradient(90deg, transparent, var(--ai-blue), transparent);
        animation: scanLine 4s linear infinite;
        opacity: 0.3;
    }

    @keyframes scanLine {
        0% { top: 0%; }
        100% { top: 100%; }
    }

    /* Input & UI Elements */
    .node-input {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: white;
        border-radius: 1rem;
        padding: 1.2rem;
        width: 100%;
        outline: none;
        transition: 0.3s ease;
        margin-bottom: 20px;
    }

    .node-input:focus {
        border-color: var(--ai-blue);
        background: rgba(255, 255, 255, 0.07);
        box-shadow: 0 0 15px rgba(37, 99, 235, 0.2);
    }

    .input-label {
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: var(--ai-blue);
        margin-bottom: 8px;
        display: block;
    }

    .sync-btn {
        background: white;
        color: black;
        width: 100%;
        padding: 1.2rem;
        border-radius: 1rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 4px;
        border: none;
        cursor: pointer;
        transition: 0.4s;
        margin-top: 10px;
    }

    .sync-btn:hover {
        background: var(--ai-blue);
        color: white;
        box-shadow: 0 0 30px var(--ai-blue);
    }

    .file-drop {
        border: 2px dashed rgba(255, 255, 255, 0.1);
        padding: 25px;
        border-radius: 1rem;
        text-align: center;
        cursor: pointer;
        margin-bottom: 25px;
    }
</style>

<div class="cyber-grid"></div>

<div class="form-wrapper">
    <div class="rotating-border-bg"></div>

    <form action="submit_app.php" method="POST" enctype="multipart/form-data" class="ai-card-stable">
        
        <div class="text-center mb-10">
            <h2 class="text-3xl font-black uppercase italic" style="font-family: 'Syncopate', sans-serif;">
                Collective <span style="color: var(--ai-blue);">Sync</span>
            </h2>
            <p class="input-label" style="color: #444;">Node Recruitment // v0.2</p>
        </div>

        <div class="input-group">
            <label class="input-label">Identity Name</label>
            <input type="text" name="name" placeholder="OPERATOR FULL NAME" class="node-input" required>
        </div>

        <div class="input-group">
            <label class="input-label">Classification</label>
            <select name="skill" class="node-input" required style="color-scheme: dark;">
                <option value="" disabled selected>SELECT SPECIALIZATION</option>
                <option value="Photographer">HYBRID PHOTOGRAPHER</option>
                <option value="Graphic Designer">VISUAL ARCHITECT</option>
            </select>
        </div>

        <div class="input-group">
            <label class="input-label">Creative Logic (Bio)</label>
            <textarea name="bio" placeholder="DESCRIBE YOUR PROCESSING..." class="node-input" rows="3"></textarea>
        </div>

        <div class="input-group">
            <label class="input-label">Visual Asset</label>
            <div class="file-drop" onclick="document.getElementById('fileUpload').click()">
                <input type="file" name="profile_img" id="fileUpload" style="display:none;" required onchange="updateFileName(this)">
                <i class="fas fa-hdd text-xl mb-2 text-gray-500"></i>
                <p id="fileName" style="font-size: 10px; color: #555; margin: 0;">UPLOAD PROFILE IMAGE</p>
            </div>
        </div>

        <button type="submit" class="sync-btn">Initialize Sync</button>
    </form>
</div>

<script>
    function updateFileName(input) {
        const name = input.files[0]?.name || "Asset Ready";
        const label = document.getElementById('fileName');
        label.textContent = "SYNCING: " + name.toUpperCase();
        label.style.color = "#2563eb";
    }
</script>

<?php include 'includes/footer.php'; ?>