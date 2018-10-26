<template>
  <div id="app">
    <router-view/>
  </div>
</template>

<script>
export default {
  name: 'App',
	// 'mounted：此时，组件已经出现在页面中，数据、真实dom都已经处理好了,事件都已经挂载好了
	mounted() {
  		const _this = this
        window.onresize = () => {
            return (() => {
                let clientWidth = document.documentElement.clientWidth || document.body.clientWidth;
      			let clientHeight = document.documentElement.clientHeight || document.body.clientHeight;

			   	let clientWh = {
			        clientWidth: clientWidth,
			        clientHeight: clientHeight
			    }

			    _this.$store.dispatch('changeClientWh', clientWh)
			                
			            })()
        }
}
}
</script>

<style>
body,html{margin: 0;padding: 0;}
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale; 
}
</style>
