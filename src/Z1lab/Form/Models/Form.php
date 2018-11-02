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
     * @param $value
     */
    public function setActionAttribute($value)
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
            if ($field instanceof Fieldset) throw new MassAssignmentException('createMany accepts only Inputs.');

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
     * @param Fieldset $fieldset
     */
    private function fieldset(Fieldset $fieldset)
    {
        $this->attributes['field_set'] = TRUE;

        $this->setFormAttribute($fieldset->toArray());
    }

    /**
     * @param array $data
     */
    public function setFormAttribute(array $data = [])
    {
        $this->attributes['form'][] = $data;
    }

    /**
     * @param \Z1lab\Form\Models\Input $input
     */
    private function input($input)
    {
        if ($this->attributes['field_set']) throw new MassAssignmentException('Not allowed to set input and fieldsets in same Model.');

        $this->setFormAttribute($input->toArray());
    }

    /**
     * @return mixed
     */
    public function getFormAttribute()
    {
        return $this->attributes['form'];
    }
}
