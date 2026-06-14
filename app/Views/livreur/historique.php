<?php if (empty($livraisons)): ?>
<div class="card" style="text-align:center;padding:3rem;color:var(--gray);">
    <div style="font-size:3rem;margin-bottom:1rem;">📜</div>
    <p>Aucune livraison dans l'historique.</p>
</div>
<?php else: ?>
<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>Client</th>
                <th>Adresse</th>
                <th>Montant</th>
                <th>Statut</th>
                <th>Date livraison</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($livraisons as $l): ?>
        <tr>
            <td>
                <strong><?= esc($l['client_nom']) ?></strong><br>
                <span style="font-size:.8rem;color:var(--gray);"><?= esc($l['client_tel']) ?></span>
            </td>
            <td style="font-size:.85rem;">📍 <?= esc($l['ville']) ?>, <?= esc($l['quartier']) ?></td>
            <td><strong><?= number_format($l['total'], 0, ',', '.') ?> FCFA</strong></td>
            <td><span class="badge badge-<?= $l['statut'] ?>"><?= str_replace('_',' ',$l['statut']) ?></span></td>
            <td style="font-size:.82rem;color:var(--gray);">
                <?= !empty($l['date_livraison']) ? date('d/m/Y H:i', strtotime($l['date_livraison'])) : '—' ?>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>
