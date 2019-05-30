<template>
    <div class="mt-3" style="margin-top: 0 !important;">
        <div class="custom-control custom-radio"  v-for="(radio, key) in data.radios">
            <input type="radio" :id="`radio-${data.name}-${key}`" :name="data.name" class="custom-control-input" :value="radio.value" v-model="data.value"
                   :data-vv-as="data.label" v-validate="validate" v-if="key === 0">
            <input type="radio" :id="`radio-${data.name}-${key}`" class="custom-control-input" :value="radio.value" v-model="data.value" v-else>
            <label class="custom-control-label" :for="`radio-${data.name}-${key}`">{{radio.label}}</label>
        </div>
    </div>
</template>

<script>
    export default {
        name: "radio-input",
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

