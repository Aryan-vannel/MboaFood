<?php if (empty($livraisons)): ?>
<div class="card" style="text-align:center;padding:3rem;">
    <div style="font-size:3rem;margin-bottom:1rem;">📭</div>
    <h3>Aucune livraison assignée</h3>
    <p style="color:var(--gray);margin-top:.5rem;">Revenez plus tard, l'admin vous assignera des livraisons.</p>
</div>
<?php else: ?>
<?php foreach ($livraisons as $l): ?>
<div class="card" style="margin-bottom:1rem;">
    <div class="card-body">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:1rem;">
            <div>
                <div style="font-size:.72rem;text-transform:uppercase;color:var(--gray);margin-bottom:.3rem;">Client</div>
                <strong><?= esc($l['client_nom']) ?></strong> — <span style="color:var(--gray);"><?= esc($l['client_tel']) ?></span>
                <div style="margin-top:.4rem;color:var(--gray);font-size:.85rem;">
                    📍 <?= esc($l['ville']) ?>, <?= esc($l['quartier']) ?>
                    <?php if (!empty($l['adresse'])): ?><br><small><?= esc($l['adresse']) ?></small><?php endif; ?>
                </div>
                <div style="margin-top:.5rem;">
                    <strong style="color:var(--primary);font-size:1.1rem;"><?= number_format($l['total'], 0, ',', '.') ?> FCFA</strong>
                </div>
            </div>
            <div style="display:flex;flex-direction:column;align-items:flex-end;gap:.5rem;">
                <span class="badge badge-<?= $l['statut'] ?>"><?= str_replace('_',' ',$l['statut']) ?></span>
                <a href="<?= base_url('/livreur/livraison/'.$l['id']) ?>" class="btn btn-primary btn-sm">Voir / Agir →</a>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
<?php endif; ?>
