<?php
namespace Tify\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Mvc\MvcEvent;
use Laminas\View\Model\ViewModel;
use Laminas\ModuleManager\ModuleManager;

class TifyIiifViewerController extends AbstractActionController {
    /**
     * @var ModuleManager
     */
    protected $modules;

    /**
     * @param ModuleManager $modules
     */
    public function __construct(ModuleManager $modules) {
        $this->modules = $modules;
    }

    public function indexAction()
    {
        $tify = $this->modules->getModule('Tify');
        $settings = $tify->getSettings();

        // Set the default Mirador configuration.
        $tifyConfig = [
            'manifestUrl' => $this->params()->fromQuery('url'),
            'tifyContainerStyles' => $settings['tify_container_styles'],
            'textFonts' => $this->parseTextFonts((string) ($settings['tify_text_fonts'] ?? '')),
        ];

        // Allow modules to modify the Tify configuration.
        /** @var \Laminas\EventManager\EventManager */
        $eventManager = $this->getEventManager();
        $args = $eventManager->prepareArgs(['tify_config' => $tifyConfig]);
        $eventManager->triggerEvent(new MvcEvent('tify.tify_config', null, $args));
        $tifyConfig = $args['tify_config'];

        $view = new ViewModel;
        $view->setTerminal(true);
        $view->setVariable('tifyConfig', $tifyConfig);
        $view->setTemplate('tify-iiif-viewer/index');
        return $view;
    }

    /** Font file extensions mapped to their @font-face format() hint. */
    const FONT_FILE_FORMATS = [
        'woff2' => 'woff2',
        'woff' => 'woff',
        'ttf' => 'truetype',
        'otf' => 'opentype',
    ];

    /**
     * Parse the "Full text fonts" setting.
     *
     * One font per line: `Label | CSS font-family | URL`. The URL is optional
     * and may be http(s) or site-root-relative (`/…`). It is either a
     * stylesheet (e.g. Google Fonts), linked as is, or a font file
     * (.woff2/.woff/.ttf/.otf), for which an @font-face rule is generated under
     * the first name in the family list. Lines without a label or family are
     * skipped.
     *
     * @return array<int, array{label: string, family: string, url: string, face: ?array{name: string, format: string}}>
     */
    protected function parseTextFonts(string $setting): array
    {
        $fonts = [];
        foreach (preg_split('/\R/', $setting) as $line) {
            $parts = array_map('trim', explode('|', $line, 3));
            if (count($parts) < 2 || $parts[0] === '' || $parts[1] === '') {
                continue;
            }

            // Protocol-relative URLs ("//host") are not site-relative.
            $url = $parts[2] ?? '';
            if (!preg_match('#^(https?://|/(?!/))#i', $url)) {
                $url = '';
            }

            $face = null;
            $extension = strtolower(pathinfo((string) parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION));
            if ($url !== '' && isset(self::FONT_FILE_FORMATS[$extension])) {
                // Both the URL and the @font-face name (the first family in the
                // list) are written into CSS, so only plain values are allowed:
                // no quotes, parentheses, angle brackets, backslashes or spaces
                // in the URL.
                $name = trim(explode(',', $parts[1])[0], " \t'\"");
                if (!preg_match('/^[\w \-]+$/u', $name)
                    || !preg_match('#^[A-Za-z0-9\-._~:/?\#\[\]@!$&*+,;=%]+$#', $url)
                ) {
                    continue;
                }
                $face = ['name' => $name, 'format' => self::FONT_FILE_FORMATS[$extension]];
            }

            $fonts[] = [
                'label' => $parts[0],
                'family' => $parts[1],
                'url' => $url,
                'face' => $face,
            ];
        }
        return $fonts;
    }
}
