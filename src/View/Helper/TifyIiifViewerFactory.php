<?php

namespace Tify\View\Helper;

use Psr\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Tify\View\Helper\TifyIiifViewer;

class TifyIiifViewerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $services, $requestedName, array $options = null)
    {
        return new TifyIiifViewer(
            $services->get('ModuleManager')
        );
    }
}
