<?php
/**
 * Created by Olimar Ferraz
 * webmaster@z1lab.com.br
 * Date: 01/11/2018
 * Time: 12:45
 */

namespace Z1lab\Form\Models\Inputs;

use Z1lab\Form\Models\Input;

class TextArea extends Input
{
    const TYPE_INPUT = 'input-textarea';

    /**
     * TextArea constructor.
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
