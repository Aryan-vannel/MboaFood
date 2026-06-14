<?php
/** @var array $plats_par_categorie */
$plats_par_categorie ??= [];
?>
<section style="padding:2rem 0;">

    <div class="container">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;flex-wrap:wrap;gap:1rem;">
            <h2>Notre Menu</h2>
            <a href="<?= base_url('/client/panier') ?>" class="btn btn-primary">
                🛒 Mon panier
                <?php $n = count(session()->get('panier') ?? []); if ($n): ?>(<?= $n ?>)<?php endif; ?>
            </a>
        </div>
        <?php foreach ($plats_par_categorie as $categorie => $plats): ?>
        <div style="margin-bottom:2.5rem;">
            <h3 style="font-family:var(--font-disp);font-size:1.3rem;margin-bottom:1rem;padding-bottom:.5rem;border-bottom:3px solid var(--primary);display:inline-block;"><?= esc($categorie) ?></h3>
            <div class="grid grid-3" style="margin-top:1rem;">
                <?php foreach ($plats as $plat): ?>
                <div class="card plat-card">
                    <div class="plat-img">
                        <?php if (!empty($plat['image'])): ?>
                        <img src="<?= base_url($plat['image']) ?>" alt="<?= esc($plat['nom']) ?>">
                        <?php else: ?>
                        <div class="plat-placeholder">🍽️</div>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <h3 style="margin-bottom:.3rem;"><?= esc($plat['nom']) ?></h3>
                        <p style="color:var(--gray);font-size:.82rem;margin-bottom:1rem;"><?= character_limiter(esc($plat['description']), 70) ?></p>
                        <div style="display:flex;justify-content:space-between;align-items:center;">
                            <span class="plat-price"><?= number_format($plat['prix'], 0, ',', '.') ?> FCFA</span>
                            <form action="<?= base_url('/client/panier/ajouter') ?>" method="POST">
                                <?= csrf_field() ?>
                                <input type="hidden" name="plat_id" value="<?= $plat['id'] ?>">
                                <input type="hidden" name="quantite" value="1">
                                <button class="btn btn-primary btn-sm">+ Ajouter</button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
