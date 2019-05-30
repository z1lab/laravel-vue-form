<template>
    <div class="card">
        <loading :is-loading="isLoading" />

        <div class="card-header form-custom" v-if="!isEmpty(data.attributes.header)">
            <h4 class="header-title">
                {{ data.attributes.header.title }}
            </h4>
            <p class="text-muted font-13">
                {{ data.attributes.header.subtitle }}
            </p>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <component :is="form.component" :id="`component-${key}`" :key="`component-${key}`" :data="formatData(form)" v-for="(form, key) in data.attributes.form" />
                </div>
            </div>
        </div>
        <div class="card-footer form-custom text-right">
            <a :href="data.links.callback" class="btn btn-secondary" v-if="data.links.callback">Voltar</a>
            <slot name="header" v-else />
            <button type="button" class="btn btn-primary" @click="submitForm">{{buttonSubmit || 'Salvar'}}</button>
        </div>
    </div>
</template>

<script>
    import {toSeek, exceptionError, submitFormVue, sendAlert} from "./vendor/common"
    import {mapActions, mapState} from 'vuex'

    import Loading from './components/loading'
    import FieldsetComponent from './components/fieldset'
    import PostalCodeComponent from './components/postal-code'
    import InputComponent from './components/input'

    export default {
        name: "forms-vue",
        $_veeValidate: {
            validator: 'new'
        },
        components: {
            Loading,
            InputComponent,
            FieldsetComponent,
            PostalCodeComponent
        },
        props: {
            buttonSubmit: {
                type: String,
                default: 'Salvar'
            },
            apiToken: {
                type: String
            },
            url: {
                require: true,
                type: String
            }
        },
        data:() => ({
            header: {}
        }),
        computed: {
            ...mapState({
                isLoading: state => state.loadVueForm,
                data: state => state.data
            }),
        },
        methods: {
            ...mapActions(['changeLoadVueForm', 'changeData']),
            isEmpty(value) {
                return _.isEmpty(value)
            },
            formatData(data) {
                return data.component === 'input-component' ? data.data : data
            },
            submitForm() {
                this.$validator.validateAll().then(
                    res => {
                        if (res) {
                            let dataForm = new FormData()

                            for(let index of this.data.attributes.form) {
                                if (index.data.length) {
                                    for (let subIndex of index.data) {
                                        dataForm.set(subIndex.name, subIndex.value)
                                    }
                                } else {
                                    dataForm.set(index.data.name, index.data.value)
                                }
                            }

                            this.changeLoadVueForm(true)

                            submitFormVue(this.data.links.action, dataForm, this.header).then(
                                response => {
                                    sendAlert({
                                        title: 'Tudo Certo!',
                                        message: 'Requisição relizada com sucesso!',
                                        type: 'success'
                                    })

                                    if (this.data.links.callback)  window.location.href = this.data.links.callback || this.data.links.self

                                    this.changeLoadVueForm(false)
                                }
                            ).catch(
                                error => {
                                    this.changeLoadVueForm(false)
                                    exceptionError(error)
                                }
                            )
                        }
                    }
                )
            }
        },
        mounted() {
            if (this.apiToken) {
                this.header = {Authorization: `Bearer ${this.apiToken}`, Accept: 'application/json'}
            }

            toSeek(this.url, this.header).then(
                response => {
                    if (response.data.attributes.api_token) {
                        this.header = {Authorization: `Bearer ${response.data.attributes.api_token}`, Accept: 'application/json'}
                    }

                    this.changeData(response.data)
                    this.changeLoadVueForm(false)
                }
            ).catch(error => {
                exceptionError(error)
                this.changeLoadVueForm(false)
            })
        }
    }
</script>
