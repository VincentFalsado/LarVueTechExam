/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// require('./bootstrap');
import { createApp } from 'vue';    
import login from './components/login.vue';
import register from './components/register.vue';
import usersManager from './components/admin/usersManager.vue';
import rolesManager from './components/admin/rolesManager.vue';
import profile from './components/client/profile.vue';

// window.Vue = require('vue').default;
createApp(login).mount('#login');
createApp(register).mount('#register');
createApp(usersManager).mount('#usersManager');
createApp(rolesManager).mount('#rolesManager');
createApp(profile).mount('#profile');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('app', require('./components/app.vue'));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// const app = new Vue({
//     el: '#app',
// });


