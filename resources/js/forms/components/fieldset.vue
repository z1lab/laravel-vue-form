<template>
    <fieldset class="margin-fieldset my-2">
        <legend class="h5 header-title" v-if="data.legend">{{ data.legend }}</legend>
        <p v-if="data.subtitle">{{ data.subtitle }}</p>

        <div class="row">
            <input-component :key="`input-component-${key}`" :data="input" v-for="(input, key) in data.data"/>
        </div>
    </fieldset>
</template>

<script>
    import InputComponent from './input'

    export default {
        name: "fieldset-component",
        components: {
            InputComponent
        },
        props: {
            data: {
                required: true,
                type: [Array, Object]
            }
        }
    }
</script>
