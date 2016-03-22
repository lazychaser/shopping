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
        $nav = $this->renderNav();
        $content = $this->renderContent();

        return '<div>'.$nav.$content.'</div>';
    }

    /**
     * @return string
     */
    protected function renderNav()
    {
        return '<ul class="nav nav-tabs">'.$this->renderNavItems().'</ul>';
    }

    /**
     * @return string
     */
    protected function renderContent()
    {
        return '<div class="tab-content">'.$this->renderPanes().'</div>';
    }

    /**
     * @return mixed
     */
    protected function renderNavItems()
    {
        return array_reduce($this->items, function ($html, $item) {
            return $html.$this->renderNavItem($item);
        }, '');
    }

    /**
     * @param TabPane $tabPane
     *
     * @return string
     */
    protected function renderNavItem(TabPane $tabPane)
    {
        $class = $this->isActive($tabPane) ? ' class="active"' : '';

        return '<li'.$class.'><a href="#'.$tabPane->getId().'" data-toggle="tab">'.$tabPane->getTitle().'</a></li>';
    }

    /**
     * @return mixed
     */
    protected function renderPanes()
    {
        return array_reduce($this->items, function ($html, $item) {
            return $html.$this->renderPane($item);
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
        $active = $this->isActive($tabPane) ? ' active' : '';

        return '<div class="tab-pane'.$active.'" id="'.$tabPane->getId().'">'.$tabPane->render().'</div>';
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