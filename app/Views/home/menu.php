<section style="padding:3rem 0;">
    <div class="container">
        <h1 style="font-family:var(--font-disp);margin-bottom:.5rem;">Notre <span style="color:var(--primary);">Menu</span></h1>
        <p style="color:var(--gray);margin-bottom:3rem;">Cuisine traditionnelle camerounaise, préparée avec passion</p>
        <?php foreach ($plats_par_categorie as $categorie => $plats): ?>
        <div style="margin-bottom:3rem;">
            <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1.5rem;">
                <h2 style="font-family:var(--font-disp);font-size:1.6rem;"><?= esc($categorie) ?></h2>
                <div style="flex:1;height:2px;background:linear-gradient(to right,var(--primary),transparent);"></div>
                <span style="background:var(--primary);color:#fff;padding:.2rem .7rem;border-radius:50px;font-size:.75rem;font-weight:600;"><?= count($plats) ?> plats</span>
            </div>
            <div class="grid grid-3">
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
                        <h3 style="margin-bottom:.4rem;"><?= esc($plat['nom']) ?></h3>
                        <p style="color:var(--gray);font-size:.85rem;margin-bottom:1rem;"><?= esc($plat['description']) ?></p>
                        <div style="display:flex;justify-content:space-between;align-items:center;">
                            <span class="plat-price"><?= number_format($plat['prix'], 0, ',', '.') ?> FCFA</span>
                            <?php if (session()->get('user_role') === 'client'): ?>
                            <form action="<?= base_url('/client/panier/ajouter') ?>" method="POST">
                                <?= csrf_field() ?>
                                <input type="hidden" name="plat_id" value="<?= $plat['id'] ?>">
                                <input type="hidden" name="quantite" value="1">
                                <button class="btn btn-primary btn-sm">🛒 Ajouter</button>
                            </form>
                            <?php else: ?>
                            <a href="<?= base_url('/auth/login') ?>" class="btn btn-outline btn-sm">Commander</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
