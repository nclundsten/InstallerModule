<?php
//return array();
return array(
    'di' => array(
        'instance' => array(
            'alias' => array(
                'install' => 'Installer',
            ),
            'CatalogManager\Service\Install' => array(
                'parameters' => array(
                    'catalogService' => 'Catalog\Service\CatalogService',
                ),
            ),  
        ),
    ),
);      
