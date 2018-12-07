<?php
/**
 * Created by Olimar Ferraz
 * webmaster@z1lab.com.br
 * Date: 01/11/2018
 * Time: 12:46
 */

namespace Z1lab\Form\Models;

use Jenssegers\Model\Model;

class Input extends Model
{
    const TYPE = 'text';
    const COL = 'col-12';
    const VALUE = '';
    /**
     * @var array
     */
    protected $fillable = [
        'label',
        'name',
        'col',
        'value',
        'validate',
        'type',
        'placeholder',
        'type_input',
        'required',
        'disabled',
        'readonly',
    ];
    /**
     * @var array
     */
    protected $attributes = [
        'type'  => self::TYPE,
        'col'   => self::COL,
        'value' => self::VALUE,
    ];

    /**
     * @param $value
     */
    public function setNameAttribute($value)
    {
        if (!isset($this->attributes['label'])) $this->setLabelAttribute($value);

        $this->attributes['disabled'] = FALSE;
        $this->attributes['readonly'] = FALSE;
        $this->attributes['name'] = $value;
    }

    /**
     * @param $value
     */
    public function setLabelAttribute($value)
    {
        $this->attributes['label'] = trans("form::form.$value");
    }

    /**
     * @param      $target
     * @param      $condition
     * @param bool $visible
     * @param bool $cascade
     * @return $this
     */
    public function condition($target, $condition, bool $visible = TRUE, bool $cascade = FALSE)
    {
        $this->attributes['condition'] = [
            'name'    => $target->name,
            'value'   => $condition,
            'default' => $visible,
            'cascade' => $cascade,
        ];

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function name(string $value)
    {
        $this->setNameAttribute($value);

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function col(string $value)
    {
        $this->attributes['col'] = $value;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function validate(string $value)
    {
        if (str_contains($value, 'required')) $this->attributes['required'] = TRUE;

        $this->attributes['validate'] = $value;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function type(string $value)
    {
        $this->attributes['type'] = $value;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function placeholder(string $value)
    {
        $this->attributes['placeholder'] = $value;

        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function value($value)
    {
        $this->attributes['value'] = $value;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function typeInput(string $value)
    {
        $this->attributes['type_input'] = $value;

        return $this;
    }

    /**
     * @param bool $value
     * @return $this
     */
    public function required(bool $value = TRUE)
    {
        $this->attributes['required'] = $value;

        return $this;
    }

    /**
     * @param bool $value
     * @return $this
     */
    public function disabled(bool $value = TRUE)
    {
        $this->attributes['disabled'] = $value;
        $this->attributes['readonly'] = $value;

        return $this;
    }

    /**
     * @param bool $value
     * @return Input
     */
    public function readonly(bool $value = TRUE)
    {
        return $this->disabled($value);
    }
}
