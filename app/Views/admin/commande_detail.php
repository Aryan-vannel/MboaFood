<a href="<?= base_url('/admin/commandes') ?>" style="color:var(--gray);margin-bottom:1rem;display:inline-block;">← Toutes les commandes</a>
<div style="display:grid;grid-template-columns:1fr 340px;gap:1.5rem;align-items:start;">
    <div>
        <div class="card" style="margin-bottom:1rem;">
            <div class="card-header" style="display:flex;justify-content:space-between;align-items:center;">
                <h3>Commande #<?= $commande['id'] ?></h3>
                <span class="badge badge-<?= $commande['statut'] ?>" style="font-size:.85rem;padding:.4rem 1rem;"><?= str_replace('_',' ',strtoupper($commande['statut'])) ?></span>
            </div>
            <div class="card-body">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem;">
                    <div>
                        <div style="font-size:.72rem;text-transform:uppercase;color:var(--gray);margin-bottom:.3rem;">Client</div>
                        <strong><?= esc($commande['client_nom']) ?></strong><br>
                        <span style="color:var(--gray);font-size:.85rem;"><?= esc($commande['client_tel']) ?></span>
                    </div>
                    <div>
                        <div style="font-size:.72rem;text-transform:uppercase;color:var(--gray);margin-bottom:.3rem;">Date</div>
                        <strong><?= date('d/m/Y à H:i', strtotime($commande['created_at'])) ?></strong>
                    </div>
                    <?php if ($commande['ville']): ?>
                    <div>
                        <div style="font-size:.72rem;text-transform:uppercase;color:var(--gray);margin-bottom:.3rem;">Adresse livraison</div>
                        <strong><?= esc($commande['ville']) ?> — <?= esc($commande['quartier']) ?></strong>
                        <?php if ($commande['adresse_desc']): ?><br><span style="color:var(--gray);font-size:.82rem;"><?= esc($commande['adresse_desc']) ?></span><?php endif; ?>
                    </div>
                    <?php endif; ?>
                    <?php if ($commande['note']): ?>
                    <div>
                        <div style="font-size:.72rem;text-transform:uppercase;color:var(--gray);margin-bottom:.3rem;">Note</div>
                        <em style="color:var(--gray);font-size:.85rem;"><?= esc($commande['note']) ?></em>
                    </div>
                    <?php endif; ?>
                </div>
                <table class="table">
                    <thead><tr><th>Plat</th><th>Prix unit.</th><th>Qté</th><th>Sous-total</th></tr></thead>
                    <tbody>
                    <?php foreach ($commande['lignes'] as $l): ?>
                    <tr>
                        <td><?= esc($l['plat_nom']) ?></td>
                        <td><?= number_format($l['prix_unitaire'], 0, ',', '.') ?> FCFA</td>
                        <td>× <?= $l['quantite'] ?></td>
                        <td><strong><?= number_format($l['prix_unitaire'] * $l['quantite'], 0, ',', '.') ?> FCFA</strong></td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot><tr>
                        <td colspan="3" style="text-align:right;font-weight:700;">TOTAL</td>
                        <td style="font-weight:700;color:var(--primary);"><?= number_format($commande['total'], 0, ',', '.') ?> FCFA</td>
                    </tr></tfoot>
                </table>
            </div>
        </div>
    </div>
    <div>
        <div class="card" style="margin-bottom:1rem;">
            <div class="card-header"><h3>⚙️ Actions</h3></div>
            <div class="card-body" style="display:flex;flex-direction:column;gap:.5rem;">
                <?php if ($commande['statut'] === 'en_attente'): ?>
                <form action="<?= base_url('/admin/commande/accepter/'.$commande['id']) ?>" method="POST"><?= csrf_field() ?><button class="btn btn-success btn-block">✅ Accepter la commande</button></form>
                <form action="<?= base_url('/admin/commande/refuser/'.$commande['id']) ?>" method="POST" onsubmit="return confirm('Refuser cette commande ?')"><?= csrf_field() ?><button class="btn btn-danger btn-block">❌ Refuser</button></form>
                <?php elseif ($commande['statut'] === 'acceptee'): ?>
                <form action="<?= base_url('/admin/commande/preparer/'.$commande['id']) ?>" method="POST"><?= csrf_field() ?><button class="btn btn-primary btn-block">👨‍🍳 Mettre en préparation</button></form>
                <?php elseif ($commande['statut'] === 'en_preparation'): ?>
                <form action="<?= base_url('/admin/commande/prete/'.$commande['id']) ?>" method="POST"><?= csrf_field() ?><button class="btn btn-success btn-block">🍽️ Marquer comme prête</button></form>
                <?php endif; ?>
                <?php if ($facture): ?>
                <a href="<?= base_url('/admin/facture/'.$facture['id']) ?>" class="btn btn-dark btn-block">🧾 Voir la facture</a>
                <?php endif; ?>
            </div>
        </div>
        <?php if ($commande['statut'] === 'prete'): ?>
        <div class="card" style="margin-bottom:1rem;">
            <div class="card-header"><h3>🚴 Assigner un livreur</h3></div>
            <div class="card-body">
                <?php if (empty($livreurs)): ?>
                <div class="alert alert-warning">Aucun livreur disponible.</div>
                <?php else: ?>
                <form action="<?= base_url('/admin/commande/assigner/'.$commande['id']) ?>" method="POST">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <select name="livreur_id" class="form-control" required>
                            <option value="">-- Sélectionner --</option>
                            <?php foreach ($livreurs as $l): ?>
                            <option value="<?= $l['id'] ?>"><?= esc($l['nom']) ?> — <?= esc($l['telephone']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button class="btn btn-primary btn-block">Assigner</button>
                </form>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
        <?php if ($livraison): ?>
        <div class="card">
            <div class="card-header"><h3>📦 Livraison</h3></div>
            <div class="card-body" style="font-size:.9rem;">
                <div style="margin-bottom:.4rem;"><strong>Statut :</strong> <span class="badge badge-<?= $livraison['statut'] ?>"><?= $livraison['statut'] ?></span></div>
                <div><strong>Tentatives :</strong> <?= $livraison['tentatives'] ?></div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
