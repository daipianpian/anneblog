<template>
  <div class="left-menu hidden-md-and-down" :style="{height: clientHeight+'px'}">

    <div class="left-menu-box">
      <div class="admin-wrap">
        <div class="admin-avatar"><img src="../assets/images/userAvatar@2x.png" alt=""></div>
        <div class="admin-info">一片天空</div>
      </div>
    	<!-- <el-menu class="aside"
                :default-active="$route.path" :router="true">
              <el-menu-item  v-for="(item, index) in  menu" :index="item.url"  :key="index"  @click="handleMenuSelect(item.url)">
                <span slot="title">{{item.name}}</span>
              </el-menu-item>
            </el-menu> -->
      <ul class="aside el-menu">
        <li class="el-menu-item is-active"><a href="/">首页</a></li>
        <li class="el-menu-item"><a href="http://blog.admin.daipianpian.com/">管理</a></li>
      </ul>
    </div>


  </div>
</template>

<script type="text/ecmascript-6">
	export default {
		data() {
			return {
        menu: this.$store.state.menu
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
       width:55%;height:auto; margin: 20px auto; border: 1px solid white; border-radius: 50%;overflow: hidden;
       img{width:100%;}
    }
    .admin-info{text-align: center; @include font-size(title);margin-bottom: 40px;}

  }
  .el-menu{
    .el-menu-item{text-align: center;}
  }
}
</style>