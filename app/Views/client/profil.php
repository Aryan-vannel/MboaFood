<?php
/** @var array $user */
$user ??= [];
?>
<section style="padding:2rem 0;">

    <div class="container" style="max-width:600px;">
        <h2 style="margin-bottom:1.5rem;">Mon Profil</h2>
        <div class="card">
            <div class="card-header">
                <div style="display:flex;align-items:center;gap:1rem;">
                    <div style="width:56px;height:56px;background:var(--primary);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.5rem;font-weight:700;"><?= strtoupper(substr($user['nom'],0,1)) ?></div>
                    <div><h3><?= esc($user['nom']) ?></h3><p style="color:var(--gray);font-size:.85rem;"><?= esc($user['email']) ?></p></div>
                </div>
            </div>
            <div class="card-body">
                <form action="<?= base_url('/client/profil/modifier') ?>" method="POST">
                    <?= csrf_field() ?>
                    <div class="form-group"><label class="form-label">Nom complet</label><input type="text" name="nom" class="form-control" value="<?= esc($user['nom']) ?>" required></div>
                    <div class="form-group"><label class="form-label">Téléphone</label><input type="text" name="telephone" class="form-control" value="<?= esc($user['telephone'] ?? '') ?>"></div>
                    <div class="form-group">
                        <label class="form-label">Nouveau mot de passe <small style="color:var(--gray);font-weight:400;">(laisser vide si inchangé)</small></label>
                        <input type="password" name="password" class="form-control" placeholder="Minimum 6 caractères">
                    </div>
                    <button class="btn btn-primary btn-block">💾 Enregistrer</button>
                </form>
            </div>
        </div>
    </div>
</section>
