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
    const INPUT_SELECTED        = 'input-selected';
    const INPUT_SELECTED_HELPER = 'input-selected-helper';
    const INPUT_SELECTED_SEARCH = 'input-selected-search';

    /**
     * Selected constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $attributes = array_merge($this->getAttributes(), $attributes);
        if (!isset($attributes['type_input'])) $attributes['type_input'] = self::INPUT_SELECTED;

        parent::__construct($attributes);
    }

    /**
     * @param array $data
     * @param string|array|NULL $label
     * @param string|NULL $key
     * @return $this
     */
    public function options(array $data = [], $label = NULL, string $key = NULL)
    {
        if ($label !== NULL || $key !== NULL) {
            $this->attributes['options'] = [
                'label' => (NULL !== $label) ? $label : '',
                'key' => $key,
                'data'  => $data,
            ];
        } else {
            $this->attributes['options'] = $data;
        }

        return $this;
    }

    /**
     * @param string|array $label
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
     * @param string $key
     * @return $this
     */
    public function key(string $key)
    {
        $this->attributes['options']['key'] = $key;

        return $this;
    }

    /**
     * @param array $array
     * @return $this
     */
    public function data(array $array)
    {
        if (gettype($array[0]) === 'array') {
            $this->attributes['options']['data'] = $array;
        } else {
            $this->attributes['options'] = $array;
        }

        return $this;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function typeInput(string $type)
    {
        if ($type === 'helper') {
            $this->attributes['type_input'] = self::INPUT_SELECTED_HELPER;
        } elseif($type === 'search') {
            $this->attributes['type_input'] = self::INPUT_SELECTED_SEARCH;
        }

        return $this;
    }
}
