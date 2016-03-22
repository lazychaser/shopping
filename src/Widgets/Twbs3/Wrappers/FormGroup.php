<?php

namespace Kalnoy\Shopping\Widgets\Twbs3\Wrappers;

use Kalnoy\Shopping\Widgets\AbstractWidget;
use Kalnoy\Shopping\Widgets\Wrappers\AbstractWrapper;

class FormGroup extends AbstractWrapper
{
    /**
     * @var string
     */
    public $label;

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        $label = $this->presentLabel();

        return '<div class="form-group">'.$label.$this->renderInner().'</div>';
    }

    /**
     * @return string
     */
    protected function presentLabel()
    {
        if ( ! $this->label) return '';

        $html = '<label';

        if ($this->inner instanceof AbstractWidget) {
            $html .= ' for="'.$this->inner->getId().'"';
        }

        return $html.'>'.e($this->label).'</label>'.PHP_EOL;
    }

}