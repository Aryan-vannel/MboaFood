<div style="min-height:calc(100vh - 70px);display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,var(--dark),var(--dark-soft));padding:2rem;">
    <div style="width:100%;max-width:420px;">
        <div style="text-align:center;margin-bottom:2rem;">
            <div style="font-family:var(--font-disp);font-size:2rem;font-weight:900;color:var(--secondary);">Mboa<span style="color:var(--primary-l);">Food</span></div>
            <p style="color:var(--gray-l);margin-top:.5rem;">Connectez-vous à votre compte</p>
        </div>
        <div class="card">
            <div class="card-body" style="padding:2rem;">
                <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error"><?= esc(session()->getFlashdata('error')) ?></div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
                <?php endif; ?>
                <form action="<?= base_url('/auth/login') ?>" method="POST">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label class="form-label">Adresse email</label>
                        <input type="email" name="email" class="form-control" placeholder="votre@email.com" required value="<?= old('email') ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Mot de passe</label>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block btn-lg" style="margin-top:1rem;">Se connecter</button>
                </form>
                <div style="margin-top:1.5rem;padding-top:1.5rem;border-top:1px solid var(--light-2);text-align:center;">
                    <p style="color:var(--gray);font-size:.9rem;">Pas encore de compte ? <a href="<?= base_url('/auth/register') ?>" style="font-weight:600;">Créer un compte</a></p>
                </div>
                <div style="margin-top:1rem;padding:.8rem;background:var(--light);border-radius:var(--radius);font-size:.75rem;color:var(--gray);">
                    <strong>Comptes démo :</strong> admin@mboafood.cm / client@mboafood.cm / livreur@mboafood.cm<br>
                    <em>Mot de passe : <strong>password</strong></em>
                </div>
            </div>
        </div>
    </div>
</div>
