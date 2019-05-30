<?php
/**
 * Created by Olimar Ferraz
 * webmaster@z1lab.com.br
 * Date: 01/11/2018
 * Time: 11:11
 */

namespace Z1lab\Form\Models;

use Jenssegers\Model\MassAssignmentException;
use Jenssegers\Model\Model;
use Z1lab\Form\Models\Inputs\Text;

class PostalCode extends Model
{
    const COMPONENT = 'postal-code-component';
    const MASK = '#####-###';
    const COL = 'col-md-3';
    const VALIDATE = 'required|cep';

    /**
     * @var array
     */
    protected $fillable = [
        'component',
        'legend',
        'subtitle',
        'config'
    ];

    /**
     * @var array
     */
    protected $attributes = [
        'component' => self::COMPONENT,
        'config' => [
            'mask'      => self::MASK,
            'col'       => self::COL,
            'validate'  => self::VALIDATE,
            'value'     => ''
        ],
        'data' => [],
    ];

    /**
     * @param string $value
     * @return $this
     */
    public function legend(string $value)
    {
        $this->attributes['legend'] = $value;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function subtitle(string $value)
    {
        $this->attributes['subtitle'] = $value;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function validate(string $value)
    {
        $this->attributes['config']['validate'] = $value;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function mask(string $value)
    {
        $this->attributes['config']['mask'] = $value;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function col(string $value)
    {
        $this->attributes['config']['col'] = $value;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function value(string $value)
    {
        $this->attributes['config']['value'] = $value;

        return $this;
    }

    /**
     * @param array $inputs_address
     * @return $this
     */
    public function inputs(array $inputs_address = [])
    {
        $inputs_address['postal_code'] = new Text;
        $inputs_address['postal_code']->name('address[postal_code]')->value($this->attributes['config']['value']);

        $this->createMany($inputs_address);

        return $this;
    }

    /**
     * @param array $fields
     * @return $this
     */
    private function createMany(array $fields)
    {
        foreach ($fields as $key => $field) {
            if (!$field instanceof Input) throw new MassAssignmentException('createMany accepts only Inputs');

            $this->create($field->key($key));
        }

        return $this;
    }

    /**
     * @param Input $input
     * @return $this
     */
    private function create(Input $input)
    {
        $this->setDataAttribute($input->toArray());

        return $this;
    }

    /**
     * @param array $data
     */
    private function setDataAttribute(array $data = [])
    {
        $this->attributes['data'][] = $data;
    }
}
