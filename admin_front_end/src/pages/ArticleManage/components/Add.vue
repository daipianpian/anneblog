<template>
	<el-dialog class="dialog-wrap medium-dialog article-dialog" title="新增文章" :visible.sync="showFlag">
		<el-form :model="formDatas" :rules="formRules" ref="formDatas" size="small" :label-width="formLabelWidth">
			<el-form-item label="文章名称：" prop="title">
			    <el-input type="text" v-model="formDatas.title"></el-input>
			</el-form-item>
			<el-form-item label="文章内容：" prop="content">
			    <quill-editor class="quill" :options="editorOption" ref="QuillEditor" v-model="formDatas.content">
			        </quill-editor>
			</el-form-item>
			
			<el-form-item label="类别：" prop="typeId">
			    <el-select v-model="formDatas.typeId" placeholder="请选择">
				    <el-option
				      v-for="item in optionList.type" 
				      :key="item.value"
				      :label="item.label"
				      :value="item.value">
				    </el-option>
				</el-select>
			</el-form-item>
			<el-form-item label="分类：" prop="classifyId">
			    <el-checkbox :indeterminate="isIndeterminate" v-model="checkAll" @change="handleCheckAllChange">全选</el-checkbox>
				<el-checkbox-group v-model="formDatas.classifyId" @change="handleClassifyChange">
				    <el-checkbox v-for="item in optionList.classify" :label="item.value" :key="item.value">{{item.label}}</el-checkbox>
				</el-checkbox-group>
			</el-form-item>
			<el-form-item label="标签：" prop="tagId">
			    <el-select v-model="formDatas.tagId" multiple filterable allow-create default-first-option placeholder="请选择">
				    <el-option
				      v-for="item in optionList.tag" 
				      :key="item.value"
				      :label="item.label"
				      :value="item.value">
				    </el-option>
				</el-select>
			</el-form-item>
			<el-form-item label="状态：" prop="status">
			    <el-radio-group v-model="formDatas.status">
			      <el-radio v-for="item in optionList.status" :label="item.value" :key="item.value">{{item.label}}</el-radio>
			    </el-radio-group>
			</el-form-item>
		</el-form>

		<div slot="footer" class="dialog-footer">
		    <el-button type="primary" size="small" @click="onSubmit('formDatas')">保 存</el-button>
		    <el-button size="small" @click="onCancel">取 消</el-button>
		</div>

		<el-upload
			class="quill-editor-uploader-img"
			id="uploader-img"
    		ref="upload"
		  	:action="upLoad.actionUrl"
		  	:headers="upLoad.headers"
		  	:data="upLoad.upLoadData"
		  	accept="image/png, image/gif, image/jpg, image/jpeg"
		  	name="fileName"
		  	:show-file-list="false"
		  	:on-success="handleUploadSuccess"
		  	:on-remove="handleRemove"
		  	:on-error="handleError">
			  	<el-button size="small" type="primary">点击上传</el-button>
		</el-upload>

	</el-dialog>
</template>

<script type="text/ecmascript-6">
	import {articleAddArticle, typeQueryType, classifyQueryClassify, tagQueryTag, commonUpload} from "../../../config/interface.js"
	export default {
        props: {
        },
        data() {
        	// 工具栏配置
			const toolbarOptions = [
				  ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
				  ['blockquote', 'code-block'],
				  [{'header': 1}, {'header': 2}],               // custom button values
				  [{'list': 'ordered'}, {'list': 'bullet'}],
				  [{'script': 'sub'}, {'script': 'super'}],      // superscript/subscript
				  [{'indent': '-1'}, {'indent': '+1'}],          // outdent/indent
				  [{'direction': 'rtl'}],                         // text direction

				  [{'size': ['small', false, 'large', 'huge']}],  // custom dropdown
				  [{'header': [1, 2, 3, 4, 5, 6, false]}],
				  [{'color': []}, {'background': []}],          // dropdown with defaults from theme
				  [{'font': []}],
				  [{'align': []}],
				  ['link', 'image'],
				  ['clean']                                         // remove formatting button
			];
            return {
            	formLabelWidth: '120px',
            	showFlag: false,
		        formDatas: {
		        	title: null,
		        	content: null,
		        	typeId: null,
		        	classifyId: [],
		        	tagId: [],
		        	status: 1
		        },
		        formRules: {
		        	title: [
						{ required: true, message: '请填写文章标题', trigger: 'blur' }
					],
		        	typeId: [
						{ required: true, message: '请选择类别', trigger: 'blur' }
					],
					classifyId: [
						{ required: true, message: '请选择分类', trigger: 'blur' }
					],
					status: [
						{ required: true, message: '请选择状态', trigger: 'blur' }
					]
		        },
		        editorOption: {
					placeholder: '',
					theme: 'snow',  // or 'bubble'
					modules: {
						toolbar: {
							container: toolbarOptions,  // 工具栏
							handlers: {
								'image': function (value) {
									if (value) {
										document.querySelector('#uploader-img input').click()
									} else {
										this.quill.format('image', false);
									}
								}
							}
						}
					}
			    },
			    optionList: {
			    	type: [],
					classify: [],
					tag: [],
					status: [{
						value: 1,
						label: '立即发布'
					},{
						value: 2,
						label: '保存草稿'
					}]
			    },
		        checkAll: false,
		        classifyList: [],
        		isIndeterminate: false,
        		pagination: {
        			type: {
        				pageNum: 1,
        				pageSize: 10
        			},
        			cassify: {
        				pageNum: 1,
        				pageSize: 10
        			},
        			tag: {
        				pageNum: 1,
        				pageSize: 10
        			}
        		},
        		upLoad: {
		        	actionUrl: baseURL+commonUpload,
			        headers: {
			        	userToken: this.$store.state.token
			        },
		        	upLoadData: {
			        	catalog: 0,
			        	adminId: this.$store.state.adminId
			        }
		        }
            }
        },
		methods: {
			// 初始化
			init() {
				this.$nextTick(() => {
					this.queryType()
					this.queryClassify()
					this.queryTag()
				})
				this.changeShowFlag()
			},
			// 查询类别
			queryType() {
				const url = typeQueryType;
				const _this = this;
				let params = {
        			pageNum: this.pagination.type.pageNum,
        			pageSize: this.pagination.type.pageSize,
        			typeId: null,
        			typeName: null,
        			status: 1
        		}
        		fetch(url,params)
				.then(res =>{
					if(res.code == 10000){
						let data=res.data

						let list = data.list
						let list_length = list.length
						if(list_length > 0){
							let typeList = []
							list.forEach(function(value,index){
								let obj = {}
								obj.value = value.id
								obj.label = value.name
								typeList.push(obj)
							})
							_this.optionList.type = typeList
						}else{
							_this.optionList.type = []
						}
					}
				})
			},
			// 查询分类
			queryClassify() {
				const url = classifyQueryClassify;
				const _this = this;

        		let params = {
        			pageNum: this.pagination.cassify.pageNum,
        			pageSize: this.pagination.cassify.pageSize,
        			classifyId: null,
        			classifyName: null,
        			status: 1
        		}
        		fetch(url,params)
				.then(res =>{
					if(res.code == 10000){
						let data=res.data

						let list = data.list
						let list_length = list.length
						if(list_length > 0){
							let classifyList = []
							list.forEach(function(value,index){
								let obj = {}
								obj.value = value.id
								obj.label = value.name
								classifyList.push(obj)
								_this.classifyList.push(obj.value)
							})
							_this.optionList.classify = classifyList
						}else{
							_this.optionList.classify = []
						}
					}
				})
			},
			// 查询标签
			queryTag() {
				const url = tagQueryTag;
				const _this = this;

        		let params = {
        			pageNum: this.pagination.tag.pageNum,
        			pageSize: this.pagination.tag.pageSize,
        			tagId: null,
        			tagName: null,
        			status: 1
        		}
        		fetch(url,params)
				.then(res =>{
					if(res.code == 10000){
						let data=res.data

						let list = data.list
						let list_length = list.length
						if(list_length > 0){
							let tagList = []
							list.forEach(function(value,index){
								let obj = {}
								obj.value = value.id
								obj.label = value.name
								tagList.push(obj)
							})
							_this.optionList.tag = tagList
						}else{
							_this.optionList.tag = []
						}
					}
				})
			},
			// 对话框是否显示
			changeShowFlag() {
				this.showFlag = !this.showFlag
			},
			handleCheckAllChange(val) {
				this.formDatas.classifyId = val ? this.classifyList : [];
				this.isIndeterminate = false;
			},
			handleClassifyChange(value) {
				let checkedCount = value.length;
				this.checkAll = checkedCount === this.classifyList.length;
				this.isIndeterminate = checkedCount > 0 && checkedCount < this.classifyList.length;
			},
			// 上传图片成功
		    handleUploadSuccess(response, file, fileList){
		    	/*console.log('response='+JSON.stringify(response))*/
		    	let quill = this.$refs.QuillEditor.quill
		    	if(response.code == 10000){
		    		// 获取富文本组件实例
                	
			    	let image = response.data;
			    	/*this.formDatas.icoPath = [];
			    	this.formDatas.icoPath.push({url:response.data})*/
			    	// 获取光标所在位置
                    let length = quill.getSelection().index;
                    // 插入图片  res.info为服务器返回的图片地址
                    quill.insertEmbed(length, 'image', image)
                    // 调整光标到最后
                    quill.setSelection(length + 1)
			    }else{
			    	if(response.code == 20100){
				    	router.replace({
					        path: '/'
					    });
				    }else{
				    	bs.toast(response.message,'error',false)
				    }
			    }
		    },
		    // 删除已上传的图片
			handleRemove(file, fileList) {
		        // console.log(file, fileList);
		    },
		    //上传图片发生错误
		    handleError(file,fileList){
		    	this.$message.error('上传失败请重新上传');
		    },
			onSubmit(formDatas){
				console.log('this.formDatas='+JSON.stringify(this.formDatas));
				this.$refs[formDatas].validate((valid) => {
					if (valid) {
						const url = articleAddArticle
			            const _this = this
			            let params = {
			            	title: this.formDatas.title,
				        	content: this.formDatas.content,
				        	typeId: this.formDatas.typeId,
				        	tagId: this.formDatas.tagId,
				        	classifyId: this.formDatas.classifyId,
				        	status: this.formDatas.status
			            }
			            fetch(url,params)
						.then(res =>{
							if(res.code == 10000){
								bs.toast('添加成功','success',false)
								_this.changeShowFlag()
								_this.$refs['formDatas'].resetFields()
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