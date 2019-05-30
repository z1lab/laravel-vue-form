export default {
    changeLoadVueForm(context, payload) {
        context.commit('CHANGE_LOAD_VUE_FORM', payload)
    },
    changeData(context, payload) {
        context.commit('CHANGE_DATA', payload)
    }
}
