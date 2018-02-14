require('./bootstrap');

window.Vue = require('vue');

var axios = require('axios');
Vue.component('contacts', require('./components/Contacts.vue'));
const app = new Vue({
    el: '#app'
});
