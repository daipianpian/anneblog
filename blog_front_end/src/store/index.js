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
			name: '管理'
		}
    ],
    articlePageNum: 1, // 请求第几页
	articlePageSize: 10, // 每页请求多少条
	articlePageTotal: 0, // 总共多少条数据
	articleCurPage: 1, // 初始时在第几页
    articleList: []
}

export default new Vuex.Store({
	state,
	actions,
	mutations,
})