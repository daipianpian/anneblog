<template>
	<el-row class="main flex-item">
		<el-col :sm="24" :md="17">
			<transition name="fade" mode="out-in" appear>

				<div class="article-list-box" :style="{'min-height': clientHeight}">
					<div class="main-content attr-name" v-if="searchKeywords">全部文章&nbsp;&gt;&nbsp;前端</div>

					<div class="article-list article-info">
						<div class="main-content article-item" v-for="item in articleData">
							<div class="title flex">
								<span :class="{'type type-success': item.typeId==1, 'type type-danger': item.typeId==2}">{{item.typeId==1?'原':'转'}}</span>
								<span class="title-info flex-item">{{item.title}}</span>
							</div>
							<div class="line-clamp-1 abstract" v-html="item.abstract"></div>
							<div class="other-info">
								<span><i class="el-icon-date"></i>{{item.createTime}}</span>
							</div>
						</div>

					</div>

					<el-pagination :current-page.sync="curPage" :page-sizes="[pageSize, 20, 30]" :page-size="pageSize" layout="total, sizes, prev, pager, next, jumper" :total="pageTotal" @size-change="handleSizeChange" @current-change="handleCurrentChange" align="right"></el-pagination>

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
				searchKeywords: null,
				pageNum: 1, // 请求第几页
				pageSize: 10, // 每页请求多少条
				pageTotal: 0, // 总共多少条数据
				curPage: 1, // 初始时在第几页
				articleData: [], // 列表数据
				queryFlag: { // 是否可发送请求
			    	article: true
			    },
			    loading: { // 是否显示loading
			    	table: false
			    }
			};
		},
		components: {
			RightSidebar
		},
		computed: {
			clientHeight: function() {
				return this.$store.state.clientHeight+'px'
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
				this.queryArticle()
			},
			queryArticle() {
				const url = articleQueryArticle;
				const _this = this;
				if(this.queryFlag.article == true){
            		this.queryFlag.article = false
            		this.loading.table = true
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
									value.abstract = value.content.toString().substr(0, 100)
								})
							}

							


							_this.articleData = data.list
							_this.pageTotal = data.count

							_this.queryFlag.article = true
							_this.loading.table = false
						}
					})
				}
			},
			// 改变pageSize
			handleSizeChange(val){
				this.pageSize = val;
				this.queryArticle()
			},
			// 改变pageNum
			handleCurrentChange(val) {
				this.pageNum = val;
		    	this.queryArticle()
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
		.attr-name,.article-item{ border-bottom: 1px solid $color-gray-light;}
		.abstract{width: 100%;}
		.el-pagination{padding:50px 24px 50px 0;}
	}
</style>