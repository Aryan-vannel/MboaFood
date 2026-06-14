<div style="max-width:700px;">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;flex-wrap:wrap;gap:1rem;">
        <a href="<?= base_url('/admin/factures') ?>" style="color:var(--gray);">← Toutes les factures</a>
        <button onclick="window.print()" class="btn btn-dark btn-sm">🖨️ Imprimer</button>
    </div>

    <div class="facture-header">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:1rem;">
            <div>
                <div style="font-family:var(--font-disp);font-size:2rem;font-weight:900;color:var(--secondary);">Mboa<span style="color:var(--primary-l);">Food</span></div>
                <p style="color:rgba(255,255,255,.6);font-size:.85rem;margin-top:.3rem;">Yaoundé, Cameroun — +237 677 000 000</p>
            </div>
            <div style="text-align:right;">
                <div style="font-size:.72rem;text-transform:uppercase;letter-spacing:1px;color:rgba(255,255,255,.5);">Facture</div>
                <div style="font-size:1.5rem;font-weight:700;color:var(--secondary);"><?= esc($facture['numero']) ?></div>
                <div style="color:rgba(255,255,255,.6);font-size:.85rem;"><?= date('d/m/Y', strtotime($facture['date_facture'])) ?></div>
            </div>
        </div>
    </div>

    <div class="facture-body">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:2rem;margin-bottom:1.5rem;">
            <div>
                <div style="font-size:.72rem;text-transform:uppercase;letter-spacing:1px;color:var(--gray);margin-bottom:.4rem;">Facturé à</div>
                <strong><?= esc($facture['client_nom']) ?></strong><br>
                <span style="color:var(--gray);font-size:.85rem;"><?= esc($facture['client_email']) ?></span><br>
                <?php if ($facture['telephone']): ?>
                <span style="color:var(--gray);font-size:.85rem;"><?= esc($facture['telephone']) ?></span>
                <?php endif; ?>
            </div>
            <div>
                <div style="font-size:.72rem;text-transform:uppercase;letter-spacing:1px;color:var(--gray);margin-bottom:.4rem;">Commande</div>
                <strong>#<?= $commande['id'] ?></strong><br>
                <span style="color:var(--gray);font-size:.85rem;"><?= date('d/m/Y à H:i', strtotime($commande['created_at'])) ?></span>
            </div>
        </div>

        <table class="table" style="margin-bottom:1.5rem;">
            <thead><tr><th>Plat</th><th>Prix unit.</th><th>Qté</th><th>Total</th></tr></thead>
            <tbody>
            <?php foreach ($commande['lignes'] as $l): ?>
            <tr>
                <td><?= esc($l['plat_nom']) ?></td>
                <td><?= number_format($l['prix_unitaire'], 0, ',', '.') ?> FCFA</td>
                <td><?= $l['quantite'] ?></td>
                <td><strong><?= number_format($l['prix_unitaire'] * $l['quantite'], 0, ',', '.') ?> FCFA</strong></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <div style="max-width:280px;margin-left:auto;">
            <div style="display:flex;justify-content:space-between;padding:.4rem 0;font-size:.9rem;border-bottom:1px solid var(--light-2);">
                <span style="color:var(--gray);">Montant HT</span>
                <span><?= number_format($facture['montant_ht'], 0, ',', '.') ?> FCFA</span>
            </div>
            <div style="display:flex;justify-content:space-between;padding:.4rem 0;font-size:.9rem;border-bottom:1px solid var(--light-2);">
                <span style="color:var(--gray);">TVA (0%)</span>
                <span>0 FCFA</span>
            </div>
            <div class="facture-total" style="margin-top:.7rem;">
                <span>Total TTC</span>
                <span><?= number_format($facture['montant_ttc'], 0, ',', '.') ?> FCFA</span>
            </div>
        </div>

        <div style="margin-top:2rem;padding-top:1.5rem;border-top:1px solid var(--light-2);text-align:center;color:var(--gray);font-size:.8rem;">
            Merci pour votre commande ! MboaFood — La cuisine camerounaise à votre porte.
        </div>
    </div>
</div>
<style>@media print { .admin-sidebar, .admin-header, .btn { display:none !important; } .admin-main { padding:0; } }</style>
