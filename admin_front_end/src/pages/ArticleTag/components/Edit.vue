<template>
	<el-dialog class="dialog-wrap" title="新增分类" :visible.sync="showFlag">
		<el-form :model="formDatas" :rules="formRules" ref="formDatas" size="small" :label-width="formLabelWidth">
			<el-form-item label="分类名称：" prop="name">
			    <el-input type="text" v-model="formDatas.name"></el-input>
			</el-form-item>
			<el-form-item label="分类描述：" prop="desc">
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
	import {tagEditTag, tagUpdateTag} from "../../../config/interface.js"
	export default {
        props: {
        },
        data() {
            return {
            	formLabelWidth: '120px',
            	showFlag: false,
		        formDatas: {
		        	id: 0,
		        	name: '',
		        	desc: '',
		        	status: null
		        },
		        formRules: {
		        	name: [
						{ required: true, message: '请填写分类名称', trigger: 'blur' }
					]
		        }
            }
        },
		methods: {
			// 初始化
			init(tagId) {
				this.formDatas.id = tagId
				this.$nextTick(() => {
					this.editClassify()
				})
				this.changeShowFlag()
			},
			// 对话框是否显示
			changeShowFlag() {
				this.showFlag = !this.showFlag
			},
			editClassify() {
				const url = tagEditTag
	            const _this = this
				let params = {
					tagId: this.formDatas.id
				}
				fetch(url,params)
				.then(res =>{
					if(res.code == 10000){
						let data=res.data
						this.formDatas = {
				        	id: data.id,
				        	name: data.name,
				        	desc: data.desc,
				        	status: data.status
				        }
					}
				})
			},
			onSubmit(formDatas){
				this.$refs[formDatas].validate((valid) => {
					if (valid) {
						const url = tagUpdateTag
			            const _this = this
			            let params = {
			            	tagId: this.formDatas.id,
			            	name: this.formDatas.name,
			            	desc: this.formDatas.desc,
			            	status: this.formDatas.status
			            }
			            fetch(url,params)
						.then(res =>{
							if(res.code == 10000){
								bs.toast('编辑成功','success',false)
								_this.changeShowFlag()
								_this.$refs['formDatas'].resetFields()
								_this.$emit('editEvent')
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