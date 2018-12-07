<template>
    <div class="mt-3" style="margin-top: 0 !important;">
        <div class="custom-control custom-checkbox" v-for="(checkbox, key) in data.checkboxs">
            <input type="checkbox" class="custom-control-input" :name="data.name" :id="`checkbox-${data.name}-${key}`" v-bind:value="checkbox.value" v-model="data.value"
                   :data-vv-as="data.label" v-validate="validate" v-if="key === 0">

            <input type="checkbox" class="custom-control-input" :id="`checkbox-${data.name}-${key}`" v-bind:value="checkbox.value" v-model="data.value" v-else>
            <label class="custom-control-label" :for="`checkbox-${data.name}-${key}`">{{checkbox.label}}</label>
        </div>
    </div>
</template>

<script>
    export default {
        name: "checkbox-input",
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

