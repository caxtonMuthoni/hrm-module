import Vue from 'vue'
import Toast from '../../plugins/toast'

const state = {
  salaries: [],
  salaryErrors: [],
  closeDialog: false
}

const getters = {
 getSalaries (state) {
     return state.salaries;
 },

 getSErrors (state) {
    return state.salaryErrors
},

getCloseDialogS (state) {
    return state.closeDialog
}

}

const mutations = {
    setSalaries (state, salaries) {
        state.salaries = salaries
    },

    setSalaryErrors (state, salaryErrors) {
        state.salaryErrors = salaryErrors
    },

    setCloseDialogue(state, dialog) {
        state.closeDialog = dialog
    }
}

const actions = {
    async getSalariesAction({ commit }) {
        Vue.prototype.$Progress.start()
        try {
            const response = await axios.get('/api/salaries')
            commit('setSalaries', response.data)
            Vue.prototype.$Progress.finish()
        } catch (error) {
            Vue.prototype.$Progress.fail()
            console.log(error.message);
        }
    },

    async createSalaryAction({ commit, dispatch }, data) {
        Vue.prototype.$Progress.start()
        try {
            const response = await axios.post('/api/salary/create', data)
            dispatch('getSalariesAction')
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
                    commit('setSalaryErrors', error.response.data.errors )
                }
            } else {
                Toast.fire({
                    icon: 'error',
                    title: error.message
                })
            }
        }
    },

    async updateSalaryAction({ commit, dispatch }, data) {
        Vue.prototype.$Progress.start()
        try {
            const response = await axios.put(`/api/salary/update/${data.id}`, data.data)
            dispatch('getSalariesAction')
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
                    commit('setSalaryErrors', error.response.data.errors )
                }
            } else {
                Toast.fire({
                    icon: 'error',
                    title: error.message
                })
            }
        }
    },

    async deleteSalaryAction({ commit, dispatch }, id) {
        Vue.prototype.$Progress.start()
        try {
            const response = await axios.delete(`/api/salary/delete/${id}`)
            dispatch('getSalariesAction')
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