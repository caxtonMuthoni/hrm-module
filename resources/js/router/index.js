import Vue from 'vue'
import VueRouter from 'vue-router'

import Home from '../pages/Home.vue'
import Designation from '../pages/designation'
import Employees from '../pages/employees'
import Salary from '../pages/salary'
import Sms from '../pages/sms'



Vue.use(VueRouter)

const routes = [
    {
      path: '/home',
      component: Home
    },
    {
      path: '/designation',
      component: Designation
    },

    {
      path: '/employees',
      component: Employees
    },

    {
      path: '/salary',
      component: Salary
    },

    {
      path: '/sms',
      component: Sms
    },
]

const router = new VueRouter({
    routes,
    mode: 'history'
})


export default router