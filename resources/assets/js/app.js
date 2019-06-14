import './bootstrap'
window.Vue = require('vue');
import VueRouter from 'vue-router'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VueEvents from 'vue-events'
import BackToTop from 'vue-backtotop'

Vue.use(BackToTop)
Vue.use(VueEvents)
Vue.use(VueRouter)
Vue.use(VueAxios, axios)

// global app component
import App from './App.vue'

// views 
import Home from './views/Home.vue'
import SignIn from './views/SignIn.vue'
import SignUp from './views/SignUp.vue'
import Overview from './views/Overview.vue'
import Dashboard from './views/Dashboard.vue'
import UserProfile from './views/UserProfile.vue'
import RecoverUser from './views/RecoverUser.vue'
import ForgotPassword from './views/ForgotPassword.vue'


const routes = [ 
	{ 
	 	name: 'home', 
	 	path: '/', 
	 	component: Home
	},
	{ 
		name: 'signin', 
		path: '/signin', 
		component: SignIn, 
		props: (route) => ({ 
			query: route.query.q
		}),
		meta: { 
			auth: false
		}
	}, 
	{ 
		name: 'signup', 
		path: '/signup', 
		component: SignUp, 
		meta: { 
			auth: false
		}	
	},
	{ 
		name: 'forgot-password', 
		path: '/forgot-password', 
		component: ForgotPassword, 
		meta: { 
			auth: false
		}
	}, 
	{ 
		name: 'recover-user', 
		path: '/recover-user/:token', 
		props: true, 
		component: RecoverUser, 
		meta: { 
			auth: false
		}
	}, 
	{ 
		name: 'dashboard', 
		path: '/dashboard', 
		component: Dashboard, 
		meta: { 
			auth: true
		}
	}, 
	{ 
		name: 'overview', 
		props: true,
		path: '/property/overview/:address', 
		component: Overview, 
	},
	{ 
		name: 'profile', 
		props: true, 
		path: '/admin/user/profile/:token', 
		component: UserProfile, 
		meta: { 
			auth: true
		}
	}
]

const router = new VueRouter({ 
	routes, 
	mode: 'history'
})

Vue.router = router

Vue.use(require('vio-auth'), {
	auth: require('vio-auth/drivers/auth/bearer.js'),
	http: require('vio-auth/drivers/http/axios.1.x.js'),
	router: require('vio-auth/drivers/router/vue-router.2.x.js'),
});



const app = new Vue({
    el: '#app', 
    render: h => h(App), 
    router,
    root: '/'
});
