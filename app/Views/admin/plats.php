<div style="display:flex;justify-content:flex-end;margin-bottom:1rem;">
    <a href="<?= base_url('/admin/plat/ajouter') ?>" class="btn btn-primary">+ Ajouter un plat</a>
</div>
<div class="card">
    <table class="table">
        <thead><tr><th>Plat</th><th>Catégorie</th><th>Prix</th><th>Disponible</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach ($plats as $plat): ?>
        <tr>
            <td>
                <div style="display:flex;align-items:center;gap:.7rem;">
                    <?php if (!empty($plat['image'])): ?>
                    <img src="<?= base_url($plat['image']) ?>" style="width:44px;height:44px;object-fit:cover;border-radius:8px;">
                    <?php else: ?>
                    <div style="width:44px;height:44px;background:var(--light-2);border-radius:8px;display:flex;align-items:center;justify-content:center;">🍽️</div>
                    <?php endif; ?>
                    <div>
                        <strong><?= esc($plat['nom']) ?></strong>
                        <div style="font-size:.78rem;color:var(--gray);"><?= character_limiter(esc($plat['description']), 50) ?></div>
                    </div>
                </div>
            </td>
            <td><?= esc($plat['categorie_nom'] ?? '—') ?></td>
            <td><strong><?= number_format($plat['prix'], 0, ',', '.') ?> FCFA</strong></td>
            <td>
                <form action="<?= base_url('/admin/plat/toggle/'.$plat['id']) ?>" method="POST" style="display:inline;">
                    <?= csrf_field() ?>
                    <button class="btn btn-sm <?= $plat['disponible'] ? 'btn-success' : 'btn-danger' ?>"><?= $plat['disponible'] ? '✅ Dispo' : '❌ Indispo' ?></button>
                </form>
            </td>
            <td style="display:flex;gap:.4rem;flex-wrap:wrap;">
                <a href="<?= base_url('/admin/plat/modifier/'.$plat['id']) ?>" class="btn btn-outline btn-sm">✏️ Modifier</a>
                <form action="<?= base_url('/admin/plat/supprimer/'.$plat['id']) ?>" method="POST" onsubmit="return confirm('Supprimer ce plat ?')"><?= csrf_field() ?><button class="btn btn-danger btn-sm">🗑️</button></form>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
