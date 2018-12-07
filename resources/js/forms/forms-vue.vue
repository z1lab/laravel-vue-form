<template>
    <div class="card">
        <loading-component :is-loading="isLoading"></loading-component>

        <div class="card-header form-custom" v-if="header !== null">
            <h4 class="header-title">
                {{ header.title }}
            </h4>
            <p class="text-muted font-13">
                {{ header.subtitle }}
            </p>
        </div>
        <div class="card-body">
            <form id="form-submit" class="needs-validation" method="post">
                <div class="row" v-if="field_set">
                    <div class="col-md-12">
                        <fieldset class="margin-fieldset my-2" v-for="(group, key) in form">
                            <legend class="h3 header-title">{{ group.legend }}</legend>
                            <p>{{ group.subtitle || ''}}</p>

                            <div class="row">
                                <div v-for="input in group.inputs" :class="input.col || 'col-md-12'" v-if="condition(input, form)">
                                    <div class="form-group" v-if="input.disabled">
                                        <label class="col-form-label"> {{ input.label }} </label>

                                        <input class="form-control disabled form-control-plaintext" type="text" :value="input.value" disabled :readonly="input.readonly">
                                    </div>

                                    <div class="form-group mb-6" :class="errors.has(input.name) ? 'u-has-error' : ''" v-else>
                                        <label :for="input.name" class="col-form-label">
                                            {{ input.label }} <span class="text-danger" v-if="input.required || false">*</span>
                                        </label>

                                        <component :is="input.type_input || 'input-default'" :data="input" :block="group.inputs" @load="setLoading"
                                                   :class="errors.has(input.name) ? 'is-invalid' : ''" :id="input.name"
                                                   :key="input.name"></component>

                                        <div v-show="errors.has(input.name)" class="invalid-feedback" style="display: block!important;">
                                            {{ errors.first(input.name) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>

                <div class="row" v-else>
                    <div v-for="input in form" :class="input.col || 'col-md-12'" v-if="condition(input, form)">
                        <div class="form-group" v-if="input.disabled">
                            <label class="col-form-label"> {{ input.label }} </label>

                            <input class="form-control u-form__input disabled form-control-plaintext" type="text" :value="input.value" disabled :readonly="input.readonly">
                        </div>

                        <div class="form-group" :class="errors.has(input.name) ? 'u-has-error' : ''" v-else>
                            <label :for="input.name" class="col-form-label">
                                {{ input.label }} <span class="text-danger" v-if="input.required || false">*</span>
                            </label>

                            <component :is="input.type_input || 'input-default'" :data="input" :block="form" @load="setLoading"
                                       :class="errors.has(input.name) ? 'is-invalid' : ''" :id="input.name"
                                       :key="input.name"></component>

                            <div v-show="errors.has(input.name)" class="invalid-feedback" style="display: block">
                                {{ errors.first(input.name) }}
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer form-custom">
            <button type="button" class="btn btn-primary" @click="submitForm">Salvar</button>
            <a :href="links.return" class="btn btn-outline-secondary">Voltar</a>
        </div>
    </div>
</template>

<script>
    import LoadingComponent from '../components/loadingComponent'

    import InputMask from './inputs/mask'
    import InputDefault from './inputs/default'
    import InputSelected from './inputs/selected'
    import InputEditor from './inputs/editor'
    import InputMoney from './inputs/money'
    import InputSwitch from './inputs/switch'
    import InputDate from './inputs/date'
    import InputCheckbox from './inputs/checkbox'
    import InputRadio from './inputs/radio'
    import InputSelectedSearch from './inputs/selected-search'
    import InputSelectedHelper from './inputs/selected-helper'
    import InputTextarea from './inputs/textarea'
    import InputPostalCode from './inputs/postal-code'

    export default {
        name: "forms-vue",
        $_veeValidate: {
            validator: 'new'
        },
        components: {
            LoadingComponent,
            InputMask,
            InputDefault,
            InputSelected,
            InputEditor,
            InputMoney,
            InputCheckbox,
            InputDate,
            InputSwitch,
            InputRadio,
            InputSelectedSearch,
            InputSelectedHelper,
            InputTextarea,
            InputPostalCode
        },
        data: () => ({
            isLoading: true,
            field_set: false,
            header: {},
            links: {
                action: '',
                self: '',
                return: '',
                callback: ''
            },
            form: {},
            method: ''
        }),
        props: {
            data: {
                require: true,
                type: [String, Object, Array]
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
            submitForm() {
                this.$validator.validateAll().then(
                    res => {
                        if (res) {
                            let data = [],
                                inputs = [],
                                group = this.field_set,
                                form = collect(this.form),
                                dataForm = new FormData()

                            if (!group) {
                                data = form.pluck('value', 'name').all()
                            } else {
                                inputs = form.pluck('inputs').all()

                                _.forEach(inputs, function (value, key) {
                                    value = collect(value)

                                    let collection = value.pluck('value', 'name').all()

                                    _.forEach(collection, function (item, key) {
                                        let collection_put = collect(data)
                                        data = collection_put.put(key, item).all()
                                    })
                                })
                            }

                            for (let key in data) {
                                if (_.isObject(data[key])) {
                                    dataForm.set(key, data[key])
                                } else {
                                    dataForm.set(key, data[key])
                                }
                            }

                            dataForm.set('_method', this.method)

                            this.$emit('submit', dataForm, this.links.action, this.links.callback)
                        }
                    }
                )
            },
            setLoading(value) {
                this.isLoading = value
            }
        },
        mounted() {
            let data = {}

            if (_.isString(this.data)) {
                data = JSON.parse(this.data)
            } else {
                data = this.data
            }

            this.field_set = data.field_set || false
            this.form = data.form
            this.method = data.method || 'POST'
            this.header = data.header || null
            this.links.action = data.action || null
            this.links.self = data.self || null
            this.links.return = data.return || '/'
            this.links.callback = data.callback || null

            this.isLoading = false
        }
    }
</script>
