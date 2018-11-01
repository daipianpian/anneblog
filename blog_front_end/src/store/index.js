import Vue from 'vue'
import Vuex from 'vuex'
import actions from './actions'
import mutations from './mutations'


Vue.use(Vuex)

const state = {
	clientWidth: document.documentElement.clientWidth || document.body.clientWidth,
	clientHeight: document.documentElement.clientHeight || document.body.clientHeight,
	menu: [
		{
			url: '/',
			name: '首页'
		},
		{
			url: '/home/article/manage',
			name: '文章管理'
		},
		{
			url: '/home/article/type',
			name: '文章类别'
		}
    ]
}

export default new Vuex.Store({
	state,
	actions,
	mutations,
})