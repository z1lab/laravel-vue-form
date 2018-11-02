<template>
    <div class="card">
        <div class="card-header form-custom" v-if="header">
            <h4 class="header-title">
                {{ config.header.title }}
            </h4>
            <p class="text-muted font-13">
                {{ config.header.information }}
            </p>
        </div>
        <div class="card-body">
            <form id="form-submit" class="needs-validation" method="post">
                <div class="row" v-if="field_set">
                    <div class="col-md-12">
                        <fieldset class="margin-fieldset" v-for="group in form">
                            <legend class="h3 header-title">{{ group.legend }}</legend>

                            <div class="row">
                                <div class="form-group" v-for="input in group.inputs" :class="input.col || 'col-md-12'">
                                    <label :for="input.name" class="col-form-label"> {{ input.label }} </label>

                                    <component :is="input.type_input || 'input-default'" :data="input"
                                               :class="errors.has(input.name) ? 'is-invalid' : ''"
                                               :key="input.name" @uploads="setUploads(input.name)"></component>

                                    <div v-show="errors.has(input.name)" class="invalid-feedback"
                                         style="display: block!important;">
                                        {{ errors.first(input.name) }}
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>

                <div class="row" v-else>
                    <div class="form-group" v-for="input in form" :class="input.col || 'col-md-12'"
                         v-if="condition(input, form)">
                        <label :for="input.name" class="col-form-label"> {{ input.label }} </label>

                        <component :is="input.type_input || 'input-default'" :data="input"
                                   :class="errors.has(input.name) ? 'is-invalid' : ''"
                                   :key="input.name" @uploads="setUploads(input.name)"></component>

                        <div v-show="errors.has(input.name)" class="invalid-feedback" style="display: block">
                            {{ errors.first(input.name) }}
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer form-custom">
            <button type="button" class="btn btn-primary" @click="submitForm">Salvar</button>
            <a :href="config.url_return" class="btn btn-outline-secondary">Voltar</a>
        </div>
    </div>
</template>

<script>
    import InputMask from './components/inputs/mask'
    import InputDefault from './components/inputs/default'
    import InputSelected from './components/inputs/selected'
    import InputEditor from './components/inputs/editor'
    import InputMoney from './components/inputs/money'
    import InputSwitch from './components/inputs/switch'
    import InputDate from './components/inputs/date'
    import InputUpload from './components/inputs/upload'
    import InputCheckbox from './components/inputs/checkbox'
    import InputRadio from './components/inputs/radio'
    import InputSelectedSearch from './components/inputs/selected-search'
    import InputSelectedHelper from './components/inputs/selected-helper'
    import InputTextarea from './components/inputs/textarea'

    export default {
        name: "forms-vue",
        $_veeValidate: {
            validator: 'new'
        },
        components: {
            InputMask,
            InputDefault,
            InputSelected,
            InputEditor,
            InputMoney,
            InputCheckbox,
            InputDate,
            InputUpload,
            InputSwitch,
            InputRadio,
            InputSelectedSearch,
            InputSelectedHelper,
            InputTextarea
        },
        data: () => ({
            config: {},
            form: {},
            varUploads: [],
            count: 0
        }),
        props: {
            data: {
                require: true,
                type: String
            }
        },
        computed: {
            header: function () {
                return this.config.header || false
            },
            field_set: function () {
                return this.config.field_set || false
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
            setInputGroup(input) {
                return JSON.parse(input)
            },
            setUploads(name) {
                this.varUploads[this.count] = name

                this.count++
            },
            cleanMask(value) {
                return _.isArray(value) ? collect(value).values().all() : value
            },
            submitForm() {
                this.$validator.validateAll().then(
                    res => {
                        if (res) {
                            let data = [],
                                inputs = [],
                                group = this.config.field_set || false,
                                form = collect(this.form)

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

                            let dataForm = new FormData(),
                                headers = {}

                            if (this.varUploads.length > 0) {
                                headers = {
                                    'Content-Type': 'multipart/form-data'
                                }

                                for (let key in data) {
                                    let condition = _.find(this.varUploads, function(o) { return o === key })

                                    if (_.isUndefined(condition)) {
                                        if (_.isObject(data[key])){
                                            dataForm.set(key, data[key])
                                        } else {
                                            dataForm.set(key, data[key])
                                        }
                                    } else {
                                        let attachments = data[key]

                                        for (let i = 0; i < attachments.length; i++) {
                                            dataForm.append(`${key}[]`, attachments[i]);
                                        }
                                    }

                                    if (key === 'attachments') {

                                    } else {
                                        dataForm.set(key, data[key])
                                    }
                                }
                            } else {
                                for (let key in data) {
                                    if (_.isObject(data[key])) {
                                        dataForm.set(key, data[key])
                                    } else {
                                        dataForm.set(key, data[key])
                                    }
                                }
                            }

                            dataForm.set('_method', this.config.method)

                            this.$emit('submitForm', this.config.url_submit, this.config.callback, dataForm, headers)
                        }
                    }
                )
            }
        },
        mounted() {
            let data = JSON.parse(this.data)

            this.form = data.form
            this.config = data.config
        }
    }
</script>
