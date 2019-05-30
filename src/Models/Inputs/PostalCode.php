<?php

namespace Z1lab\Form\Models\Inputs;

use Z1lab\Form\Models\Input;

class PostalCode extends Input
{
    const TYPE_INPUT = 'input-postal-code';

    /**
     * Mask constructor.
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
