import * as types from './mutation-types.js'

const actions = {
	storageAdminInfo({commit},data){
		commit(types.STORAGE_ADMININFO, data)
	},
	changeClientWh({commit}, clientWh) {
		commit(types.CHANGE_CLIENT_WH, clientWh)
	}
}

export default actions
