import Vue from 'vue'
import Toast from '../../plugins/toast'

const state = {
  employees: [],
  employeeErrors: [],
  closeEmpDialog: false
}

const getters = {
   getEmployees (state) {
       return state.employees
   },

   getEmpErrors (state) {
    return state.employeeErrors
},

getCloseDialogEmp (state) {
    return state.closeEmpDialog
}
}

const mutations = {
    setEmployees (state, employees) {
        state.employees = employees
    },

    setEmployeeErrors (state, employeeErrors) {
        state.employeeErrors = employeeErrors
    },

    setCloseDialogueEmp(state, dialog) {
        state.closeEmpDialog = dialog
    }
}

const actions = {
    async getEmployeesAction({ commit }) {
        Vue.prototype.$Progress.start()
        try {
            const response = await axios.get('/api/employees')
            commit('setEmployees', response.data)
            Vue.prototype.$Progress.finish()
        } catch (error) {
            Vue.prototype.$Progress.fail()
            console.log(error.message);
        }
    },

    async createEmployeeAction({ commit, dispatch }, data) {
        commit('setCloseDialogueEmp', false)
        Vue.prototype.$Progress.start()
        try {
            const response = await axios.post('/api/employees/create', data)
            dispatch('getEmployeesAction')
            Vue.prototype.$Progress.finish()
            Toast.fire({
                icon: 'success',
                title: response.data.message
            })
            commit('setCloseDialogueEmp', true)

        } catch (error) {
            Vue.prototype.$Progress.fail()

            if(error.response) {
                if (error.response.status === 422) {
                    commit('setEmployeeErrors', error.response.data.errors )
                }
            } else {
                Toast.fire({
                    icon: 'error',
                    title: error.message
                })
            }
        }
    },

    async updateEmployeeAction({ commit, dispatch }, data) {
        commit('setCloseDialogueEmp', false)
        Vue.prototype.$Progress.start()
        try {
            const response = await axios.post(`/api/employees/update/${data.id}`, data.data)
            dispatch('getEmployeesAction')
            Vue.prototype.$Progress.finish()

            Toast.fire({
                icon: 'success',
                title: response.data.message
            })
            commit('setCloseDialogueEmp', true)
            
            
        } catch (error) {
            Vue.prototype.$Progress.fail()

            if(error.response) {
                if (error.response.status === 422) {
                    commit('setEmployeeErrors', error.response.data.errors )
                }
            } else {
                Toast.fire({
                    icon: 'error',
                    title: error.message
                })
            }
        }
    },

    async deleteEmployeeAction({ commit, dispatch }, id) {
        Vue.prototype.$Progress.start()
        try {
            const response = await axios.delete(`/api/employees/delete/${id}`)
            dispatch('getEmployeesAction')
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