<template>
    <the-mask class="form-control" :name="data.name" :id="data.name" :placeholder="data.placeholder" :data-vv-as="data.label"
              :masked="true" :mask="data.mask" v-model="date" v-validate="validate">
    </the-mask>
</template>

<script>
    import moment from 'moment'

    import {TheMask} from 'vue-the-mask'

    export default {
        name: "date-input",
        inject: ['$validator'],
        components: {
            TheMask
        },
        data: function() {
            return {
                date: moment(this.data.value, this.data.format_input).format(this.data.format_exhibition)
            }
        },
        watch: {
            date(value) {
                if (value !== moment(this.data.value, this.data.format_input).format(this.data.format_exhibition)) {
                    this.data.value = moment(value, this.data.format_exhibition).format(this.data.format_output)
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
        props: {
            data: {
                required: true,
                type: [Array, String, Object]
            }
        }
    }
</script>
