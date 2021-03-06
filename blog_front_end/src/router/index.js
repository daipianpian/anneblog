import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/pages/Home.vue'
import refresh from '@/pages/refresh.vue'
import main from '@/pages/Main.vue'
import article from '@/pages/Article.vue'

Vue.use(Router)

export default new Router({
	mode: 'history',
	base: '/',
	routes: [
		{
			path: '/',
			name: 'Home',
			component: Home,
			children: [
			    // 刷新中转页面
				{ path: '/refresh', name: 'refresh', component: refresh},
				{ path: '/', name: 'Main', component: main },
		      	{ path: '/article', name: 'article', component: article}
			]
		}
	]
})
