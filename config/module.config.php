<?php

namespace Tify;

return [
    'view_manager' => [
        'template_path_stack' => [
            dirname(__DIR__) . '/view',
        ],
    ],
    
    'form_elements' => [
        'invokables' => [
            Form\ConfigForm::class => Form\ConfigForm::class,
        ],
    ],
    'tify' => [
        'config' => [
            'tify_viewer_style' => 'width: 100%; aspect-ratio: 1/1;',
            'tify_container_styles' => "#tify {\nwidth: 100%;\nheight: 97vh;\n}",
            // Fonts readers can pick for the Full text tab, one per line:
            // Label | CSS font-family | URL (optional) of a stylesheet or of a
            // font file (.woff2/.woff/.ttf/.otf). The first line is the
            // default; with fewer than two, no switcher is shown.
            'tify_text_fonts' => "Manjari | 'Manjari', sans-serif | https://fonts.googleapis.com/css2?family=Manjari:wght@100;400;700&display=swap\n"
                . "Noto Serif Malayalam | 'Noto Serif Malayalam', serif | https://fonts.googleapis.com/css2?family=Noto+Serif+Malayalam:wght@400;700&display=swap\n"
                // Thumba by C-DIT, Government of Kerala, from
                // kerala.gov.in/assets/malayalamfonts. Bundled because that
                // site's bot check blocks cross-site font requests.
                . "Thumba | 'Thumba', sans-serif | /modules/Tify/asset/fonts/THUMBA.ttf",
        ],
    ],

    'media_ingesters' => [
        'factories' => [
            'tify_iiif_presentation' => Service\Media\Ingester\TifyIiifPresentationFactory::class,
        ],
    ],
    'media_renderers' => [
        'invokables' => [
            'tify_iiif_presentation' => Media\Renderer\TifyIiifPresentation::class,
        ],
    ],
    'view_helpers' => [
        'factories' => [
            'tifyIiifViewer' => View\Helper\TifyIiifViewerFactory::class,
        ],
        // 'invokables' => [
        //     'tifyIiifViewer' => View\Helper\TifyIiifViewer::class,
        // ],
    ],
    'router' => [
        'routes' => [
            'tify-iiif-viewer' => [
                'type' => \Laminas\Router\Http\Literal::class,
                'options' => [
                    'route' => '/tify-iiif-viewer',
                    'defaults' => [
                        'controller' => 'Tfiy\Controller\TifyIiifViewer',
                        'action' => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            'Tfiy\Controller\TifyIiifViewer' => Controller\TifyIiifViewerControllerFactory::class,
        ],
    ],
];
