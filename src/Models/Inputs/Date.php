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
    const FORMAT_INPUT = 'YYYY-MM-DD';
    const FORMAT_OUTPUT = 'YYYY-MM-DD';
    const FORMAT_EXHIBITION = 'DD/MM/YYYY';
    const MASK = '##/##/####';

    /**
     * Date constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $attributes = array_merge($this->getAttributes(), $attributes);
        $attributes['type_input'] = self::TYPE_INPUT;
        $attributes['format_input'] = self::FORMAT_INPUT;
        $attributes['format_output'] = self::FORMAT_OUTPUT;
        $attributes['format_exhibition'] = self::FORMAT_EXHIBITION;
        $attributes['mask'] = self::MASK;

        parent::__construct($attributes);
    }

    /**
     * @param string $input
     * @param string $output
     * @param string $exhibition
     * @return $this
     */
    public function format(string $input = 'YYYY-MM-DD', string $output = 'YYYY-MM-DD', string $exhibition = 'DD/MM/YYYY')
    {
        $this->attributes['format_input'] = $input;
        $this->attributes['format_output'] = $output;
        $this->attributes['format_exhibition'] = $exhibition;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function exhibition(string $value)
    {
        $this->attributes['mask'] = $value;

        return $this;
    }
}
