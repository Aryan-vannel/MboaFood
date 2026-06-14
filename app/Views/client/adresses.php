<section style="padding:2rem 0;">
    <div class="container" style="max-width:800px;">
        <h2 style="margin-bottom:1.5rem;">Mes Adresses de Livraison</h2>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;align-items:start;">
            <div>
                <?php if (empty($adresses)): ?>
                <div class="alert alert-info">Aucune adresse enregistrée.</div>
                <?php else: ?>
                <?php foreach ($adresses as $adr): ?>
                <div class="card" style="margin-bottom:1rem;">
                    <div class="card-body">
                        <div style="display:flex;justify-content:space-between;align-items:flex-start;">
                            <div>
                                <strong><?= esc($adr['ville']) ?> — <?= esc($adr['quartier']) ?></strong>
                                <?php if ($adr['is_default']): ?><span class="badge" style="background:var(--secondary);color:var(--dark);margin-left:.5rem;">Par défaut</span><?php endif; ?>
                                <?php if ($adr['description']): ?><p style="color:var(--gray);font-size:.85rem;margin-top:.3rem;"><?= esc($adr['description']) ?></p><?php endif; ?>
                            </div>
                            <form action="<?= base_url('/client/adresse/supprimer/'.$adr['id']) ?>" method="POST" onsubmit="return confirm('Supprimer ?')">
                                <?= csrf_field() ?><button class="btn btn-danger btn-sm">✕</button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="card">
                <div class="card-header"><h3>Ajouter une adresse</h3></div>
                <div class="card-body">
                    <form action="<?= base_url('/client/adresse/ajouter') ?>" method="POST">
                        <?= csrf_field() ?>
                        <div class="form-group"><label class="form-label">Ville</label><input type="text" name="ville" class="form-control" placeholder="Yaoundé" required></div>
                        <div class="form-group"><label class="form-label">Quartier</label><input type="text" name="quartier" class="form-control" placeholder="Bastos, Nlongkak…" required></div>
                        <div class="form-group"><label class="form-label">Description</label><textarea name="description" class="form-control" placeholder="Repères, bâtiment…" rows="2"></textarea></div>
                        <div style="display:flex;align-items:center;gap:.5rem;margin-bottom:1rem;">
                            <input type="checkbox" name="is_default" id="is_default">
                            <label for="is_default" style="cursor:pointer;font-size:.9rem;">Adresse par défaut</label>
                        </div>
                        <button class="btn btn-primary btn-block">Ajouter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
