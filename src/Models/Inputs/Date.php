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
    const FORMAT = 'Y-m-d H:i:S';
    const TIME = FALSE;
    const TIME_24HR = TRUE;
    const ALT_INPUT = TRUE;

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
        $attributes['time'] = self::TIME;
        $attributes['time_24hr'] = self::TIME_24HR;
        $attributes['alt_input'] = self::ALT_INPUT;

        parent::__construct($attributes);
    }

    /**
     * @param string $value
     * @return $this
     */
    public function format(string $value)
    {
        $this->attributes['format'] = $value;

        return $this;
    }

    /**
     * @param bool $value
     * @return $this
     */
    public function time(bool $value = TRUE)
    {
        $this->attributes['time'] = $value;

        return $this;
    }

    /**
     * @param bool $value
     * @return $this
     */
    public function time_24hr(bool $value = TRUE)
    {
        $this->attributes['time_24hr'] = $value;

        return $this;
    }

    /**
     * @param bool $value
     * @return $this
     */
    public function alt_input(bool $value = TRUE)
    {
        $this->attributes['alt_input'] = $value;

        return $this;
    }
}
