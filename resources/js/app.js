
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';

window.Vue.use(VueRouter);

import VeeValidate from 'vee-validate';


import CompaniesIndex from './components/companies/CompaniesIndex.vue';
import CompaniesCreate from './components/companies/CompaniesCreate.vue';
import CompaniesEdit from './components/companies/CompaniesEdit.vue';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));


const routes = [
    {
        path: '/',
        components: {
            companiesIndex: CompaniesIndex
        }
    },
    {
        name: 'createCompany',
        path: '/create',
        component: CompaniesCreate
    },
    {
        name: 'editCompany',
        path: '/edit/:id',
        component: CompaniesEdit
    },
]

let dictionary = {
    dictionary: {
        en: {
            custom: {
                name: {
                    required: 'Company name is required.'
                },
                email: {
                    required: 'Company mail is required.',
                    email: 'Company mail must be a valid email.'
                },
                address: {
                    required: 'Company address is required.',
                    min: 'Company address must be at least 6 characters.'
                },
            }
        }
    }
};
window.Vue.use(VeeValidate, dictionary);

const router = new VueRouter({ routes })

const app = new Vue({ router }).$mount('#app')
