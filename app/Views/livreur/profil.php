<div style="max-width:500px;">
    <div class="card">
        <div class="card-header">
            <div style="display:flex;align-items:center;gap:1rem;">
                <div style="width:56px;height:56px;background:var(--secondary);border-radius:50%;display:flex;align-items:center;justify-content:center;color:var(--dark);font-size:1.5rem;font-weight:700;">
                    <?= strtoupper(substr($user['nom'], 0, 1)) ?>
                </div>
                <div>
                    <h3><?= esc($user['nom']) ?></h3>
                    <span class="badge" style="background:var(--secondary);color:var(--dark);">🚴 Livreur</span>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div style="display:flex;flex-direction:column;gap:.7rem;">
                <div style="display:flex;padding:.6rem;background:var(--light);border-radius:var(--radius);">
                    <span style="color:var(--gray);min-width:120px;font-size:.85rem;">Email</span>
                    <strong><?= esc($user['email']) ?></strong>
                </div>
                <div style="display:flex;padding:.6rem;background:var(--light);border-radius:var(--radius);">
                    <span style="color:var(--gray);min-width:120px;font-size:.85rem;">Téléphone</span>
                    <strong><?= esc($user['telephone'] ?? '—') ?></strong>
                </div>
                <div style="display:flex;padding:.6rem;background:var(--light);border-radius:var(--radius);">
                    <span style="color:var(--gray);min-width:120px;font-size:.85rem;">Membre depuis</span>
                    <strong><?= date('d/m/Y', strtotime($user['created_at'])) ?></strong>
                </div>
                <div style="display:flex;padding:.6rem;background:var(--light);border-radius:var(--radius);">
                    <span style="color:var(--gray);min-width:120px;font-size:.85rem;">Statut</span>
                    <span class="badge badge-<?= $user['actif'] ? 'acceptee' : 'annulee' ?>"><?= $user['actif'] ? 'Actif' : 'Inactif' ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
