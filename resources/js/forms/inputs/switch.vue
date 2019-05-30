<template>
    <div class="custom-control custom-switch">
        <input :id="generateId" type="checkbox" class="custom-control-input" :name="data.name" v-model="data.value">
        <label :for="generateId" class="custom-control-label">{{data.description}}</label>
    </div>
</template>

<script>
    export default {
        name: "switch-input",
        inject: ['$validator'],
        computed: {
            generateId() {
                return `customSwitch-${Math.random()}`
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
