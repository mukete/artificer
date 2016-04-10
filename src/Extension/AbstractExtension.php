<?php namespace Mascame\Artificer\Extension;

use App;
use Mascame\Artificer\Options\PluginOption;
use Mascame\Extender\Manager;

abstract class AbstractExtension
{

    /**
     * Namespace will automatically be set if empty
     *
     * @var string
     */
    public $namespace;

    /**
     * @var string
     */
    public $version = '1.0';

    /**
     * Name that will be shown on extensions page
     *
     * @var string
     */
    public $name = null;

    /**
     * @var string
     */
    public $description = 'No description provided';

    /**
     * @var string
     */
    public $author = 'Anonymous';

    /**
     * @var string
     */
    public $configFile = null;

    /**
     * @var string
     */
    public $thumbnail = null;

    /**
     * @var string
     */
    public $slug;

    /**
     * @var PluginOption
     */
    protected $option;

    /**
     * Return your plugin routes.
     * 
     * @return \Closure|null
     */
    public function getRoutes() {
        return null;
    }

    abstract public function boot();

    public function getSlug() {
        return $this->slug;
    }
    
    /**
     * @return Manager
     */
    abstract function getManager();

    /**
     * @param array $routes
     */
    public function isInstalled()
    {
        return $this->getManager()->isInstalled($this->namespace);
    }

}