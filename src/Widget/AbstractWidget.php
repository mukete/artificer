<?php namespace Mascame\Artificer\Widget;

use Mascame\Artificer\Extension\AbstractExtension;

abstract class AbstractWidget extends AbstractExtension implements WidgetInterface
{

    /**
     * @var string
     */
    public static $assetsPath = '/packages/mascame/artificer-widgets';


    /**
     * @return null
     */
    public function assets()
    {
        return null;
    }
    
    /**
     * @return null
     */
    public function output()
    {
        return null;
    }

    /**
     * @return Manager
     */
    public function getManager() {
        return \App::make('ArtificerWidgetManager');
    }

    public function boot()
    {
        return null;
    }

}