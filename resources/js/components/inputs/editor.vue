<template>
    <div>
        <vue-editor :id="data.name" :name="data.name" v-model="data.value" :data-vv-as="data.label" v-validate="validate"></vue-editor>
    </div>
</template>

<script>
    import {VueEditor} from 'vue2-editor'

    export default {
        name: "editor-input",
        inject: ['$validator'],
        components: {
            VueEditor
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
            },
        }
    }
</script>
