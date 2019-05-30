<template>
    <loading :active.sync="isLoading" :is-full-page="isFullPage" :loader="loader" :color="color"></loading>
</template>

<style>
    .vld-overlay {
        z-index: 99 !important;
    }
</style>

<script>
    import Loading from 'vue-loading-overlay';

    import 'vue-loading-overlay/dist/vue-loading.css';

    export default {
        name: "LoadingVue",
        components: {
            Loading
        },
        props: {
            isLoading: {
                type: Boolean,
                default: true
            },
            color: {
                type: String,
                default: '#377dff'
            },
            loader: {
                type: String,
                default: 'spinner'
            },
            isFullPage: {
                type: Boolean,
                default: false
            }
        }
    }
</script>
