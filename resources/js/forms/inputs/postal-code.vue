<template>
    <the-mask class="form-control"  :type="data.type || 'text'" :id="data.name" :name="data.name" :placeholder="data.placeholder || ''"
              v-validate="validate" :data-vv-as="data.label" :mask="cleanMask(data.mask)" v-model="code"
    ></the-mask>
</template>

<script>
    import {TheMask} from 'vue-the-mask'
    import {getCEP} from "../../vendor/api";

    export default {
        name: "postal-code-input",
        inject: ['$validator'],
        data: () => ({
            code: '',
            completeAddress: false,
            street: '',
            district: '',
            state: '',
            city: '',
            ibge_id: ''
        }),
        components: {
            TheMask
        },
        props: {
            data: {
                required: true,
                type: [Array, String, Object]
            },
            block: {
                type: [Array, String, Object]
            }
        },
        watch: {
            async code(value) {
                this.completeAddress = false

                if (value.length === 8) {
                    Pace.start()
                    this.$emit('load', true)

                    await getCEP(value).then(
                        response => {
                            if (_.isUndefined(response.data.erro)) {
                                let cep = response.data

                                this.completeAddress = true

                                this.state = cep.uf
                                this.district = cep.bairro
                                this.city = cep.localidade
                                this.street = cep.logradouro
                                this.ibge_id = cep.ibge
                            }
                        }
                    ).catch(
                        error => this.completeAddress = false
                    ).finally(
                        () => {
                            Pace.stop()
                            this.$emit('load', false)
                        }
                    )
                }
            },
            completeAddress(check) {
                if (check) {
                     _.find(this.block, function(o) { return o.name === 'address[state]'; }).value = this.state;
                     _.find(this.block, function(o) { return o.name === 'address[district]'; }).value = this.district;
                     _.find(this.block, function(o) { return o.name === 'address[city]'; }).value = this.city;
                     _.find(this.block, function(o) { return o.name === 'address[street]'; }).value = this.street;
                     _.find(this.block, function(o) { return o.name === 'address[ibge_id]'; }).value = this.ibge_id;

                     this.data.value = this.code
                } else {
                    _.find(this.block, function(o) { return o.name === 'address[state]'; }).value = '';
                    _.find(this.block, function(o) { return o.name === 'address[district]'; }).value = '';
                    _.find(this.block, function(o) { return o.name === 'address[city]'; }).value = '';
                    _.find(this.block, function(o) { return o.name === 'address[street]'; }).value = '';
                    _.find(this.block, function(o) { return o.name === 'address[ibge_id]'; }).value = '';
                }
            }
        },
        computed: {
            validate() {
                if (typeof this.data.validate === "string") {
                    return this.data.validate
                } else if (this.data.validate === undefined) {
                    return ''
                } else {
                    return 'required'
                }
            }
        },
        methods: {
            cleanMask(value) {
                return _.isArray(value) ? collect(value).values().all() : value
            }
        }
    }
</script>
