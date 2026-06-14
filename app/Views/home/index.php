<!-- HERO -->
<section class="hero">
    <div class="container hero-content" style="padding:4rem 1.5rem;">
        <div class="animate-in">
            <p style="color:var(--secondary);font-weight:600;text-transform:uppercase;letter-spacing:2px;margin-bottom:1rem;font-size:.85rem;">🔥 Livraison rapide à Douala</p>
            <h1 style="color:var(--white);">La cuisine <span style="color:var(--secondary);">camerounaise</span><br>à votre porte</h1>
            <p style="color:var(--gray-l);margin:1.5rem 0;font-size:1.05rem;max-width:500px;">Ndolé, Eru, Poulet DG… Découvrez les meilleures spécialités de nos cuisines traditionnelles livrées chez vous.</p>
            <div style="display:flex;gap:1rem;flex-wrap:wrap;">
                <a href="<?= base_url('/menu') ?>" class="btn btn-primary btn-lg">Voir le menu 🍽️</a>
                <a href="<?= base_url('/auth/register') ?>" class="btn btn-lg" style="background:rgba(255,255,255,.1);color:#fff;border:2px solid rgba(255,255,255,.3);">Commander maintenant</a>
            </div>
        </div>
    </div>
</section>

<!-- CATÉGORIES -->
<?php if (!empty($categories)): ?>
<section class="section" style="background:var(--white);padding:3rem 0;">
    <div class="container">
        <h2 class="section-title text-center">Nos Catégories</h2>
        <p class="section-sub text-center">Une sélection variée pour tous les goûts</p>
        <div style="display:flex;gap:1rem;flex-wrap:wrap;justify-content:center;margin-top:1.5rem;">
            <?php foreach ($categories as $cat): ?>
            <a href="<?= base_url('/menu') ?>"
               style="background:var(--light);border:2px solid var(--light-2);border-radius:50px;padding:.55rem 1.4rem;font-weight:600;color:var(--dark);transition:var(--trans);"
               onmouseover="this.style.background='var(--primary)';this.style.color='#fff';this.style.borderColor='var(--primary)'"
               onmouseout="this.style.background='var(--light)';this.style.color='var(--dark)';this.style.borderColor='var(--light-2)'">
                <?= esc($cat['nom']) ?>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- PLATS VEDETTE -->
<section class="section">
    <div class="container">
        <div style="display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:2rem;flex-wrap:wrap;gap:1rem;">
            <div>
                <h2 class="section-title">Nos Spécialités</h2>
                <p class="section-sub" style="margin:0;">Les plats les plus appréciés de nos clients</p>
            </div>
            <a href="<?= base_url('/menu') ?>" class="btn btn-outline">Voir tout le menu →</a>
        </div>
        <div class="grid grid-3">
            <?php foreach ($plats_vedette as $i => $plat): ?>
            <div class="card plat-card animate-in stagger-<?= ($i % 3) + 1 ?>">
                <div class="plat-img">
                    <?php if (!empty($plat['image'])): ?>
                    <img src="<?= base_url($plat['image']) ?>" alt="<?= esc($plat['nom']) ?>">
                    <?php else: ?>
                    <div class="plat-placeholder">🍽️</div>
                    <?php endif; ?>
                    <span class="plat-badge"><?= esc($plat['categorie_nom'] ?? 'Spécialité') ?></span>
                </div>
                <div class="card-body">
                    <h3 style="margin-bottom:.4rem;"><?= esc($plat['nom']) ?></h3>
                    <p style="color:var(--gray);font-size:.85rem;margin-bottom:1rem;line-height:1.5;"><?= character_limiter(esc($plat['description']), 80) ?></p>
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <span class="plat-price"><?= number_format($plat['prix'], 0, ',', '.') ?> FCFA</span>
                        <?php if (session()->get('user_role') === 'client'): ?>
                        <form action="<?= base_url('/client/panier/ajouter') ?>" method="POST" style="display:inline;">
                            <?= csrf_field() ?>
                            <input type="hidden" name="plat_id" value="<?= $plat['id'] ?>">
                            <input type="hidden" name="quantite" value="1">
                            <button type="submit" class="btn btn-primary btn-sm">+ Ajouter</button>
                        </form>
                        <?php else: ?>
                        <a href="<?= base_url('/auth/login') ?>" class="btn btn-outline btn-sm">Commander</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- COMMENT ÇA MARCHE -->
<section class="section" style="background:var(--dark-soft);">
    <div class="container">
        <h2 class="section-title text-center" style="color:var(--white);">Comment ça marche ?</h2>
        <p class="section-sub text-center" style="color:var(--gray-l);">Commander en 4 étapes simples</p>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:2rem;margin-top:2rem;">
            <?php foreach ([
                ['🔐','1. Créez un compte','Inscrivez-vous gratuitement en quelques secondes.'],
                ['🍽️','2. Choisissez vos plats','Parcourez notre menu et ajoutez au panier.'],
                ['✅','3. Validez la commande','Confirmez votre adresse et passez commande.'],
                ['🚴','4. Recevez chez vous','Notre livreur vous apporte votre repas chaud.'],
            ] as $s): ?>
            <div style="text-align:center;padding:1.5rem;">
                <div style="font-size:2.5rem;margin-bottom:1rem;"><?= $s[0] ?></div>
                <h3 style="color:var(--secondary);margin-bottom:.5rem;font-size:1rem;"><?= $s[1] ?></h3>
                <p style="color:var(--gray-l);font-size:.85rem;"><?= $s[2] ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
