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
}
