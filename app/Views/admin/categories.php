<div style="display:grid;grid-template-columns:1fr 360px;gap:1.5rem;align-items:start;">
    <div class="card">
        <table class="table">
            <thead><tr><th>Nom</th><th>Description</th><th>Actions</th></tr></thead>
            <tbody>
            <?php foreach ($categories as $cat): ?>
            <tr>
                <td><strong><?= esc($cat['nom']) ?></strong></td>
                <td style="color:var(--gray);font-size:.85rem;"><?= esc($cat['description']) ?></td>
                <td>
                    <form action="<?= base_url('/admin/categorie/supprimer/'.$cat['id']) ?>" method="POST" onsubmit="return confirm('Supprimer cette catégorie ?')"><?= csrf_field() ?><button class="btn btn-danger btn-sm">🗑️</button></form>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="card">
        <div class="card-header"><h3>Nouvelle catégorie</h3></div>
        <div class="card-body">
            <form action="<?= base_url('/admin/categorie/ajouter') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="form-group"><label class="form-label">Nom *</label><input type="text" name="nom" class="form-control" required placeholder="Ex: Plats locaux"></div>
                <div class="form-group"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="2" placeholder="Brève description…"></textarea></div>
                <button class="btn btn-primary btn-block">Ajouter</button>
            </form>
        </div>
    </div>
</div>
