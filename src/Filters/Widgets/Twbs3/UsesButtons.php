<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 24.06.2015
 * Time: 11:22
 */

namespace Kalnoy\Shopping\Filters\Widgets\Twbs3;

trait UsesButtons
{
    /**
     * @var string
     */
    public $buttonType = 'default';

    /**
     * @var null
     */
    public $buttonSize = null;

    /**
     * @return array
     */
    protected function getButtonClasses()
    {
        return [ 'btn', 'btn-'.$this->buttonType ];
    }

    /**
     * @param bool|false $withSize
     *
     * @return string
     */
    protected function getButtonClass($withSize = false)
    {
        $classes = $this->getButtonClasses();

        if ($withSize) $classes[] = $this->getButtonSizeModifier();

        return implode(' ', $classes);
    }

    /**
     * @param string $prefix
     *
     * @return string
     */
    protected function getButtonSizeModifier($prefix = 'btn')
    {
        return $this->buttonSize ? $prefix.'-'.$this->buttonSize : '';
    }

    /**
     * @return string
     */
    protected function getButtonGroupClass()
    {
        return 'btn-group'.$this->getButtonSizeModifier(' btn-group');
    }
}