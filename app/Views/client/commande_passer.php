<?php
/** @var array $adresses */
/** @var array $panier */
/** @var float|int $total */
$adresses ??= [];
$panier ??= [];
$total ??= 0;
?>
<section style="padding:2rem 0;">

    <div class="container">
        <div style="display:grid;grid-template-columns:1fr 380px;gap:2rem;align-items:start;">
            <div>
                <h2 style="margin-bottom:1.5rem;">Finaliser la commande</h2>
                <form action="<?= base_url('/client/commande/valider') ?>" method="POST">
                    <?= csrf_field() ?>
                    <div class="card" style="margin-bottom:1.5rem;">
                        <div class="card-header"><h3>📍 Adresse de livraison</h3></div>
                        <div class="card-body">
                            <?php if (empty($adresses)): ?>
                            <div class="alert alert-warning">Aucune adresse enregistrée. <a href="<?= base_url('/client/adresses') ?>">Ajouter une adresse</a></div>
                            <?php else: ?>
                            <?php foreach ($adresses as $adr): ?>
                            <label style="display:flex;align-items:flex-start;gap:.8rem;padding:.9rem;border:2px solid var(--light-2);border-radius:var(--radius);margin-bottom:.7rem;cursor:pointer;">
                                <input type="radio" name="adresse_id" value="<?= $adr['id'] ?>" <?= $adr['is_default'] ? 'checked' : '' ?> style="margin-top:3px;">
                                <div>
                                    <strong><?= esc($adr['ville']) ?> — <?= esc($adr['quartier']) ?></strong>
                                    <?php if ($adr['description']): ?><div style="color:var(--gray);font-size:.85rem;"><?= esc($adr['description']) ?></div><?php endif; ?>
                                    <?php if ($adr['is_default']): ?><span class="badge" style="background:var(--secondary);color:var(--dark);margin-top:.3rem;">Par défaut</span><?php endif; ?>
                                </div>
                            </label>
                            <?php endforeach; ?>
                            <a href="<?= base_url('/client/adresses') ?>" class="btn btn-outline btn-sm" style="margin-top:.5rem;">+ Nouvelle adresse</a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card" style="margin-bottom:1.5rem;">
                        <div class="card-header"><h3>📝 Note pour la cuisine</h3></div>
                        <div class="card-body">
                            <textarea name="note" class="form-control" placeholder="Sans piment, bien cuit, allergie aux crevettes…" rows="3"></textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg btn-block">✅ Confirmer — <?= number_format($total, 0, ',', '.') ?> FCFA</button>
                </form>
            </div>
            <div class="card" style="position:sticky;top:80px;">
                <div class="card-header"><h3>🛒 Récapitulatif</h3></div>
                <div class="card-body">
                    <?php foreach ($panier as $item): ?>
                    <div style="display:flex;justify-content:space-between;align-items:center;padding:.6rem 0;border-bottom:1px solid var(--light-2);">
                        <div>
                            <div style="font-weight:600;font-size:.9rem;"><?= esc($item['nom']) ?></div>
                            <div style="color:var(--gray);font-size:.8rem;">× <?= $item['quantite'] ?> × <?= number_format($item['prix'], 0, ',', '.') ?></div>
                        </div>
                        <strong><?= number_format($item['prix'] * $item['quantite'], 0, ',', '.') ?></strong>
                    </div>
                    <?php endforeach; ?>
                    <div style="display:flex;justify-content:space-between;align-items:center;padding-top:1rem;margin-top:.5rem;">
                        <strong style="font-size:1.1rem;">TOTAL</strong>
                        <strong style="color:var(--primary);font-size:1.4rem;font-family:var(--font-disp);"><?= number_format($total, 0, ',', '.') ?> FCFA</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
