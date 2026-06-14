<?php
/** @var int $total_commandes */
/** @var int $en_cours */
/** @var array $commandes */
$total_commandes ??= 0;
$en_cours ??= 0;
$commandes ??= [];
?>
<section style="padding:2rem 0;background:linear-gradient(135deg,var(--dark),var(--dark-soft));">

    <div class="container">
        <h1 style="color:var(--white);">Bonjour, <span style="color:var(--secondary);"><?= esc(session()->get('user_nom')) ?></span> 👋</h1>
        <p style="color:var(--gray-l);">Bienvenue dans votre espace personnel</p>
    </div>
</section>
<section style="padding:2rem 0;">
    <div class="container">
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1rem;margin-bottom:2rem;">
            <div class="stat-card">
                <div class="stat-icon orange">🛒</div>
                <div><div class="stat-val"><?= $total_commandes ?></div><div class="stat-label">Total commandes</div></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon yellow">⏳</div>
                <div><div class="stat-val"><?= $en_cours ?></div><div class="stat-label">En cours</div></div>
            </div>
        </div>
        <div style="display:grid;grid-template-columns:2fr 1fr;gap:1.5rem;align-items:start;flex-wrap:wrap;">
            <div class="card">
                <div class="card-header">
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <h3>Mes dernières commandes</h3>
                        <a href="<?= base_url('/client/commandes') ?>" class="btn btn-outline btn-sm">Voir tout</a>
                    </div>
                </div>
                <?php if (empty($commandes)): ?>
                <div class="card-body" style="text-align:center;padding:3rem;">
                    <div style="font-size:3rem;margin-bottom:1rem;">🍽️</div>
                    <p style="color:var(--gray);">Aucune commande pour l'instant</p>
                    <a href="<?= base_url('/client/menu') ?>" class="btn btn-primary" style="margin-top:1rem;">Commander maintenant</a>
                </div>
                <?php else: ?>
                <table class="table">
                    <thead><tr><th>#</th><th>Date</th><th>Total</th><th>Statut</th><th></th></tr></thead>
                    <tbody>
                    <?php foreach (array_slice($commandes, 0, 5) as $cmd): ?>
                    <tr>
                        <td><strong>#<?= $cmd['id'] ?></strong></td>
                        <td style="color:var(--gray);font-size:.85rem;"><?= date('d/m/Y', strtotime($cmd['created_at'])) ?></td>
                        <td><strong><?= number_format($cmd['total'], 0, ',', '.') ?> FCFA</strong></td>
                        <td><span class="badge badge-<?= $cmd['statut'] ?>"><?= str_replace('_',' ',$cmd['statut']) ?></span></td>
                        <td><a href="<?= base_url('/client/commande/'.$cmd['id']) ?>" class="btn btn-outline btn-sm">Voir</a></td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </div>
            <div>
                <div class="card" style="margin-bottom:1rem;">
                    <div class="card-body" style="text-align:center;">
                        <div style="font-size:2rem;margin-bottom:.5rem;">🍽️</div>
                        <h3 style="margin-bottom:.5rem;">Nouvelle commande</h3>
                        <p style="color:var(--gray);font-size:.85rem;margin-bottom:1rem;">Découvrez nos plats du jour</p>
                        <a href="<?= base_url('/client/menu') ?>" class="btn btn-primary btn-block">Voir le menu</a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h3 style="margin-bottom:.8rem;">Liens rapides</h3>
                        <div style="display:flex;flex-direction:column;gap:.5rem;">
                            <a href="<?= base_url('/client/panier') ?>" class="btn btn-outline btn-sm">🛒 Mon panier</a>
                            <a href="<?= base_url('/client/adresses') ?>" class="btn btn-outline btn-sm">📍 Mes adresses</a>
                            <a href="<?= base_url('/client/profil') ?>" class="btn btn-outline btn-sm">👤 Mon profil</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
