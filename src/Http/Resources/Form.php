<?php
/**
 * Created by Olimar Ferraz
 * webmaster@z1lab.com.br
 * Date: 01/11/2018
 * Time: 19:03
 */

namespace Z1lab\Form\Http\Resource;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Str;

class Form extends Resource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'type'       => 'forms',
            'id'         => Str::uuid(),
            'attributes' => [
                'form'          => $this->resource['form'],
                'method'        => $this->resource['method'],
                'header'        => $this->resource['header'],
                'api_token'     => $this->when(filled($this->resource['api_token']), $this->resource['api_token'])
            ],
            'links' => [
                'self'     => $this->when(filled($this->resource['self']), $this->resource['self']),
                'action'   => $this->when(filled($this->resource['action']), $this->resource['action']),
                'callback' => $this->when(filled($this->resource['callback']), $this->resource['callback'])
            ],
        ];
    }
}
