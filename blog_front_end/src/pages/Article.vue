<template>
	<div class="main flex-item article article-info" :style="{'min-height': clientHeight}">
		<div class="title flex">
			<span :class="{'type type-success': articleData.typeId==1, 'type type-danger': articleData.typeId==2}">{{articleData.typeId==1?'原':'转'}}</span>
			<span class="title-info flex-item">{{articleData.title}}</span>
		</div>
		<div class="other-info">
			<span><i class="el-icon-date"></i>{{articleData.createTime}}</span>
			<!-- <span><i class="el-icon-tickets"></i>npm,vue,vue3.0,前后端分离</span> -->
		</div>
		<div class="abstract" v-html="articleData.content">
		</div>
	</div>
</template>

<script type="text/ecmascript-6">
	import {queryArticleDetail} from "../config/interface.js"
	export default {
		data() {
			return {
				articleId: this.$route.query.articleId,
				articleData: null
			}
		},
		computed: {
			clientHeight: function() {
				return this.$store.state.clientHeight+'px'
			}
		},
		created() {
			this.init()
		},
	    methods: {
	    	// 初始化
			init(){
				// this.$store.dispatch('changeArticleCurPage',1)
				this.queryArticleDetail()
			},
			queryArticleDetail(){
				const url = queryArticleDetail;
				const _this = this;
				let params = {
        			articleId: this.articleId
        		}
        		fetch(url,params)
				.then(res =>{
					if(res.code == 10000){
						let data=res.data
						_this.articleData = data
					}
				})
			}
	    }
	}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" rel="stylesheet/scss">
	.article{margin-left:15px; margin-right:15px; padding: 20px 30px; background: #fff;}
</style>