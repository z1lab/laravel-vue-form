<template>
    <the-mask class="form-control"  :type="data.type || 'text'" :id="data.name" :name="data.name" :placeholder="data.placeholder || ''"
              v-validate="validate" :data-vv-as="data.label" :mask="cleanMask(data.mask)" v-model="data.value" :masked="data.masked || false"
    />
</template>

<script>
    import {TheMask} from 'vue-the-mask'

    export default {
        name: "mask-input",
        inject: ['$validator'],
        components: {
            TheMask
        },
        props: {
            data: {
                required: true,
                type: [Array, String, Object]
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
