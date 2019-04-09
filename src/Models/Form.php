<?php
/**
 * Created by Olimar Ferraz
 * webmaster@z1lab.com.br
 * Date: 01/11/2018
 * Time: 10:45
 */

namespace Z1lab\Form\Models;

use Illuminate\Support\Str;
use Jenssegers\Model\MassAssignmentException;
use Jenssegers\Model\Model;

class Form extends Model
{
    const FORM      = [];
    const HEADER    = [];
    const SELF      = '';
    const ACTION    = '';
    const METHOD    = 'POST';
    const FIELDSET  = FALSE;
    const API_TOKEN = '';

    /**
     * @var array
     */
    protected $fillable = [
        'self',
        'header',
        'action',
        'return',
        'callback',
    ];
    /**
     * @var array
     */
    protected $attributes = [
        'form'      => self::FORM,
        'header'    => self::HEADER,
        'method'    => self::METHOD,
        'field_set' => self::FIELDSET,
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

        if (\Auth::check() && isset(\Auth::user()->api_token)) $this->attributes['api_token'] = \Auth::user()->api_token;
    }

    /**
     * @param  string  $value
     */
    public function setActionAttribute(string $value)
    {
        if (Str::contains($value, 'update')) $this->attributes['method'] = 'PUT';

        $this->attributes['action'] = $value;
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
     * @param  Fieldset|Input  $field
     *
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
     * @param  array  $data
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
    public function return(string $value)
    {
        $this->attributes['return'] = $value;

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
     * @param  Fieldset  $fieldset
     *
     * @return $this
     */
    private function fieldset(Fieldset $fieldset)
    {
        if (isset($this->attributes['form']) && isset($this->attributes['form'][0]['type'])) {
            throw new MassAssignmentException('Not allowed to set input and fieldsets in same Form instance.');
        }

        $this->attributes['field_set'] = TRUE;

        $this->setFormAttribute($fieldset->toArray());

        return $this;
    }

    /**
     * @param $input
     *
     * @return $this
     */
    private function input($input)
    {
        if ($this->attributes['field_set']) throw new MassAssignmentException('Not allowed to set input and fieldsets in same Form instance.');

        $this->setFormAttribute($input->toArray());

        return $this;
    }
}
