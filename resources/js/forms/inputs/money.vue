<template>
    <money class="form-control" :id="data.name" v-model="data.value" v-bind="types(data.porcentage)" v-validate="validate" :data-vv-as="data.label" :name="data.name" :masked="data.masked || false" />
</template>

<script>
    import {Money} from 'v-money'

    export default {
        name: "money-input",
        inject: ['$validator'],
        components: {
            Money
        },
        props: {
            data: {
                required: true,
                type: [Array, String, Object]
            },
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
        data: () => ({
            money: {
                decimal: ',',
                thousands: '.',
                prefix: 'R$ ',
                suffix: '',
                precision: 2,
                masked: false
            },
            porcentage: {
                decimal: '',
                thousands: '',
                prefix: '',
                suffix: ' %',
                precision: 0,
                masked: false
            }
        }),
        methods: {
            types(format) {
                return format ? this.porcentage : this.money
            }
        }
    }
</script>
