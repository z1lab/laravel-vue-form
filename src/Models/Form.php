<?php
/**
 * Created by Olimar Ferraz
 * webmaster@z1lab.com.br
 * Date: 01/11/2018
 * Time: 10:45
 */

namespace Z1lab\Form\Models;

use Jenssegers\Model\Model;
use Z1lab\Form\Http\Resource\Form as Resource;

class Form extends Model
{
    const FORM      = [];
    const HEADER    = [];
    const SELF      = '';
    const ACTION    = '';
    const METHOD    = 'POST';
    const API_TOKEN = '';

    /**
     * @var array
     */
    protected $fillable = [
        'self',
        'header',
        'action',
        'callback',
    ];
    /**
     * @var array
     */
    protected $attributes = [
        'form'      => self::FORM,
        'header'    => self::HEADER,
        'method'    => self::METHOD,
        'self'      => self::SELF,
        'action'    => self::ACTION,
        'api_token' => self::API_TOKEN,
    ];

    /**
     * Form constructor.
     */
    public function __construct()
    {
        parent::__construct();

        if (\Auth::check() && isset(\Auth::user()->api_token)) {
            $this->attributes['api_token'] = \Auth::user()->api_token;
        } elseif (\Auth::guard('api')->check() && isset(\Auth::guard()->user('api')->api_token)) {
            $this->attributes['api_token'] = \Auth::guard('api')->user()->api_token;
        }
    }

    /**
     * @param  string  $title
     * @param  string  $subtitle
     *
     * @return $this
     */
    public function header(string $title = '', string $subtitle = '')
    {
        $this->attributes['header'] = [
            'title'    => $title,
            'subtitle' => $subtitle,
        ];

        return $this;
    }

    /**
     * @param  array  $fields
     *
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
     * @param  Fieldset|PostalCode|Input  $field
     *
     * @return $this
     */
    public function create($field)
    {
        if ($field instanceof Fieldset) {
            $this->fieldset($field);
        } elseif($field instanceof PostalCode) {
            $this->postalCode($field);
        } else {
            $this->input($field);
        }

        return $this;
    }

    /**
     * @param  string  $value
     *
     * @return $this
     */
    public function action(string $value)
    {
        $this->attributes['action'] = $value;

        return $this;
    }

    /**
     * @param  string  $value
     *
     * @return $this
     */
    public function self(string $value)
    {
        $this->attributes['self'] = $value;

        return $this;
    }

    /**
     * @param  string  $value
     *
     * @return $this
     */
    public function method(string $value)
    {
        $this->attributes['method'] = $value;

        return $this;
    }

    /**
     * @param  string  $value
     *
     * @return $this
     */
    public function callback(string $value)
    {
        $this->attributes['callback'] = $value;

        return $this;
    }

    /**
     * @return Resource
     */
    public function return()
    {
        return new Resource(collect($this->toArray()));
    }

    /**
     * @param  Fieldset  $fieldset
     *
     * @return $this
     */
    private function fieldset(Fieldset $fieldset)
    {
        $this->setFormAttribute($fieldset->toArray());

        return $this;
    }

    /**
     * @param PostalCode $postalCode
     * @return $this
     */
    private function postalCode(PostalCode $postalCode)
    {
        $this->setFormAttribute($postalCode->toArray());

        return $this;
    }

    /**
     * @param Input $input
     * @return $this
     */
    private function input(Input $input)
    {
        $this->setFormAttribute(['data' => $input->toArray(), 'component' => 'input-component']);

        return $this;
    }

    /**
     * @param array $data
     */
    private function setFormAttribute(array $data = [])
    {
        $this->attributes['form'][] = $data;
    }
}
