<?php
namespace Tify\Controller;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Tify\Controller\TifyIiifViewerController;
use Psr\Container\ContainerInterface;

class TifyIiifViewerControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $services, $requestedName, array $options = null)
    {
        return new TifyIiifViewerController(
            $services->get('ModuleManager')
        );
    }
}
