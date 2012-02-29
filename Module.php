<?php

namespace Install;

use Zend\Module\Manager,
    Zend\EventManager\StaticEventManager,
    Zend\Module\Consumer\AutoloaderProvider;

class Module implements AutoloaderProvider
{
    protected $view;
    protected $viewListener;
    protected $moduleManager;

    public function init(Manager $moduleManager)
    {
        $this->moduleManager = $moduleManager;
        $staticEvents = StaticEventManager::getInstance();
        $staticEvents->attach('bootstrap', 'bootstrap', array($this, 'onBootstrap'), 100); 
    }    

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function onBootstrap($e)
    {
        $app          = $e->getParam('application');
        $basePath     = $app->getRequest()->getBasePath();
        $locator      = $app->getLocator();

        $event = $this->moduleManager->getEvent();
        $event->setParam('locator', $locator);

        $this->moduleManager->events()->trigger('install', $event);
    }


    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

} 
