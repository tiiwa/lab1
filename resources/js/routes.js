import VueRouter from "vue-router";
import helper from "./services/helper";

let routes = [
	{
		path: "/",
		component: require("./layouts/guest-page"),
		children: [
			{
				path: "/",
				component: require("./views/pages/home")
			},
			{
				path: "/home",
				component: require("./views/pages/home")
			},
			{
				path: "/org",
				component: require("./views/organizations/organization.vue"),
				children: [
					// {
					// 	path: "all",
					// 	component: require("./views/lessons/allLessons.vue"),
					// 	name: "allLessons"
					// },
					// {
					// 	path: "create",
					// 	component: require("./views/lessons/createLesson"),
					// 	name: "createLesson"
					// },
					{
						path: ":org_id",
						component: require("./views/organizations/showOrganization"),
						name: "showOrganization"
					},
					// {
					// 	path: ":lesson_id/edit",
					// 	component: require("./views/lessons/editLesson"),
					// 	name: "editLesson"
					// }
				]
			},
		]
	},
	{
		path: "/",
		component: require("./layouts/guest-page"),
		meta: { requiresGuest: true },
		children: [
			{
				path: "/login",
				component: require("./views/auth/login")
			},
			{
				path: "/password",
				component: require("./views/auth/password")
			},
			{
				path: "/register",
				component: require("./views/auth/register")
			},
			{
				path: "/auth/:token/activate",
				component: require("./views/auth/activate")
			},
			{
				path: "/password/reset/:token",
				component: require("./views/auth/reset")
			},
		]
	},
	{
		path: "/dashboard",
		component: require("./layouts/default-page"),
		meta: { requiresAuth: true },
		children: [
			{
				path: "/dashboard",
				component: require("./views/pages/dashboard")
			}
		]
	},
	{
		path: "*",
		component : require("./layouts/error-page"),
		children: [
			{
				path: "*",
				component: require("./views/errors/page-not-found")
			}
		]
	}
];

const router = new VueRouter({
	routes,
	linkActiveClass: "active",
	mode: "history"
});

router.beforeEach((to, from, next) => {

	if (to.matched.some(m => m.meta.requiresAuth)){
		return helper.check().then(response => {
			if(!response){
				return next({ path : "/login"});
			}

			return next();
		});
	}

	if (to.matched.some(m => m.meta.requiresGuest)){
		return helper.check().then(response => {
			if(response){
				return next({ path : "/dashboard"});
			}

			return next();
		});
	}

	return next();
});

export default router;
