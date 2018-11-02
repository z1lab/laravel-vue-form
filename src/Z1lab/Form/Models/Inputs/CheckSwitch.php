<?php
/**
 * Created by Olimar Ferraz
 * webmaster@z1lab.com.br
 * Date: 01/11/2018
 * Time: 16:48
 */

namespace Z1lab\Form\Models\Inputs;

use Z1lab\Form\Models\Input;

class CheckSwitch extends Input
{
    const TYPE_INPUT = 'input-switch';
    const VALUE = FALSE;

    /**
     * CheckSwitch constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $attributes = array_merge($this->getAttributes(), $attributes);
        $attributes['type_input'] = self::TYPE_INPUT;
        $attributes['value'] = self::VALUE;

        parent::__construct($attributes);
    }

    /**
     * @return bool
     */
    public function on()
    {
        return $this->attributes['value'] = TRUE;
    }
}
