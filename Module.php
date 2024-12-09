<?php
namespace Tify;

use Omeka\Module\AbstractModule;
use Laminas\Mvc\Controller\AbstractController;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Laminas\View\Renderer\PhpRenderer;
use Laminas\Mvc\MvcEvent;

class Module extends AbstractModule
{
    const NAMESPACE = __NAMESPACE__;
    public function getConfig()
    {
        return require __DIR__ . '/config/module.config.php';
    }

    public function uninstall(ServiceLocatorInterface $serviceLocator)
    {
        $settings = $serviceLocator->get('Omeka\Settings');
        $space = strtolower(static::NAMESPACE);
        $settings->delete($space);
    }

    public function onBootstrap(MvcEvent $event): void
    {
        parent::onBootstrap($event);
        $this->addAclRules();
    }

    protected function addAclRules(): void
    {
        /** @var \Omeka\Permissions\Acl $acl */
        $acl = $this->getServiceLocator()->get('Omeka\Acl');
        $acl
            // All can access Tify IIIF viewer.
            ->allow(
                null,
                [
                    'Tfiy\Controller\TifyIiifViewer'
                ]
            );
    }

    public function getSettings() {
        $services = $this->getServiceLocator();
        $space = strtolower(static::NAMESPACE);
        $settings = $services->get('Omeka\Settings');

        $config = $this->getConfig();
        $defaultSettings = $config[$space]['config'];

        $savedSettings = $settings->get($space) ?? [];
        return array_merge($defaultSettings, $savedSettings);
    }

    /**
     * @return  \Tify\Form\ConfigForm
     */
    public function getConfigFormObject() {
        $formManager = $this->getServiceLocator()->get('FormElementManager');
        $formClass = static::NAMESPACE . '\Form\ConfigForm';
        if (!$formManager->has($formClass)) {
            return FALSE;
        }
        return  $formManager->get($formClass);
    }

    /**
     * Get this module's configuration form.
     *
     * @param PhpRenderer $renderer
     * @return string
     */
    public function getConfigForm(PhpRenderer $renderer)
    {
        $settings = $this->getSettings();

        $form = $this->getConfigFormObject();
        $form->init();
        $form->setData($settings);
        $form->prepare();
        return $renderer->render('tify/config-form', [
            'data' => $settings,
            'form' => $form,
        ]);
    }

    /**
     * This will be called on configuration form submission.
     * 
     * We need to retrieve submitted data validate it.
     * Then set it to global settings service. That service will save it on the DB.
     */
    public function handleConfigForm(AbstractController $controller)
    {
        $space = strtolower(static::NAMESPACE);

        $services = $this->getServiceLocator();

        /** @var \Laminas\Http\Request $request */
        $request = $controller->getRequest();
        // Get submitted POST data.
        $params = $request->getPost();

        // Load the form object and validate the submitted data.
        $form = $this->getConfigFormObject();
        $form->init();
        $form->setData($params);
        if (!$form->isValid()) {
            $controller->messenger()->addErrors($form->getMessages());
            return false;
        }

        // Get the validated data.
        $submittedSettings = $form->getData();

        $savedSettings = $this->getSettings();

        foreach ($savedSettings as $key => $value) {
            if (isset($submittedSettings[$key])) {
                $savedSettings[$key] = $submittedSettings[$key];
            }
        }

        // Get settings service.
        $settings = $services->get('Omeka\Settings');
        $settings->set($space, $savedSettings);

        return true;
    }
}
