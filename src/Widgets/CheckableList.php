<?php

namespace Lazychaser\Shopping\Widgets;

use Illuminate\Contracts\Support\Renderable;
use Lazychaser\Shopping\Contracts\Widgets\Option as OptionContract;

/**
 * The widget that renders a list of options.
 */
class CheckableList extends AbstractOptionsList
{
    /**
     * @var string
     */
    public $itemTemplate = '<li class="{class}"><label>'.PHP_EOL.'{option}{frequency}'.PHP_EOL.'</label></li>';

    /**
     * @param OptionContract $option
     *
     * @return string
     */
    protected function renderOption(OptionContract $option)
    {
        $checked = $this->isActive($option) ? ' checked="checked"' : '';

        $filterId = $this->id;
        $id = $this->getInputId($option->getValue());
        $type = $this->getCheckableType();

        if ($this->multiple) {
            $filterId .= '[]';
        }

        $title = $this->renderTitle($option->getTitle());

        return '<input type="'.$type.'" value="'.$option->getValue().'" name="'.$filterId.'" id="'.$id.'"'.$checked.'>'.PHP_EOL.$title;
    }

    /**
     * @param string $value
     *
     * @return string
     */
    protected function renderTitle($value)
    {
        if ( ! $this->html) $value = e($value);

        return '<span class="title">'.$value.'</span>';
    }

    /**
     * @return string
     */
    protected function getCheckableType()
    {
        return $this->multiple ? 'checkbox' : 'radio';
    }

    /**
     * @inheritDoc
     */
    protected function getItemClasses(OptionContract $option)
    {
        $classes = parent::getItemClasses($option);

        $classes[] = $this->getCheckableClass();

        return $classes;
    }

    /**
     * @return string
     */
    public function getBaseContainerClass()
    {
        return 'CheckableFilter';
    }

    /**
     * @param $key
     *
     * @return string
     */
    protected function getInputId($key)
    {
        return $this->id.'__'.$key;
    }

    /**
     * @return string
     */
    protected function getCheckableClass()
    {
        return $this->getBaseItemClass().'--'.$this->getCheckableType();
    }
}