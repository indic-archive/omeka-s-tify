<?php
namespace Tify\Media\Renderer;

use Omeka\Api\Representation\MediaRepresentation;
use Laminas\View\Renderer\PhpRenderer;
use Omeka\Media\Renderer\RendererInterface;

class TifyIiifPresentation implements RendererInterface
{
    public function render(PhpRenderer $view, MediaRepresentation $media, array $options = [])
    {
        if (!empty($options['alternate_url'])) {
            $url = $options['alternate_url'];
        }
        else {
            $url = $media->source();
        }
        $query = [
            'url' => $url,
        ];
        return $view->tifyIiifViewer($query, $options);
    }
}
