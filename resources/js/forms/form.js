import Vue from 'vue'

import FormVue from './forms-vue.vue'
import store from './store/store'

/* Ziggy */
Vue.mixin({
    methods: {
        route: route
    }
});

/* Validate */
import VeeValidate from 'vee-validate'
Vue.use(VeeValidate, { inject: false })

require('./vendor/validator')

new Vue({
    name: 'vue-form',
    el: '#vue-form',
    data: () => ({
        url: '',
        apiToken: '',
        buttonSubmit: ''
    }),
    render(h) {
        this.url = this.$el.dataset.url ? this.$el.dataset.url : this.url
        this.apiToken = this.$el.dataset.apiToken ? this.$el.dataset.apiToken : this.apiToken
        this.buttonSubmit = this.$el.dataset.buttonSubmit ? this.$el.dataset.buttonSubmit : this.buttonSubmit

        return h(FormVue, {
            props: {
                url: this.url,
                apiToken: this.apiToken,
                buttonSubmit: this.buttonSubmit
            }
        })
    },
    store
});
