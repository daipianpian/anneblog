<template>
	<div class="hidden-sm-and-down right-sidebar">
		<!-- 搜索 start -->
		<div class="main-content">
			<el-input placeholder="请输入文章名称" v-model="searchKeywords">
			    <el-button slot="append" icon="el-icon-search" @click="searchArticle"></el-button>
			</el-input>
		</div>
		<!-- 搜索 end -->

		<!-- 文章分类 start -->
		<div class="main-content">
			<div class="title">文章分类</div>
			<div class="info">
				<div class="flex info-item" v-for="item in classifyList" @click="classifyArticle(item.id)">
					<div class="flex-item">{{item.name}}</div>
					<div>{{item.count}}篇</div>
				</div>
			</div>
			<!-- <div class="btn-box">
				<i class="el-icon-caret-bottom"></i>
				<span>展示</span>
			</div>
			<div class="btn-box">
				<i class="el-icon-caret-top"></i>
				<span>收缩</span>
			</div> -->
		</div>
		<!-- 文章分类 end -->

		<!-- 归档 start -->
		<div class="main-content">
			<div class="title">标签</div>
			<div class="info">
				<div class="flex info-item" v-for="item in tagList" @click="tagArticle(item.id)">
					<div class="flex-item">{{item.name}}</div>
					<div>{{item.count}}篇</div>
				</div>
			</div>
			<!-- <div class="btn-box">
				<i class="el-icon-caret-bottom"></i>
				<span>展示</span>
			</div>
			<div class="btn-box">
				<i class="el-icon-caret-top"></i>
				<span>收缩</span>
			</div> -->
		</div>
		<!-- 归档 end -->

		<!-- 友情链接 start -->
		<div class="main-content">
			<div class="title">友情链接</div>
			<div class="info">
				<div class="flex info-item">
					<div class="flex-item"><a href="http://www.cnblogs.com/daipianpian/">竹立荷塘-博客园</a></div>
				</div>
				<div class="flex info-item">
					<div class="flex-item"><a href="https://blog.csdn.net/daipianpian">【一片天空】Bootstrap_Git_GitHub - CSDN博客</a></div>
				</div>
			</div>
			<!-- <div class="btn-box">
				<i class="el-icon-caret-bottom"></i>
				<span>展示</span>
			</div>
			<div class="btn-box">
				<i class="el-icon-caret-top"></i>
				<span>收缩</span>
			</div> -->
		</div>
		<!-- 友情链接 end -->

	</div>
</template>

<script type="text/ecmascript-6">
	import {queryClassifyTag, articleQueryArticle, queryArticleByClassify, queryArticleByTag} from "../config/interface.js"
	export default {
		data() {
			return {
				classifyList: [], // 列表数据
				tagList: [], // 列表数据
				queryFlag: { // 是否可发送请求
			    	query: true,
			    	article: true
			    },
			    loading: { // 是否显示loading
			    	table: false
			    }
			}
		},
		computed: {
			searchKeywords: {
				get: function () {
			      return this.$store.state.searchKeywords
			    },
			    set: function (newValue) {
			      this.$store.state.searchKeywords = newValue
			    }
			},
			pageNum: function() {
				return this.$store.state.articlePageNum
			},
			pageSize: function() {
				return this.$store.state.articlePageSize
			}
		},
		created() {
			this.init()
		},
	    methods: {
	    	// 初始化
			init(){
				this.queryClassifyTag()
			},
			queryClassifyTag() {
				const url = queryClassifyTag;
				const _this = this;
				if(this.queryFlag.query == true){
            		this.queryFlag.query = false
            		this.loading.table = true
            		let params = {}
            		fetch(url,params)
					.then(res =>{
						if(res.code == 10000){
							let data=res.data

							let classifyList = data.classifyList
							classifyList.forEach(function(value,index){
								if(value.count > 0){
									_this.classifyList.push(value)
								}
							})

							let tagList = data.tagList
							tagList.forEach(function(value,index){
								if(value.count > 0){
									_this.tagList.push(value)
								}
							})

							_this.queryFlag.query = true
							_this.loading.table = false
						}
					})
				}
			},
			searchArticle(){
				this.$store.dispatch('changeArticlePageNum',1);
				const url = articleQueryArticle;
				const _this = this;
				if(this.queryFlag.article == true){
            		this.queryFlag.article = false
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

							_this.$store.dispatch('changeSearchKeywords',this.searchKeywords);
							_this.$store.dispatch('changeArticle',data)
							_this.$store.dispatch('changeArticleCurPage',1)
							_this.queryFlag.article = true
						}
					})
				}
			},
			classifyArticle(classifyId){
				this.$store.dispatch('changeArticlePageNum',1);
				const url = queryArticleByClassify;
				const _this = this;
				if(this.queryFlag.article == true){
            		this.queryFlag.article = false
					let params = {
						pageNum: this.pageNum,
	            		pageSize: this.pageSize,
						classifyId: classifyId
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

							_this.$store.dispatch('changeSearchKeywords',null);
							_this.$store.dispatch('changeArticle',data)
							_this.$store.dispatch('changeArticleCurPage',1)
							_this.queryFlag.article = true
						}
					})
				}
			},
			tagArticle(tagId){
				this.$store.dispatch('changeArticlePageNum',1);
				const url = queryArticleByTag;
				const _this = this;
				if(this.queryFlag.article == true){
            		this.queryFlag.article = false
					let params = {
						pageNum: this.pageNum,
	            		pageSize: this.pageSize,
						tagId: tagId
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

							/*_this.$store.dispatch('changeSearchKeywords',null);*/
							_this.$store.dispatch('changeArticle',data)
							_this.$store.dispatch('changeArticleCurPage',1)
							_this.queryFlag.article = true
						}
					})
				}
			}
	    }
	}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" rel="stylesheet/scss">
	.right-sidebar{margin-right: 15px;
		.main-content{
			.title{ padding: 0 10px; margin-bottom: 15px; font-size: 18px; color: $color-gray; border-left: 4px solid $color-main;}
			.info{font-size: 14px;}
			.info-item{margin-bottom: 5px; color: $color-gray-medium;
				&:hover{color:$color-main;cursor:pointer;}
			}
			.btn-box{
		    height: 44px;
		    box-sizing: border-box;
		    border-bottom-left-radius: 4px;
		    border-bottom-right-radius: 4px;
		    text-align: center;
		    margin-top: 5px;
		    color: #d3dce6;
		    cursor: pointer;
		    position: relative;
		    border-top: 1px dashed #E5E5E5;
				i {
				    font-size: 16px;
				    line-height: 44px;
				    transition: .3s; 
				}
				span{
					position: absolute;
				    -ms-transform: translateX(-30px);
				    transform: translateX(-30px);
				    font-size: 14px;
				    line-height: 44px;
				    transition: .3s;
				    display: none;
				}
				&:hover{
					i {-ms-transform: translateX(-30px);
				    transform: translateX(-30px);}
				    span{
				    	display: inline-block;
				    }
				}
			}
			a{text-decoration: none;color: $color-gray-medium;
				&:hover{color:$color-main;}
			}
		}
	}
</style>