<?php
/**
 * Layout du Front Office : assemble les blocs communs autour du contenu de la page.
 *
 * Variables fournies par Controller::render() :
 *   $title, $description  titre de l'onglet et meta description
 *   $currentPage          clé de la page courante (lien actif du menu)
 *   $pageCss              feuilles de style propres à la page
 *   $pageScripts          scripts propres à la page
 *   $extraHead            balises supplémentaires dans <head> (facultatif)
 *   $content              HTML de la page (déjà rendu)
 */
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/header.php';

echo $content;

require __DIR__ . '/partials/footer.php';
require __DIR__ . '/partials/scripts.php';
