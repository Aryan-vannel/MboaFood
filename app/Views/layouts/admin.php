<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Admin - MboaFood') ?></title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>
<div class="admin-layout">
    <aside class="admin-sidebar">
        <div class="logo">Mboa<span>Food</span></div>
        <div style="background:rgba(200,65,11,.15);border-radius:var(--radius);padding:.4rem .9rem;margin-bottom:1.5rem;font-size:.78rem;color:var(--primary-l);font-weight:600;">⚙️ Administration</div>

        <div class="sidebar-section">
            <div class="sidebar-section-title">Principal</div>
            <a href="<?= base_url('/admin') ?>" class="sidebar-link">📊 Tableau de bord</a>
        </div>
        <div class="sidebar-section">
            <div class="sidebar-section-title">Commandes</div>
            <a href="<?= base_url('/admin/commandes') ?>" class="sidebar-link">🛒 Commandes</a>
            <a href="<?= base_url('/admin/factures') ?>" class="sidebar-link">🧾 Factures</a>
        </div>
        <div class="sidebar-section">
            <div class="sidebar-section-title">Catalogue</div>
            <a href="<?= base_url('/admin/plats') ?>" class="sidebar-link">🍽️ Plats</a>
            <a href="<?= base_url('/admin/categories') ?>" class="sidebar-link">📂 Catégories</a>
        </div>
        <div class="sidebar-section">
            <div class="sidebar-section-title">Utilisateurs</div>
            <a href="<?= base_url('/admin/utilisateurs') ?>" class="sidebar-link">👥 Utilisateurs</a>
        </div>
        <div style="margin-top:2rem;padding-top:1rem;border-top:1px solid rgba(255,255,255,.08);">
            <div style="padding:.4rem .5rem;font-size:.82rem;color:var(--gray-l);">👤 <?= esc(session()->get('user_nom')) ?></div>
            <a href="<?= base_url('/auth/logout') ?>" class="sidebar-link" style="color:var(--danger);">🚪 Déconnexion</a>
        </div>
    </aside>
    <main class="admin-main">
        <div class="admin-header">
            <h1><?= esc($title ?? '') ?></h1>
            <div style="font-size:.82rem;color:var(--gray);"><?= date('d/m/Y H:i') ?></div>
        </div>
        <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">✅ <?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-error">❌ <?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>
        <?= $content ?>
    </main>
</div>
<script>
setTimeout(() => {
    document.querySelectorAll('.alert').forEach(el => {
        el.style.transition='opacity .5s'; el.style.opacity='0';
        setTimeout(()=>el.remove(),500);
    });
}, 4000);
</script>
</body>
</html>
