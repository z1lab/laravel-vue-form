<?php
/**
 * Created by Olimar Ferraz
 * webmaster@z1lab.com.br
 * Date: 01/11/2018
 * Time: 16:39
 */

namespace Z1lab\Form\Models\Inputs;

class SelectedHelper extends Selected
{
    const TYPE_INPUT = 'input-selected-helper';

    /**
     * Selected constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $attributes = array_merge($this->getAttributes(), $attributes);
        $attributes['type_input'] = self::TYPE_INPUT;

        parent::__construct($attributes);
    }
}