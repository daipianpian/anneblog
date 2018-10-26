
import * as types from './mutation-types.js'
const mutations = {
	[types.STORAGE_ADMININFO](state,data){
		if(data == ''){
			state.adminId = null;
			state.token = null;
			state.adminInfo = null;
		}else{
			state.adminId = data.id;
			state.token = data.token;
			state.adminInfo=data;
		}
		

	},
	[types.CHANGE_CLIENT_WH] (state, clientWh) {
		state.clientWidth = clientWh.clientWidth;
		state.clientHeight = clientWh.clientHeight;
	}
}

export default mutations