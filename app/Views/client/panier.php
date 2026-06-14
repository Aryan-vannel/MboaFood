<?php
/** @var array $panier */
/** @var float|int $total */
$panier ??= [];
$total ??= 0;
?>
<section style="padding:2rem 0;">

    <div class="container">
        <div style="display:grid;grid-template-columns:1fr 360px;gap:2rem;align-items:start;">
            <div>
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;">
                    <h2>Mon Panier <span style="color:var(--gray);font-size:1rem;font-weight:400;">(<?= count($panier) ?> article<?= count($panier) > 1 ? 's' : '' ?>)</span></h2>
                    <?php if (!empty($panier)): ?>
                    <form action="<?= base_url('/client/panier/vider') ?>" method="POST" onsubmit="return confirm('Vider le panier ?')">
                        <?= csrf_field() ?>
                        <button class="btn btn-danger btn-sm">🗑️ Vider</button>
                    </form>
                    <?php endif; ?>
                </div>
                <?php if (empty($panier)): ?>
                <div class="card" style="text-align:center;padding:3rem;">
                    <div style="font-size:4rem;margin-bottom:1rem;">🛒</div>
                    <h3>Votre panier est vide</h3>
                    <p style="color:var(--gray);margin:.5rem 0 1.5rem;">Découvrez notre menu et commandez vos plats favoris</p>
                    <a href="<?= base_url('/client/menu') ?>" class="btn btn-primary">Voir le menu 🍽️</a>
                </div>
                <?php else: ?>
                <?php foreach ($panier as $item): ?>
                <div class="panier-item">
                    <?php if (!empty($item['image'])): ?>
                    <img src="<?= base_url($item['image']) ?>" alt="<?= esc($item['nom']) ?>">
                    <?php else: ?>
                    <div style="width:70px;height:70px;background:var(--light-2);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:1.5rem;flex-shrink:0;">🍽️</div>
                    <?php endif; ?>
                    <div style="flex:1;">
                        <h4 style="margin-bottom:.2rem;"><?= esc($item['nom']) ?></h4>
                        <span class="plat-price" style="font-size:1rem;"><?= number_format($item['prix'], 0, ',', '.') ?> FCFA</span>
                    </div>
                    <form action="<?= base_url('/client/panier/modifier') ?>" method="POST" class="qty-control" style="gap:.4rem;">
                        <?= csrf_field() ?>
                        <input type="hidden" name="plat_id" value="<?= $item['id'] ?>">
                        <button type="submit" name="quantite" value="<?= $item['quantite'] - 1 ?>" class="qty-btn">−</button>
                        <span style="min-width:28px;text-align:center;font-weight:700;"><?= $item['quantite'] ?></span>
                        <button type="submit" name="quantite" value="<?= $item['quantite'] + 1 ?>" class="qty-btn">+</button>
                    </form>
                    <div style="min-width:100px;text-align:right;">
                        <strong><?= number_format($item['prix'] * $item['quantite'], 0, ',', '.') ?> FCFA</strong>
                    </div>
                    <form action="<?= base_url('/client/panier/supprimer') ?>" method="POST">
                        <?= csrf_field() ?>
                        <input type="hidden" name="plat_id" value="<?= $item['id'] ?>">
                        <button class="btn btn-danger btn-sm">✕</button>
                    </form>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <?php if (!empty($panier)): ?>
            <div>
                <div class="card" style="position:sticky;top:80px;">
                    <div class="card-header"><h3>Résumé</h3></div>
                    <div class="card-body">
                        <?php foreach ($panier as $item): ?>
                        <div style="display:flex;justify-content:space-between;font-size:.85rem;margin-bottom:.4rem;color:var(--gray);">
                            <span><?= esc($item['nom']) ?> × <?= $item['quantite'] ?></span>
                            <span><?= number_format($item['prix'] * $item['quantite'], 0, ',', '.') ?></span>
                        </div>
                        <?php endforeach; ?>
                        <div style="border-top:2px solid var(--light-2);margin:1rem 0;padding-top:1rem;display:flex;justify-content:space-between;">
                            <strong>TOTAL</strong>
                            <strong style="color:var(--primary);font-size:1.2rem;"><?= number_format($total, 0, ',', '.') ?> FCFA</strong>
                        </div>
                        <a href="<?= base_url('/client/commande/passer') ?>" class="btn btn-primary btn-block btn-lg">✅ Valider la commande</a>
                        <a href="<?= base_url('/client/menu') ?>" class="btn btn-outline btn-block" style="margin-top:.5rem;">← Continuer</a>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
