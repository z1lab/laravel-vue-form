## Introduction

Laravel Vue Form is a package developed for make agile forms using Json:API response and VueJS components.

## License

Laravel Vue Form is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Installation

```
composer require z1lab/laravel-vue-form
```

## Publish Vue Components and JS files 

```
php artisan vendor:publish --tag=form-components
```

### Properties

| Property    | Required  | Input                   | Default | Description                                               |
|-------------|-----------|-------------------------|---------|-----------------------------------------------------------|
| action      | **true**  | String                  |         | Route to submit the form.                                 |
| header      | false     | String                  |         | title and sub-title for creating the form's card header.  |
| method      | false     | String                  | POST    | Method of submitting the form.                            |
| self        | false     | String                  |         | Form root route.                                          |
| callback    | false     | String                  |         | Return route after submitting the form.                   |
| return      | **true**  |                         |         | Padronizando retorno para utilizar formVue.js             |
| create      | **true*** | Input,Fieldset          |         | Emit value with mask chars, default is raw.               |
| createMany  | **true*** | Input,Fieldset          |         | Emit value with mask chars, default is raw.               |

*Create is mandatory if you do not have a createMany being used and vice versa.

### Example Simple

#####HomeController.php

``` php
$form = new \Z1lab\Form\Models\Form;
$form->action('resource/to/send/form');

$name = new \Z1lab\Form\Models\Inputs\Text;
$name->value('Name');
$name->name('name');

$form->create($name);

return $form;
```

#####home.blade

``` php
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel</title>

        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="row justify-content-center mt-5">
                    <div class="col-10">
                    
                        <div id="vue-form" data-url="{{ route('send.form') }}"></div>
                        
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

@routes

<script src="{{ mix("js/form.js") }}"></script>
```

### Fieldset

| Property    | Required | Input                   | Default | Description                                           |
|-------------|----------|-------------------------|---------|-------------------------------------------------------|
| legend      | false    | String                  |         | Use this property to titrate the fieldset component.  |
| subtitle    | false    | String                  |         | Subtitle for description of the component Fieldset.   |
| create      | **true***| Input                   |         | Emit value with mask chars, default is raw.           |
| createMany  | **true***| Input                   |         | Emit value with mask chars, default is raw.           |

*Create is mandatory if you do not have a createMany being used and vice versa.

``` php
$form = new \Z1lab\Form\Models\Form;
$basic = new \Z1lab\Form\Models\Fieldset;

$name = new \Z1lab\Form\Models\Inputs\Text;
$name->value('Name')->name('name');

$basic->create($inputs_basic);
$basic->legend('title');

$form->create($basic);

return $form;
```

### PostalCode

| Property    | Required | Input     | Default          | Description                                                                                                                                       |
|-------------|----------|-----------|------------------|---------------------------------------------------------------------------------------------------------------------------------------------------|
| legend      | false    | String    |                  | Use this property to titrate the fieldset component.                                                                                              |
| subtitle    | false    | String    |                  | Subtitle for description of the component Fieldset.                                                                                               |
| col         | false    | String    | col-md-3         | Use if you want to change the grid size of the postal code.                                                                                       |
| validate    | false    | String    | required,cep     | Use if you want to change the default validation of the postal code.                                                                              |
| mask        | false    | String    | #####-###        | Use if you want to modify the default masking of the postal code.                                                                                 |
| value       | false    | String    |                  | Use if you want to modify the initial value of the postal code.                                                                                   |
| inputs      | **true** | Array     | []               | Use to add other fields in the address fieldset, if you do not add any, only the portal code will be displayed because it is created by default.  |

``` php
$form = new Form;

$address = new PostalCode;
$address->legend('Address')->subtitle('Description');

$inputs_address['street'] = new Text;
$inputs_address['district'] = new Text;
$inputs_address['city'] = new Text;
$inputs_address['state'] = new Text;
$inputs_address['number'] = new Text;
$inputs_address['complement'] = new Text;

$inputs_address['street']->name('address[street]')->col('col-md-6')->validate('required');
$inputs_address['district']->name('address[district]')->col('col-md-3')->validate('required');
$inputs_address['number']->name('address[number]')->col('col-md-2')->validate('required');
$inputs_address['complement']->name('address[complement]')->col('col-md-4');
$inputs_address['city']->name('address[city]')->col('col-md-4')->disabled();
$inputs_address['state']->name('address[state]')->col('col-md-2')->disabled();

$form->action(route('test.post'));
$form->header('Test', 'description');
$form->callback(route('home'));

$form->createMany([$address->inputs($inputs_address)]);

return $form->return();
```

### Inputs

| Property    | Required | Input          | Default        | Restricted            | Description                                                                                                                            |
|-------------|----------|----------------|----------------|-----------------------|----------------------------------------------------------------------------------------------------------------------------------------|
| name        | **true** | String         |                |                       | Name to assign to input.                                                                                                               |
| col         | false    | String         | col-12         |                       | Size of the component in the grid.                                                                                                     |
| validate    | false    | String         |                |                       | Validation, use the [VeeValidate](https://baianat.github.io/vee-validate/) package for use.                                            |
| type        | false    | String         | text           |                       | Input type.                                                                                                                            |
| key         | false    | String         |                |                       | If you need to use a key other than name in js.                                                                                        |
| placeholder | false    | String         |                |                       | Description/Example of input.                                                                                                          |
| value       | false    |                |                |                       | Input value.                                                                                                                           |
| disabled    | false    | Bool           | FALSE          |                       | Disable input for editing.                                                                                                             |
| readonly    | false    | Bool           | FALSE          |                       | Enable read mode for input.                                                                                                            |
| removeLabel | false    |                | FALSE          |                       | If you want your component does not have a label.                                                                                      |
| condition   | false    |                |                |                       | Condition for certain fields to be displayed if certain inputs have a certain value.                                                   |
| checkboxs   | **true** | Array          |                | Checkbox              | Receives a checkbox array for component creation. It receives two values within this label and value array.                            |
| format      | false    |                |                | Date, DateFlatpickr   | Use to identify the format that will arrive for the component, the function may undergo changes in different components.               |
| exhibition  | false    | String         | '##/##/####'   | Date                  | Use to create masks for UX.                                                                                                            |
| time        | false    | String         | FALSE          | DateFlatpickr         | Enables time picker.                                                                                                                   |
| time_24hr   | false    | String         | TRUE           | DateFlatpickr         | Displays time picker in 24 hour mode without AM/PM selection when enabled.                                                             |
| alt_input   | false    | String         | TRUE           | DateFlatpickr         | Show the user a readable date (as per format), but return something totally different to the server.                                   |
| range       | false    |                |                | DateFlatpickr         | Use to create a minimum or maximum date.                                                                                               |
| mask        | **true** | String         |                | Mask                  | Use to create masks for your components to have a friendly UX.                                                                         |
| masked      | false    | Bool           | FALSE          | Mask, Money           | Use if you want the component return to come with the mask.                                                                            |
| percentage  | false    |                | FALSE          | Money                 | Use if you want to use percentage in the component.                                                                                    |
| data        | false    | Array          |                | Selected              | Use to populate the selected component.                                                                                                |
| key         | false    | String         |                | Selected              | Use to tell the key to be returned when selecting an option.                                                                           |
| label       | false    | String, Array  |                | Selected              | Use to enter the title to be displayed in the option.                                                                                  |
| options     | **true** |                |                | Selected              | Function for complete creation of the selected component. See the Example below for more details.                                      |
| typeInput   | false    | String         | FALSE          | Selected              | If you want a more advanced select, used in cases where the component has many options. You only get 2 "search" or "helper" options.   |
| on          | false    |                | FALSE          | CheckSwitch           | Set switch value to TRUE.                                                                                                              |

- [checkbox](#checkbox)
- [date](#date)
- [date-flatpickr](#date-flatpickr)
- [default](#default)
- [editor](#editor)
- [mask](#mask)
- [money](#money)
- [radio](#radio)
- [selected](#selected)
- [selected-helper](#selected-helper)
- [selected-search](#selected-search)
- [switch](#switch)
- [textarea](#textarea)

#### ``checkbox``

``` php
$form = new \Z1lab\Form\Models\Form;

$name = new \Z1lab\Form\Models\Inputs\Checkbox;

$input->name('test')->col('col-md-4')->checkboxs([
    [
        'label' => 'test1',
        'value' => TRUE
    ], [
        'label' => 'test2',
        'value' => FALSE
    ]
]);

$form->action(route('post'));
$form->header('Test', 'Description');
$form->callback(route('home'));

$form->create($input);

return $form->return();
```

#### ``date``

This component uses [vue-the-mask](https://vuejs-tips.github.io/vue-the-mask/) for its construction, if you want to modify the display exhibition see your doc.

``` php
$form = new \Z1lab\Form\Models\Form;

$name = new \Z1lab\Form\Models\Inputs\Date;

$input->name('test')->col('col-md-4')->exhibition('##/##/####')->format('YYYY-MM-DD', 'YYYY-MM-DD', 'DD/MM/YYYY');

$form->action(route('post'));
$form->header('Test', 'Description');
$form->callback(route('home'));

$form->create($input);

return $form->return();
```

#### ``date-flatpickr``

This component uses the [flatpickr](https://flatpickr.js.org/) package for its construction, if you want to create any modification see your doc.

``` php
$form = new \Z1lab\Form\Models\Form;

$name = new \Z1lab\Form\Models\Inputs\DateFlatpickr;

$input->name('test')->col('col-md-4')->validate('required|today')->value('2019-12-20 12:30:50')->format('Y-m-d H:i:S')->time()->time_24hr()->alt_input()->range('today');

$form->action(route('post'));
$form->header('Test', 'Description');
$form->callback(route('home'));

$form->create($input);

return $form->return();
```

#### ``default``

``` php
$form = new \Z1lab\Form\Models\Form;

$name = new \Z1lab\Form\Models\Inputs\Text;

$input->name('test')->col('col-md-4');

$form->action(route('post'));
$form->header('Test', 'Description');
$form->callback(route('home'));

$form->create($input);

return $form->return();
```

#### ``editor``

This component uses the [Vue2Editor](https://www.vue2editor.com/examples/) package for its construction, if you want to create any modification see your doc.

``` php
$form = new \Z1lab\Form\Models\Form;

$name = new \Z1lab\Form\Models\Inputs\Editor;

$input->name('test')->col('col-md-4');

$form->action(route('post'));
$form->header('Test', 'Description');
$form->callback(route('home'));

$form->create($input);

return $form->return();
```

#### ``mask``

This component uses [vue-the-mask](https://vuejs-tips.github.io/vue-the-mask/) for its construction, if you want to modify the display exhibition see your doc.

``` php
$form = new \Z1lab\Form\Models\Form;

$name = new \Z1lab\Form\Models\Inputs\Mask;

$input->name('phone')->col('col-md-12')->mask('(##) ####-####')->mask('(##) #####-####');

$form->action(route('post'));
$form->header('Test', 'Description');
$form->callback(route('home'));

$form->create($input);

return $form->return();
```

#### ``money``

This component uses [v-money](https://github.com/vuejs-tips/v-money) for its construction, if you want to modify the display exhibition see your doc.

``` php
$form = new \Z1lab\Form\Models\Form;

$name = new \Z1lab\Form\Models\Inputs\Mask;

$input->name('money')->col('col-md-12');

$form->action(route('post'));
$form->header('Test', 'Description');
$form->callback(route('home'));

$form->create($input);

return $form->return();
```

#### ``radio``

``` php
$form = new \Z1lab\Form\Models\Form;

$name = new \Z1lab\Form\Models\Inputs\Mask;

$input->name('test')->col('col-md-4')->radios([
    [
        'label' => 'test1',
        'value' => 'test-one'
    ], [
        'label' => 'test2',
        'value' => 'test-two'
    ]
]);

$form->action(route('post'));
$form->header('Test', 'Description');
$form->callback(route('home'));

$form->create($input);

return $form->return();
```

#### ``selected``

``` php
$form = new \Z1lab\Form\Models\Form;

$name = new \Z1lab\Form\Models\Inputs\Selected;

$input->name('test')->col('col-md-4')->options([['id' => '1', 'name' => 'Test 1' ], ['id' => '2', 'name' => 'Test 2' ]], 'name', 'id');

// or

$input->name('test')->col('col-md-4')->options(['Option 1', 'Option 2', 'Option 3']);

// or 

$input->name('test')->col('col-md-4')->data([['id' => '1', 'name' => 'Test 1' ], ['id' => '2', 'name' => 'Test 2' ]])->label('name')->key('id');

// or

$input->name('test')->col('col-md-4')->data(['Option 1', 'Option 2', 'Option 3']);

$form->action(route('post'));
$form->header('Test', 'Description');
$form->callback(route('home'));

$form->create($input);

return $form->return();
```

#### ``selected-helper``

``` php
$form = new \Z1lab\Form\Models\Form;

$name = new \Z1lab\Form\Models\Inputs\Selected;

$input->name('test')->col('col-md-4')->options([['id' => '1', 'name' => 'Test 1' ], ['id' => '2', 'name' => 'Test 2' ]], 'name', 'id')->typeInput('helper');

$form->action(route('post'));
$form->header('Test', 'Description');
$form->callback(route('home'));

$form->create($input);

return $form->return();
```

#### ``selected-search``

``` php
$form = new \Z1lab\Form\Models\Form;

$name = new \Z1lab\Form\Models\Inputs\Selected;

$input->name('test')->col('col-md-4')->options([['id' => '1', 'name' => 'Test 1' ], ['id' => '2', 'name' => 'Test 2' ]], 'name', 'id')->typeInput('search');

$form->action(route('post'));
$form->header('Test', 'Description');
$form->callback(route('home'));

$form->create($input);

return $form->return();
```

#### ``switch``

``` php
$form = new \Z1lab\Form\Models\Form;

$name = new \Z1lab\Form\Models\Inputs\CheckSwitch;

$input->name('test')->col('col-md-4')->description('Test 1');

$form->action(route('post'));
$form->header('Test', 'Description');
$form->callback(route('home'));

$form->create($input);

return $form->return();
```

#### ``textarea``

``` php
$form = new \Z1lab\Form\Models\Form;

$name = new \Z1lab\Form\Models\Inputs\TextArea;

 $input->name('test')->col('col-md-4');

$form->action(route('post'));
$form->header('Test', 'Description');
$form->callback(route('home'));

$form->create($input);

return $form->return();
```
