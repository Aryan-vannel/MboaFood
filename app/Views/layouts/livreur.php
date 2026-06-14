<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Livreur - MboaFood') ?></title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>
<div class="admin-layout">
    <aside class="admin-sidebar">
        <div class="logo">Mboa<span>Food</span></div>
        <div style="background:rgba(245,166,35,.12);border-radius:var(--radius);padding:.4rem .9rem;margin-bottom:1.5rem;font-size:.78rem;color:var(--secondary);font-weight:600;">🚴 Espace Livreur</div>
        <div class="sidebar-section">
            <a href="<?= base_url('/livreur') ?>" class="sidebar-link">🏠 Tableau de bord</a>
            <a href="<?= base_url('/livreur/livraisons') ?>" class="sidebar-link">📦 Mes Livraisons</a>
            <a href="<?= base_url('/livreur/historique') ?>" class="sidebar-link">📋 Historique</a>
            <a href="<?= base_url('/livreur/profil') ?>" class="sidebar-link">👤 Mon Profil</a>
        </div>
        <div style="margin-top:2rem;padding-top:1rem;border-top:1px solid rgba(255,255,255,.08);">
            <div style="padding:.4rem .5rem;font-size:.82rem;color:var(--gray-l);">👤 <?= esc(session()->get('user_nom')) ?></div>
            <a href="<?= base_url('/auth/logout') ?>" class="sidebar-link" style="color:var(--danger);">🚪 Déconnexion</a>
        </div>
    </aside>
    <main class="admin-main">
        <div class="admin-header">
            <h1><?= esc($title ?? '') ?></h1>
        </div>
        <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">✅ <?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-error">⚠️ <?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>
        <?= $content ?>
    </main>
</div>
</body>
</html>
