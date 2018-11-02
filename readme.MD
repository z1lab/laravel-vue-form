## Introduction

Laravel Vue Form is a package developed for make agile forms using Json:API response and VueJS components

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

### Example

``` php
$form = new \Z1lab\Form\Models\Form;
$form->action('resource/to/send/form');

$name = new \Z1lab\Form\Models\Inputs\Text;
$name->value('Name');
$name->name('name');

$form->create($name);

return new \Z1lab\Form\Builder($form)->toJson();
```