# WASLA — Plan d'intégration pour la 2ᵉ validation

> ## État d'avancement (15/11/2026)
>
> | Phase | État | Commit |
> |---|---|---|
> | 0 — Dépôt Git + `.gitignore` | ✅ | `chore: initialisation du dépôt et .gitignore` |
> | 1 — Squelette MVC (`index.php`, `routes.php`, `helpers.php`, `Controller.php`, `Model.php`) | ✅ | `feat: squelette MVC …` |
> | 2 — Assets du Front Office dans `app/Views/frontoffice/assets/` | ✅ | `chore(front): déplacement des assets du Front Office` |
> | 3 — Partials (head, header, footer, scripts) + layout | ✅ | `feat(front): extraction des partials …` |
> | 4 — 6 pages FO servies par `index.php?page=…` + 4 contrôleurs | ✅ vérifié : même structure HTML que les originaux, aucun fichier manquant, lien actif calculé en PHP | `feat(front): intégration des 6 pages en MVC …` |
> | 5 — Liens JS (`layout.js`, `data.js`) | ✅ 0 lien `.html` restant | `fix(front): liens JavaScript adaptés au routeur …` |
> | 6a — Prototype Back Office (`backoffice-prototype/`) | ✅ dashboard, liste type, formulaire type avec contrôle de saisie JS | `feat(back): prototype HTML du Back Office …` |
> | 6b — Intégration du Back Office (partials, sidebar dynamique, layout) | ✅ `index.php?page=dashboard`, `admin-interruptions`, `admin-interruption-form` ; prototype supprimé | `feat(back): intégration du Back Office …` |
> | 7 — Pages des modules | ⏳ à faire (chaque membre) | |
>
> **Comment ajouter une page Back Office (modèle pour les 4 modules)** :
> 1. copier `app/Views/backoffice/pages/interruptions/liste.php` (ou `form.php`) dans le dossier de son module et adapter les colonnes/champs à son entité ;
> 2. ajouter une méthode dans son contrôleur avec `'office' => 'backoffice'` et la bonne clé `'page'` ;
> 3. ajouter la route dans **son** bloc de `app/routes.php` : l'entrée correspondante de la sidebar devient cliquable toute seule (elle est grisée tant que la route n'existe pas) ;
> 4. si c'est un formulaire lié à une liste, ajouter sa clé dans le 3ᵉ élément du lien de la sidebar (ex. `['admin-alertes', 'Alertes', ['admin-alerte-form']]`) pour que le menu reste actif.
> | 8 — Models | ⏳ | |
> | 9 — Nettoyage, docs, README standardisé | ⏳ | |
>
> **Différence avec le code de la section 6.3** : `helpers.php` contient aussi `ariaCurrent()` (accessibilité du lien actif), `url()` (construit `index.php?page=…#ancre`), `isOpen()` (groupe ouvert de la sidebar, comme dans l'atelier), `routeExists()` et `pageUrl()` (n'activent un lien que si la page existe).

> Document de travail de l'équipe (Bechir, Houssem, Louay, Hiba).
> Il a été produit **sans rien modifier** dans le projet : c'est une proposition à valider avant toute action.
>
> Sources analysées :
> - Atelier « Intégration Template » (FR + version EN, contenu identique) ;
> - « Standardisation des dépôts GitHub – Projets PI » ;
> - « Guide pour rédiger un README » (PW 2026-2027) ;
> - le dossier `wasla_Copie` (6 pages HTML, assets, outils Node) ;
> - `WASLA_Dictionnaire_Entites.docx` (modules, entités, associations) ;
> - `WASLA_Diagrammes_UML_style_reference.pdf` (acteurs, cas d'utilisation global et par module, diagramme de classes global et par module).
>
> Répartition des modules :
>
> | Module | Responsable | Entités principales ⭐ | Entités bonus ➕ |
> |---|---|---|---|
> | 1 — Interruptions, signalements & alertes | **Houssem** | Interruption, Signalement | Alerte, Confirmation, Zone |
> | 2 — Analyse des factures & consommation | **Hiba** | Facture, Consommation | AnalyseFacture |
> | 3 — Refuge Zones | **Louay** | Entreprise, RefugeZone | ReservationRefuge |
> | 4 — Assistance d'urgence, solaire & fournisseurs | **Bechir** | DemandeAssistance, Reponse, Fournisseur | Service, InstallationSolaire |
> | Tables partagées | équipe | Utilisateur, Notification | — |

Légende utilisée partout :
- **[OBLIGATOIRE]** : demandé explicitement par un atelier ou par les règles du projet ;
- **[RECOMMANDÉ]** : bonne pratique proposée, pas exigée par les documents ;
- **[À CONFIRMER]** : information manquante, à vérifier avec vos tuteurs ou dans vos diagrammes.

---

## Sommaire

1. [Synthèse des 4 ateliers](#1-synthèse-des-4-ateliers)
2. [Ce que vous avez aujourd'hui](#2-ce-que-vous-avez-aujourdhui)
3. [Ce qui manque](#3-ce-qui-manque)
4. [Le MVC appliqué à WASLA](#4-le-mvc-appliqué-à-wasla)
5. [Structure finale recommandée du dépôt](#5-structure-finale-recommandée-du-dépôt)
6. [Comment transformer vos pages HTML](#6-comment-transformer-vos-pages-html)
7. [Correspondance fichier par fichier](#7-correspondance-fichier-par-fichier)
8. [Pages à créer par module](#8-pages-à-créer-par-module)
9. [Feuille de route par phases](#9-feuille-de-route-par-phases)
10. [GitHub : dépôt, README, branches, commits](#10-github--dépôt-readme-branches-commits)
11. [Tâches du GitHub Project](#11-tâches-du-github-project)
12. [Erreurs fréquentes à éviter](#12-erreurs-fréquentes-à-éviter)
13. [Checklist finale de la 2ᵉ validation](#13-checklist-finale-de-la-2ᵉ-validation)

---

## 1. Synthèse des 4 ateliers

> Attention : les ateliers utilisent des projets d'exemple (**eLEARNING** pour le Front Office, **PlainAdmin/TailAdmin** pour le Back Office, **SmartTask** dans le guide GitHub). Ce sont des **exemples de méthode**, pas des fonctionnalités de WASLA. Vos fonctionnalités viennent uniquement de votre dictionnaire des entités et de vos diagrammes.

### 1.1 Atelier « Intégration Template », partie 1 (Front Office)

| Point | Contenu |
|---|---|
| **Objectif** | Arrêter de répéter le même `<head>`, la même navbar, le même footer et les mêmes scripts dans chaque page. Chaque bloc commun est écrit **une seule fois** dans un fichier `.php` et inclus partout avec `require_once`. |
| **Problème illustré** | « Sur un site de 10 pages, changer un lien du menu = 10 modifications → erreurs et perte de temps. » |
| **Structure montrée** | `Controllers/` (HomeController…), `Models/` (classes), `Views/` avec `assets/{css,img,js,lib}`, `includes/` (head, spinner, navbar, footer, scripts) et les pages `.php`. |
| **Étapes** | 1) Repérer les zones répétées dans `index.html` · 2) créer `includes/` · 3) extraire `head.php` (le contenu **entre** `<head>` et `</head>`, sans les balises) · 4) `spinner.php` · 5) `navbar.php` **dynamique** (classe `active` calculée en PHP avec `$currentPage`) · 6) `footer.php` (+ bouton « back to top ») · 7) `scripts.php` · 8) assembler `index.php` · 9) tester avec XAMPP/WAMP · 10) répéter pour chaque page. |
| **Variables clés** | `$pageTitle` (titre de l'onglet) et `$currentPage` (lien actif), définies **avant** l'inclusion. |
| **Règle importante** | Le visuel doit rester **strictement identique** à la version HTML. |

### 1.2 Atelier « Intégration Template », partie 2 (Back Office)

| Point | Contenu |
|---|---|
| **Objectif** | Même idée, mais avec une vraie architecture MVC : un point d'entrée unique, un routeur, des contrôleurs et un **layout** central. |
| **Structure montrée** | `index.php` (racine) · `app/routes.php` · `app/helpers.php` · `app/Controllers/` (`Controller.php` + un contrôleur par page) · `app/Models/` (`Model.php` + classes) · `app/Views/assets/{css,fonts,images,js,scss}` · `app/Views/partials/` (head, sidebar, header, footer, scripts) · `app/Views/pages/` (contenu de chaque page) · `app/Views/layout.php`. |
| **Étapes** | 1) Repérer les zones répétées · 2) créer `app/Views/partials/` · 3) `head.php` (+ preloader) · 4) `sidebar.php` **dynamique** (fonctions `isActive`, `isOpen`…) · 5) `header.php` (copier-coller, aucune logique) · 6) `footer.php` · 7) `scripts.php` (+ `$extraScripts` pour les scripts propres à une page) · 8) `layout.php` qui reçoit `$title`, `$currentPage`, `$content` et inclut les partials dans le bon ordre · 9) `Controller::render()` capture la page dans `$content` puis inclut le layout · 10) tester (`php -S localhost:8000` ou XAMPP, URL `index.php?page=dashboard`) · 11) répéter : vue + contrôleur + route pour chaque page. |
| **Résultat attendu** | Les pages de `pages/` redeviennent du **HTML pur** (sans `require_once`), et un seul fichier (`layout.php`) décide de l'ordre d'assemblage. |
| **Template fourni** | Lien GitHub TailAdmin (Tailwind). Remarque : les captures de l'atelier montrent en réalité **PlainAdmin** (Bootstrap). **[À CONFIRMER]** quel template Back Office votre équipe a choisi. |

### 1.3 Standardisation des dépôts GitHub

| Exigence | Détail | Points |
|---|---|---|
| **Nom du dépôt [OBLIGATOIRE]** | `Esprit-[PI]-[Classe]-[AU]-[NomDuProjet]` (exemple : `Esprit-PIDEV-3A10-2026-TaskManager`) | 0,5 |
| **Description [OBLIGATOIRE]** | « Developed at Esprit School of Engineering – Tunisia » + année universitaire + technologies principales | 0,5 |
| **Topics [OBLIGATOIRE]** | `esprit-school-of-engineering`, `academic-project`, `esprit-[pi]`, l'année universitaire, la technologie principale | 0,5 |
| **README structuré [OBLIGATOIRE]** | Title, Overview, Features, Tech Stack (Frontend/Backend), Architecture, Contributors, Academic Context, Getting Started, Acknowledgments. Le mot-clé **« Esprit School of Engineering »** doit apparaître. | 0,25 (0,5 sans hébergement) |
| **Hébergement [RECOMMANDÉ]** | GitHub Pages, Vercel, Render, Railway, DigitalOcean | 0,25 (facultatif) |
| **Suivi** | Le tuteur vérifie le nom, les topics, le README et la publication **publique**. | |

### 1.4 Guide pour rédiger un README

- Cycle de travail montré : créer le dépôt avec un `README.md` → `git clone` → modifier → `git add .` → `git commit -m "..."` → `git push origin main`.
- Sections recommandées : titre, description (objectif, problème résolu, fonctionnalités), **table des matières** (si le README est long), **installation** (clone + XAMPP/WAMP : `htdocs`/`www`, démarrer Apache et MySQL, ouvrir `http://localhost/projet`), **utilisation** (installer PHP, `php -v`), **contributions** (contributeurs + fork/branche/pull request), **licence**.
- Syntaxe Markdown expliquée : `#`, `##`, `###`, listes `1.` et `*`, blocs de code avec ```` ```bash ````, liens `[texte](url)`, gras et italique.

### 1.5 Comment les 4 ateliers se complètent

```
Template HTML statique  ──(Atelier partie 1)──>  Front Office découpé en partials PHP
                         ──(Atelier partie 2)──>  Back Office + layout + Controllers + routeur (MVC)
                                                            │
                                         ┌──────────────────┴──────────────────┐
                                  Dépôt GitHub conforme                README de qualité
                               (Standardisation : nom, description,   (Guide README : installation
                                topics, README minimal, public)        XAMPP, utilisation, contributions)
```

En une phrase : les ateliers d'intégration vous disent **comment organiser le code**, les deux documents GitHub vous disent **comment le publier et le documenter**. Kif kif : le code propre ne suffit pas, il faut aussi un dépôt propre.

---

## 2. Ce que vous avez aujourd'hui

### 2.1 Le contenu du dossier

| Élément | Constat |
|---|---|
| **6 pages HTML** | `index.html`, `carte.html`, `analyses.html`, `services.html`, `a-propos.html`, `connexion.html` : ce sont **toutes des pages Front Office** (côté citoyen). |
| **CSS (6 fichiers)** | `tokens.css` (variables : couleurs, thème clair/sombre), `base.css`, `components.css`, `home.css`, `pages.css`, `motion.css`. Bien découpés, rien à refaire. |
| **JS (9 fichiers)** | `prefs.js` (thème/langue, chargé dans `<head>`), `i18n.js` (FR/EN/AR), `data.js` (données fictives), `icons.js`, `layout.js` (menu, recherche, notifications, toasts), `charts.js`, `map.js`, `motion.js`, `pages.js`. |
| **Assets** | `assets/img` (6 images), `assets/fonts` (Inter + IBM Plex Arabic), `assets/data` (géométrie de la Tunisie). |
| **Outils Node** | `tools/build-pages.js` + `tools/partials/*.html`, plus des outils de test et de capture. |
| **Divers** | `screenshots/` (19 captures), 2 images WhatsApp (charte graphique + maquette de l'accueil), `README.md`. |
| **Git** | Le dossier **n'est pas** encore un dépôt Git. |

### 2.2 Bonne nouvelle : votre projet applique déjà l'idée de l'atelier

Votre script `tools/build-pages.js` fait déjà en JavaScript ce que l'atelier fait en PHP :

- il **découpe** l'en-tête (`<a class="skip-link">` … `<div data-search-root></div>`) et le footer (`<footer class="site-footer">` … `</footer>`) depuis `index.html` ;
- il **colle** ces blocs autour du contenu de `tools/partials/carte.html`, `analyses.html`, etc. ;
- il choisit **par page** les CSS et les scripts à charger.

Donc `tools/partials/*.html` contient **déjà exactement** ce que l'atelier appelle une page de contenu (`Views/pages/*.php`) : le HTML propre à la page, sans header ni footer. Il suffira de les renommer en `.php` et de les déplacer.

Fhemt ? Le travail de découpage est déjà fait à 80 %. Il faut seulement remplacer « le script Node qui génère les pages » par « PHP qui assemble les pages à chaque requête ».

### 2.3 Ce qui doit changer techniquement

| Situation actuelle | Ce que demandent les ateliers |
|---|---|
| Pages `.html` générées une fois par `node tools/build-pages.js` | Pages `.php` assemblées par `layout.php` à chaque requête **[OBLIGATOIRE]** |
| Lien actif calculé en JavaScript (`layout.js` → `setActiveNav()` avec `data-page`) | Lien actif calculé en **PHP** avec `$currentPage` **[OBLIGATOIRE]** (le JS peut rester, il fera la même chose) |
| Liens `carte.html`, `services.html#refuge`… | Liens via le routeur : `index.php?page=carte`, `index.php?page=services#refuge` **[OBLIGATOIRE]**, sinon les liens cassent quand les `.html` disparaissent |
| Ouverture directe du fichier dans le navigateur | Serveur PHP obligatoire : XAMPP/WAMP ou `php -S` |
| Aucun Back Office | Template Back Office intégré avec sidebar dynamique **[OBLIGATOIRE]** |

---

## 3. Ce qui manque

### 3.1 Informations à fournir **[À CONFIRMER]**

| # | Information | État |
|---|---|---|
| 1 | **Template Back Office** | ✅ Option A retenue (section 6.6). Reçu sous forme d'**image** seulement (`references/dachboard admin.png`) : c'est une maquette, il n'y a **pas de HTML/CSS** à intégrer. Voir la section 6.6 pour la marche à suivre. |
| 2 | Qui gère quel module | ✅ M1 Houssem · M2 Hiba · M3 Louay · M4 Bechir |
| 3 | Code PI, classe, année | ✅ Projet Technologies Web · 2A6 · 2026/2027. Il reste à confirmer **l'abréviation** du PI avec le tuteur (voir 10.1) |
| 4 | Diagrammes de cas d'utilisation et de classes | ✅ Reçus : la section 8 est maintenant construite à partir de ces diagrammes |
| 5 | Les tuteurs exigent-ils une **base de données** dès la 2ᵉ validation ? | ❓ Le plan suppose que **non** (validation 2 = interfaces intégrées + MVC prêt) |

**Cohérence vérifiée** entre le dictionnaire et les diagrammes : mêmes 17 entités, mêmes attributs, mêmes associations et cardinalités. Les clés étrangères (`id_zone`, `id_utilisateur`…) n'apparaissent pas comme attributs dans le diagramme de classes : c'est normal, la note « Règles » du diagramme dit qu'elles découlent des associations lors du passage au relationnel.

### 3.2 Interfaces qui n'existent pas encore

Votre règle de projet dit : **« Chaque entité est une table et correspond à un formulaire (Front Office ou Back Office) »**. Or vos 6 pages actuelles ne contiennent que **2 formulaires** :

- `carte.html` → formulaire de **signalement** (Module 1) ;
- `connexion.html` → formulaire de **connexion** (table partagée `utilisateur`).

Les cartes de `services.html` (Alertes, Factures & IA, Fournisseurs, Zones refuge, Relais de voisinage, Priorité santé) **présentent** les modules mais ne sont pas encore des pages de travail. Il manque donc la quasi-totalité du **Back Office** et plusieurs pages **Front Office** par module (détail en [section 8](#8-pages-à-créer-par-module)).

> Une page HTML ≠ un module. Exemple : `services.html` présente des éléments des modules 1, 2, 3 et 4 à la fois ; `analyses.html` touche le Module 2 (consommation) et le Module 1 (table des incidents).

---

## 4. Le MVC appliqué à WASLA

**MVC = séparer trois responsabilités.** B'tounsi : kol wa7ed w khedmtou.

| Couche | Rôle | Chez WASLA | Exemple concret |
|---|---|---|---|
| **Model** | Représente les données (une classe par entité) | Les 17 entités du dictionnaire : `Utilisateur`, `Notification`, `Interruption`, `Signalement`, `Alerte`, `Confirmation`, `Zone`, `Facture`, `Consommation`, `AnalyseFacture`, `Entreprise`, `RefugeZone`, `ReservationRefuge`, `DemandeAssistance`, `Reponse`, `Fournisseur`, `Service`, `InstallationSolaire` | `Signalement.php` avec les attributs `id_signalement`, `type_ressource`, `description`… |
| **View** | Ce que l'utilisateur voit (HTML) | Vos pages actuelles + les pages Back Office | `pages/carte.php` (la carte et le formulaire de signalement) |
| **Controller** | Reçoit la requête, prépare les données, choisit la vue | Un contrôleur par page (validation 2), qui deviendra un contrôleur par entité avec les actions CRUD (validations suivantes) | `CarteController::index()` → `render('carte')` |

**Le parcours d'une requête :**

```
Navigateur : index.php?page=carte
      │
      ▼
index.php  ──lit──>  app/routes.php  ('carte' => CarteController)
      │
      ▼
CarteController::index()
      │   (plus tard : demande au Model Signalement/Interruption/Zone les données)
      ▼
Controller::render('carte')
      │   capture app/Views/frontoffice/pages/carte.php dans $content
      ▼
app/Views/frontoffice/layout.php
      head.php → spinner.php → navbar.php → $content → footer.php → scripts.php
      │
      ▼
Page HTML finale, identique visuellement à carte.html
```

**Pour la 2ᵉ validation**, les contrôleurs se contentent d'afficher les vues, et les Models peuvent n'être que des classes avec attributs, constructeur et getters/setters reprenant le diagramme de classes. Le CRUD avec la base de données viendra ensuite. Ne commencez **pas** par le backend.

---

## 5. Structure finale recommandée du dépôt

Cette structure suit **la partie 2 de l'atelier** (la plus complète : `app/`, `routes.php`, `layout.php`, `partials/`, `pages/`), appliquée **deux fois** : une fois pour le Front Office, une fois pour le Back Office. Le dossier `includes/` de la partie 1 et `partials/` de la partie 2 sont la même chose (l'atelier le dit) : on garde le nom `partials/` partout pour être cohérent.

```text
Esprit-PW-<Classe>-<AU>-Wasla/              ← nom à confirmer (section 10)
│
├── index.php                               ← point d'entrée unique (routeur)
├── README.md                               ← README standardisé (section 10)
├── .gitignore
│
├── app/
│   ├── routes.php                          ← 'clé de page' => [Contrôleur, layout]
│   ├── helpers.php                         ← isActive(), e(), asset()
│   │
│   ├── Controllers/
│   │   ├── Controller.php                  ← render() : capture la vue + inclut le bon layout
│   │   ├── HomeController.php              ← commun FO : accueil, services, à propos
│   │   ├── DashboardController.php         ← commun BO : tableau de bord
│   │   │   ── Module 1 (Houssem) ──
│   │   ├── InterruptionController.php      ← carte FO + interruptions BO
│   │   ├── SignalementController.php       ← signaler, suivre, confirmer (FO) + modération (BO)
│   │   ├── AlerteController.php  ZoneController.php  SousAdminController.php
│   │   │   ── Module 2 (Hiba) ──
│   │   ├── UtilisateurController.php       ← connexion, inscription, profil, mot de passe, comptes citoyens
│   │   ├── FactureController.php  ConsommationController.php  AnalyseFactureController.php
│   │   │   ── Module 3 (Louay) ──
│   │   ├── EntrepriseController.php  RefugeZoneController.php
│   │   ├── ReservationRefugeController.php  ProfessionnelController.php
│   │   │   ── Module 4 (Bechir) ──
│   │   ├── DemandeAssistanceController.php  ReponseController.php  FournisseurController.php
│   │   └── ServiceController.php  InstallationSolaireController.php  ActeurController.php
│   │
│   ├── Models/
│   │   ├── Model.php                       ← classe de base (connexion BD plus tard)
│   │   ├── Utilisateur.php  Notification.php
│   │   ├── Interruption.php Signalement.php Alerte.php Confirmation.php Zone.php
│   │   ├── Facture.php Consommation.php AnalyseFacture.php
│   │   ├── Entreprise.php RefugeZone.php ReservationRefuge.php
│   │   └── DemandeAssistance.php Reponse.php Fournisseur.php Service.php InstallationSolaire.php
│   │
│   └── Views/
│       ├── frontoffice/
│       │   ├── assets/                     ← VOTRE dossier assets/ actuel, déplacé tel quel
│       │   │   ├── css/   js/   img/   fonts/   data/
│       │   ├── partials/
│       │   │   ├── head.php                ← <!DOCTYPE> … <head> … </head><body>
│       │   │   ├── spinner.php             ← spinner de chargement (juste après <body>)
│       │   │   ├── navbar.php              ← skip-link + site-header (menu dynamique) + racines mobile/recherche
│       │   │   ├── footer.php              ← site-footer + bouton « Back to top »
│       │   │   └── scripts.php             ← scripts communs + scripts de la page + </body></html>
│       │   ├── pages/
│       │   │   ├── accueil.php  services.php  a-propos.php     ← commun (équipe)
│       │   │   ├── interruptions/   ← Module 1 (Houssem) : carte.php (ex-carte.html) + nouvelles pages
│       │   │   ├── factures/        ← Module 2 (Hiba) : connexion.php, analyses.php (ex-.html) + nouvelles pages
│       │   │   ├── refuges/         ← Module 3 (Louay)
│       │   │   └── assistance/      ← Module 4 (Bechir)
│       │   └── layout.php
│       │
│       └── backoffice/
│           ├── assets/                     ← admin.css, admin.js, img/ (tokens.css, polices et icônes
│           │                                  sont repris de frontoffice/assets : une seule charte)
│           ├── partials/
│           │   ├── head.php (+ preloader)  sidebar.php  header.php  footer.php  scripts.php
│           ├── pages/
│           │   ├── dashboard.php                ← commun
│           │   ├── interruptions/   factures/   refuges/   assistance/   ← un dossier par module
│           └── layout.php
│
└── docs/
    ├── PLAN-INTEGRATION-WASLA.md           ← ce document
    ├── uml/                                ← cas d'utilisation, diagramme de classes (PNG/PDF)
    ├── dictionnaire-entites.docx
    ├── uml/diagrammes-uml.pdf              ← WASLA_Diagrammes_UML_style_reference.pdf
    ├── charte-graphique.jpeg               ← ex-« WhatsApp Image … 15.53.213.jpeg »
    ├── maquette-accueil.jpeg               ← ex-« WhatsApp Image … 15.53.23.jpeg »
    ├── maquette-backoffice.png             ← ex-« references/dachboard admin.png »
    └── screenshots/                        ← vos captures actuelles
```

**Pourquoi ces choix :**

| Choix | Justification |
|---|---|
| `assets/` **dans** `Views/` | C'est ce que montrent les deux parties de l'atelier (`Views/assets/`). **[OBLIGATOIRE dans l'esprit de l'atelier]** |
| Un dossier `frontoffice/` et un `backoffice/` | Les deux templates ont des CSS et JS différents : les mélanger dans un seul `assets/` crée des conflits de noms (`main.css`, `main.js`…). **[RECOMMANDÉ]** |
| Déplacer `assets/` **en bloc** | Vos CSS référencent les polices et images en chemins relatifs (`../fonts/…`) : en déplaçant le dossier entier, ces chemins restent valides sans rien toucher. |
| Sous-dossiers par module dans `pages/` | À 4, chacun travaille dans son dossier → beaucoup moins de conflits Git. **[RECOMMANDÉ]** |
| Contrôleurs « à plat » (pas de sous-dossiers) | Plus simple pour débuter, identique à l'atelier. **[RECOMMANDÉ]** |
| Un contrôleur **par entité** (et non un par page) | L'atelier fait un contrôleur par page parce que le template n'a que des pages d'affichage. WASLA aura une quarantaine de pages : un contrôleur par entité regroupe la liste, le formulaire et (plus tard) les actions CRUD d'une même entité. C'est la forme attendue quand le CRUD arrivera. **[RECOMMANDÉ]** |
| Un contrôleur de comptes **par module** | Chaque membre gère les comptes de ses rôles (cas d'utilisation « Gérer les comptes sous-admins / citoyens / professionnels / acteurs du module »). Tous utilisent le même Model `Utilisateur` filtré par `role`, mais personne ne modifie le fichier d'un autre. |
| `docs/` | Garde la racine propre et regroupe ce que le tuteur veut voir (UML, dictionnaire). **[RECOMMANDÉ]** |

---

## 6. Comment transformer vos pages HTML

### 6.1 Découpage de `index.html` (le modèle des autres pages)

| Zone dans `index.html` | Lignes | Répétée partout ? | Destination |
|---|---|---|---|
| `<!DOCTYPE>` … `</head>` + `<body data-page="accueil">` | 1–19 | Oui, sauf `<title>`, `description`, la liste des CSS et le préchargement de l'image du hero | `frontoffice/partials/head.php` |
| Skip-link + `<header class="site-header">` + `data-mobile-menu-root` + `data-search-root` | 20–100 | Oui, sauf le lien actif | `frontoffice/partials/header.php` |
| `<main id="main">` … `</main>` | 102–304 | **Non** (contenu propre) | `frontoffice/pages/accueil.php` |
| `<footer class="site-footer">` … `</footer>` | 306–367 | Oui, identique | `frontoffice/partials/footer.php` |
| `<script>` … + `</body></html>` | 369–378 | Oui, mais la **liste** varie selon la page | `frontoffice/partials/scripts.php` |

Pour les 5 autres pages, **pas besoin de découper** : le contenu propre est déjà isolé dans `tools/partials/*.html` (chacun commence par son propre `<main>`).

### 6.2 Ce qui varie d'une page à l'autre (relevé dans `build-pages.js`)

| Page | CSS spécifiques (en plus de tokens, base, components, motion) | Scripts spécifiques (entre i18n.js et motion.js) |
|---|---|---|
| accueil | `home.css` + préchargement de `hero-coast.jpg` | tunisia.js, data.js, icons.js, layout.js, charts.js, map.js |
| carte | `home.css`, `pages.css` | tunisia.js, data.js, icons.js, layout.js, map.js, pages.js |
| analyses | `pages.css` | data.js, icons.js, layout.js, charts.js, pages.js |
| services | `pages.css` | data.js, icons.js, layout.js, pages.js |
| a-propos | `pages.css` | data.js, icons.js, layout.js, pages.js |
| connexion | `pages.css` | data.js, icons.js, layout.js, pages.js |

Comme l'atelier passe `$extraScripts` au layout, on passera ici deux tableaux : `$pageCss` et `$pageScripts`. C'est la même idée, adaptée au fait que chez vous la liste change d'une page à l'autre.

### 6.3 Code proposé (à valider, pas encore appliqué)

**`index.php` (racine) : le routeur**

```php
<?php
require_once __DIR__ . '/app/helpers.php';
$routes = require __DIR__ . '/app/routes.php';

$page = $_GET['page'] ?? 'accueil';
if (!isset($routes[$page])) {
    http_response_code(404);
    $page = 'accueil';            // ou une page 404 si vous en créez une
}

[$controllerName, $method] = $routes[$page];
require_once __DIR__ . '/app/Controllers/Controller.php';
require_once __DIR__ . '/app/Controllers/' . $controllerName . '.php';

(new $controllerName())->$method();
```

**`app/routes.php`** : chaque clé de page pointe vers `[Contrôleur, méthode]`. Par rapport à l'atelier, la seule différence est la méthode, qui permet à un contrôleur d'entité de servir plusieurs pages. Les pages Back Office commencent par `admin-`.

```php
<?php
return [
    // ── Commun ───────────────────────────────────────────────
    'accueil'   => ['HomeController', 'accueil'],
    'services'  => ['HomeController', 'services'],
    'a-propos'  => ['HomeController', 'aPropos'],
    'dashboard' => ['DashboardController', 'index'],          // BO

    // ── Module 1 — Houssem ──────────────────────────────────
    'carte'                => ['InterruptionController', 'carte'],
    'admin-interruptions'  => ['InterruptionController', 'adminListe'],
    // …

    // ── Module 2 — Hiba ─────────────────────────────────────
    'connexion' => ['UtilisateurController', 'connexion'],
    'analyses'  => ['ConsommationController', 'analyses'],
    // …

    // ── Module 3 — Louay ────────────────────────────────────
    // ── Module 4 — Bechir ───────────────────────────────────
];
```

Chaque membre n'ajoute des lignes que dans **son** bloc : les conflits Git restent rares et faciles à résoudre.

**`app/helpers.php`**

```php
<?php
/** Retourne la classe active si la page correspond (même idée que navActive() de l'atelier). */
function isActive(string $page, string $currentPage, string $class = 'is-active'): string {
    return $page === $currentPage ? $class : '';
}

/** Échappe un texte avant de l'afficher (sécurité XSS). */
function e(?string $value): string {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

/** Chemin vers un fichier d'assets, pour ne pas répéter le préfixe partout. */
function asset(string $path, string $office = 'frontoffice'): string {
    return 'app/Views/' . $office . '/assets/' . ltrim($path, '/');
}
```

**`app/Controllers/Controller.php`** (même logique que l'atelier : capturer la page dans `$content`, puis inclure le layout ; en plus, on choisit FO ou BO)

```php
<?php
abstract class Controller
{
    /** Scripts communs à presque toutes les pages FO (i18n.js et motion.js sont ajoutés par scripts.php). */
    protected const FO_SCRIPTS = ['js/data.js', 'js/icons.js', 'js/layout.js', 'js/pages.js'];

    /**
     * @param string $view    chemin de la vue dans pages/ (ex. 'interruptions/carte')
     * @param array  $options page, title, description, office, css, scripts
     * @param array  $data    variables pour la vue (plus tard : données des Models)
     */
    protected function render(string $view, array $options = [], array $data = []): void
    {
        $office      = $options['office']      ?? 'frontoffice';
        $currentPage = $options['page']        ?? 'accueil';
        $title       = $options['title']       ?? 'WASLA — Connecter. Anticiper. Protéger.';
        $description = $options['description'] ?? '';
        $pageCss     = $options['css']         ?? ['pages'];
        $pageScripts = $options['scripts']     ?? self::FO_SCRIPTS;

        $viewsDir = __DIR__ . '/../Views/' . $office;

        extract($data);
        ob_start();
        require $viewsDir . '/pages/' . $view . '.php';
        $content = ob_get_clean();

        require $viewsDir . '/layout.php';
    }
}
```

**`app/Controllers/InterruptionController.php`** (exemple : une entité, une page FO et une page BO)

```php
<?php
class InterruptionController extends Controller
{
    /** FO — cas d'utilisation « Consulter la carte des interruptions » (ex-carte.html) */
    public function carte(): void
    {
        $this->render('interruptions/carte', [
            'page'        => 'carte',
            'title'       => 'Carte des réseaux — WASLA',
            'description' => "Visualisez l'état de l'électricité et de l'eau dans les 24 gouvernorats…",
            'css'         => ['home', 'pages'],
            'scripts'     => ['data/tunisia.js', 'js/data.js', 'js/icons.js',
                              'js/layout.js', 'js/map.js', 'js/pages.js'],
        ]);
    }

    /** BO — « Publier / modifier / clôturer une interruption » (sous-admin STEG/SONEDE) */
    public function adminListe(): void
    {
        $this->render('interruptions/liste', [
            'office' => 'backoffice',
            'page'   => 'admin-interruptions',
            'title'  => 'Interruptions — WASLA Admin',
        ]);
    }
}
```

**`app/Views/frontoffice/layout.php`**

```php
<?php
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/header.php';
echo $content;
require __DIR__ . '/partials/footer.php';
require __DIR__ . '/partials/scripts.php';
```

**`frontoffice/partials/head.php`** (extrait : lignes 1–19 de `index.html`, avec les parties variables en PHP)

```php
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($title) ?></title>
  <meta name="description" content="<?= e($description) ?>">
  <meta name="theme-color" content="#003B5C">
  <script src="<?= asset('js/prefs.js') ?>"></script>
  <link rel="icon" href="<?= asset('img/favicon.svg') ?>" type="image/svg+xml">
  <link rel="preload" href="<?= asset('fonts/inter-latin.woff2') ?>" as="font" type="font/woff2" crossorigin>
  <?php foreach (array_merge(['tokens', 'base', 'components'], $pageCss, ['motion']) as $css): ?>
  <link rel="stylesheet" href="<?= asset('css/' . $css . '.css') ?>">
  <?php endforeach; ?>
</head>
<body data-page="<?= e($currentPage) ?>">
```

**`frontoffice/partials/header.php`** (extrait : seule la navigation change)

```php
<nav class="main-nav" aria-label="Navigation principale">
  <a class="nav-link <?= isActive('accueil', $currentPage) ?>" href="index.php?page=accueil" data-nav="accueil"
     <?= $currentPage === 'accueil' ? 'aria-current="page"' : '' ?>>Accueil</a>
  <a class="nav-link <?= isActive('carte', $currentPage) ?>" href="index.php?page=carte" data-nav="carte"
     <?= $currentPage === 'carte' ? 'aria-current="page"' : '' ?>>Carte</a>
  <!-- … idem pour analyses, services (bouton dropdown), a-propos -->
</nav>
```

On garde `data-nav` : `layout.js` continue de fonctionner et donne le même résultat que le PHP.

**`frontoffice/partials/scripts.php`**

```php
<script src="<?= asset('js/i18n.js') ?>"></script>
<?php foreach ($pageScripts as $src): ?>
<script src="<?= asset($src) ?>"></script>
<?php endforeach; ?>
<script src="<?= asset('js/motion.js') ?>"></script>
</body>
</html>
```

### 6.4 Liens à mettre à jour **[OBLIGATOIRE]**

Les `.html` vont disparaître : chaque lien interne doit passer par le routeur.

| Où | Liens concernés |
|---|---|
| `partials/header.php` (ex-index.html l.24-91) | `index.html`, `carte.html`, `analyses.html`, `services.html#…` (×6), `a-propos.html`, `connexion.html` |
| `partials/footer.php` (ex-index.html l.306-367) | Tous les liens du footer (Plateforme, Services, À propos, mentions…) |
| `pages/*.php` | Fil d'Ariane (`index.html`), boutons `connexion.html`, `services.html`, `carte.html` |
| `assets/js/layout.js` | Lignes 13–29 (menu mobile), 98, 121, 283 |
| `assets/js/data.js` | Lignes 80–130 (`link:`) et 135–146 (`url:` de la recherche) |

Règle de remplacement : `xxx.html` → `index.php?page=xxx`, et `index.html` → `index.php?page=accueil`. Les ancres (`#refuge`) restent à la fin : `index.php?page=services#refuge`.

À ne **pas** toucher : `mailto:contact@wasla.tn`, les liens d'ancre internes (`#dashboard`, `#features`).

`motion.js` (transitions de page) compare l'origine, le chemin **et** la query string : il fonctionnera avec `?page=` sans modification.

### 6.5 Formulaires

| Formulaire | Fichier | Maintenant (validation 2) | Plus tard (CRUD) |
|---|---|---|---|
| Signalement | `tools/partials/carte.html` l.142 (`data-report-form novalidate`) | Garder tel quel : validation JS dans `pages.js` | Ajouter `method="post"` et `action="index.php?page=signaler"` ; renommer les champs actuels d'après les colonnes de `signalement` : `zone` → `id_zone`, `type` → `type_ressource`, `address` → `localisation`, `message` → `description` (vérifier d'abord dans `pages.js` que la validation ne lit pas les anciens `name`) |
| Connexion | `tools/partials/connexion.html` l.38 (`data-login-form novalidate`) | Garder tel quel | `method="post"` vers `ConnexionController`, champs `email` et `mot_de_passe` |

**[RECOMMANDÉ]** Dès maintenant, nommez les champs (`name="…"`) d'après les colonnes du dictionnaire : le passage au CRUD sera beaucoup plus simple.

### 6.6 Back Office : de la maquette au template intégré

**Constat.** Le dossier `references/` contient une seule image, `dachboard admin.png`. C'est une maquette du tableau de bord admin aux couleurs de WASLA, pas un template téléchargé. Or l'atelier (partie 2) part d'un **template HTML existant** qu'on découpe en partials. Il manque donc l'étape « avoir le HTML ».

> ✅ **Décision de l'équipe : option A** (coder le Back Office d'après la maquette). Reste à faire valider par le tuteur (tâche 10a).

**Deux options :**

| | Option A **[RECOMMANDÉE]** : coder le Back Office en HTML/CSS d'après la maquette, avec votre propre design system | Option B : partir de TailAdmin (lien de l'atelier) et le restyler pour ressembler à la maquette |
|---|---|---|
| Technologie | Même chose que le Front Office : HTML, CSS, JS sans framework | Tailwind CSS + Alpine.js, avec une étape `npm install` / `npm run build` |
| Réutilisation | `tokens.css` (couleurs, polices), `icons.js` (icônes Lucide), `charts.js` (sparklines et courbes), polices Inter : déjà prêts | Il faut réécrire les couleurs et les composants dans la syntaxe Tailwind |
| Fidélité à la maquette | Totale | Approximative, beaucoup de retouches |
| Cohérence FO / BO | Un seul design system | Deux systèmes de styles différents dans le même projet |
| Conformité à l'atelier | La méthode (partials, sidebar dynamique, layout, contrôleurs) est appliquée à l'identique ; seul le point de départ change (votre HTML au lieu d'un HTML téléchargé) | Suit l'atelier à la lettre |
| Risque | Le tuteur peut exiger un template téléchargé : **à confirmer** avec lui | Plus long, et un résultat visuel éloigné de votre maquette |

**Démarche pour l'option A** (2 étapes, comme dans l'atelier) :

1. **Prototype statique**, dans le même esprit que le Front Office : `backoffice-prototype/dashboard.html`, plus une page **liste** et une page **formulaire** type, qui serviront de modèles à toutes les pages Back Office des 4 modules.
2. **Intégration** de ce prototype selon l'atelier (partie 2) : repérer les zones, extraire les partials, faire le layout, puis supprimer le prototype.

**Découpage de la maquette en partials :**

| Zone de la maquette | Partial | Dynamique ? |
|---|---|---|
| `<head>` (tokens.css du FO + `admin.css`) | `backoffice/partials/head.php` | `$title` |
| Barre latérale : logo, menu, illustration du bas | `backoffice/partials/sidebar.php` | **Oui** : élément actif et groupe ouvert selon `$currentPage` (`isActive()`, comme dans l'atelier) |
| Barre du haut : recherche, cloche de notifications, « Super Admin » | `backoffice/partials/header.php` | Non (copier-coller, comme dans l'atelier) |
| Titre de page + filtres de période + contenu | `backoffice/pages/...` | Contenu propre à chaque page |
| (pas de footer sur la maquette) | `backoffice/partials/footer.php` | Petit copyright, facultatif |
| Scripts : `icons.js`, `charts.js`, `admin.js` | `backoffice/partials/scripts.php` | `$pageScripts` |

**Assets :** le Back Office charge `tokens.css`, les polices et `icons.js`/`charts.js` **depuis** `frontoffice/assets/`, pour garder une seule source de couleurs, et ajoute uniquement ses fichiers propres dans `backoffice/assets/` : `css/admin.css`, `js/admin.js`, `img/` (l'illustration de Tunis en bas de la sidebar n'existe pas encore dans vos assets : à fournir en SVG/PNG, ou à retirer).

**Attention au menu de la maquette.** Ses entrées (Utilisateurs, Sociétés & STEG, Consommations, Notifications, Rapports & Analyses, Paramètres, Sécurité, Journal d'activité, Support) ne correspondent **pas** à vos cas d'utilisation. *Paramètres*, *Sécurité*, *Journal d'activité* et *Support* n'apparaissent dans aucun diagramme, et *Sociétés & STEG* mélange les entreprises (Module 3) avec les sous-admins STEG (Module 1). Gardez le **style** de la maquette, mais remplacez son menu par les groupes de la section 8.7 (un groupe par module). Sinon, le tuteur verra des entrées qui ne mènent à aucun cas d'utilisation.

**Tableau de bord (page commune) :** les widgets de la maquette peuvent être conservés avec des données fictives, car ils s'appuient sur vos entités : consommation d'électricité et d'eau (Consommation, M2), coupures signalées (Signalement, M1), consommation par gouvernorat (Zone), activités récentes, nombre d'utilisateurs (Utilisateur). Le bloc « État du système » (base de données, API, serveur) ne correspond à aucun cas d'utilisation : il est décoratif, à garder ou retirer selon l'avis du tuteur.

### 6.7 Ce qu'on ne touche pas

- Le **design** : CSS, classes, images et animations restent identiques (règle de l'atelier : « visuel strictement identique »).
- `i18n.js`, `prefs.js`, `icons.js`, `charts.js`, `map.js`, `motion.js`, `tokens.css`… : déplacés, mais leur contenu n'est pas modifié.
- Le contenu des pages : copié tel quel dans `pages/*.php`.

---

## 7. Correspondance fichier par fichier

Priorité : **P1** = indispensable pour la validation 2 · **P2** = important · **P3** = nettoyage / bonus.

### 7.1 Pages HTML

| Fichier actuel | Rôle actuel | Office | Destination | Modifications | Priorité |
|---|---|---|---|---|---|
| `index.html` | Accueil : hero, bandeau, tableau de bord (KPI, carte, alerte), engagements | FO · commun | `app/Views/frontoffice/pages/accueil.php` (l.102–304) + extraction des 4 partials (l.1–100, 306–378) | Découpage ; liens internes → `?page=` ; préchargement du hero passé en option de page | P1 |
| `carte.html` | Carte, filtres par statut, liste des zones, **formulaire de signalement** | FO · M1 Houssem | `pages/interruptions/carte.php` (depuis `tools/partials/carte.html`) | Liens ; **ajouter le filtre eau / électricité** (cas d'utilisation « Filtrer par ressource ») | P1 |
| `analyses.html` | Indicateurs, graphiques de consommation, table des incidents | FO · M2 Hiba | `pages/factures/analyses.php` (depuis `tools/partials/analyses.html`) | Liens ; sert de base à « Consulter sa consommation » | P1 |
| `services.html` | Présentation des 6 services | FO · commun | `pages/services.php` (depuis `tools/partials/services.html`) | Liens ; chaque carte pointera vers la page du module (voir 8.6) | P1 |
| `a-propos.html` | Mission, valeurs, mentions légales | FO · commun | `pages/a-propos.php` (depuis `tools/partials/a-propos.html`) | Liens | P1 |
| `connexion.html` | Connexion (démonstration) | FO · M2 Hiba | `pages/factures/connexion.php` (depuis `tools/partials/connexion.html`) | Liens ; lien « mot de passe oublié » et « s'inscrire » vers les nouvelles pages ; plus tard `method/action/name` | P1 |

Toutes partagent le **même layout Front Office**. Le code dupliqué (header, footer, head, scripts) disparaît des pages.

### 7.2 CSS, JS, assets

| Fichier / dossier | Destination | Modifications | Priorité |
|---|---|---|---|
| `assets/css/*.css` (6) | `app/Views/frontoffice/assets/css/` | Aucune (chemins relatifs conservés) | P1 |
| `assets/js/layout.js` | `frontoffice/assets/js/` | Liens `.html` → `?page=` (l.13–29, 98, 121, 283) | P1 |
| `assets/js/data.js` | `frontoffice/assets/js/` | Liens `link:` et `url:` (l.80–146) | P1 |
| `assets/js/` (7 autres) | `frontoffice/assets/js/` | Aucune | P1 |
| `assets/img/`, `assets/fonts/`, `assets/data/` | `frontoffice/assets/…` | Aucune | P1 |

### 7.3 Outils, documents, divers

| Fichier / dossier | Décision | Raison | Priorité |
|---|---|---|---|
| `tools/build-pages.js` | **Supprimer** une fois la migration terminée | Remplacé par `layout.php` : le garder créerait deux sources de vérité | P2 |
| `tools/partials/*.html` | **Déplacer** vers `frontoffice/pages/*.php` | Ce sont déjà les vues de contenu | P1 |
| `tools/serve.js`, `screenshot.js`, `test-pages.js`, `check-links.js`, `debug-page.js`, `measure-page.js`, `build-tunisia.js` | Retirer du dépôt (ou garder dans un dossier `tools/` hors validation) | Ils visent les URLs `.html` et un serveur Node : ils ne marcheront plus sans adaptation. Ils ne font pas partie de l'architecture demandée. | P3 |
| `screenshots/` | `docs/screenshots/` | Documentation | P3 |
| `WhatsApp Image … 15.53.213.jpeg` | `docs/charte-graphique.jpeg` | Charte graphique : nom parlant | P3 |
| `WhatsApp Image … 15.53.23.jpeg` | `docs/maquette-accueil.jpeg` | Maquette de référence | P3 |
| `references/dachboard admin.png` | `docs/maquette-backoffice.png` | Maquette du Back Office (référence visuelle, pas du code) | P3 |
| `README.md` | Réécrire selon le format standardisé ; garder les parties utiles (langues, thème, accessibilité) dans « Features » et « Architecture » | Le README est noté | P1 |

---

## 8. Pages à créer par module

Cette section vient **directement de vos diagrammes de cas d'utilisation** (un cas d'utilisation → une page ou une action dans une page) et du dictionnaire (chaque entité a son formulaire). Rien n'est inventé.

**Règle FO / BO** déduite de votre diagramme des acteurs :
- **Front Office** (site public + espace connecté) : Citoyen, Bénévole, Propriétaire d'une installation solaire, Professionnel, Fournisseur ;
- **Back Office** (administration) : Administrateur et sous-admins STEG / SONEDE.

Les « include » (Vérifier la localisation, Vérifier la capacité d'accueil, Vérifier le matricule fiscal, Vérifier la disponibilité, Détecter les anomalies…) ne sont **pas** des pages : ce sont des contrôles faits dans le formulaire (JS) ou dans le contrôleur (plus tard). Les « extend » (Filtrer par ressource, Comparer avec la moyenne de la zone, Réinitialiser son mot de passe) sont des options **dans** une page existante, sauf la réinitialisation du mot de passe, qui a sa propre petite page.

Pour la 2ᵉ validation, chaque page = l'interface (tableau et/ou formulaire) avec des **données fictives**, intégrée dans le bon layout. Les champs des formulaires portent les noms des colonnes du dictionnaire.

Légende : ✅ existe déjà · 🆕 à créer · ✏️ à adapter.

### 8.1 Commun (équipe)

| Page | Clé `?page=` | Office | Vue | Contrôleur → méthode | État |
|---|---|---|---|---|---|
| Accueil | `accueil` | FO | `pages/accueil.php` | `HomeController::accueil` | ✅ |
| Services | `services` | FO | `pages/services.php` | `HomeController::services` | ✏️ liens des cartes |
| À propos | `a-propos` | FO | `pages/a-propos.php` | `HomeController::aPropos` | ✅ |
| Tableau de bord | `dashboard` | BO | `pages/dashboard.php` | `DashboardController::index` | 🆕 (template BO) |
| Notifications (table partagée) | — | FO | panneau du header (`layout.js`) | — | ✅ |

### 8.2 Module 1 — Interruptions, signalements & alertes · **Houssem**

| Cas d'utilisation | Acteur | Clé `?page=` | Office | Vue | Contrôleur → méthode | État |
|---|---|---|---|---|---|---|
| Consulter la carte des interruptions (+ *extend* Filtrer par ressource) | Citoyen | `carte` | FO | `interruptions/carte.php` | `InterruptionController::carte` | ✏️ ajouter le filtre eau / électricité (aujourd'hui : filtre par statut seulement) |
| Signaler une coupure d'électricité / une interruption d'eau (+ *include* Vérifier la localisation) | Citoyen | dans `carte` (modale) | FO | `interruptions/carte.php` | `SignalementController::signaler` (plus tard) | ✅ formulaire existant (champs `zone`, `type`, `address`, `message`) |
| Suivre ses signalements | Citoyen | `mes-signalements` | FO | `interruptions/mes-signalements.php` | `SignalementController::mesSignalements` | 🆕 |
| Confirmer un signalement | Citoyen | bouton dans `carte` / `mes-signalements` | FO | — | `ConfirmationController` ou méthode de `SignalementController` | 🆕 |
| Consulter les alertes | Citoyen | `alertes` | FO | `interruptions/alertes.php` | `AlerteController::liste` | 🆕 (le panneau de notifications et la carte d'alerte de l'accueil existent) |
| Publier une interruption planifiée · Modifier / clôturer · Fournir les données de coupures | Sous-admin STEG/SONEDE | `admin-interruptions`, `admin-interruption-form` | BO | `interruptions/liste.php`, `interruptions/form.php` | `InterruptionController::adminListe / adminForm` | 🆕 |
| Modérer les signalements | Admin | `admin-signalements` | BO | `interruptions/signalements.php` | `SignalementController::adminListe` | 🆕 |
| Envoyer une alerte d'urgence · Gérer les alertes | Admin | `admin-alertes`, `admin-alerte-form` | BO | `interruptions/alertes.php`, `interruptions/alerte-form.php` | `AlerteController::adminListe / adminForm` | 🆕 |
| Gérer les zones géographiques | Admin | `admin-zones`, `admin-zone-form` | BO | `interruptions/zones.php`, `interruptions/zone-form.php` | `ZoneController` | 🆕 |
| Gérer les comptes sous-admins | Admin | `admin-sous-admins` | BO | `interruptions/sous-admins.php` | `SousAdminController` | 🆕 |

Formulaires CRUD à prévoir (une entité = un formulaire) : **Interruption** (BO), **Signalement** (FO ✅), **Alerte** (BO), **Confirmation** (FO), **Zone** (BO).

### 8.3 Module 2 — Analyse des factures & consommation · **Hiba**

| Cas d'utilisation | Acteur | Clé `?page=` | Office | Vue | Contrôleur → méthode | État |
|---|---|---|---|---|---|---|
| S'authentifier | Citoyen (tous les utilisateurs) | `connexion` | FO | `factures/connexion.php` | `UtilisateurController::connexion` | ✅ |
| Réinitialiser son mot de passe (*extend*) | Citoyen | `mot-de-passe-oublie` | FO | `factures/mot-de-passe-oublie.php` | `UtilisateurController::motDePasseOublie` | 🆕 |
| S'inscrire | Citoyen | `inscription` | FO | `factures/inscription.php` | `UtilisateurController::inscription` | 🆕 (réutiliser la mise en page de `connexion`) |
| Gérer son profil | Citoyen | `profil` | FO | `factures/profil.php` | `UtilisateurController::profil` | 🆕 |
| Ajouter une facture · Modifier / supprimer une facture | Citoyen | `facture-form` | FO | `factures/facture-form.php` | `FactureController::form` | 🆕 |
| Consulter l'historique des factures | Citoyen | `mes-factures` | FO | `factures/mes-factures.php` | `FactureController::liste` | 🆕 (réutiliser le style de la table des incidents d'`analyses`) |
| Analyser une facture (+ *include* Détecter les anomalies, Générer des recommandations) | Citoyen | `analyse-facture` | FO | `factures/analyse-facture.php` | `AnalyseFactureController::afficher` | 🆕 |
| Saisir un relevé de consommation | Citoyen | `releve-form` | FO | `factures/releve-form.php` | `ConsommationController::form` | 🆕 |
| Consulter sa consommation (+ *extend* Comparer avec la moyenne de la zone) | Citoyen | `analyses` | FO | `factures/analyses.php` | `ConsommationController::analyses` | ✏️ graphiques existants à présenter comme « ma consommation » |
| Fournir les données de consommation | Sous-admin STEG/SONEDE | `admin-consommations` | BO | `factures/consommations.php` | `ConsommationController::adminListe` | 🆕 |
| Gérer les comptes citoyens | Admin | `admin-citoyens` | BO | `factures/citoyens.php` | `UtilisateurController::adminCitoyens` | 🆕 |

Formulaires CRUD : **Facture** (FO), **Consommation** (FO, + données STEG/SONEDE en BO), **AnalyseFacture** (affichage + suppression, conformément au diagramme de classes : `analyser()`, `afficher()`, `supprimer()`), **Utilisateur** (inscription/profil).

### 8.4 Module 3 — Refuge Zones · **Louay**

| Cas d'utilisation | Acteur | Clé `?page=` | Office | Vue | Contrôleur → méthode | État |
|---|---|---|---|---|---|---|
| Rechercher une Refuge Zone | Citoyen | `refuges` | FO | `refuges/refuges.php` | `RefugeZoneController::liste` | 🆕 (la carte et la recherche de `carte` peuvent servir de modèle visuel) |
| Consulter le détail d'une Refuge Zone | Citoyen | `refuge` | FO | `refuges/refuge-detail.php` | `RefugeZoneController::detail` | 🆕 |
| Réserver une place (+ *include* Vérifier la capacité d'accueil) | Citoyen | `reservation-form` | FO | `refuges/reservation-form.php` | `ReservationRefugeController::form` | 🆕 |
| Suivre ses réservations | Citoyen | `mes-reservations` | FO | `refuges/mes-reservations.php` | `ReservationRefugeController::mesReservations` | 🆕 |
| Gérer son entreprise | Professionnel | `mon-entreprise` | FO | `refuges/entreprise-form.php` | `EntrepriseController::form` | 🆕 |
| Gérer ses Refuge Zones | Professionnel | `mes-refuges`, `refuge-form` | FO | `refuges/mes-refuges.php`, `refuges/refuge-form.php` | `RefugeZoneController::mesRefuges / form` | 🆕 |
| Consulter les réservations de ses Refuge Zones | Professionnel | `reservations-recues` | FO | `refuges/reservations-recues.php` | `ReservationRefugeController::recues` | 🆕 |
| Valider une Refuge Zone (+ *include* Vérifier le matricule fiscal) | Admin | `admin-refuges` | BO | `refuges/refuges.php` | `RefugeZoneController::adminListe` | 🆕 |
| Gérer les entreprises | Admin | `admin-entreprises` | BO | `refuges/entreprises.php` | `EntrepriseController::adminListe` | 🆕 |
| Gérer les comptes professionnels | Admin | `admin-professionnels` | BO | `refuges/professionnels.php` | `ProfessionnelController` | 🆕 |

Formulaires CRUD : **Entreprise** (FO), **RefugeZone** (FO + validation BO), **ReservationRefuge** (FO).

### 8.5 Module 4 — Assistance d'urgence, solaire & fournisseurs · **Bechir**

| Cas d'utilisation | Acteur | Clé `?page=` | Office | Vue | Contrôleur → méthode | État |
|---|---|---|---|---|---|---|
| Consulter les fournisseurs et leurs services | Citoyen | `fournisseurs`, `fournisseur` | FO | `assistance/fournisseurs.php`, `assistance/fournisseur-detail.php` | `FournisseurController::liste / detail` | 🆕 |
| Envoyer une demande d'assistance (+ *include* Vérifier la localisation) | Citoyen | `demande-form` | FO | `assistance/demande-form.php` | `DemandeAssistanceController::form` | 🆕 |
| Suivre sa demande d'assistance | Citoyen | `mes-demandes` | FO | `assistance/mes-demandes.php` | `DemandeAssistanceController::mesDemandes` | 🆕 |
| Prendre en charge une demande · Clôturer une intervention | Bénévole | `demandes-ouvertes`, `mes-interventions` | FO | `assistance/demandes-ouvertes.php`, `assistance/mes-interventions.php` | `DemandeAssistanceController::ouvertes / interventions` | 🆕 |
| Gérer ses installations solaires | Propriétaire | `mes-installations`, `installation-form` | FO | `assistance/mes-installations.php`, `assistance/installation-form.php` | `InstallationSolaireController` | 🆕 |
| Répondre à une demande d'assistance solaire (+ *include* Vérifier la disponibilité) | Propriétaire | `reponse-form` (avec `id_installation`) | FO | `assistance/reponse-form.php` | `ReponseController::form` | 🆕 |
| Gérer sa fiche fournisseur | Fournisseur | `ma-fiche-fournisseur` | FO | `assistance/fournisseur-form.php` | `FournisseurController::form` | 🆕 |
| Gérer ses services | Fournisseur | `mes-services`, `service-form` | FO | `assistance/mes-services.php`, `assistance/service-form.php` | `ServiceController` | 🆕 |
| Répondre à une demande d'assistance | Fournisseur | `reponse-form` (avec `id_fournisseur`) | FO | même vue que ci-dessus | `ReponseController::form` | 🆕 |
| Gérer les demandes d'assistance | Admin | `admin-demandes` | BO | `assistance/demandes.php` | `DemandeAssistanceController::adminListe` | 🆕 |
| Gérer les fournisseurs | Admin | `admin-fournisseurs` | BO | `assistance/fournisseurs.php` | `FournisseurController::adminListe` | 🆕 |
| Gérer les comptes des acteurs du module | Admin | `admin-acteurs` | BO | `assistance/acteurs.php` | `ActeurController` | 🆕 |

Formulaires CRUD : **DemandeAssistance**, **Reponse**, **Fournisseur**, **Service**, **InstallationSolaire** (tous en FO). Dans le formulaire de réponse, **exactement un** des deux champs `id_fournisseur` / `id_installation` est rempli, selon le rôle de la personne connectée (règle du dictionnaire).

### 8.6 Relier les nouvelles pages à la navigation existante **[RECOMMANDÉ]**

Votre menu **Services** (header, footer, `layout.js`, `data.js`) contient déjà 6 entrées. Au lieu d'ajouter un nouveau menu, il suffit de les faire pointer vers les pages des modules :

| Entrée existante | Lien actuel | Nouveau lien proposé | Module |
|---|---|---|---|
| Alertes personnalisées | `services.html#alertes` | `index.php?page=alertes` | M1 Houssem |
| Factures & IA | `services.html#factures` | `index.php?page=mes-factures` | M2 Hiba |
| Fournisseurs | `services.html#fournisseurs` | `index.php?page=fournisseurs` | M4 Bechir |
| Zones refuge | `services.html#refuge` | `index.php?page=refuges` | M3 Louay |
| Relais de voisinage | `services.html#relais` | `index.php?page=demandes-ouvertes` | M4 Bechir |
| Priorité santé | `services.html#sante` | `index.php?page=demande-form` | M4 Bechir |

Pour les pages des rôles connectés (Professionnel, Fournisseur, Propriétaire, Bénévole), un menu **« Mon espace »** à la place du bouton « Connexion » peut lister les pages du rôle. En validation 2, sans authentification réelle, il peut afficher tous les liens. **[À CONFIRMER avec le tuteur]**

### 8.7 Sidebar du Back Office

Dans `backoffice/partials/sidebar.php`, un groupe par module, chacun modifié **uniquement** par son responsable :

```
Tableau de bord
Interruptions & alertes (Houssem)   Interruptions · Signalements · Alertes · Zones · Sous-admins
Factures & consommation (Hiba)      Données de consommation · Citoyens
Refuge Zones (Louay)                Refuges à valider · Entreprises · Professionnels
Assistance (Bechir)                 Demandes · Fournisseurs · Acteurs du module
```

### 8.8 Résumé de la charge par membre

| Membre | Pages FO (✅ existantes / 🆕 nouvelles) | Pages BO 🆕 | Contrôleurs |
|---|---|---|---|
| Houssem (M1) | 1 ✅ ✏️ (carte) / 2 🆕 | ~8 | 5 |
| Hiba (M2) | 2 ✅ ✏️ (connexion, analyses) / 7 🆕 | 2 | 4 |
| Louay (M3) | 0 / 8 🆕 | 3 | 4 |
| Bechir (M4) | 0 / ~12 🆕 | 3 | 6 |
| Équipe | accueil, services, à propos ✅ | dashboard 🆕 | 2 |

Ce qui est commun (structure MVC, partials, layout FO, intégration du template BO, liens JS) doit être fait **avant** le travail par module, par une ou deux personnes, puis fusionné dans `develop`. Ensuite, chacun travaille en parallèle dans ses dossiers.

---

## 9. Feuille de route par phases

Ordre pensé pour la 2ᵉ validation : d'abord la structure et le Front Office existant (le plus rapide à rendre fonctionnel), puis le Back Office, puis les pages par module, puis GitHub.

### Phase 0 — Préparer le terrain

1. **Objectif** : avoir une copie de sauvegarde et un dépôt Git propre.
2. **Fichiers** : tout le dossier.
3. **Actions** : garder `wasla_Copie` comme sauvegarde intacte ; créer le dépôt GitHub avec le nom standardisé (public, README) ; inviter les tuteurs (Settings → Collaborators) ; cloner en local **dans** `htdocs` (XAMPP) ou `www` (WAMP) ; ajouter un `.gitignore` (`node_modules/`, `.vscode/`, `*.log`, `.DS_Store`).
4. **Résultat** : dépôt vide, cloné dans `htdocs/`, tuteurs invités.
5. **Vérification** : ☐ nom conforme ☐ dépôt public ☐ tuteurs invités ☐ `http://localhost/` répond.
6. **Commit** : `chore: initialisation du dépôt et .gitignore`

### Phase 1 — Squelette MVC

1. **Objectif** : créer l'ossature qui recevra les pages.
2. **Fichiers** : `index.php`, `app/routes.php`, `app/helpers.php`, `app/Controllers/Controller.php`, dossiers `Models/`, `Views/frontoffice/{assets,partials,pages}`, `Views/backoffice/…`, `docs/`.
3. **Actions** : créer les dossiers et les fichiers de la section 6.3.
4. **Résultat** : l'arborescence de la section 5 existe (encore vide de pages).
5. **Vérification** : ☐ `php -v` fonctionne ☐ `index.php` ne renvoie pas d'erreur PHP.
6. **Commit** : `feat: squelette MVC (routeur, contrôleur de base, helpers)`

### Phase 2 — Déplacer les assets Front Office

1. **Objectif** : mettre vos CSS/JS/images au bon endroit **sans les modifier**.
2. **Fichiers** : `assets/**`.
3. **Actions** : copier `assets/` entier vers `app/Views/frontoffice/assets/`.
4. **Résultat** : les assets sont dans `Views/frontoffice/assets/`.
5. **Vérification** : ☐ même nombre de fichiers ☐ polices toujours dans `assets/fonts` (les chemins relatifs des CSS restent valides).
6. **Commit** : `chore(front): déplacement des assets du Front Office`

### Phase 3 — Partials et layout du Front Office

1. **Objectif** : écrire **une seule fois** le head, le header, le footer et les scripts.
2. **Fichiers** : `index.html` (source), `frontoffice/partials/*.php`, `frontoffice/layout.php`.
3. **Actions** : découper selon la section 6.1 ; remplacer les parties variables par `$title`, `$description`, `$currentPage`, `$pageCss`, `$pageScripts` ; lien actif en PHP avec `isActive()` ; liens du header et du footer → `?page=`.
4. **Résultat** : 4 partials + 1 layout.
5. **Vérification** : ☐ `head.php` contient bien `<!DOCTYPE>` et ouvre `<body>` ☐ aucun header/footer en double ☐ fichiers enregistrés en **UTF-8 sans BOM**.
6. **Commit** : `feat(front): extraction des partials (head, header, footer, scripts) et layout`

### Phase 4 — Pages et contrôleurs du Front Office

1. **Objectif** : retrouver les 6 pages, identiques à l'original, servies par le MVC.
2. **Fichiers** : `pages/accueil.php` (depuis `index.html` l.102–304), `pages/interruptions/carte.php`, `pages/factures/analyses.php`, `pages/factures/connexion.php`, `pages/services.php`, `pages/a-propos.php` (depuis `tools/partials/`) ; `HomeController`, `InterruptionController`, `ConsommationController`, `UtilisateurController` ; `routes.php`.
3. **Actions** : copier le contenu ; créer les méthodes des contrôleurs avec leurs options `css`/`scripts` (tableau 6.2) ; déclarer les routes ; liens internes des pages → `?page=`.
4. **Résultat** : `http://localhost/<dossier>/index.php?page=carte` affiche la carte.
5. **Vérification** : ☐ comparer chaque page avec `docs/screenshots/*-1440-full.png` ☐ le bon lien est actif dans le menu ☐ la console du navigateur est sans erreur (F12) ☐ la carte, les graphiques, la recherche, la langue AR et le thème sombre fonctionnent.
6. **Commits** (un par page, c'est mieux pour l'historique) : `feat(front): intégration de la page accueil en MVC`, `feat(front): intégration de la page carte`…

### Phase 5 — Liens dans le JavaScript

1. **Objectif** : plus aucun lien vers un `.html`.
2. **Fichiers** : `frontoffice/assets/js/layout.js`, `frontoffice/assets/js/data.js`.
3. **Actions** : remplacer les liens listés en 6.4.
4. **Résultat** : menu mobile, recherche (Ctrl+K), panneau des notifications et cartes de services mènent aux bonnes pages.
5. **Vérification** : ☐ rechercher « .html » dans le projet : 0 résultat hors `docs/` ☐ tester le menu mobile en largeur 390 px.
6. **Commit** : `fix(front): liens JavaScript adaptés au routeur`

### Phase 6a — Prototype statique du Back Office (option A, section 6.6)

1. **Objectif** : obtenir le HTML/CSS du Back Office à partir de la maquette `references/dachboard admin.png`.
2. **Fichiers** : `backoffice-prototype/dashboard.html`, `liste.html` (tableau type : recherche, filtres, badges de statut, actions modifier/supprimer), `form.html` (formulaire type : champs, sélection, validation) ; `backoffice/assets/css/admin.css`, `backoffice/assets/js/admin.js`.
3. **Actions** : reprendre les variables de `tokens.css` (aucune nouvelle couleur en dur) ; réutiliser `icons.js` et `charts.js` ; sidebar avec les groupes de la section 8.7 (et non le menu de la maquette) ; responsive (sidebar repliable).
4. **Résultat** : 3 pages HTML qui ressemblent à la maquette et servent de modèles à toutes les pages BO.
5. **Vérification** : ☐ comparaison visuelle avec la maquette ☐ 1440 px et 768 px ☐ thème clair (le thème sombre est facultatif en BO).
6. **Commit** : `feat(back): prototype HTML du Back Office d'après la maquette`

### Phase 6b — Intégration du Back Office (atelier, partie 2)

1. **Objectif** : appliquer la partie 2 de l'atelier au prototype.
2. **Fichiers** : `backoffice/partials/{head,sidebar,header,footer,scripts}.php`, `backoffice/layout.php`, `backoffice/pages/dashboard.php`, `DashboardController.php`.
3. **Actions** : repérer les zones répétées (tableau 6.6) ; extraire les partials ; sidebar dynamique (`isActive`, groupe ouvert selon le module) ; `'office' => 'backoffice'` dans les options de `render()` ; supprimer `backoffice-prototype/` une fois intégré.
4. **Résultat** : `index.php?page=dashboard` affiche le Back Office.
5. **Vérification** : ☐ le lien actif de la sidebar suit la page ☐ chaque entrée de la sidebar correspond à un cas d'utilisation ☐ console sans erreur.
6. **Commit** : `feat(back): intégration du Back Office (partials, sidebar dynamique, layout, dashboard)`

*Si le tuteur exige un template téléchargé (option B)* : télécharger TailAdmin, lancer `npm install` puis `npm run build`, intégrer **uniquement le HTML compilé**, puis appliquer la phase 6b et remplacer tout le menu et les textes de démonstration (eCommerce, Calendar…) par ceux de WASLA.

### Phase 7 — Pages des modules (en parallèle, un membre par module)

1. **Objectif** : chaque entité a son interface (liste + formulaire) en FO ou BO (section 8).
2. **Fichiers** : `frontoffice/pages/<module>/…`, `backoffice/pages/<module>/…`, un contrôleur par page, une route par page.
3. **Actions** : partir des composants **existants** (tableaux de `analyses.php`, formulaires et champs de `carte.php`/`connexion.php`, cartes de `components.css` pour le FO ; tables et formulaires du template pour le BO) ; nommer les champs d'après le dictionnaire ; données fictives.
4. **Résultat** : toutes les entités ⭐ (et si possible ➕) ont une page.
5. **Vérification** : ☐ chaque page s'ouvre via `?page=` ☐ elle utilise le layout (aucun header copié) ☐ le menu y mène.
6. **Commits** : `feat(module1): interfaces interruption et signalement (BO)`, `feat(module3): formulaire refuge_zone (FO)`…

### Phase 8 — Models (selon le diagramme de classes)

1. **Objectif** : montrer le lien entre diagramme de classes et code.
2. **Fichiers** : `app/Models/*.php`.
3. **Actions** : une classe par entité avec ses attributs privés, son constructeur et ses getters/setters, en reprenant exactement les noms du dictionnaire. **[RECOMMANDÉ]** si les tuteurs ne l'exigent pas encore.
4. **Vérification** : ☐ 1 classe = 1 entité ☐ mêmes noms que le diagramme.
5. **Commit** : `feat(models): classes des entités selon le diagramme de classes`

### Phase 9 — Nettoyage, docs et README

1. **Actions** : retirer les `.html` racine, `tools/build-pages.js`, `tools/partials/` ; déplacer captures et images WhatsApp dans `docs/` ; ajouter les UML et le dictionnaire dans `docs/` ; écrire le README (section 10) ; ajouter la description et les topics GitHub.
2. **Vérification** : ☐ racine propre ☐ README conforme ☐ topics présents.
3. **Commits** : `chore: suppression de l'ancien générateur de pages`, `docs: README standardisé et diagrammes UML`

---

## 10. GitHub : dépôt, README, branches, commits

### 10.1 Réglages du dépôt **[OBLIGATOIRE]**

- **Nom proposé** : **`Esprit-PW-2A6-2027-Wasla`**
  - `PW` = Projet Technologies Web : c'est l'abréviation utilisée par Esprit dans le titre du guide README (« PW 2627 »). Le document ne donne pas d'abréviation officielle : **[À CONFIRMER]** avec le tuteur avant de créer le dépôt (renommer plus tard casse les liens déjà partagés).
  - `2A6` = votre classe.
  - `2027` : dans l'exemple officiel, `Esprit-PIDEV-3A10-2026-…` correspond à l'année universitaire **2025–2026** (voir sa description). L'année du nom est donc l'année de **fin** : 2026/2027 → `2027`. Si le tuteur préfère l'année de début, ce sera `Esprit-PW-2A6-2026-Wasla`.
- **Description** : *WASLA – platform to monitor, anticipate and manage water and electricity outages in Tunisia. Developed at Esprit School of Engineering – Tunisia, Web Technologies Project 2A (Academic Year 2026–2027). PHP (MVC), HTML, CSS, JavaScript.*
- **Topics** : `esprit-school-of-engineering`, `academic-project`, `esprit-pw`, `2026-2027`, `php`, et en plus `mvc`, `html`, `css`, `javascript`.
- **Visibilité** : public.

### 10.2 Plan du README

Structure **minimale obligatoire** du document de standardisation, complétée par les sections du guide README :

```markdown
# WASLA – Connecter. Anticiper. Protéger.

## Table des matières
## Overview          ← « developed as part of the Web Technologies Project (2A) at **Esprit School of Engineering** (2026–2027) » + problème résolu
## Features          ← les 4 modules (texte du dictionnaire) + FR/EN/AR, thème sombre, accessibilité
## Tech Stack
### Frontend         ← HTML5, CSS3, JavaScript, template Back Office choisi
### Backend          ← PHP (architecture MVC), MySQL (à venir)
## Architecture      ← arborescence de la section 5 + parcours d'une requête (section 4)
## Contributors      ← Houssem Belhaj (M1 Interruptions), Hiba Bouzid (M2 Factures), Louay Azzabi (M3 Refuge Zones),
                       Bechir Hellali (M4 Assistance) + lien GitHub de chacun
## Academic Context  ← « Developed at **Esprit School of Engineering – Tunisia** · Projet Technologies Web · 2A6 | 2026–2027 »
## Getting Started   ← git clone ; placer dans htdocs/www ; démarrer Apache (et MySQL) ; ouvrir http://localhost/<dossier>/index.php
## Utilisation       ← installer PHP/XAMPP, php -v, URLs FO (?page=accueil) et BO (?page=dashboard)
## Contributions     ← branches, pull requests
## Acknowledgments   ← tuteurs, templates utilisés (crédit à l'auteur du template BO), sources de la carte (geoBoundaries)
## Licence
```

### 10.3 Branches **[RECOMMANDÉ]** (les ateliers n'imposent rien)

```
main                ← version stable, montrée aux tuteurs
└── develop         ← intégration commune
    ├── feature/structure-mvc
    ├── feature/front-integration
    ├── feature/back-integration
    ├── feature/module1-interruptions   ← Houssem
    ├── feature/module2-factures        ← Hiba
    ├── feature/module3-refuges         ← Louay
    └── feature/module4-assistance      ← Bechir
```

Chacun travaille sur sa branche de module → pull request vers `develop` → relecture par un autre membre → fusion. `develop` est fusionnée dans `main` avant chaque validation.

Version simplifiée si l'équipe débute : `main` + une branche par membre.

### 10.4 Convention de commits **[RECOMMANDÉ]**

Format : `type(portée): message court en français`

| Type | Usage | Exemple |
|---|---|---|
| `feat` | nouvelle page, fonctionnalité | `feat(front): intégration de la page carte en MVC` |
| `fix` | correction | `fix(front): lien actif de la navbar` |
| `refactor` | réorganisation sans changement visible | `refactor(front): extraction du footer en partial` |
| `docs` | README, UML | `docs: ajout du diagramme de classes` |
| `chore` | déplacement, nettoyage, config | `chore: déplacement des assets` |
| `style` | mise en forme du code | `style: indentation des vues` |

### 10.5 Commits prévus pour l'intégration (dans l'ordre)

1. `chore: initialisation du dépôt et .gitignore`
2. `feat: squelette MVC (routeur, contrôleur de base, helpers)`
3. `chore(front): déplacement des assets du Front Office`
4. `feat(front): extraction des partials et layout`
5. `feat(front): intégration de la page accueil en MVC`
6. `feat(front): intégration des pages carte, analyses, services, a-propos, connexion` (idéalement un commit par page)
7. `fix(front): liens JavaScript adaptés au routeur`
8. `feat(back): intégration du template Back Office`
9. `feat(module1|2|3|4): …` (pages des modules)
10. `feat(models): classes des entités`
11. `chore: suppression de l'ancien générateur de pages`
12. `docs: README standardisé et diagrammes UML`

Un commit = une étape vérifiée. Évitez « update », « modif », « final ».

---

## 11. Tâches du GitHub Project

**Colonnes proposées** : `Backlog` → `To Do` → `In Progress` → `In Review` → `Done`.
Chaque tâche : un assigné, un label (`front`, `back`, `module1`…, `docs`, `uml`) et un lien vers la PR/le commit qui la termine.

| # | Tâche | Label | Assigné | Statut initial |
|---|---|---|---|---|
| 1 | Diagrammes de cas d'utilisation corrigés (global + 4 modules) → `docs/uml/` | uml | équipe | In Review |
| 2 | Diagramme de classes (global + 4 modules) → `docs/uml/` | uml | équipe | In Review |
| 3 | Créer le dépôt `Esprit-PW-2A6-2027-Wasla` (après confirmation du nom) + inviter les tuteurs | github | [à définir] | To Do |
| 4 | Description + topics du dépôt | github | [à définir] | To Do |
| 5 | Squelette MVC (index.php, routes, helpers, Controller) | structure | [à définir] | To Do |
| 6 | Déplacer les assets Front Office | front | [à définir] | To Do |
| 7 | Extraire les partials et le layout Front Office | front | [à définir] | To Do |
| 8 | Intégrer accueil, carte, analyses, services, à propos, connexion | front | [à répartir] | To Do |
| 9 | Adapter les liens JS (layout.js, data.js) | front | [à définir] | To Do |
| 10a | Confirmer avec le tuteur : Back Office codé d'après la maquette (option A) accepté ? | back | [à définir] | To Do |
| 10b | Prototype HTML du Back Office : dashboard + liste type + formulaire type | back | [à définir] | Backlog |
| 10c | Intégrer le Back Office (partials, sidebar dynamique, layout, dashboard) | back | [à définir] | Backlog |
| 11a | M1 FO : filtre eau/électricité sur la carte, mes signalements, confirmer, alertes | module1 | Houssem | Backlog |
| 11b | M1 BO : interruptions (liste + form), modération des signalements, alertes, zones, sous-admins | module1 | Houssem | Backlog |
| 12a | M2 FO : inscription, mot de passe oublié, profil, mes factures, facture-form, analyse, relevé, consommation | module2 | Hiba | Backlog |
| 12b | M2 BO : données de consommation, comptes citoyens | module2 | Hiba | Backlog |
| 13a | M3 FO : recherche/détail refuge, réservation, mes réservations, mon entreprise, mes refuges, réservations reçues | module3 | Louay | Backlog |
| 13b | M3 BO : validation des refuges, entreprises, comptes professionnels | module3 | Louay | Backlog |
| 14a | M4 FO : fournisseurs, demande d'assistance, suivi, bénévole, installations, réponse, fiche fournisseur, services | module4 | Bechir | Backlog |
| 14b | M4 BO : demandes, fournisseurs, comptes des acteurs | module4 | Bechir | Backlog |
| 14c | Relier le menu Services aux pages des modules (8.6) | front | équipe | Backlog |
| 15 | Classes Models selon le diagramme de classes | models | équipe | Backlog |
| 16 | Nettoyage (anciens .html, build-pages.js) + dossier docs/ | docs | [à définir] | Backlog |
| 17 | README standardisé | docs | [à définir] | Backlog |
| 18 | Test final de toutes les pages (FO + BO) | test | équipe | Backlog |

**Documenter le travail terminé** : fermer la tâche **par le commit ou la PR** (`Closes #12` dans la description de la PR), ajouter une capture d'écran de la page dans la PR, et ne passer une tâche en « Done » qu'après la checklist de sa phase.

---

## 12. Erreurs fréquentes à éviter

| Erreur | Conséquence | Bonne pratique |
|---|---|---|
| Ouvrir `index.php` par double-clic (`file://`) | Le navigateur affiche le code PHP brut | Toujours passer par `http://localhost/…` (XAMPP/WAMP ou `php -S`) |
| Copier `<head>`/`</head>` dans `head.php` **et** dans la page | HTML invalide, doublons | Une seule source : le layout/partial |
| Garder un header ou un footer dans une page de `pages/` | Header affiché deux fois | Les pages ne contiennent que le contenu propre |
| Oublier de définir `$currentPage` | Aucun lien actif, ou erreur PHP | Toujours défini par le contrôleur |
| Laisser des liens `.html` (dans le HTML **ou** le JS) | Erreurs 404 | Chercher « .html » avant chaque commit |
| Chemins relatifs cassés après déplacement | Pages sans style ni image | Déplacer `assets/` en bloc ; utiliser `asset()` |
| Fichiers PHP en UTF-8 **avec BOM** | Caractères parasites en haut de la page | Enregistrer en « UTF-8 » (sans BOM) dans VS Code |
| `require 'partials/head.php'` sans `__DIR__` | Fichier introuvable selon l'endroit d'appel | `require __DIR__ . '/partials/head.php'` |
| Garder les noms de l'exemple (eLEARNING, PlainAdmin, eCommerce) | Le tuteur voit un copier-coller | Remplacer par WASLA partout |
| Modifier encore les anciens `.html` après la migration | Deux versions divergentes | Supprimer les `.html` dès que les `.php` sont validés |
| Créer une table par rôle (citoyen, bénévole…) | Contraire au dictionnaire | Une table `utilisateur` avec la colonne `role` |
| Tout committer en un seul « final commit » | Historique illisible, peu de commits (indicateur suivi par Esprit) | Un commit par étape vérifiée |

---

## 13. Checklist finale de la 2ᵉ validation

**Conception**
- ☐ Diagrammes de cas d'utilisation corrigés (dans `docs/uml/`)
- ☐ Diagramme de classes cohérent avec le dictionnaire des entités (dans `docs/uml/`)

**Dépôt GitHub**
- ☐ Nom `Esprit-[PI]-[Classe]-[AU]-Wasla`
- ☐ Description avec « Esprit School of Engineering – Tunisia », l'année et les technologies
- ☐ Topics : `esprit-school-of-engineering`, `academic-project`, `esprit-[pi]`, année, `php`
- ☐ Dépôt public, tuteurs invités
- ☐ README avec toutes les sections minimales + mot-clé « Esprit School of Engineering »
- ☐ Commits réguliers et lisibles, de **tous** les membres

**Architecture MVC**
- ☐ `index.php` + `app/routes.php` + `app/helpers.php`
- ☐ `app/Controllers/Controller.php` avec `render()` + un contrôleur par page
- ☐ `app/Models/` présent (classes des entités si demandé)
- ☐ `app/Views/frontoffice/` et `app/Views/backoffice/` avec `assets/`, `partials/`, `pages/`, `layout.php`

**Front Office**
- ☐ Les 6 pages s'affichent via `index.php?page=…`, identiques aux originaux
- ☐ Header, footer, head et scripts écrits **une seule fois**
- ☐ Lien actif calculé en PHP
- ☐ Aucun lien `.html` restant (HTML + JS)
- ☐ Carte, graphiques, recherche, langues, thème : OK, console sans erreur

**Back Office**
- ☐ Template intégré avec partials + layout
- ☐ Sidebar dynamique avec les entrées WASLA (plus de menu de démonstration)
- ☐ Dashboard fonctionnel

**Modules**
- ☐ Chaque entité principale ⭐ des 4 modules a son interface (liste + formulaire) en FO ou BO
- ☐ Champs de formulaires nommés comme les colonnes du dictionnaire

**GitHub Project**
- ☐ Tâches créées, assignées, avec labels
- ☐ Statuts à jour, tâches terminées liées à leurs commits/PR
