
import * as types from './mutation-types.js'
const mutations = {
	[types.CHANGE_CLIENT_WH] (state, clientWh) {
		state.clientWidth = clientWh.clientWidth;
		state.clientHeight = clientWh.clientHeight;
	}
}

export default mutations