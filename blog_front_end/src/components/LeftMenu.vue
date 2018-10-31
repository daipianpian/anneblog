<template>
  <div class="left-menu hidden-md-and-down" :style="{height: clientHeight+'px'}">

    <div class="left-menu-box">
      <div class="admin-wrap">
        <div class="admin-avatar"><img src="../assets/images/userAvatar@2x.png" alt=""></div>
        <div class="admin-info">一片天空</div>
      </div>
    	<el-menu class="aside"
          :default-active="$route.path" :router="true">
        <el-menu-item  v-for="(item, index) in  menu" :index="item.url"  :key="index"  @click="handleMenuSelect(item.url)">
          <i :class="item.icon"></i>
          <span slot="title">{{item.name}}</span>
        </el-menu-item>
      </el-menu>
    </div>


  </div>
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
				return this.$store.state.clientHeight
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
.left-menu{width: 12em;}
.left-menu-box{
  position:fixed; width: 12em; height:100%; left: 0;z-index: 100;
  background-color: #5f6d7e;
  color: #fff;
  .admin-wrap{
   
    .admin-avatar{
       width:60%;height:auto; margin: 20px auto; border: 1px solid white; border-radius: 50%;overflow: hidden;
       img{width:100%;}
    }
    .admin-info{text-align: center; @include font-size(title);margin-bottom: 40px;}

  }
  .el-menu{width:100%; background-color: #5f6d7e;
    .el-menu-item{padding: 0 20px !important;color: #fff; @include font-size(menu);text-align: center;
      i{color: #fff;}
    }
  }
}
</style>