import Vue from 'vue'
import Router from 'vue-router'
import Index from '@/pages/Index/Index' //达人续约

Vue.use(Router)

export default new Router({
	mode: 'history',
	base: '/',
	routes: [
		{ 	path: '/', name: 'Index', component: Index ,
			meta: { keepAlive: false, title: '首页' }
		}
	]
})