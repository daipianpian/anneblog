<template>
	<el-row class="main flex-item">
		<el-col :sm="24" :md="17">
			<transition name="fade" mode="out-in" appear>

				<div class="article-list-box" :style="{'min-height': clientHeight}">
					<div class="main-content attr-name" v-if="keywords">全部文章&nbsp;&gt;&nbsp;{{keywords}}</div>

					<div class="article-list article-info" v-loading="loading.article">
						<div class="main-content article-item" v-for="item in articleList">
							<div class="title flex" @click="goArticle(item.id)">
								<span :class="{'type type-success': item.typeId==1, 'type type-danger': item.typeId==2}">{{item.typeId==1?'原':'转'}}</span>
								<span class="title-info flex-item">{{item.title}}</span>
							</div>
							<div class="abstract">{{item.abstract}}...</div>
							<div class="other-info">
								<span><i class="el-icon-date"></i>{{item.createTime}}</span>
							</div>
						</div>

					</div>

					<el-pagination v-if="articleList.length > 0" :current-page.sync="curPage" :page-sizes="[10, 20, 30]" :page-size="pageSize" layout="total, sizes, prev, pager, next, jumper" :total="pageTotal" @size-change="handleSizeChange" @current-change="handleCurrentChange" align="right"></el-pagination>

				</div>


			</transition>
		</el-col>
		<el-col :md="7">
			<right-sidebar></right-sidebar>
		</el-col>
	</el-row>
</template>

<script type="text/ecmascript-6">
	import RightSidebar from '../components/RightSidebar'
	import {articleQueryArticle} from "../config/interface.js"
	export default {
		data() {
			return {
				queryFlag: { // 是否可发送请求
			    	article: true
			    },
			    loading: { // 是否显示loading
			    	article: false
			    }
			};
		},
		components: {
			RightSidebar
		},
		computed: {
			clientHeight: function() {
				return this.$store.state.clientHeight+'px'
			},
			searchKeywords: function() {
				return this.$store.state.searchKeywords
			},
			pageNum: function() {
				return this.$store.state.articlePageNum
			},
			pageSize: function() {
				return this.$store.state.articlePageSize
			},
			pageTotal: function() {
				return this.$store.state.articlePageTotal
			},
			curPage: {
				get: function () {
			      return this.$store.state.articleCurPage
			    },
			    set: function (newValue) {
			      this.$store.state.articleCurPage = newValue
			    }
			},
			keywords: function() {
				return this.$store.state.keywords
			},
			articleList: function() {
				return this.$store.state.articleList
			}
		},
		created() {
			this.init()
		},
		watch: {

		},
		// 'mounted：此时，组件已经出现在页面中，数据、真实dom都已经处理好了,事件都已经挂载好了
		mounted() {
			
		},
		methods: {
			// 初始化
			init(){
				// this.$store.dispatch('changeArticleCurPage',1)
				this.queryArticle()
			},
			queryArticle() {
				const url = articleQueryArticle;
				const _this = this;
				if(this.queryFlag.article == true){
            		this.queryFlag.article = false
            		this.loading.article = true
            		let params = {
            			pageNum: this.pageNum,
            			pageSize: this.pageSize,
            			searchKeywords: this.searchKeywords
            		}
            		fetch(url,params)
					.then(res =>{
						if(res.code == 10000){
							let data=res.data

							let list = data.list
							let list_length = list.length

							if(list_length > 0){
								list.forEach(function(value,index){
									value.abstract = value.content.replace(/<[^>]*>|/g,"").toString().substr(0, 100)
								})
							}


							_this.$store.dispatch('changeArticle',data)

							_this.queryFlag.article = true
							_this.loading.article = false
						}
					})
				}
			},
			// 改变pageNum
			handleCurrentChange(val) {
				/*this.pageNum = val;*/
				this.$store.dispatch('changeArticlePageNum',val)
		    	this.queryArticle()
		  	},
			// 改变pageSize
			handleSizeChange(val){
				/*this.pageSize = val;*/
				this.$store.dispatch('changeArticlePageSize',val)
				this.queryArticle()
			},
			goArticle(articleId) {

				return router.push({
			        path:'/article',
			        query:{
			          articleId:articleId
			        }
			    })
			}
		},
		// destroyed:组件的数据绑定、监听...都去掉了,只剩下dom空壳，这里也可以善后
		beforeDestroy() {

		}
	}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" rel="stylesheet/scss">
	.article-list-box{
		margin: 0 15px; background-color: #fff;
		.article-item{
			.title:hover{cursor: pointer;}
		}
		.attr-name,.article-item{ border-bottom: 1px solid $color-gray-light;}
		/* .abstract{width: 100%;} */
		.el-pagination{padding:50px 24px 50px 0;}
	}
</style>