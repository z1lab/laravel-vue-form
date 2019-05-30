<template>
    <div :class="data.col || 'col-md-12'">
        <input :type="data.type" :name="data.name" :value="data.value" v-if="data.type === 'hidden'">

        <div class="form-group" v-else-if="data.disabled">
            <label class="col-form-label" v-if="data.label"> {{ data.label }} </label>

            <input class="form-control u-form__input disabled form-control-plaintext" type="text" :value="data.value" disabled :readonly="data.readonly">
        </div>

        <div class="form-group" :class="errors.has(data.name) ? 'u-has-error' : ''" v-else>
            <label :for="data.name" class="col-form-label" v-if="data.label">
                {{ data.label }} <span class="text-danger" v-if="data.required || false">*</span>
            </label>

            <component :is="data.type_input || 'input-default'" :data="data" :class="errors.has(data.name) ? 'is-invalid' : ''" :id="data.name" :key="data.name" />

            <div v-show="errors.has(data.name)" class="invalid-feedback" style="display: block">
                {{ errors.first(data.name) }}
            </div>
        </div>
    </div>
</template>

<script>
    import InputMask from '../inputs/mask'
    import InputDefault from '../inputs/default'
    import InputSelected from '../inputs/selected'
    import InputEditor from '../inputs/editor'
    import InputMoney from '../inputs/money'
    import InputSwitch from '../inputs/switch'
    import InputDate from '../inputs/date'
    import InputDateFlatpickr from '../inputs/date-flatpickr'
    import InputCheckbox from '../inputs/checkbox'
    import InputRadio from '../inputs/radio'
    import InputSelectedSearch from '../inputs/selected-search'
    import InputSelectedHelper from '../inputs/selected-helper'
    import InputTextarea from '../inputs/textarea'

    export default {
        name: "input-component",
        inject: ['$validator'],
        components: {
            InputMask,
            InputDefault,
            InputSelected,
            InputEditor,
            InputMoney,
            InputCheckbox,
            InputDate,
            InputDateFlatpickr,
            InputSwitch,
            InputRadio,
            InputSelectedSearch,
            InputSelectedHelper,
            InputTextarea
        },
        props: {
            data: {
                required: true,
                type: [Array, Object]
            }
        },
        methods: {
            condition(input, form) {
                if (_.isString(input.condition)) {
                    let index = searchIndex(input.condition, form)

                    return _.isBoolean(form[index].value) ? form[index].value : false
                } else if (_.isArray(input.condition) || _.isObject(input.condition)) {
                    let index = searchIndex(input.condition.name, form)

                    if (input.condition.cascade && form[index].condition) {
                        let result = true

                        if (_.isString(form[index].condition)) {
                            let sub_index = searchIndex(form[index].condition, form)

                            result = _.isBoolean(form[sub_index].value) ? form[sub_index].value : false
                        } else if (_.isArray(form[index].condition) || _.isObject(form[index].condition)) {
                            let sub_index = searchIndex(form[index].condition.name, form)

                            result = form[sub_index].value === '' ? form[index].condition.default || false : form[sub_index].value === form[index].condition.value
                        }

                        if (!result) {
                            return false
                        }
                    }

                    return form[index].value === '' ? input.condition.default || false : form[index].value === input.condition.value
                }

                function searchIndex(value, form) {
                    return _.findIndex(form, function (o) {
                        return o.name === value;
                    })
                }

                return true
            },
        }
    }
</script>
