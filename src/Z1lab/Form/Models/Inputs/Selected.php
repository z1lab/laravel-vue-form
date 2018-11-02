<?php
/**
 * Created by Olimar Ferraz
 * webmaster@z1lab.com.br
 * Date: 01/11/2018
 * Time: 12:44
 */

namespace Z1lab\Form\Models\Inputs;

use Z1lab\Form\Models\Input;

class Selected extends Input
{
    const TYPE_INPUT = 'input-selected';

    /**
     * Selected constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $attributes = array_merge($this->getAttributes(), $attributes);
        if (!isset($attributes['type_input'])) $attributes['type_input'] = self::TYPE_INPUT;

        parent::__construct($attributes);
    }

    /**
     * @param string|array $label
     * @param string       $value
     * @param array        $data
     * @return $this
     */
    public function options($label = '', string $value = '', array $data = [])
    {
        $this->attributes['options'] = [
            'label' => (NULL !== $label) ? $label : '',
            'value' => $value,
            'data'  => $data,
        ];

        return $this;
    }

    /**
     * @param string| array $label
     * @return $this
     */
    public function label($label)
    {
        if (isset($this->attributes['options']['label'])) {
            array_push($this->attributes['options']['label'], $label);
        } else {
            $this->attributes['options']['label'] = $label;
        }

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function value(string $value)
    {
        $this->attributes['options']['value'] = $value;

        return $this;
    }

    /**
     * @param array $array
     */
    public function data(array $array)
    {
        if (isset($this->attributes['options']['data'])) {
            $this->attributes['options']['data'] = $array;
        } else {
            $this->attributes['options'] = $array;
        }
    }
}
