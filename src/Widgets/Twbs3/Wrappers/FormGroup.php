<?php

namespace Lazychaser\Shopping\Widgets\Twbs3\Wrappers;

use Lazychaser\Shopping\Widgets\AbstractWidget;
use Lazychaser\Shopping\Widgets\Wrappers\AbstractWrapper;

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

        return '<div class="form-group">'.PHP_EOL.$label.$this->renderInner().'</div>';
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