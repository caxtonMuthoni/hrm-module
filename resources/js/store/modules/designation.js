import Vue from 'vue'
import Toast from '../../plugins/toast'

const state = {
    designations: [],
    errors: [],
    closeDialog: false
}

const getters = {
    getDesignations(state) {
        return state.designations
    },

    getErrors (state) {
        return state.errors
    },

    getCloseDialog (state) {
        return state.closeDialog
    }
}

const mutations = {
    setDesignations(state, designations) {
        state.designations = designations
    },

    setErrors (state, errors) {
        state.errors = errors
    },

    setCloseDialogue(state, dialog) {
        state.closeDialog = dialog
    }
}

const actions = {
    async getDesignationsAction({ commit }) {
        Vue.prototype.$Progress.start()
        try {
            const response = await axios.get('/api/designations')
            commit('setDesignations', response.data)
            Vue.prototype.$Progress.finish()
        } catch (error) {
            Vue.prototype.$Progress.fail()
            console.log(error.message);
        }
    },

    async createDesignationsAction({ commit, dispatch }, data) {
        Vue.prototype.$Progress.start()
        try {
            const response = await axios.post('/api/designations/create', data)
            dispatch('getDesignationsAction')
            Vue.prototype.$Progress.finish()
            Toast.fire({
                icon: 'success',
                title: response.data.message
            })
            commit('setCloseDialogue', true)

        } catch (error) {
            Vue.prototype.$Progress.fail()

            if(error.response) {
                if (error.response.status === 422) {
                    commit('setErrors', error.response.data.errors )
                }
            } else {
                Toast.fire({
                    icon: 'error',
                    title: error.message
                })
            }
        }
    },

    async updateDesignationsAction({ commit, dispatch }, data) {
        Vue.prototype.$Progress.start()
        try {
            const response = await axios.put(`/api/designations/update/${data.id}`, data.data)
            dispatch('getDesignationsAction')
            Vue.prototype.$Progress.finish()

            Toast.fire({
                icon: 'success',
                title: response.data.message
            })
            commit('setCloseDialogue', true)
            
            
        } catch (error) {
            Vue.prototype.$Progress.fail()

            if(error.response) {
                if (error.response.status === 422) {
                    commit('setErrors', error.response.data.errors )
                }
            } else {
                Toast.fire({
                    icon: 'error',
                    title: error.message
                })
            }
        }
    },

    async deleteDesignationsAction({ commit, dispatch }, id) {
        Vue.prototype.$Progress.start()
        try {
            const response = await axios.delete(`/api/designations/delete/${id}`)
            dispatch('getDesignationsAction')
            Vue.prototype.$Progress.finish()
            Toast.fire({
                icon: 'success',
                title: response.data.message
            })
        } catch (error) {
            Vue.prototype.$Progress.fail()
            Toast.fire({
                icon: 'error',
                title: error.message
            })
        }
    }


}


export default {
    state,
    getters,
    mutations,
    actions
}