<template>
	<el-row class="main flex-item">
		<el-col :sm="24" :md="17">
			<transition name="fade" mode="out-in" appear>
				<div class="article-list" :style="{'height': clientHeight}">
					<div class="main-content article-item">
						<div class="title flex">
							<span class="type">原</span>
							<span class="title-info flex-item">将博客搬至CSDN将博客搬至CSDN将博客搬至CSDN将博客搬至CSDN将博客搬至CSDN将博客搬至CSDN将博客搬至CSDN将博客搬至CSDN将博客搬至CSDN</span>
						</div>
						<div class="abstract">
							最近打算将博客搬到CSDN里，在此发出通知，声明一下。
						</div>
						<div class="other-info">
							<span><i class="el-icon-date"></i>2018-10-08</span>
							<span><i class="el-icon-tickets"></i>npm,vue,vue3.0,前后端分离</span>
						</div>
					</div>

					<div class="main-content article-item">
						<div class="title flex">
							<span class="type">原</span>
							<span class="title-info flex-item">将博客搬至CSDN将博客搬至CSDN将博客搬至CSDN将博客搬至CSDN将博客搬至CSDN将博客搬至CSDN将博客搬至CSDN将博客搬至CSDN将博客搬至CSDN</span>
						</div>
						<div class="abstract">
							最近打算将博客搬到CSDN里，在此发出通知，声明一下。
						</div>
						<div class="other-info">
							<span><i class="el-icon-date"></i>2018-10-08</span>
							<span><i class="el-icon-tickets"></i>npm,vue,vue3.0,前后端分离</span>
						</div>
					</div>

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
	export default {
		data() {
			return {
				
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

		},
		watch: {

		},
		// 'mounted：此时，组件已经出现在页面中，数据、真实dom都已经处理好了,事件都已经挂载好了
		mounted() {
			
		},
		methods: {

		},
		// destroyed:组件的数据绑定、监听...都去掉了,只剩下dom空壳，这里也可以善后
		beforeDestroy() {

		}
	}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" rel="stylesheet/scss">
	.article-list{
		margin: 0 15px; background-color: #fff;
		.article-item{ border-bottom: 1px solid $color-gray-light;
			.title{font-size: 18px; line-height: 28px;}
			.type{display: block; width: 26px;
		    height: 26px; line-height: 26px; margin-right: 10px; color:$color-success; text-align: center; border-radius: 50%;border:1px solid $color-success;font-size: 12px;}
		    .title-info{font-weight: 700;}
		    .abstract{font-size: 16px; color: #555;margin-top: 4px;text-align:justify;text-justify:inter-ideograph;}
		    .other-info{
		    	font-size: 13px;color: #b3b3b3;text-align: right;margin-top: 4px;
				i{margin-right: 5px;}
		    }
		}
	}
</style>