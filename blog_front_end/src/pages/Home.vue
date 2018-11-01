<template>
	<div class="home flex">
		<top-menu></top-menu>
		<left-menu></left-menu>
		<router-view></router-view>
	</div>
</template>

<script type="text/ecmascript-6">
	import TopMenu from '../components/TopMenu'
	import LeftMenu from '../components/LeftMenu'
	export default {
		data() {
			return {
				
			};
		},
		components: {
			TopMenu,
			LeftMenu
		},
		computed: {

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
	.fade-enter-active,
	.fade-leave-active {
		transition: opacity .3s
	}

	.fade-enter,
	.fade-leave-active {
		opacity: 0
	}
</style>