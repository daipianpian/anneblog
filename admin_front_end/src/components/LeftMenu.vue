<template>
	<el-menu class="aside left-menu"
      :default-active="$route.path" :router="true" :style="{height: clientHeight+'px'}">
      <el-menu-item  v-for="(item, index) in  menu" :index="item.url"  :key="index"  @click="handleMenuSelect(item.url)">
        <i :class="item.icon"></i>
        <span slot="title">{{item.name}}</span>
      </el-menu-item>
    </el-menu>
</template>

<script type="text/ecmascript-6">
	export default {
		data() {
			return {
        menu: [
          {
            url: '/home/article/manage',
            icon: 'el-icon-document',
            name: '文章管理'
          },
          {
            url: '/home/article/type',
            icon: 'el-icon-bell',
            name: '文章类别'
          },
          {
            url: '/home/article/classify',
            icon: 'el-icon-menu',
            name: '分类管理'
          },
          {
            url: '/home/article/tag',
            icon: 'el-icon-star-off',
            name: '标签管理'
          }
        ]
			}
		},
		computed: {
			clientHeight: function() {
				return parseInt(this.$store.state.clientHeight-60)
			}
		},
    methods: {
      handleMenuSelect(path) {
        if (path != this.$route.path) {
          this.$router.push(path)
        }else{
          bs.shallowRefresh(this.$route.name)
        }
      }
    }
	}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" rel="stylesheet/scss">
.left-menu{position:fixed; width: 210px; left: 0;top: 60px;z-index: 100;
  .el-menu-item{padding: 0 20px !important;font-size: 16px;text-align: center;}
}


</style>