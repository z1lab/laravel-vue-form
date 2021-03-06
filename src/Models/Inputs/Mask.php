<?php
/**
 * Created by Olimar Ferraz
 * webmaster@z1lab.com.br
 * Date: 01/11/2018
 * Time: 12:43
 */

namespace Z1lab\Form\Models\Inputs;

use Z1lab\Form\Models\Input;

class Mask extends Input
{
    const TYPE_INPUT = 'input-mask';
    const MASKED = FALSE;

    /**
     * Mask constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $attributes = array_merge($this->getAttributes(), $attributes);
        $attributes['type_input'] = self::TYPE_INPUT;
        $attributes['masked'] = self::MASKED;

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
     * @param bool $value
     * @return $this
     */
    public function masked(bool $value = TRUE)
    {
        $this->attributes['masked'] = $value;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    private function add(string $value)
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
