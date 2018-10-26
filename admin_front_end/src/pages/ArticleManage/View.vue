<template>
	<div class="main">
		<div class="main-content search">
			<el-form :inline="true" :model="searchKeywords" ref="searchKeywords" :rules="searchRules" label-position="left" label-width="85px" size="small">
				<el-row>
					<el-col :span="6">
						<el-form-item label="文章ID" prop="articleId">
							<el-input type="number" v-model.number="searchKeywords.articleId" placeholder="请输入文章ID"></el-input>
						</el-form-item>
					</el-col>
					<el-col :span="6">
						<el-form-item label="文章名称" prop="articleName">
							<el-input type="text" v-model="searchKeywords.articleName" placeholder="请输入文章名称"></el-input>
						</el-form-item>
					</el-col>
					<el-col :span="6">
						<el-form-item label="状态" prop="status">
							<el-select v-model="searchKeywords.status" filterable placeholder="请选择分类状态">
						        <el-option
							      v-for="item in optionList.status"
							      :key="item.value"
							      :label="item.label"
							      :value="item.value">
							    </el-option>
						    </el-select>
						</el-form-item>
					</el-col>
					<!-- <el-col :span="6">
						<el-form-item label="文章类别" prop="typeName">
							<el-input type="text" v-model="searchKeywords.typeName" placeholder="请输入文章类别名称"></el-input>
						</el-form-item>
					</el-col>
					<el-col :span="6">
						<el-form-item label="分类名称" prop="classifyName">
							<el-input type="text" v-model="searchKeywords.classifyName" placeholder="请输入分类名称"></el-input>
						</el-form-item>
					</el-col> -->
				</el-row>
				<!-- <el-row>
					<el-col :span="6">
						<el-form-item label="标签名称" prop="tagName">
							<el-input type="text" v-model="searchKeywords.tagName" placeholder="请输入标签名称"></el-input>
						</el-form-item>
					</el-col>
					<el-col :span="6">
						<el-form-item label="状态" prop="status">
							<el-select v-model="searchKeywords.status" filterable placeholder="请选择分类状态">
						        <el-option
							      v-for="item in optionList.status"
							      :key="item.value"
							      :label="item.label"
							      :value="item.value">
							    </el-option>
						    </el-select>
						</el-form-item>
					</el-col>
				</el-row> -->
				<el-row>
					<el-form-item>
					    <el-button type="primary" @click="onSubmit('searchKeywords')">搜索</el-button>
					    <el-button @click="resetForm('searchKeywords')">重置</el-button>
					    <!-- <el-button icon="el-icon-question">帮助</el-button> -->
					</el-form-item>
				</el-row>
			</el-form>
		</div>

		<div class="hr-10"></div>

		<div class="main-content content">
			<el-row class="content-header">
				<el-button type="primary" size="small" @click="addHandle">新增文章</el-button>
			</el-row>

			<el-table :data="tableData" stripe border fit :class="{'table-fixed':tableFixed==true,'table-static':tableFixed==false}" id="table-wrap">
				<el-table-column label="操作" width="160" align="center">
			      <template slot-scope="scope">
			        <el-button type="text" size="small" @click="editHandle(scope.row.id)">编辑</el-button>
			        <el-button type="text" size="small" class="text-danger" @click="deleteHandle(scope.row.id)">删除</el-button>
			      </template>
			    </el-table-column>
			    <el-table-column prop="id" label="文章ID" align="center"> </el-table-column>
			    <el-table-column prop="title" label="文章名称" align="center"> </el-table-column>
			    <el-table-column prop="adminName" label="发布者" align="center"> </el-table-column>
			    <el-table-column prop="typeName" label="类别" align="center"> </el-table-column>
			    <el-table-column label="分类" align="center">
					<template slot-scope="scope">
				        <el-popover trigger="hover" placement="top">
				        	<div class="popover-center">{{scope.row.classifyName}}</div>
				        	<div slot="reference" class="name-wrapper">{{scope.row.classifyName}}</div>
				        </el-popover>
				    </template>
			    </el-table-column>
			    <el-table-column label="标签" align="center">
					<template slot-scope="scope">
				        <el-popover trigger="hover" placement="top">
				        	<div class="popover-center">{{scope.row.tagName}}</div>
				        	<div slot="reference" class="name-wrapper">{{scope.row.tagName}}</div>
				        </el-popover>
				    </template>
			    </el-table-column>
			    <el-table-column prop="createTime" label="创建时间" align="center"> </el-table-column>
			    <el-table-column prop="updateTime" label="更新时间" align="center"> </el-table-column>
			    <el-table-column prop="status" label="状态" align="center">
			      <template slot-scope="scope">
			      	<el-select class="state-select" :class="{'text-danger': scope.row.status==2}" v-model="scope.row.status" placeholder="请选择" @change="updateStatus(scope.row.id,scope.row.status)">
					    <el-option
					      v-for="item in statusOptions" 
					      :key="item.value"
					      :label="item.label"
					      :value="item.value">
					    </el-option>
					</el-select>
			      </template>
			    </el-table-column>
			</el-table>

			<el-pagination :current-page.sync="curPage" :page-sizes="[10, 20, 50]" :page-size="pageSize" layout="total, sizes, prev, pager, next, jumper" :total="pageTotal" @size-change="handleSizeChange" @current-change="handleCurrentChange" align="right"></el-pagination>

		</div>

		<add v-if="addShowFlag" ref="add" @addEvent="addTableData"></add>
		<edit v-if="editShowFlag" ref="edit" @editEvent="editTableData"></edit>

	</div>
</template>

<script type="text/ecmascript-6">
	import Add from './components/Add'
	import Edit from './components/Edit'
	import {articleQueryArticle, articleDeleteArticle, articleUpdateStatus} from "../../config/interface.js"
	export default {
        props: {
        },
        data() {
            return {
            	tableHeader: null,
				tableTop: 0,
				tableFixed: false,
		        winTop: 0,
		        leftNum: 0,
            	searchKeywords: {
            		articleId: null,
            		articleName: null,
            		typeName: null,
            		classifyName: null,
            		tagName: null,
            		status: null
            	},
				searchRules: {
				},
				pageNum: 1, // 请求第几页
				pageSize: 10, // 每页请求多少条
				pageTotal: 0, // 总共多少条数据
				curPage: 1, // 初始时在第几页
				tableData: [], // 列表数据
				addShowFlag: false,
				editShowFlag: false,
		        optionList: {
		        	status: [{ // 下拉框-状态
			          value: null,
			          label: '全部'
			        }, { // 下拉框-状态
			          value: 1,
			          label: '已发布'
			        }, {
			          value: 2,
			          label: '未发布'
			        }]
		        },
		        statusOptions: [{ // 下拉框-状态
		          value: 1,
		          label: '发布'
		        }, {
		          value: 2,
		          label: '草稿 '
		        }],
				queryFlag: { // 是否可发送请求
			    	article: true
			    },
			    loading: { // 是否显示loading
			    	table: false
			    }
            }
        },
		components: {
			Add,
			Edit
		},
		created() {
			this.init()
		},
		// 'mounted：此时，组件已经出现在页面中，数据、真实dom都已经处理好了,事件都已经挂载好了
		mounted() {
			/*滚动监控 start*/
			window.addEventListener('scroll', this.onScroll);

			this.tableHeader = document.getElementsByClassName('el-table__header-wrapper')[0];
	  		this.tableHeader.id = 'header-wrapper-first';

			let tableWrap = document.getElementById('table-wrap')
			this.tableTop = parseInt(this.getTop(tableWrap)-50);
			/*滚动监控 end*/
		},
		methods: {
			// 初始化
			init(){
				this.queryArticle()
			},
			queryArticle() {
				const url = articleQueryArticle;
				const _this = this;
				if(this.queryFlag.article == true){
            		this.queryFlag.article = false
            		this.loading.table = true
            		let params = {
            			pageNum: this.pageNum,
            			pageSize: this.pageSize,
            			articleId: this.searchKeywords.articleId,
            			articleName: this.searchKeywords.articleName,
            			status: this.searchKeywords.status
            		}
            		fetch(url,params)
					.then(res =>{
						if(res.code == 10000){
							let data=res.data

							let list = data.list
							let list_length = list.length

							
							if(list_length > 0){
								list.forEach(function(value,index){
									let classifyName = []
									let tagName = []
									
									// 分类
									let classify = list[index].classify
									let classify_length = classify.length
									if(classify_length > 0){
										classify.forEach(function(ele,idx){
											classifyName.push(ele.name)
										})
										list[index].classifyName = classifyName.toString()

									}
									
									// 标签
									let tag = list[index].tag
									let tag_length = tag.length
									tag.forEach(function(ele,idx){
										tagName.push(ele.name)
									})
									list[index].tagName = tagName.toString()
								})

								
								
							}


							_this.tableData = data.list
							_this.pageTotal = data.count

							_this.queryFlag.article = true
							_this.loading.table = false
						}
					})
				}
			},
			// 改变pageSize
			handleSizeChange(val){
				this.pageSize = val;
				this.queryArticle()
			},
			// 改变pageNum
			handleCurrentChange(val) {
				this.pageNum = val;
		    	this.queryArticle()
		  	},
		  	// 新增
		  	addHandle() {
		  		this.addShowFlag = true
		    	this.$nextTick(() => {
		    		this.$refs.add.init();
		    	})
		  	},
		  	addTableData() {
		  		this.pageNum = 1;
		    	this.resetForm('searchKeywords');
		    	this.queryArticle()
		    	this.curPage = 1
		  	},
		  	deleteHandle(articleId) {
		  		const url = articleDeleteArticle;
				const _this = this
				let params = {
					articleId: articleId
				}
				fetch(url,params)
				.then(res =>{
					if(res.code == 10000){
						let data=res.data
						this.queryArticle()
						bs.toast('删除成功','success',false)
					}
				})		  		
		  	},
		  	editHandle(articleId) {
		  		this.editShowFlag = true
		    	this.$nextTick(() => {
		    		this.$refs.edit.init(articleId);
		    	})
		  	},
		  	updateStatus(articleId, status) {
		  		const url = articleUpdateStatus;
				const _this = this
				let params = {
					articleId: articleId,
					status: status
				}
				fetch(url,params)
				.then(res =>{
					if(res.code == 10000){
						let data=res.data
						this.queryArticle()
						bs.toast('修改状态成功','success',false)
					}
				})
		  	},
		  	editTableData() {
		  		this.queryArticle()
		  	},
			// 搜索查询
		    onSubmit(searchKeywords){
				this.pageNum = 1
				this.queryArticle()
				this.curPage = 1
		    },
	    	// 重置
	    	resetForm(formName) {
	    		this.$refs[formName].resetFields()
	    		this.pageNum = 1
				this.queryArticle()
				this.curPage = 1
		    },
			/*滚动监控 start*/
		    onScroll(){
		    	this.showTop()
		    	this.scrollLeft()
		    },
		    getTop(e){
		    	let offsetTop=e.offsetTop;
			    if(e.offsetParent!=null) offsetTop += this.getTop(e.offsetParent);
			    return offsetTop;
		    },
		    showTop(){
	  		  let scrollTop = document.documentElement.scrollTop || window.pageYOffset || document.body.scrollTop;
	  		  this.winTop = scrollTop;
	    		if(this.winTop > this.tableTop){
	    			this.tableFixed = true;
	    		}else{
	    			this.tableFixed = false;
	    		}
	    	},
	    	scrollLeft(){
	    		let scrollLeft = document.documentElement.scrollLeft;
	  		  	let subtract = parseInt(1440-window.innerWidth-12);
	  		  	if(this.winTop > this.tableTop){
	  		  		if(scrollLeft > 0){
	  		  			this.tableHeader.style.right = (scrollLeft-subtract)+'px';
	  		  		}else{
	  		  			this.tableHeader.style.right ='auto';
	  		  		}
	  		  	} 	

	    	}
	    	/*滚动监控 end*/
		}
    }
</script>


<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" rel="stylesheet/scss">

</style>