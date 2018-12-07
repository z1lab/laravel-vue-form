import Vue from 'vue'
import {submitFormVue} from "../vendor/common";

/* Validate */
import VeeValidate from 'vee-validate'
Vue.use(VeeValidate, { inject: false })

require('../vendor/validator')

/* Components */
import FormVue from './forms-vue'
import LoadingComponent from '../components/loadingComponent'

new Vue({
    name: 'vue-form',
    el: '#vue-form',
    components: {
        FormVue,
        LoadingComponent
    },
    data: () => ({
        isLoading: false
    }),
    methods: {
        submitForm(dataForm, action, callback = null) {
            Pace.start()
            this.isLoading = true

            submitFormVue(action, dataForm).then(
                response => {
                    window.location.href = callback || response.data.data.links.self
                }
            ).catch(
                error => {
                    Pace.stop()
                    this.isLoading = false

                    console.dir(error)
                }
            )
        },
    }
});
