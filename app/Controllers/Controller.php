<?php
/**
 * Contrôleur de base.
 *
 * render() fait le lien entre le contrôleur et la vue, comme dans l'atelier :
 *   1. il capture le HTML de la page (Views/<office>/pages/<vue>.php) dans $content ;
 *   2. il inclut le layout (Views/<office>/layout.php), qui assemble les partials
 *      autour de $content.
 */

declare(strict_types=1);

abstract class Controller
{
    /** Scripts communs à la plupart des pages FO (i18n.js et motion.js sont ajoutés par scripts.php). */
    protected const FO_SCRIPTS = ['js/data.js', 'js/icons.js', 'js/layout.js', 'js/pages.js'];

    /** Scripts communs aux six pages « Services » (données de démonstration + outils partagés). */
    protected const SERVICE_SCRIPTS = ['js/data.js', 'js/icons.js', 'js/layout.js', 'js/services/demo-data.js', 'js/services/core.js'];

    /** Clé de la page courante, utilisée par la navbar / la sidebar pour l'état actif. */
    protected string $page = 'accueil';

    /** Titre affiché dans <title>. */
    protected string $title = 'WASLA — Connecter. Anticiper. Protéger.';

    /**
     * @param string $view    vue dans pages/, sans .php (ex. 'interruptions/carte')
     * @param array  $options page, title, description, office, css, scripts, head
     *                        (page et title prennent par défaut $this->page et $this->title)
     * @param array  $data    variables envoyées à la vue (plus tard : données des Models)
     */
    protected function render(string $view, array $options = [], array $data = []): void
    {
        $office      = $options['office'] ?? 'frontoffice';
        $currentPage = $options['page'] ?? $this->page;
        $title       = $options['title'] ?? $this->title;
        $description = $options['description'] ?? '';
        $pageCss     = $options['css'] ?? ($office === 'frontoffice' ? ['pages'] : []);
        $pageScripts = $options['scripts'] ?? ($office === 'frontoffice' ? self::FO_SCRIPTS : []);
        $extraHead   = $options['head'] ?? '';

        $viewsDir = __DIR__ . '/../Views/' . $office;

        extract($data, EXTR_SKIP);

        ob_start();
        require $viewsDir . '/pages/' . $view . '.php';
        $content = ob_get_clean();

        require $viewsDir . '/layout.php';
    }

    /**
     * Affiche une page du menu « Services » (Front Office).
     *
     * @param string $view        vue dans pages/ (ex. 'assistance/relais')
     * @param string $page        clé de la page (routes.php)
     * @param string $title       titre de l'onglet
     * @param string $description meta description
     * @param string $script      script propre au service (ex. 'relais' → js/services/relais.js)
     * @param bool   $withMap     true si la page affiche la carte de Tunisie
     */
    protected function renderService(string $view, string $page, string $title, string $description, string $script, bool $withMap = false): void
    {
        $scripts = self::SERVICE_SCRIPTS;
        if ($withMap) {
            array_unshift($scripts, 'data/tunisia.js');
        }
        $scripts[] = 'js/services/' . $script . '.js';

        $this->render($view, [
            'page'        => $page,
            'title'       => $title,
            'description' => $description,
            'css'         => $withMap ? ['home', 'pages', 'services'] : ['pages', 'services'],
            'scripts'     => $scripts,
        ]);
    }
}
