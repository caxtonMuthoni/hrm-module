import Vue from 'vue'
import Vuex from 'vuex'

// Modules

import designation from './modules/designation'
import employee from './modules/employee'
import salary from './modules/salary'
import sms from './modules/sms'

Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
       designation,
       employee,
       salary,
       sms
  }
})


export default store