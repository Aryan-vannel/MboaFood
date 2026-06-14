# TODO - Uniformiser CodeIgniter en 4.7.3

- [ ] 1) Inspecter `public/index.php` et `spark` (bootstrapping / paths)
- [ ] 2) Vérifier qu’il n’y a qu’une seule installation du framework (pas de duplications `vendor/` ou autre dossier `system/`)
- [ ] 3) Rechercher dans tout le projet des artefacts de version (CI_VERSION, strings CodeIgniter, codeigniter4/framework, etc.)
- [ ] 4) Si duplications trouvées: supprimer/neutraliser les copies erronées et corriger l’autoload / paths
- [ ] 5) Pinner le framework exactement à `4.7.3` dans `composer.json` puis exécuter `composer install`
- [x] 6) Lancer un test rapide (ex: `php spark routes`) pour valider que CI4 charge correctement

✅ Statut actuel:
- CI4 charge (spark routes OK) et le framework est cohérent en 4.7.3.


