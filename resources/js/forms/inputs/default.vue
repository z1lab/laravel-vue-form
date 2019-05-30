<template>
    <input class="form-control" :name="data.name" :type="data.type || 'text'" :id="data.name" :placeholder="data.placeholder || ''"
           v-validate="validate" :data-vv-as="data.label" v-model="data.value"/>
</template>

<script>
    export default {
        name: "default-input",
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
