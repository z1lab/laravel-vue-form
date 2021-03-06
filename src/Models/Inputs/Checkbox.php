<?php
/**
 * Created by Olimar Ferraz
 * webmaster@z1lab.com.br
 * Date: 01/11/2018
 * Time: 12:41
 */

namespace Z1lab\Form\Models\Inputs;

use Z1lab\Form\Models\Input;

class Checkbox extends Input
{
    const TYPE_INPUT = 'input-checkbox';

    /**
     * Checkbox constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $attributes = array_merge($this->getAttributes(), $attributes);
        $attributes['type_input'] = self::TYPE_INPUT;
        $attributes['value'] = [];

        parent::__construct($attributes);
    }

    /**
     * @param array $data
     * @return $this
     */
    public function checkboxs(array $data)
    {
        $this->attributes['checkboxs'] = $data;

        return $this;
    }
}
