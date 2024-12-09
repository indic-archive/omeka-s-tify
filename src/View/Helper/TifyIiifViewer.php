<?php
namespace Tify\View\Helper;

use Laminas\View\Helper\AbstractHelper;
use Laminas\ModuleManager\ModuleManager;

class TifyIiifViewer extends AbstractHelper {

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

    /**
     * Render the Tify IIIF viewer in an iframe.
     *
     * The $query array should include a "url" parameter that points to a IIIF
     * manifest or collection. See `Tify\Controller\TifyIiifViewerController` for more
     * information.
     *
     * @param array $query
     * @param array $options
     * @return string
     */
    public function __invoke(array $query, array $options = [])
    {
        $tify = $this->modules->getModule('Tify');
        $settings = $tify->getSettings();

        /** @var \Laminas\View\Renderer\PhpRenderer */
        $view = $this->getView();

        $attributes = $view->htmlAttributes();

        if (!empty($settings['tify_viewer_style'])) {
            $attributes->add('style', $settings['tify_viewer_style']);
        }           

        $src = $view->escapeHtml($view->url('tify-iiif-viewer', [], ['force_canonical' => true, 'query' => $query]));
        $attributes->add('src', $src);
        return sprintf('<iframe %s></iframe>', $attributes);
    }
}
