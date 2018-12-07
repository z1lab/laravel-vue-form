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

    /**
     * @param string $value
     * @return Mask
     */
    public function mask(string $value)
    {
        return $this->add($value);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function add(string $value)
    {
        if (isset($this->attributes['mask'])) {
            if (is_array($this->attributes['mask'])) {
                array_push($this->attributes['mask'], $value);
            } else {
                $this->attributes['mask'] = [
                    $this->attributes['mask'], $value,
                ];
            }
        } else {
            $this->attributes['mask'] = $value;
        }

        return $this;
    }
}
