<template>
    <input class="form-control" :name="data.name" :id="data.name" v-validate="validate" :data-vv-as="data.label" v-model.lazy="data.value"/>
</template>

<script>
    import flatpickr from "flatpickr"

    require('flatpickr/dist/flatpickr.min.css');

    const Portuguese = require("flatpickr/dist/l10n/pt.js").default.pt;
    flatpickr.localize(Portuguese);

    export default {
        name: "date-input",
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
        },
        updated() {
            flatpickr(`#${this.data.name}`, {
                minDate: this.data.min_date ? this.data.min_date : '',
                maxDate: this.data.max_date ? this.data.max_date : '',
                time_24hr: this.data.time_24hr || true,
                altInput: this.data.altInput || true,
                defaultDate: this.data.value,
                enableTime: this.data.time || false,
                dateFormat: this.data.format || 'Y-m-d'
            });
        }
    }
</script>

