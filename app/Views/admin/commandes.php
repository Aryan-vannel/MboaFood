<div style="display:flex;gap:.5rem;flex-wrap:wrap;margin-bottom:1.5rem;">
    <?php foreach (['' => 'Toutes','en_attente'=>'En attente','acceptee'=>'Acceptées','en_preparation'=>'En préparation','prete'=>'Prêtes','en_livraison'=>'En livraison','livree'=>'Livrées','annulee'=>'Annulées'] as $val => $lbl): ?>
    <a href="<?= base_url('/admin/commandes'.($val ? '?statut='.$val : '')) ?>" class="btn btn-sm <?= $filtre === $val ? 'btn-primary' : 'btn-outline' ?>"><?= $lbl ?></a>
    <?php endforeach; ?>
</div>
<div class="card">
    <?php if (empty($commandes)): ?>
    <div class="card-body" style="text-align:center;padding:3rem;color:var(--gray);">Aucune commande trouvée.</div>
    <?php else: ?>
    <table class="table">
        <thead><tr><th>#</th><th>Client</th><th>Date</th><th>Total</th><th>Statut</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach ($commandes as $cmd): ?>
        <tr>
            <td><strong>#<?= $cmd['id'] ?></strong></td>
            <td><div style="font-weight:600;"><?= esc($cmd['client_nom']) ?></div><div style="font-size:.8rem;color:var(--gray);"><?= esc($cmd['client_tel']) ?></div></td>
            <td style="font-size:.85rem;"><?= date('d/m/Y H:i', strtotime($cmd['created_at'])) ?></td>
            <td><strong><?= number_format($cmd['total'], 0, ',', '.') ?> FCFA</strong></td>
            <td><span class="badge badge-<?= $cmd['statut'] ?>"><?= str_replace('_',' ',$cmd['statut']) ?></span></td>
            <td><a href="<?= base_url('/admin/commande/'.$cmd['id']) ?>" class="btn btn-outline btn-sm">Gérer →</a></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>
