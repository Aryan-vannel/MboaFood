<?php
/** @var array $commande */
/** @var array|null $facture */
$commande ??= [];
$facture ??= null;
?>
<section style="padding:2rem 0;">

    <div class="container">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;flex-wrap:wrap;gap:1rem;">
            <div>
                <a href="<?= base_url('/client/commandes') ?>" style="color:var(--gray);font-size:.85rem;">← Mes commandes</a>
                <h2 style="margin-top:.3rem;">Commande <span style="color:var(--primary);">#<?= $commande['id'] ?></span></h2>
            </div>
            <span class="badge badge-<?= $commande['statut'] ?>" style="font-size:.9rem;padding:.5rem 1.2rem;"><?= str_replace('_',' ',strtoupper($commande['statut'])) ?></span>
        </div>

        <?php if ($commande['statut'] !== 'annulee'):
            $etapes  = ['en_attente','acceptee','en_preparation','prete','en_livraison','livree'];
            $labels  = ['Reçue','Acceptée','En préparation','Prête','En livraison','Livrée'];
            $cur     = array_search($commande['statut'], $etapes); ?>
        <div class="timeline" style="margin-bottom:2rem;">
            <?php foreach ($etapes as $i => $e): ?>
            <div class="timeline-step <?= $i < $cur ? 'done' : ($i === $cur ? 'active' : '') ?>"><?= $labels[$i] ?></div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="alert alert-error" style="margin-bottom:1.5rem;">❌ Cette commande a été annulée.</div>
        <?php endif; ?>

        <div style="display:grid;grid-template-columns:1fr 340px;gap:1.5rem;align-items:start;">
            <div>
                <div class="card" style="margin-bottom:1.5rem;">
                    <div class="card-header"><h3>🍽️ Articles commandés</h3></div>
                    <table class="table">
                        <thead><tr><th>Plat</th><th>Prix unit.</th><th>Qté</th><th>Sous-total</th></tr></thead>
                        <tbody>
                        <?php foreach ($commande['lignes'] as $l): ?>
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:.7rem;">
                                    <?php if (!empty($l['plat_image'])): ?><img src="<?= base_url($l['plat_image']) ?>" style="width:40px;height:40px;object-fit:cover;border-radius:6px;"><?php endif; ?>
                                    <strong><?= esc($l['plat_nom']) ?></strong>
                                </div>
                            </td>
                            <td><?= number_format($l['prix_unitaire'], 0, ',', '.') ?> FCFA</td>
                            <td>× <?= $l['quantite'] ?></td>
                            <td><strong><?= number_format($l['prix_unitaire'] * $l['quantite'], 0, ',', '.') ?> FCFA</strong></td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                        <tfoot><tr style="background:var(--light);">
                            <td colspan="3" style="text-align:right;font-weight:700;padding:1rem;">TOTAL</td>
                            <td style="font-weight:700;color:var(--primary);font-size:1.1rem;padding:1rem;"><?= number_format($commande['total'], 0, ',', '.') ?> FCFA</td>
                        </tr></tfoot>
                    </table>
                </div>
                <?php if ($commande['note']): ?>
                <div class="card"><div class="card-body"><h4 style="margin-bottom:.4rem;">📝 Note</h4><p style="color:var(--gray);"><?= esc($commande['note']) ?></p></div></div>
                <?php endif; ?>
            </div>
            <div>
                <div class="card" style="margin-bottom:1rem;">
                    <div class="card-header"><h3>📍 Livraison</h3></div>
                    <div class="card-body">
                        <?php if ($commande['ville']): ?>
                        <p><strong><?= esc($commande['ville']) ?> — <?= esc($commande['quartier']) ?></strong></p>
                        <?php if ($commande['adresse_desc']): ?><p style="color:var(--gray);font-size:.85rem;"><?= esc($commande['adresse_desc']) ?></p><?php endif; ?>
                        <?php else: ?><p style="color:var(--gray);">Aucune adresse spécifiée</p><?php endif; ?>
                    </div>
                </div>
                <div class="card" style="margin-bottom:1rem;">
                    <div class="card-header"><h3>ℹ️ Informations</h3></div>
                    <div class="card-body">
                        <div style="display:flex;flex-direction:column;gap:.5rem;font-size:.9rem;">
                            <div style="display:flex;justify-content:space-between;"><span style="color:var(--gray);">Date</span><span><?= date('d/m/Y à H:i', strtotime($commande['created_at'])) ?></span></div>
                            <div style="display:flex;justify-content:space-between;"><span style="color:var(--gray);">Référence</span><strong>#<?= $commande['id'] ?></strong></div>
                        </div>
                    </div>
                </div>
                <?php if ($facture): ?>
                <div class="card"><div class="card-body" style="text-align:center;">
                    <div style="font-size:2rem;margin-bottom:.5rem;">🧾</div>
                    <p style="font-weight:600;margin-bottom:.7rem;">Facture disponible</p>
                    <a href="<?= base_url('/client/facture/'.$facture['id']) ?>" class="btn btn-outline btn-block">Voir la facture</a>
                </div></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
