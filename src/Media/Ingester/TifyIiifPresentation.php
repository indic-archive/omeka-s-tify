<?php
namespace Tify\Media\Ingester;

use Omeka\Api\Request;
use Omeka\Entity\Media;
use Omeka\File\Downloader;
use Omeka\Stdlib\ErrorStore;
use Laminas\Form\Element\Url;
use Laminas\Http\Client as HttpClient;
use Laminas\Uri\Http as HttpUri;
use Laminas\View\Renderer\PhpRenderer;
use Omeka\Media\Ingester\IiifPresentation;

class TifyIiifPresentation extends IiifPresentation
{

    public function getLabel()
    {
        return 'Tify IIIF presentation'; // @translate
    }

    public function getRenderer()
    {
        return 'tify_iiif_presentation';
    }
}
