import Vue from 'vue'
import Vuex from 'vuex'
import actions from './actions'
import mutations from './mutations'


Vue.use(Vuex)

const state = {
	clientWidth: document.documentElement.clientWidth || document.body.clientWidth,
	clientHeight: document.documentElement.clientHeight || document.body.clientHeight,
	adminId: localStorage.getItem("adminId"), //用户信息
	token: localStorage.getItem('token'),
	adminInfo: localStorage.getItem('adminInfo')
}

export default new Vuex.Store({
	state,
	actions,
	mutations,
})