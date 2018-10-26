import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/pages/Home.vue'
import refresh from '@/pages/refresh.vue'

Vue.use(Router)

export default new Router({
	mode: 'history',
	base: '/',
	routes: [
		{
			path: '/',
			name: 'Index',
			component: Home
		}, 
	    {
			path: '/index',
			name: 'Index',
			component: Home,
			children: [
			    // 刷新中转页面
				{ path: '/refresh', component: refresh, name: 'refresh' }
			]
	  	}
	]
})
