
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");
import store from "./store";
import router from "./routes";

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
	el: "#app",
	store,
	router
});


toastr.options = {
	positionClass: "toast-top-right",
	closeButton: true,
	closeDuration: 100,
	preventDuplicates: true,
	progressBar: true,
	timeOut: 2500,
};
