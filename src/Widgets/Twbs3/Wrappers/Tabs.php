<?php

namespace Kalnoy\Shopping\Widgets\Twbs3\Wrappers;

use Illuminate\Support\Arr;
use Kalnoy\Shopping\Widgets\AbstractWidget;

class Tabs extends AbstractWidget
{
    /**
     * @var array|TabPane[]
     */
    public $items = [];

    /**
     * @var string
     */
    public $activate;

    /**
     * @var string
     */
    public $navClass = 'nav nav-tabs';

    /**
     * @var string
     */
    public $tabContentClass = 'tab-content';

    /**
     * @var string
     */
    public $tabPaneClass = 'tab-pane';

    /**
     * @var TabPane
     */
    private $activePane;

    /**
     * @param TabPane $tabPane
     *
     * @return $this
     */
    public function push(TabPane $tabPane)
    {
        $this->items[] = $tabPane;

        return $this;
    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        $nav = $this->renderNav().PHP_EOL;
        $content = $this->renderContent().PHP_EOL;

        return '<div>'.PHP_EOL.$nav.$content.'</div>';
    }

    /**
     * @return string
     */
    protected function renderNav()
    {
        return '<ul class="'.$this->navClass.'">'.PHP_EOL.$this->renderNavItems().'</ul>';
    }

    /**
     * @return string
     */
    protected function renderContent()
    {
        return '<div class="'.$this->tabContentClass.'">'.PHP_EOL.$this->renderPanes().'</div>';
    }

    /**
     * @return mixed
     */
    protected function renderNavItems()
    {
        return array_reduce($this->items, function ($html, $item) {
            return $html.$this->renderNavItem($item).PHP_EOL;
        }, '');
    }

    /**
     * @param TabPane $tabPane
     *
     * @return string
     */
    protected function renderNavItem(TabPane $tabPane)
    {
        if ($class = $this->getTabPaneNavClass($tabPane)) {
            $class = ' class="'.$class.'"';
        }

        return '<li'.$class.'><a href="#'.$tabPane->getId().'" data-toggle="tab">'.$tabPane->getTitle().'</a></li>';
    }

    /**
     * @param TabPane $tabPane
     *
     * @return string
     */
    protected function getTabPaneNavClass(TabPane $tabPane)
    {
        return $this->isActive($tabPane) ? 'active' : '';
    }

    /**
     * @return mixed
     */
    protected function renderPanes()
    {
        return array_reduce($this->items, function ($html, $item) {
            return $html.$this->renderPane($item).PHP_EOL;
        }, '');
    }

    /**
     * @param TabPane $tabPane
     *
     * @return bool
     */
    protected function isActive(TabPane $tabPane)
    {
        return $tabPane == $this->getActivePane();
    }

    /**
     * @param TabPane $tabPane
     *
     * @return string
     */
    protected function renderPane(TabPane $tabPane)
    {
        return '<div class="'.$this->getTabPaneClass($tabPane).'" id="'.$tabPane->getId().'">'.$tabPane->render().'</div>';
    }

    /**
     * @param TabPane $tabPane
     *
     * @return string
     */
    protected function getTabPaneClass(TabPane $tabPane)
    {
        $class = $this->tabPaneClass;

        if ($this->isActive($tabPane)) {
            $class .= ' active';
        }

        return $class;
    }

    /**
     * @return mixed
     */
    public function getActivePane()
    {
        if ( ! is_null($this->activePane)) {
            return $this->activePane;
        }

        if ($this->activate) {
            $this->activePane = Arr::first($this->items, function ($key, $item) {
                return $item->getId() == $this->activate;
            });
        }

        if ( ! $this->activePane) {
            $this->activePane = reset($this->items);
        }

        return $this->activePane;
    }
}