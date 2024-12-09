<?php
namespace Tify\Media\Ingester;

use Omeka\Api\Request;
use Omeka\Entity\Media;
use Omeka\Stdlib\ErrorStore;
use Laminas\Form\Element\Url;
use Laminas\View\Renderer\PhpRenderer;
use Omeka\Media\Ingester\IiifPresentation;
use Omeka\Api\Representation\MediaRepresentation;
use Omeka\Media\Ingester\MutableIngesterInterface;

class TifyIiifPresentation extends IiifPresentation implements MutableIngesterInterface
{

    public function getLabel()
    {
        return 'Tify IIIF presentation'; // @translate
    }

    public function getRenderer()
    {
        return 'tify_iiif_presentation';
    }

    public function updateForm(PhpRenderer $view, MediaRepresentation $media, array $options = [])
    {
        $data = $media->source();
        return $this->getForm($view, 'o:source', $options, $data);
    }

    public function form(PhpRenderer $view, array $options = [])
    {
        return $this->getForm($view, 'o:media[__index__][o:source]', $options);
    }

    public function getForm(PhpRenderer $view, $name, array $options = [],  $value = '')
    {
        $urlInput = new Url($name);
        $urlInput->setOptions([
            'label' => 'IIIF presentation URL', // @translate
            'info' => 'Enter the URL to a IIIF collection or manifest.', // @translate
        ]);
        $urlInput->setAttributes([
            'required' => true,
            'value' => $value,
        ]);
        return $view->formRow($urlInput);
    }

    public function update(Media $media, Request $request, ErrorStore $errorStore)
    {
        $this->ingest($media, $request, $errorStore);
        $data = $request->getContent();
        if (isset($data['o:source'])) {
            $source = $data['o:source'];
            $media->setSource($source);
        }
    }
}
