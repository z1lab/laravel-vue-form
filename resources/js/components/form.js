import Vue from 'vue'

/* Validate */
import VeeValidate from 'vee-validate'
Vue.use(VeeValidate, { inject: false })

require('../vendor/validator')

/* Components */
import FormVue from './forms-vue'

new Vue({
    name: 'vue-form',
    el: '#vue-form',
    components: {
        FormVue
    }
});
