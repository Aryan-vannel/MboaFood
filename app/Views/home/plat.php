<section style="padding:3rem 0;">
    <div class="container" style="max-width:900px;">
        <a href="<?= base_url('/menu') ?>" style="color:var(--gray);font-size:.9rem;display:inline-block;margin-bottom:1.5rem;">← Retour au menu</a>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:3rem;align-items:start;">
            <!-- Image -->
            <div style="border-radius:var(--radius-lg);overflow:hidden;box-shadow:var(--shadow-lg);aspect-ratio:4/3;">
                <?php if (!empty($plat['image'])): ?>
                <img src="<?= base_url($plat['image']) ?>" alt="<?= esc($plat['nom']) ?>"
                     style="width:100%;height:100%;object-fit:cover;">
                <?php else: ?>
                <div style="width:100%;height:100%;background:linear-gradient(135deg,var(--light-2),var(--gray-l));
                            display:flex;align-items:center;justify-content:center;font-size:6rem;min-height:300px;">
                    🍽️
                </div>
                <?php endif; ?>
            </div>

            <!-- Infos -->
            <div>
                <span style="background:var(--light-2);color:var(--gray);padding:.3rem .8rem;border-radius:50px;font-size:.8rem;font-weight:600;text-transform:uppercase;letter-spacing:.5px;">
                    <?= esc($plat['categorie_nom'] ?? 'Spécialité') ?>
                </span>
                <h1 style="font-family:var(--font-disp);margin:1rem 0 .5rem;font-size:2.2rem;">
                    <?= esc($plat['nom']) ?>
                </h1>
                <p style="color:var(--gray);line-height:1.7;margin-bottom:1.5rem;">
                    <?= esc($plat['description']) ?>
                </p>
                <div style="font-family:var(--font-disp);font-size:2.2rem;font-weight:700;color:var(--primary);margin-bottom:2rem;">
                    <?= number_format($plat['prix'], 0, ',', '.') ?> FCFA
                </div>

                <?php if (session()->get('user_role') === 'client'): ?>
                <form action="<?= base_url('/client/panier/ajouter') ?>" method="POST">
                    <?= csrf_field() ?>
                    <input type="hidden" name="plat_id" value="<?= $plat['id'] ?>">
                    <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1rem;">
                        <label style="font-weight:600;font-size:.85rem;text-transform:uppercase;letter-spacing:.5px;">Quantité</label>
                        <input type="number" name="quantite" value="1" min="1" max="10"
                               style="width:70px;padding:.5rem;border:2px solid var(--light-2);border-radius:var(--radius);text-align:center;font-size:1rem;">
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg" style="width:100%;">
                        🛒 Ajouter au panier
                    </button>
                </form>
                <?php else: ?>
                <a href="<?= base_url('/auth/login') ?>" class="btn btn-primary btn-lg" style="width:100%;justify-content:center;">
                    Connectez-vous pour commander
                </a>
                <?php endif; ?>

                <div style="margin-top:1.5rem;padding:1rem;background:var(--light);border-radius:var(--radius);font-size:.85rem;color:var(--gray);">
                    🚴 Livraison rapide à Yaoundé<br>
                    ✅ Préparé à la commande<br>
                    🌶️ Épices traditionnelles camerounaises
                </div>
            </div>
        </div>
    </div>
</section>
