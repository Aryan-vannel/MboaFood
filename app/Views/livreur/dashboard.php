<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1rem;margin-bottom:2rem;">
    <div class="stat-card">
        <div class="stat-icon yellow">📦</div>
        <div><div class="stat-val"><?= count($en_cours) ?></div><div class="stat-label">En cours</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">✅</div>
        <div><div class="stat-val"><?= count($historique) ?></div><div class="stat-label">Terminées récentes</div></div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;">
    <div>
        <h3 style="margin-bottom:1rem;">📦 Livraisons en cours</h3>
        <?php if (empty($en_cours)): ?>
        <div class="card" style="padding:2rem;text-align:center;color:var(--gray);">
            <div style="font-size:2.5rem;margin-bottom:.5rem;">📭</div>
            <p>Aucune livraison assignée.</p>
        </div>
        <?php else: ?>
        <?php foreach ($en_cours as $l): ?>
        <div class="card" style="margin-bottom:1rem;">
            <div class="card-body">
                <div style="display:flex;justify-content:space-between;align-items:flex-start;">
                    <div>
                        <strong><?= esc($l['client_nom']) ?></strong> — <span style="color:var(--gray);font-size:.85rem;"><?= esc($l['client_tel']) ?></span><br>
                        <span style="color:var(--gray);font-size:.85rem;">📍 <?= esc($l['ville']) ?>, <?= esc($l['quartier']) ?></span><br>
                        <strong style="color:var(--primary);"><?= number_format($l['total'], 0, ',', '.') ?> FCFA</strong>
                    </div>
                    <span class="badge badge-<?= $l['statut'] ?>"><?= $l['statut'] ?></span>
                </div>
                <div style="margin-top:.8rem;">
                    <a href="<?= base_url('/livreur/livraison/'.$l['id']) ?>" class="btn btn-primary btn-sm">Gérer →</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div>
        <h3 style="margin-bottom:1rem;">📋 Historique récent</h3>
        <?php if (empty($historique)): ?>
        <div class="card" style="padding:2rem;text-align:center;color:var(--gray);">
            <div style="font-size:2.5rem;margin-bottom:.5rem;">📜</div>
            <p>Aucun historique.</p>
        </div>
        <?php else: ?>
        <?php foreach ($historique as $l): ?>
        <div class="card" style="margin-bottom:.8rem;">
            <div class="card-body" style="padding:1rem;">
                <div style="display:flex;justify-content:space-between;align-items:center;">
                    <div>
                        <strong style="font-size:.9rem;"><?= esc($l['client_nom']) ?></strong><br>
                        <span style="color:var(--gray);font-size:.8rem;">📍 <?= esc($l['ville']) ?>, <?= esc($l['quartier']) ?></span><br>
                        <strong style="font-size:.85rem;color:var(--primary);"><?= number_format($l['total'], 0, ',', '.') ?> FCFA</strong>
                    </div>
                    <span class="badge badge-<?= $l['statut'] ?>"><?= $l['statut'] ?></span>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
