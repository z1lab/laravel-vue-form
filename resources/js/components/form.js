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
    },
    methods: {
        test(url, callback, data, headers) {
            Pace.restart()

            Pace.track(() => {
                HTTP({
                    method: 'POST',
                    url: url,
                    data: data,
                    headers: headers
                }).then(
                    response => {
                        swal({
                            type: 'success',
                            title: 'Tudo certo',
                            text: 'Participante encontrado com sucesso!',
                            timer: 2000
                        }).then((result) => {
                            window.location.href = callback || window.location.reload()
                        })
                    }
                ).catch(
                    error => {
                        let data = error.response.data || error

                        swal({
                            type: 'error',
                            title: 'Oops...',
                            text: _.isUndefined(data.errors) ? data.message : JSON.stringify(data.errors)
                        })
                    }
                )
            })
        }
    }
});
