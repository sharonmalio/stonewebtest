<?php
/**
* StoneHMIS (http://stonehmis.afyaresearch.org/)
*
* @link      http://github.com/stonehmis/stone for the canonical source repository
* @copyright Copyright (c) 2009-2018 Afya Research Africa Inc. (http://www.afyaresearch.org)
* @license   http://stonehmis.afyaresearch.org/license/options License Options
* @author    Sharon Malio
* @since     19-04-2018
*/
namespace Album;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module implements ConfigProviderInterface
{
    
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
        //return include '..\config\module.config.php';
        
    }
   
    
    public function getServiceConfig()
    {
        return 
        [
            'factories' => 
            [
                Model\AlbumTable::class => function($container)
                {
                    $tableGateway = $container->get(Model\AlbumTableGateway::class);
                    return new Model\AlbumTable($tableGateway);
                },
                Model\AlbumTableGateway::class => function ($container) 
                {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Album());
                    return new TableGateway('album', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }
    
    
    public function getControllerConfig()
    {
        return 
        [
            'factories' => 
            [
                Controller\AlbumController::class => function($container) 
                {
                    return new Controller\AlbumController(
                        $container->get(Model\AlbumTable::class)
                        );
                },
                
                
                
            ],
        ];
    }
    
}

