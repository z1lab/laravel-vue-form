<?php
/**
 * Created by Olimar Ferraz
 * webmaster@z1lab.com.br
 * Date: 01/11/2018
 * Time: 10:45
 */

namespace Z1lab\Form\Models;

use Jenssegers\Model\MassAssignmentException;
use Jenssegers\Model\Model;

class Form extends Model
{
    const FORM = [];
    const SELF = '';
    const ACTION = '';
    const METHOD = 'POST';
    const FIELDSET = FALSE;

    /**
     * @var array
     */
    protected $fillable = [
        'self',
        'action',
        'return',
        'callback',
    ];
    /**
     * @var array
     */
    protected $attributes = [
        'form'      => self::FORM,
        'method'    => self::METHOD,
        'field_set' => self::FIELDSET,
        'self'      => self::ACTION,
        'action'    => self::SELF,
    ];

    /**
     * @param string $value
     */
    public function setActionAttribute(string $value)
    {
        if (str_contains($value, 'update')) $this->attributes['method'] = 'PUT';

        $this->attributes['action'] = $value;
    }

    /**
     * @param array $fields
     * @return $this
     */
    public function createMany(array $fields)
    {
        foreach ($fields as $field) {
            $this->create($field);
        }

        return $this;
    }

    /**
     * @param Fieldset|Input $field
     * @return $this
     */
    public function create($field)
    {
        if ($field instanceof Fieldset) {
            $this->fieldset($field);
        } else {
            $this->input($field);
        }

        return $this;
    }

    /**
     * @param array $data
     */
    public function setFormAttribute(array $data = [])
    {
        $this->attributes['form'][] = $data;
    }

    /**
     * @return mixed
     */
    public function getFormAttribute()
    {
        return $this->attributes['form'];
    }

    /**
     * @param string $value
     */
    public function action(string $value)
    {
        $this->attributes['action'] = $value;
    }

    /**
     * @param string $value
     */
    public function self(string $value)
    {
        $this->attributes['self'] = $value;
    }

    /**
     * @param string $value
     */
    public function method(string $value)
    {
        $this->attributes['method'] = $value;
    }

    /**
     * @param string $value
     */
    public function return(string $value)
    {
        $this->attributes['return'] = $value;
    }

    /**
     * @param string $value
     */
    public function callback(string $value)
    {
        $this->attributes['callback'] = $value;
    }

    /**
     * @param Fieldset $fieldset
     */
    private function fieldset(Fieldset $fieldset)
    {
        if (isset($this->attributes['form']) && isset($this->attributes['form'][0]['type']))
            throw new MassAssignmentException('Not allowed to set input and fieldsets in same Form instance.');

        $this->attributes['field_set'] = TRUE;

        $this->setFormAttribute($fieldset->toArray());
    }

    /**
     * @param \Z1lab\Form\Models\Input $input
     */
    private function input($input)
    {
        if ($this->attributes['field_set']) throw new MassAssignmentException('Not allowed to set input and fieldsets in same Form instance.');

        $this->setFormAttribute($input->toArray());
    }
}
