<template>
	<el-dialog class="dialog-wrap" title="新增类别" :visible.sync="showFlag">
		<el-form :model="formDatas" :rules="formRules" ref="formDatas" size="small" :label-width="formLabelWidth">
			<el-form-item label="类别名称：" prop="name">
			    <el-input type="text" v-model="formDatas.name"></el-input>
			</el-form-item>
			<el-form-item label="类别描述：" prop="desc">
			    <el-input type="textarea" v-model="formDatas.desc"></el-input>
			</el-form-item>
			<!-- <el-form-item label="状态：" prop="status">
			    <el-radio-group v-model="formDatas.status">
			      <el-radio :label="1">启用</el-radio>
			      <el-radio :label="0">禁用</el-radio>
			    </el-radio-group>
			</el-form-item> -->
		</el-form>

		<div slot="footer" class="dialog-footer">
		    <el-button type="primary" size="small" @click="onSubmit('formDatas')">保 存</el-button>
		    <el-button size="small" @click="onCancel">取 消</el-button>
		</div>

	</el-dialog>
</template>

<script type="text/ecmascript-6">
	import {typeAddType} from "../../../config/interface.js"
	export default {
        props: {
        },
        data() {
            return {
            	formLabelWidth: '120px',
            	showFlag: false,
		        formDatas: {
		        	name: '',
		        	desc: '',
		        	status: 1
		        },
		        formRules: {
		        	name: [
						{ required: true, message: '请填写类别名称', trigger: 'blur' }
					]
		        }
            }
        },
		methods: {
			// 初始化
			init() {
				this.$nextTick(() => {
					
				})
				this.changeShowFlag()
			},
			// 对话框是否显示
			changeShowFlag() {
				this.showFlag = !this.showFlag
			},
			onSubmit(formDatas){
				this.$refs[formDatas].validate((valid) => {
					if (valid) {
						const url = typeAddType
			            const _this = this
			            let params = {
			            	name: this.formDatas.name,
			            	desc: this.formDatas.desc,
			            	status: this.formDatas.status
			            }
			            fetch(url,params)
						.then(res =>{
							if(res.code == 10000){
								bs.toast('添加成功','success',false)
								_this.changeShowFlag()
								_this.$refs['formDatas'].resetFields();
								_this.$emit('addEvent')
							}
						})
					} else {
						bs.toast('信息填写有误！','error',false)
						return false;
					}
		      	})
			},
			// 取消
			onCancel() {
				this.changeShowFlag()
				this.$refs['formDatas'].resetFields();
			}
		}
    }
</script>


<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" rel="stylesheet/scss">

</style>