<?php
namespace Tify\Media\Renderer;

use Omeka\Api\Representation\MediaRepresentation;
use Laminas\View\Renderer\PhpRenderer;
use Omeka\Media\Renderer\RendererInterface;

class TifyIiifPresentation implements RendererInterface
{
    public function render(PhpRenderer $view, MediaRepresentation $media, array $options = [])
    {
        $query = [
            'url' => $media->source(),
        ];
        return $view->tifyIiifViewer($query, $options);
    }
}
