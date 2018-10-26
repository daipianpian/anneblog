import Vue from 'vue'
import Router from 'vue-router'
import Login from '@/pages/Login/View'
import Home from '@/pages/Home.vue'
import refresh from '@/pages/refresh.vue'
import articleManage from '@/pages/ArticleManage/View'
import articleType from '@/pages/ArticleType/View'
import articleClassify from '@/pages/ArticleClassify/View'
import articleTag from '@/pages/ArticleTag/View'

Vue.use(Router)

export default new Router({
	mode: 'history',
	base: '/',
	routes: [
		{
			path: '/',
			name: 'Login',
			component: Login
		}, 
	    {
			path: '/home',
			name: 'Home',
			component: Home,
			children: [
			    // 刷新中转页面
				{ path: '/refresh', component: refresh, name: 'refresh' },
				{ path: 'article/manage', component: articleManage, name: 'articleManage'},
				{ path: 'article/type', component: articleType, name: 'articleType'},
				{ path: 'article/classify', component: articleClassify, name: 'articleClassify'},
				{ path: 'article/tag', component: articleTag, name: 'articleTag'}
			]
	  	}
	]
})
