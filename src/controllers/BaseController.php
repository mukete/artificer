<?php namespace Mascame\Artificer;

use App;
use Auth;
use Controller;
use Input;
use Mascame\Artificer\Fields\Field;
use Mascame\Artificer\Model\Model;
use Mascame\Artificer\Options\AdminOption;
use Mascame\Artificer\Permit;
use View;

// Todo: Make some models forbidden for some users

class BaseController extends Controller
{

    public $fields;
    public $data;
    public $options;

    public static $routes;

    public $theme;
    public $standalone;
    public $menu = array();
    protected $master_layout = null;

    /**
     * @var Model
     */
    public $modelObject = null;


    public function __construct()
    {
        $this->theme = AdminOption::get('theme') . '::';
        $this->master_layout = 'base';

        if (Auth::check()) {
            $this->options = AdminOption::all();

            App::make('artificer-plugin-manager')->boot();
            $this->modelObject = App::make('artificer-model');

            if ($this->isStandAlone()) {
                $this->master_layout = 'standalone';
                $this->standalone = true;
            }

            $this->shareMainViewData();
        }
    }

    protected function shareMainViewData()
    {
        View::share('main_title', AdminOption::get('title'));
        View::share('menu', $this->getMenu());
        View::share('theme', $this->theme);
        View::share('layout', $this->theme . '.' . $this->master_layout);
        View::share('fields', array());
        View::share('standalone', $this->standalone);
        View::share('icon', AdminOption::get('icons'));
    }

    /**
     * @return bool
     */
    public function isStandAlone()
    {
        return (\Request::ajax() || Input::has('_standalone'));
    }

    /**
     * @return array
     */
    public function getMenu()
    {
        if (!empty($this->menu)) {
            return $this->menu;
        }
        $menu = AdminOption::get('menu');

        foreach ($menu as $key => $menuItem) {
            if (Permit\MenuPermit::access($key)) {
                $this->menu[] = $menuItem;
            }
        }

        return $this->menu;
    }

    /**
     * @param string $view
     */
    public function getView($view)
    {
        return $this->theme . $view;
    }

    /**
     * @return string
     */
    public static function assets()
    {
        $widgets = '';

        foreach (Field::$widgets as $widget) {
            $widgets .= $widget->output();
        }

        return $widgets;
    }


}