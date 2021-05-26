import Vue from 'vue'
import Toast from '../../plugins/toast'


const state = {
    smses: [],
    smsDialog: false,
}

const getters = {
    getSmses(state) {
        return state.smses;
    },

    getSmsDialog(state) {
        return state.smsDialog;
    }
}

const mutations = {
    setSmses(state, smses) {
        state.smses = smses
    },

    closeDialog(state, dialog) {
        state.smsDialog = dialog
    }
}

const actions = {
    async getSmsesAction({ commit }) {
        Vue.prototype.$Progress.start()
        try {
            const response = await axios.get('/api/smses')
            commit('setSmses', response.data)
            Vue.prototype.$Progress.finish()

        } catch (error) {
            Vue.prototype.$Progress.fail()
            Toast.fire({
                icon: 'error',
                title: error.message
            })
        }
    },

    async sendSMSAction({ commit }, data) {
        commit('closeDialog', false)
        Vue.prototype.$Progress.start()
        try {
            const response = await axios.post('/api/sms/send', data)
            if (response.data.status) {
                Toast.fire({
                    icon: 'success',
                    title: response.data.message
                })

                commit('closeDialog', true)
            } else {
                Toast.fire({
                    icon: 'error',
                    title: response.data.message
                })
            }
            Vue.prototype.$Progress.finish()
        } catch (error) {
            Vue.prototype.$Progress.fail()
            Toast.fire({
                icon: 'error',
                title: error.message
            })
        }

    },

    async deleteSMSAction({ commit, dispatch }, id) {
        Vue.prototype.$Progress.start()
        try {
            const response = await axios.delete(`/api/sms/delete/${id}`)
            dispatch('getSmsesAction')
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