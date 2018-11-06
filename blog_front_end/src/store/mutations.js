
import * as types from './mutation-types.js'
const mutations = {
	[types.CHANGE_CLIENT_WH] (state, clientWh) {
		state.clientWidth = clientWh.clientWidth;
		state.clientHeight = clientWh.clientHeight;
	},
	[types.CHANGE_SEARCHKEYWORDS] (state, searchKeywords) {
		state.searchKeywords = searchKeywords;
	},
	[types.CHANGE_ARTICLE] (state, data) {
		state.articlePageTotal = data.count;
		state.keywords = data.keywords;
		state.articleList = data.list;
	},
	[types.CHANGE_ARTICLE_PAGENUM] (state, pageNum) {
		state.articlePageNum = pageNum;
	},
	[types.CHANGE_ARTICLE_PAGESIZE] (state, pageSize) {
		state.articlePageSize = pageSize;
	},
	[types.CHANGE_ARTICLE_CURPAGE] (state, curPage) {
		state.changeArticleCurPage = curPage;
	}
}

export default mutations