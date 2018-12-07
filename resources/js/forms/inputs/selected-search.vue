<template>
    <div :class="class_show">
        <input type="text" style="display: none" v-model="data.value" :id="data.name" data-toggle="dropdown" :name="data.name" v-validate="validate" :data-vv-as="data.label"/>

        <input class="form-control dropdown-toggle" v-model="input_search" data-toggle="dropdown" :class="errors.has(data.name) ? 'is-invalid' : ''"/>

        <div class="dropdown-menu" style="width: 100%;" :class="class_show">
            <span class="dropdown-item">{{infoSearch}}</span>
            <span class="dropdown-item" v-for="option in options" @click="setValue(option)">{{ label(option, data.options.label) }}</span>
        </div>
    </div>
</template>

<script>
    export default {
        name: "selected-search-input",
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
            },
            infoSearch(){
                return _.isEmpty(this.options) ? 'Busque uma opção válida' : 'Selecione uma das opções'
            }
        },
        props: {
            data: {
                required: true,
                type: [Array, String, Object]
            }
        },
        data: () => ({
            input_search: '',
            input_base: '',
            options: [],
            class_show: ''
        }),
        watch: {
            input_search(item) {
                if (item !== this.input_base){
                    this.data.value = ''
                    this.class_show = ''
                }

                let collection = collect(this.data.options.data)

                this.class_show = 'show'

                this.options = collection.filter((value, key) => value.name.search(new RegExp(item, "i")) !== -1).all()
            }
        },
        methods: {
            setValue(value) {
                this.input_search = this.label(value, this.data.options.label)
                this.input_base = this.label(value, this.data.options.label)
                this.data.value = this.data.options.value ? value[this.data.options.value] : value
            },
            label(option, item) {
                let concat = ''

                if (_.isObject(item)) {
                    for (let key in item) {
                        if (option[item[key]]) {
                            concat += option[item[key]]
                        } else {
                            concat += item[key]
                        }
                    }
                } else {
                    concat = item ? option[item] : option
                }

                return concat
            }
        }
    }
</script>
