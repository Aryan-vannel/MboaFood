<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;">
    <div>
        <h3 style="margin-bottom:1rem;">👤 Clients (<?= count($clients) ?>)</h3>
        <div class="card">
            <table class="table">
                <thead><tr><th>Nom</th><th>Email</th><th>Tél</th><th>Actif</th></tr></thead>
                <tbody>
                <?php foreach ($clients as $u): ?>
                <tr>
                    <td><strong><?= esc($u['nom']) ?></strong></td>
                    <td style="font-size:.82rem;"><?= esc($u['email']) ?></td>
                    <td style="font-size:.82rem;"><?= esc($u['telephone'] ?? '—') ?></td>
                    <td><form action="<?= base_url('/admin/utilisateur/toggle/'.$u['id']) ?>" method="POST"><?= csrf_field() ?><button class="btn btn-sm <?= $u['actif'] ? 'btn-success' : 'btn-danger' ?>"><?= $u['actif'] ? '✅' : '❌' ?></button></form></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div>
        <h3 style="margin-bottom:1rem;">🚴 Livreurs (<?= count($livreurs) ?>)</h3>
        <div class="card">
            <table class="table">
                <thead><tr><th>Nom</th><th>Email</th><th>Tél</th><th>Actif</th></tr></thead>
                <tbody>
                <?php foreach ($livreurs as $u): ?>
                <tr>
                    <td><strong><?= esc($u['nom']) ?></strong></td>
                    <td style="font-size:.82rem;"><?= esc($u['email']) ?></td>
                    <td style="font-size:.82rem;"><?= esc($u['telephone'] ?? '—') ?></td>
                    <td><form action="<?= base_url('/admin/utilisateur/toggle/'.$u['id']) ?>" method="POST"><?= csrf_field() ?><button class="btn btn-sm <?= $u['actif'] ? 'btn-success' : 'btn-danger' ?>"><?= $u['actif'] ? '✅' : '❌' ?></button></form></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
