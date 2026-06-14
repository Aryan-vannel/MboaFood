<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'MboaFood') ?></title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🍽️</text></svg>">
</head>
<body>
<nav class="navbar">
    <a href="<?= base_url('/') ?>" class="navbar-brand">Mboa<span>Food</span></a>
    <ul class="nav-links">
        <li><a href="<?= base_url('/') ?>">Accueil</a></li>
        <li><a href="<?= base_url('/menu') ?>">Menu</a></li>
        <?php if (session()->get('user_id')): ?>
            <?php $role = session()->get('user_role');
                  $dash = match($role) { 'admin' => '/admin', 'livreur' => '/livreur', default => '/client' }; ?>
            <li><a href="<?= base_url($dash) ?>">Mon Espace</a></li>
            <?php if ($role === 'client'): ?>
            <li>
                <a href="<?= base_url('/client/panier') ?>" class="nav-cart">
                    🛒 Panier
                    <?php $n = count(session()->get('panier') ?? []); if ($n): ?>
                    <span class="cart-badge"><?= $n ?></span>
                    <?php endif; ?>
                </a>
            </li>
            <?php endif; ?>
            <li><a href="<?= base_url('/auth/logout') ?>">Déconnexion</a></li>
        <?php else: ?>
            <li><a href="<?= base_url('/auth/login') ?>">Connexion</a></li>
            <li><a href="<?= base_url('/auth/register') ?>" class="nav-cart">S'inscrire</a></li>
        <?php endif; ?>
    </ul>
</nav>

<?php if (session()->getFlashdata('success') || session()->getFlashdata('error')): ?>
<div class="container" style="padding-top:1rem;">
    <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">✅ <?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-error">❌ <?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>
</div>
<?php endif; ?>

<?= $content ?>

<footer class="footer">
    <div class="container">
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:2rem;margin-bottom:1.5rem;">
            <div>
                <div class="footer-brand">Mboa<span>Food</span></div>
                <p style="margin-top:.5rem;font-size:.9rem;color:var(--gray-l);">La meilleure cuisine camerounaise livrée chez vous.</p>
            </div>
            <div>
                <h4 style="color:#fff;margin-bottom:.7rem;">Navigation</h4>
                <ul style="list-style:none;display:flex;flex-direction:column;gap:.3rem;">
                    <li><a href="<?= base_url('/') ?>" style="color:var(--gray-l);">Accueil</a></li>
                    <li><a href="<?= base_url('/menu') ?>" style="color:var(--gray-l);">Notre Menu</a></li>
                    <li><a href="<?= base_url('/auth/register') ?>" style="color:var(--gray-l);">S'inscrire</a></li>
                </ul>
            </div>
            <div>
                <h4 style="color:#fff;margin-bottom:.7rem;">Contact</h4>
                <p style="font-size:.85rem;color:var(--gray-l);">📍 Douala, Cameroun</p>
                <p style="font-size:.85rem;color:var(--gray-l);">📞 +237 695 042 748</p>
                <p style="font-size:.85rem;color:var(--gray-l);">✉️ info@mboafood.cm</p>
            </div>
        </div>
        <div class="footer-bottom">&copy; <?= date('Y') ?> MboaFood. Tous droits réservés.</div>
    </div>
</footer>
<script>
setTimeout(() => {
    document.querySelectorAll('.alert').forEach(el => {
        el.style.transition = 'opacity .5s'; el.style.opacity = '0';
        setTimeout(() => el.remove(), 500);
    });
}, 4000);
</script>
</body>
</html>
