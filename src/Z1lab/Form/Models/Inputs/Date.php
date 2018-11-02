<?php
/**
 * Created by Olimar Ferraz
 * webmaster@z1lab.com.br
 * Date: 01/11/2018
 * Time: 12:42
 */

namespace Z1lab\Form\Models\Inputs;

use Z1lab\Form\Models\Input;

class Date extends Input
{
    const TYPE_INPUT = 'input-date';
    const FORMAT = 'D-M-Y';

    /**
     * Date constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $attributes = array_merge($this->getAttributes(), $attributes);
        $attributes['type_input'] = self::TYPE_INPUT;
        $attributes['format'] = self::FORMAT;

        parent::__construct($attributes);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function format(string $value)
    {
        $attributes['format'] = $value;

        return $this;
    }
}
