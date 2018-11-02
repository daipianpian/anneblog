<template>
	<div class="hidden-lg-and-up top-menu">
		<div class="hidden-md-and-up admin-wrap clearboth">
			<div class="admin-avatar float-left"><img src="../assets/images/userAvatar@2x.png" alt=""></div>
			<div class="admin-info float-right">一片天空</div>
		</div>
		<div class="menu-wrap">
			<el-collapse accordion class="menu-collapse">
	  			<el-collapse-item>
	  				<template slot="title">
				    	<div class="menu-btn">
				    		<span class="icon-bar"></span>
		                    <span class="icon-bar"></span>
		                    <span class="icon-bar"></span>
				    	</div>
				    </template>
				    <el-menu class="aside"
				          :default-active="$route.path" :router="true">
				        <el-menu-item  v-for="(item, index) in  menu" :index="item.url"  :key="index"  @click="handleMenuSelect(item.url)">
				          <i :class="item.icon"></i>
				          <span slot="title">{{item.name}}</span>
				        </el-menu-item>
				    </el-menu>
	  			</el-collapse-item>
	  		</el-collapse>
	  		<div class="admin-search-box">
	  			<el-input class="hidden-md-and-up" placeholder="请输入文章名称" v-model="searchKeywords">
	  				<el-button slot="append" icon="el-icon-search" @click="searchArticle"></el-button>
	  			</el-input>
	  			<div class="hidden-sm-and-down admin-wrap clearboth float-right">
					<div class="admin-avatar float-left"><img src="../assets/images/userAvatar@2x.png" alt=""></div>
					<div class="admin-info float-right">一片天空</div>
				</div>
	  		</div>
  		</div>
	</div>
</template>

<script type="text/ecmascript-6">
	import {articleQueryArticle} from "../config/interface.js"
	export default {
		data() {
			return {
				menu: this.$store.state.menu,
		        searchKeywords: null,
		        queryFlag: { // 是否可发送请求
			    	article: true
			    }
			}
		},
		computed: {
			pageNum: function() {
				return this.$store.state.articlePageNum
			},
			pageSize: function() {
				return this.$store.state.articlePageSize
			}
		},
	    methods: {
			handleMenuSelect(path) {
				if (path != this.$route.path) {
					this.$router.push(path)
				}else{
					bs.shallowRefresh(this.$route.name)
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
									value.abstract = value.content.toString().substr(0, 100)
								})
							}
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
.top-menu{position:fixed; width: 100%; z-index: 100;background: #fff;
	.admin-wrap{width:100px;margin: 0 auto; padding:10px 0;}
	.admin-avatar{width:30px;height:30px;border: 1px solid white; border-radius: 50%;overflow: hidden;
		img{width:100%;}
	}
	.admin-info{line-height: 30px; font-size: 14px;}
	.menu-wrap{position:relative}
	.menu-collapse{
		position:relative;
		.menu-btn{position: relative;
		    float: left;
		    padding: 9px 10px;
		    margin-top: 12px;
		    margin-left: 15px;
		    margin-bottom: 8px;
		    background-color: transparent;
		    background-image: none;
		    border: 1px solid #5f6d7e;
		    border-radius: 4px;
			.icon-bar{ display: block; width: 22px; height: 2px; border-radius: 1px; background:#5f6d7e;
				&+.icon-bar {margin-top: 4px;}
			}
		}
		.el-collapse-item__header{height:60px;line-height: 60px;}
		.el-collapse-item__content{color: #fff; background:#5f6d7e;}
		.el-menu{
			.el-menu-item{text-align: left;}
		}
		
	}
	.admin-search-box{position:absolute; width:50%;height:48px; padding-right: 15px; top:1px;right:0;background:#fff;
		.el-input-group{margin-top: 10px;}
		.admin-wrap{margin:14px auto 0;padding:0}
	}
}
</style>
