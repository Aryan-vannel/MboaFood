<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>Numéro</th>
                <th>Client</th>
                <th>Commande</th>
                <th>Montant TTC</th>
                <th>Date</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($factures)): ?>
        <tr><td colspan="6" style="text-align:center;padding:2rem;color:var(--gray);">Aucune facture générée.</td></tr>
        <?php else: ?>
        <?php foreach ($factures as $f): ?>
        <tr>
            <td><strong><?= esc($f['numero']) ?></strong></td>
            <td><?= esc($f['client_nom']) ?></td>
            <td><a href="<?= base_url('/admin/commande/'.$f['commande_id']) ?>">#<?= $f['commande_id'] ?></a></td>
            <td><strong><?= number_format($f['montant_ttc'], 0, ',', '.') ?> FCFA</strong></td>
            <td style="font-size:.85rem;color:var(--gray);"><?= date('d/m/Y', strtotime($f['date_facture'])) ?></td>
            <td><a href="<?= base_url('/admin/facture/'.$f['id']) ?>" class="btn btn-outline btn-sm">🧾 Voir</a></td>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>
