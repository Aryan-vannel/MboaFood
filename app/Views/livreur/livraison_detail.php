<div style="max-width:700px;">
    <a href="<?= base_url('/livreur/livraisons') ?>" style="color:var(--gray);margin-bottom:1rem;display:inline-block;">← Mes livraisons</a>

    <div class="card" style="margin-bottom:1rem;">
        <div class="card-header" style="display:flex;justify-content:space-between;align-items:center;">
            <h3>Livraison #<?= $livraison['id'] ?></h3>
            <span class="badge badge-<?= $livraison['statut'] ?>" style="font-size:.85rem;padding:.4rem 1rem;"><?= str_replace('_',' ',strtoupper($livraison['statut'])) ?></span>
        </div>
        <div class="card-body">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:1.5rem;">
                <div>
                    <div style="font-size:.72rem;text-transform:uppercase;color:var(--gray);margin-bottom:.4rem;">Client</div>
                    <strong><?= esc($livraison['client_nom']) ?></strong><br>
                    <span style="color:var(--gray);"><?= esc($livraison['client_tel']) ?></span>
                </div>
                <div>
                    <div style="font-size:.72rem;text-transform:uppercase;color:var(--gray);margin-bottom:.4rem;">Adresse de livraison</div>
                    <strong><?= esc($livraison['ville']) ?>, <?= esc($livraison['quartier']) ?></strong>
                    <?php if (!empty($livraison['adresse'])): ?><br><span style="color:var(--gray);font-size:.85rem;"><?= esc($livraison['adresse']) ?></span><?php endif; ?>
                </div>
            </div>

            <!-- Récap des articles -->
            <div style="background:var(--light);border-radius:var(--radius);padding:1rem;margin-bottom:1.5rem;">
                <div style="font-size:.72rem;text-transform:uppercase;color:var(--gray);margin-bottom:.7rem;font-weight:600;">Articles à livrer</div>
                <?php foreach ($commande['lignes'] as $l): ?>
                <div style="display:flex;justify-content:space-between;font-size:.9rem;margin-bottom:.3rem;">
                    <span><?= esc($l['plat_nom']) ?> <span style="color:var(--gray);">× <?= $l['quantite'] ?></span></span>
                    <span><?= number_format($l['prix_unitaire'] * $l['quantite'], 0, ',', '.') ?> FCFA</span>
                </div>
                <?php endforeach; ?>
                <div style="border-top:2px solid var(--light-2);margin-top:.7rem;padding-top:.7rem;display:flex;justify-content:space-between;font-weight:700;">
                    <span>Total à encaisser</span>
                    <span style="color:var(--primary);font-size:1.1rem;"><?= number_format($commande['total'], 0, ',', '.') ?> FCFA</span>
                </div>
            </div>

            <?php if (!empty($commande['note'])): ?>
            <div class="alert alert-info" style="margin-bottom:1.5rem;">📝 <strong>Note :</strong> <?= esc($commande['note']) ?></div>
            <?php endif; ?>

            <!-- Actions -->
            <div style="display:flex;gap:.7rem;flex-wrap:wrap;">
                <?php if ($livraison['statut'] === 'assignee'): ?>
                <form action="<?= base_url('/livreur/livraison/accepter/'.$livraison['id']) ?>" method="POST">
                    <?= csrf_field() ?>
                    <button class="btn btn-primary btn-lg">🚴 Démarrer la livraison</button>
                </form>
                <?php elseif ($livraison['statut'] === 'en_cours'): ?>
                <form action="<?= base_url('/livreur/livraison/livree/'.$livraison['id']) ?>" method="POST">
                    <?= csrf_field() ?>
                    <button class="btn btn-success btn-lg">✅ Confirmer la livraison</button>
                </form>
                <form action="<?= base_url('/livreur/livraison/echec/'.$livraison['id']) ?>" method="POST" onsubmit="return confirm('Signaler un échec de livraison ?')">
                    <?= csrf_field() ?>
                    <button class="btn btn-danger">❌ Échec de livraison</button>
                </form>
                <?php elseif (in_array($livraison['statut'], ['livree','echec'])): ?>
                <div class="alert alert-<?= $livraison['statut'] === 'livree' ? 'success' : 'error' ?>">
                    <?= $livraison['statut'] === 'livree' ? '✅ Livraison effectuée avec succès.' : '❌ Livraison en échec.' ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
