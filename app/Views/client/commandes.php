<section style="padding:2rem 0;">
    <div class="container">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;">
            <h2>Mes Commandes</h2>
            <a href="<?= base_url('/client/menu') ?>" class="btn btn-primary">+ Nouvelle commande</a>
        </div>
        <?php if (empty($commandes)): ?>
        <div class="card" style="text-align:center;padding:3rem;">
            <div style="font-size:4rem;margin-bottom:1rem;">📋</div>
            <h3>Aucune commande</h3>
            <p style="color:var(--gray);margin:.5rem 0 1.5rem;">Vous n'avez pas encore passé de commande.</p>
            <a href="<?= base_url('/client/menu') ?>" class="btn btn-primary">Commander maintenant</a>
        </div>
        <?php else: ?>
        <div class="card">
            <table class="table">
                <thead><tr><th>Commande</th><th>Date</th><th>Total</th><th>Statut</th><th>Actions</th></tr></thead>
                <tbody>
                <?php foreach ($commandes as $cmd): ?>
                <tr>
                    <td><strong>#<?= $cmd['id'] ?></strong></td>
                    <td style="color:var(--gray);font-size:.85rem;"><?= date('d/m/Y', strtotime($cmd['created_at'])) ?><br><small><?= date('H:i', strtotime($cmd['created_at'])) ?></small></td>
                    <td><strong><?= number_format($cmd['total'], 0, ',', '.') ?> FCFA</strong></td>
                    <td><span class="badge badge-<?= $cmd['statut'] ?>"><?= str_replace('_',' ',$cmd['statut']) ?></span></td>
                    <td style="display:flex;gap:.4rem;flex-wrap:wrap;">
                        <a href="<?= base_url('/client/commande/' . (int)$cmd['id']) ?>" class="btn btn-outline btn-sm">Voir</a>

                        <?php if (in_array($cmd['statut'], ['en_attente','acceptee','en_preparation'])): ?>
                        <form action="<?= base_url('/client/commande/annuler/'.$cmd['id']) ?>" method="POST" onsubmit="return confirm('Annuler cette commande ?')">
                            <?= csrf_field() ?>
                            <button class="btn btn-danger btn-sm">Annuler</button>
                        </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</section>
