<template>
    <select class="form-control"  :id="data.name" v-model="data.value" :name="data.name" v-validate="validate" :data-vv-as="data.label">
        <option value="">Selecione uma das Opções</option>

        <option v-for="option in options" :value="data.options.key ? option[data.options.key] : option">
            {{ label(option, data.options.label) }}
        </option>
    </select>
</template>

<script>
    export default {
        name: "selected-input",
        inject: ['$validator'],
        computed: {
            validate() {
                if (typeof this.data.validate === "string") {
                    return this.data.validate
                } else if (this.data.validate === undefined) {
                    return ''
                } else {
                    return 'required'
                }
            },
            options() {
                return this.data.options.data || this.data.options
            }
        },
        props: {
            data: {
                required: true,
                type: [Array, String, Object]
            }
        },
        methods: {
            label(option, item) {
                let concat = ''

                if (_.isObject(item)) {
                    for (let key in item) {
                        if (option[item[key]]) {
                            concat += option[item[key]]
                        } else {
                            concat += item[key]
                        }
                    }
                } else {
                    concat = item ? option[item] : option
                }

                return concat
            }
        }
    }
</script>
