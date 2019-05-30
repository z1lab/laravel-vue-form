<template>
    <textarea class="form-control" :name="data.name" rows="5" v-validate="validate" :data-vv-as="data.label" v-model="data.value"></textarea>
</template>

<script>
    export default {
        name: "textarea-input",
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
