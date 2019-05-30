<template>
    <fieldset class="margin-fieldset my-2">
        <legend class="h5 header-title" v-if="data.legend">{{ data.legend }}</legend>
        <p v-if="data.subtitle">{{ data.subtitle }}</p>

        <div class="row">
            <div :class="data.config.col">
                <div class="form-group" :class="errors.has('address[postal_code]') ? 'u-has-error' : ''">
                    <label for="postal_code" class="col-form-label">
                        {{ postalCode.label }} <span class="text-danger">*</span>
                    </label>

                    <the-mask class="form-control" type="text" id="postal_code" name="address[postal_code]" :placeholder="data.config.mask"
                              :class="errors.has('address[postal_code]') ? 'is-invalid' : ''" :mask="data.config.mask" v-model="code"
                              v-validate="validate" :data-vv-as="postalCode.label"/>

                    <div v-show="errors.has('address[postal_code]')" class="invalid-feedback" style="display: block">
                        {{ errors.first('address[postal_code]') }}
                    </div>
                </div>
            </div>

            <input-component :key="`input-component-${key}`" :data="input" v-for="(input, key) in data.data" v-if="data.data[key].key !== 'postal_code'"/>
        </div>
    </fieldset>
</template>

<script>
    import {mapActions} from 'vuex'
    import {TheMask} from 'vue-the-mask'
    import {getCEP} from "../vendor/api";
    import {exceptionError} from "../vendor/common";

    import InputComponent from './input'

    export default {
        name: "postal-code-component",
        inject: ['$validator'],
        components: {
            TheMask,
            InputComponent
        },
        data: () => ({
            postalCode: {},
            code: '',
            comparation: ''
        }),
        props: {
            data: {
                required: true,
                type: [Array, Object]
            }
        },
        watch: {
            async code(value) {
                this.completeAddress = false

                if (value.length === 8) {
                    this.changeLoadVueForm(true)
                    let cep = {}

                    await getCEP(value).then(
                        response => {
                            if (_.isUndefined(response.data.erro)) {
                                _.find(this.data.data, ['key', 'postal_code']).value = value
                                cep = response.data
                            } else {
                                exceptionError({error: {response: {data: {message: 'O Código Postal não foi encontrado ou não existe!'}}}})
                            }
                        }
                    ).catch(error => exceptionError(error)).finally(() => this.changeLoadVueForm(false))

                    let state    = _.find(this.data.data, ['key', 'state'])
                    let district = _.find(this.data.data, ['key', 'district'])
                    let city     = _.find(this.data.data, ['key', 'city'])
                    let street   = _.find(this.data.data, ['key', 'street'])

                    if (state)    state.value    = this.comparation === this.code ? state.value : cep.uf || ''
                    if (district) district.value = this.comparation === this.code ? district.value : cep.bairro || ''
                    if (city)     city.value     = this.comparation === this.code ? city.localidade : cep.localidade || ''
                    if (street)   street.value   = this.comparation === this.code ? street.logradouro : cep.logradouro || ''
                }
            }
        },
        computed: {
            validate() {
                if (typeof this.data.config.validate === "string") {
                    return this.data.config.validate
                } else if (this.data.config.validate === undefined) {
                    return ''
                } else {
                    return 'required'
                }
            }
        },
        methods: {
            ...mapActions(['changeLoadVueForm']),
        },
        mounted() {
            this.postalCode = _.find(this.data.data, ['key', 'postal_code'])

            this.code = this.postalCode.value
            this.comparation = this.postalCode.value
        }
    }
</script>
