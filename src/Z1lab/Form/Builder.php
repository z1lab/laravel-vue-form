<?php
/**
 * Created by Olimar Ferraz
 * webmaster@z1lab.com.br
 * Date: 02/11/2018
 * Time: 21:11
 */

namespace Z1lab\Form;

use Z1lab\Form\Models\Form;
use Z1lab\Form\Http\Resource\Form as Resource;

class Builder
{
    /**
     * @var Form
     */
    private $form;

    /**
     * Builder constructor.
     *
     * @param Form $form
     */
    public function __construct(Form $form)
    {
        $this->form = $form;
    }

    /**
     * @return Resource
     */
    public function toJson()
    {
        return new Resource(collect($this->form->toArray()));
    }
}