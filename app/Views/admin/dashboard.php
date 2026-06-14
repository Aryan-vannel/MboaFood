<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1rem;margin-bottom:2rem;">
    <div class="stat-card"><div class="stat-icon orange">🛒</div><div><div class="stat-val"><?= $stats['total'] ?></div><div class="stat-label">Commandes</div></div></div>
    <div class="stat-card"><div class="stat-icon yellow">⏳</div><div><div class="stat-val"><?= $stats['en_attente'] ?></div><div class="stat-label">En attente</div></div></div>
    <div class="stat-card"><div class="stat-icon blue">🔄</div><div><div class="stat-val"><?= $stats['en_cours'] ?></div><div class="stat-label">En cours</div></div></div>
    <div class="stat-card"><div class="stat-icon green">✅</div><div><div class="stat-val"><?= $stats['livrees'] ?></div><div class="stat-label">Livrées</div></div></div>
    <div class="stat-card"><div class="stat-icon orange">💰</div><div><div class="stat-val" style="font-size:1.1rem;"><?= number_format($stats['chiffre_affaires'], 0, ',', '.') ?></div><div class="stat-label">CA (FCFA)</div></div></div>
    <div class="stat-card"><div class="stat-icon blue">👥</div><div><div class="stat-val"><?= $stats['total_clients'] ?></div><div class="stat-label">Clients</div></div></div>
</div>
<div class="card">
    <div class="card-header" style="display:flex;justify-content:space-between;align-items:center;">
        <h3>Commandes récentes</h3>
        <a href="<?= base_url('/admin/commandes') ?>" class="btn btn-outline btn-sm">Voir tout</a>
    </div>
    <?php if (empty($dernieres_commandes)): ?>
    <div class="card-body" style="text-align:center;color:var(--gray);padding:2rem;">Aucune commande pour l'instant.</div>
    <?php else: ?>
    <table class="table">
        <thead><tr><th>#</th><th>Client</th><th>Date</th><th>Total</th><th>Statut</th><th></th></tr></thead>
        <tbody>
        <?php foreach (array_slice($dernieres_commandes, 0, 10) as $cmd): ?>
        <tr>
            <td><strong>#<?= $cmd['id'] ?></strong></td>
            <td><div style="font-weight:600;"><?= esc($cmd['client_nom']) ?></div><div style="font-size:.8rem;color:var(--gray);"><?= esc($cmd['client_tel']) ?></div></td>
            <td style="font-size:.85rem;color:var(--gray);"><?= date('d/m/Y H:i', strtotime($cmd['created_at'])) ?></td>
            <td><strong><?= number_format($cmd['total'], 0, ',', '.') ?> FCFA</strong></td>
            <td><span class="badge badge-<?= $cmd['statut'] ?>"><?= str_replace('_',' ',$cmd['statut']) ?></span></td>
            <td><a href="<?= base_url('/admin/commande/'.$cmd['id']) ?>" class="btn btn-outline btn-sm">Gérer →</a></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>
