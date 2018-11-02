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
            'attributes' => parent::toArray($request),
        ];
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function with($request)
    {
        return [
            'links' => [
                'self'    => $this->when(isset($this->resource['self']), function () { return $this->resource['self']; }),
                'related' => $this->resource['action'],
            ],
        ];
    }
}
