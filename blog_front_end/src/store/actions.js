import * as types from './mutation-types.js'

const actions = {
	changeClientWh({commit}, clientWh) {
		commit(types.CHANGE_CLIENT_WH, clientWh)
	},
	changeSearchKeywords({commit}, searchKeywords) {
		commit(types.CHANGE_SEARCHKEYWORDS, searchKeywords)
	},
	changeArticle({commit}, data) {
		commit(types.CHANGE_ARTICLE, data)
	},
	changeArticlePageNum({commit}, pageNum) {
		commit(types.CHANGE_ARTICLE_PAGENUM, pageNum)
	},
	changeArticlePageSize({commit}, pageSize) {
		commit(types.CHANGE_ARTICLE_PAGESIZE, pageSize)
	},
	changeArticleCurPage({commit}, curPage) {
		commit(types.CHANGE_ARTICLE_CURPAGE, curPage)
	}
}

export default actions
