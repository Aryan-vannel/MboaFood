<div style="max-width:600px;">
    <a href="<?= base_url('/admin/plats') ?>" style="color:var(--gray);margin-bottom:1rem;display:inline-block;">← Retour aux plats</a>
    <div class="card">
        <div class="card-body" style="padding:2rem;">
            <form action="<?= base_url('/admin/plat/' . ($plat ? 'modifier/' . $plat['id'] : 'ajouter')) ?>"
                  method="POST"
                  enctype="multipart/form-data">
                <?= csrf_field() ?>

                <!-- Catégorie -->
                <div class="form-group">
                    <label class="form-label">Catégorie</label>
                    <select name="categorie_id" class="form-control">
                        <option value="">-- Aucune --</option>
                        <?php
                        // BUG FIX : ne pas accéder à $plat['categorie_id'] si $plat est null
                        $platCategorieId = ($plat !== null) ? ($plat['categorie_id'] ?? '') : '';
                        foreach ($categories as $cat):
                        ?>
                        <option value="<?= (int) $cat['id'] ?>"
                            <?= ((string) $platCategorieId === (string) $cat['id']) ? 'selected' : '' ?>>
                            <?= esc($cat['nom']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Nom -->
                <div class="form-group">
                    <label class="form-label">Nom du plat *</label>
                    <input type="text"
                           name="nom"
                           class="form-control"
                           value="<?= esc($plat['nom'] ?? '') ?>"
                           required
                           placeholder="Ex: Ndolé au poisson">
                </div>

                <!-- Description -->
                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="description"
                              class="form-control"
                              rows="3"
                              placeholder="Décrivez le plat…"><?= esc($plat['description'] ?? '') ?></textarea>
                </div>

                <!-- Prix -->
                <div class="form-group">
                    <label class="form-label">Prix (FCFA) *</label>
                    <input type="number"
                           name="prix"
                           class="form-control"
                           value="<?= isset($plat['prix']) ? (int) $plat['prix'] : '' ?>"
                           required
                           min="0"
                           placeholder="2500">
                </div>

                <!-- Image -->
                <div class="form-group">
                    <label class="form-label">Image</label>
                    <input type="file" name="image" class="form-control" accept="image/jpeg,image/png,image/gif,image/webp">
                    <?php if (!empty($plat['image'])): ?>
                    <div style="margin-top:.6rem;display:flex;align-items:center;gap:.7rem;">
                        <img src="<?= base_url($plat['image']) ?>"
                             style="height:60px;border-radius:8px;object-fit:cover;">
                        <small style="color:var(--gray);">Image actuelle — laisser vide pour la garder</small>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Boutons -->
                <div style="display:flex;gap:1rem;margin-top:1.5rem;">
                    <button type="submit" class="btn btn-primary">
                        <?= $plat ? '💾 Modifier' : '➕ Ajouter' ?>
                    </button>
                    <a href="<?= base_url('/admin/plats') ?>" class="btn btn-outline">Annuler</a>
                </div>

            </form>
        </div>
    </div>
</div>
