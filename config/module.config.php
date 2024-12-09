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
