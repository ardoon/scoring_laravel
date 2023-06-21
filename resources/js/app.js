/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('members-table', require('./components/MembersTable.vue').default);
Vue.component('payments-table', require('./components/PaymentsTable.vue').default);
Vue.component('penalties-table', require('./components/PenaltiesTable.vue').default);
Vue.component('reports-table', require('./components/ReportsTable.vue').default);
Vue.component('member-edit-tab-nav', require('./components/MemberEditTabNav.vue').default);
Vue.component('dashboard-content-header', require('./components/DashboardContentHeader.vue').default);
Vue.component('dashboard-form', require('./components/DashboardForm.vue').default);
Vue.component('dashboard-form-field', require('./components/DashboardFormField.vue').default);
Vue.component('dashboard-form-select', require('./components/DashboardFormSelect.vue').default);
Vue.component('dashboard-form-date', require('./components/DashboardFormDate.vue').default);
Vue.component('alert-message', require('./components/AlertMessage.vue').default);
Vue.component('table-pagination', require('./components/TablePagination.vue').default);
Vue.component('tabs-member-edit', require('./components/TabsMemberEdit.vue').default);
Vue.component('toggle-is-penalties-strict', require('./components/ToggleIsPenaltiesStrict.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data: {
        activeEditMemberTab: 'info'
    },
    methods: {
        updateActiveTab(e) {
            this.activeEditMemberTab = e
        },
        formatPrice(value) {
            return new Intl.NumberFormat().format(value)
        }
    }
});
