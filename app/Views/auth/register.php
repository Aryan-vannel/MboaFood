<div style="min-height:calc(100vh - 70px);display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,var(--dark),var(--dark-soft));padding:2rem;">
    <div style="width:100%;max-width:460px;">
        <div style="text-align:center;margin-bottom:2rem;">
            <div style="font-family:var(--font-disp);font-size:2rem;font-weight:900;color:var(--secondary);">Mboa<span style="color:var(--primary-l);">Food</span></div>
            <p style="color:var(--gray-l);margin-top:.5rem;">Créez votre compte gratuitement</p>
        </div>
        <div class="card">
            <div class="card-body" style="padding:2rem;">
                <?php $errors = session()->getFlashdata('errors') ?? []; ?>
                <?php if (!empty($errors)): ?>
                <div class="alert alert-error">
                    <?php foreach ($errors as $e): ?><div>• <?= esc($e) ?></div><?php endforeach; ?>
                </div>
                <?php endif; ?>
                <form action="<?= base_url('/auth/register') ?>" method="POST">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label class="form-label">Nom complet *</label>
                        <input type="text" name="nom" class="form-control" placeholder="SINDJE Vannel" required value="<?= old('nom') ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email *</label>
                        <input type="email" name="email" class="form-control" placeholder="votre@email.com" required value="<?= old('email') ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Téléphone</label>
                        <input type="text" name="telephone" class="form-control" placeholder="+237 6XX XXX XXX" value="<?= old('telephone') ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Mot de passe * <small style="color:var(--gray);font-weight:400;">(min. 6 caractères)</small></label>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block btn-lg" style="margin-top:1rem;">Créer mon compte 🚀</button>
                </form>
                <div style="margin-top:1.5rem;text-align:center;border-top:1px solid var(--light-2);padding-top:1.5rem;">
                    <p style="color:var(--gray);font-size:.9rem;">Déjà un compte ? <a href="<?= base_url('/auth/login') ?>" style="font-weight:600;">Se connecter</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
