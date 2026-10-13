<?php

namespace Tify\Form;

use Laminas\Form\Element;
use Laminas\Form\Form;

class ConfigForm extends Form
{
    public function init(): void
    {
        $this
            ->add([
                'type' => Element\Text::class,
                'name' => 'tify_viewer_style',
                'options' => [
                    'label' => 'Viewer CSS Style',
                    'info' => 'Inline CSS rules to use for the Tify iframe.'
                ],
                'attributes' => [
                    'id' => 'tify_viewer_style',
                ],
            ])
            ->add([
                'type' => Element\Textarea::class,
                'name' => 'tify_container_styles',
                'options' => [
                    'label' => 'Tify Container CSS Style',
                    'info' => 'CSS style to apply to the Tify container.'
                ],
                'attributes' => [
                    'id' => 'tify_container_styles',
                    'rows' => 10,
                ],
            ])
            ->add([
                'type' => Element\Textarea::class,
                'name' => 'tify_text_fonts',
                'options' => [
                    'label' => 'Full text fonts',
                    'info' => 'Fonts readers can switch between in the Full text tab, one per line: Label | CSS font-family | URL (optional). The URL may be a stylesheet (e.g. Google Fonts) or a font file (.woff2, .woff, .ttf, .otf), absolute or starting with "/". The first line is the default. With fewer than two lines no switcher is shown.',
                ],
                'attributes' => [
                    'id' => 'tify_text_fonts',
                    'rows' => 4,
                ],
            ])
            ;
    }
}
