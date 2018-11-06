<template>
	<div class="hidden-lg-and-up top-menu">
		<div class="hidden-md-and-up admin-wrap clearboth">
			<div class="admin-avatar float-left"><img src="../assets/images/userAvatar@2x.png" alt=""></div>
			<div class="admin-info float-right">一片天空</div>
		</div>
		<div class="menu-wrap">
			<el-dropdown trigger="click">
		      <span class="el-dropdown-link">
		        <div class="menu-btn">
		    		<span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
		    	</div>
		      </span>
		      <el-dropdown-menu class="hidden-lg-and-up" slot="dropdown">
		        <el-dropdown-item><a href="/">首页</a></el-dropdown-item>
		        <el-dropdown-item><a href="http://blog.admin.daipianpian.com/">管理</a></el-dropdown-item>
		      </el-dropdown-menu>
		    </el-dropdown>
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
		        queryFlag: { // 是否可发送请求
			    	article: true
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
									value.abstract = value.content.replace(/<[^>]*>|/g,"").toString().substr(0, 100)
								})
							}
							
							_this.$store.dispatch('changeSearchKeywords',this.searchKeywords);
							_this.$store.dispatch('changeKeywords',data.keywords);
							_this.$store.dispatch('changeArticle',data)
							_this.$store.dispatch('changeArticleCurPage',1)
							_this.queryFlag.article = true
						}
					})
				}
			},
			handleMenu(){
				this.handleChange()
			},
			handleChange(val){
				console.log(val);
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
		    cursor: pointer;
			.icon-bar{ display: block; width: 22px; height: 2px; border-radius: 1px; background:#5f6d7e;
				&+.icon-bar {margin-top: 4px;}
			}
		}

	

	.admin-search-box{position:absolute; width:50%;height:48px; padding-right: 15px; top:1px;right:0;background:#fff;
		.el-input-group{margin-top: 10px;}
		.admin-wrap{margin:14px auto 0;padding:0}
	}
}

.el-dropdown-menu{width:100%;margin:0;left:0 !important;padding:0;border:none;border-radius:0;}
.el-dropdown-menu__item{height: 56px;line-height: 56px;color: #fff;
background: #5f6d7e;
}
.el-dropdown-menu__item:focus, .el-dropdown-menu__item:not(.is-disabled):hover{    background: #3B4D67;
    }
.el-popper[x-placement^=bottom] .popper__arrow{display:none}
.el-popper[x-placement^=bottom]{margin-top: 0;}
</style>
