<template>
	<div class="hidden-sm-and-down right-sidebar">
		<!-- 搜索 start -->
		<div class="main-content">
			<el-input placeholder="请输入内容" v-model="searchKeywords">
			    <el-button slot="append" icon="el-icon-search"></el-button>
			</el-input>
		</div>
		<!-- 搜索 end -->

		<!-- 文章分类 start -->
		<div class="main-content">
			<div class="title">文章分类</div>
			<div class="info">
				<div class="flex info-item">
					<div class="flex-item">Bootstrap</div>
					<div>1篇</div>
				</div>
				<div class="flex info-item">
					<div class="flex-item">Bootstrap</div>
					<div>1篇</div>
				</div>
			</div>
			<div class="btn-box">
				<i class="el-icon-caret-bottom"></i>
				<span>展示</span>
			</div>
			<!-- <div class="btn-box">
				<i class="el-icon-caret-top"></i>
				<span>收缩</span>
			</div> -->
		</div>
		<!-- 文章分类 end -->

		<!-- 归档 start -->
		<div class="main-content">
			<div class="title">归档</div>
			<div class="info">
				<div class="flex info-item">
					<div class="flex-item">Bootstrap</div>
					<div>1篇</div>
				</div>
				<div class="flex info-item">
					<div class="flex-item">Bootstrap</div>
					<div>1篇</div>
				</div>
			</div>
			<div class="btn-box">
				<i class="el-icon-caret-bottom"></i>
				<span>展示</span>
			</div>
			<!-- <div class="btn-box">
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
			<div class="btn-box">
				<i class="el-icon-caret-bottom"></i>
				<span>展示</span>
			</div>
			<!-- <div class="btn-box">
				<i class="el-icon-caret-top"></i>
				<span>收缩</span>
			</div> -->
		</div>
		<!-- 友情链接 end -->

	</div>
</template>

<script type="text/ecmascript-6">
	export default {
		data() {
			return {
				searchKeywords:''
			}
		},
		computed: {
		},
	    methods: {
	    }
	}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" rel="stylesheet/scss">
	.right-sidebar{margin-right: 15px;
		.main-content{
			.title{ padding: 0 10px; margin-bottom: 15px; font-size: 18px; color: $color-gray; border-left: 4px solid $color-main;}
			.info{font-size: 14px; padding-bottom: 5px; border-bottom: 1px dashed $color-gray-light;}
			.info-item{margin-bottom: 5px; color: $color-gray-medium;}
			.btn-box{
		    height: 44px;
		    box-sizing: border-box;
		    border-bottom-left-radius: 4px;
		    border-bottom-right-radius: 4px;
		    text-align: center;
		    margin-top: -1px;
		    color: #d3dce6;
		    cursor: pointer;
		    position: relative;
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