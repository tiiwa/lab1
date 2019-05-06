import Vue from "vue";
import VueRouter from "vue-router";
import axios from "axios";
import Form from "./services/form";
import VCalendar from "v-calendar";
import VeeValidate from "vee-validate";


window.Vue = Vue;
Vue.use(VueRouter);
window.axios = axios;
window.Form = Form;
window.toastr = require("toastr");


/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require("axios");

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
window.axios.defaults.headers.common["Authorization"] = "Bearer " + localStorage.getItem("auth_token");

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector("meta[name=\"csrf-token\"]");

if (token) {
	window.axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
} else {
	// eslint-disable-next-line no-console
	console.error("CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token");
}


/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
	window.$ = window.jQuery = require("jquery");
	require("bootstrap");
} catch (e) {
	// eslint-disable-next-line no-console
	console.error("Error in requiring jquery");
}


// Use v-calendar & v-date-picker components
Vue.use(VCalendar);
Vue.use(VeeValidate, {
	events: "change"
});
