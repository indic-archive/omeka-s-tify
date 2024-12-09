<?php
namespace Tify\Service\Media\Ingester;

use Tify\Media\Ingester\TifyIiifPresentation;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class TifyIiifPresentationFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $services, $requestedName, array $options = null)
    {
        $a = 9;
        return new TifyIiifPresentation(
            $services->get('Omeka\HttpClient'),
            $services->get('Omeka\File\Downloader')
        );
    }
}
