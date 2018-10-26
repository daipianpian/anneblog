<template>
	<el-row class="header">
		<el-col :span="4" class="cms-name">
			Anne博客管理系统
		</el-col>
		<el-col :span="3" :offset="17">
			<el-dropdown class="admin" @command="handleCommand">
				<el-button type="primary">
					<i class="fa fa-user-o" aria-hidden="false"></i> Anne
				</el-button>
			  <el-dropdown-menu class="admin" slot="dropdown">
			    <el-dropdown-item command="2"><i class="fa fa-lock" aria-hidden="true"></i> 退出</el-dropdown-item>
			  </el-dropdown-menu>
			</el-dropdown>
		</el-col>
	</el-row>
</template>

<script type="text/ecmascript-6">
	import {loginOut} from "../config/interface.js"
	export default {
		data() {
			return {

			}
		},
		methods: {
			handleCommand(command) {
				if(command == 2){ //退出注销 
					this.LoginOut()
				}
			},
			LoginOut() {
				/*console.log('清除缓存');*/
				const url = loginOut;
                const _this = this;
                let params = {}
				fetch(url,params)
                .then(res =>{
                    if(res.code == 10000){
                    	localStorage.clear();
						this.$store.dispatch('storageAdminInfo','')
						return this.$router.replace('/');
                    }
                })
			}
		}
	}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" rel="stylesheet/scss">
	.header{
		position:fixed;width:100%;height: 60px;line-height: 60px;top:0;left:0;background: #fff;color: #c0ccda;border-bottom: 1px solid #dcdfe6;z-index: 1000;
		.cms-name{text-align: center;color:#409eff}
	}
</style>
