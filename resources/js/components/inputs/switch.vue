<template>
    <div class="custom-control custom-checkbox form-custom">
        <input type="checkbox" data-switch="bool" :id="data.name" :name="data.name" v-model="data.value">
        <label :for="data.name" data-on-label="Sim" data-off-label="Não"></label>
    </div>
</template>

<script>
    export default {
        name: "switch-input",
        inject: ['$validator'],
        props: {
            data: {
                required: true,
                type: [Array, String, Object]
            }
        }
    }
</script>
