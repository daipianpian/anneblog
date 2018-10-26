<template>
	<div class="main">
		<div class="main-content search">
			<el-form :inline="true" :model="searchKeywords" ref="searchKeywords" :rules="searchRules" label-position="left" label-width="85px" size="small">
				<el-row>
					<el-col :span="6">
						<el-form-item label="类别ID" prop="typeId">
							<el-input type="number" v-model.number="searchKeywords.typeId" placeholder="请输入类别ID"></el-input>
						</el-form-item>
					</el-col>
					<el-col :span="6">
						<el-form-item label="类别名称" prop="typeName">
							<el-input type="text" v-model.number="searchKeywords.typeName" placeholder="请输入类别名称"></el-input>
						</el-form-item>
					</el-col>
				</el-row>
				<el-row>
					<el-form-item>
					    <el-button type="primary" @click="onSubmit('searchKeywords')">搜索</el-button>
					    <el-button  @click="resetForm('searchKeywords')">重置</el-button>
					</el-form-item>
				</el-row>
			</el-form>
		</div>

		<div class="hr-10"></div>

		<div class="main-content content">
			<el-row class="content-header">
				<el-button type="primary" size="small" @click="addHandle">新增类别</el-button>
			</el-row>

			<el-table v-loading="loading.table" :data="tableData" stripe border fit :class="{'table-fixed':tableFixed==true,'table-static':tableFixed==false}" id="table-wrap">
				<el-table-column label="操作" width="160" align="center">
			      <template slot-scope="scope">
			        <el-button type="text" size="small" @click="editHandle(scope.row.id)">编辑</el-button>
			        <el-button type="text" size="small" class="text-danger" @click="deleteHandle(scope.row.id)">删除</el-button>
			      </template>
			    </el-table-column>
			    <el-table-column prop="id" label="类别ID" align="center"> </el-table-column>
			    <el-table-column prop="name" label="类别名称" align="center"> </el-table-column>
			    <el-table-column prop="desc" label="类别描述" align="center"> </el-table-column>
			    <el-table-column prop="adminName" label="创建者" align="center"> </el-table-column>
			    <el-table-column prop="createTime" label="创建时间" align="center"> </el-table-column>
			    <el-table-column prop="updateTime" label="更新时间" align="center"> </el-table-column>
			    <!-- <el-table-column prop="status" label="状态" align="center"> </el-table-column> -->
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
	import {typeQueryType, typeDeleteType, typeUpdateStatus} from "../../config/interface.js"
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
            		typeId: null,
            		typeName: null,
            		status: 1
            	},
				searchRules: {
				},
				optionList: {
					status: [{ // 下拉框-状态
			          value: null,
			          label: '全部'
			        },{
			          value: 1,
			          label: '启用'
			        }, {
			          value: 0,
			          label: '禁用'
			        }]
				},
				pageNum: 1, // 请求第几页
				pageSize: 10, // 每页请求多少条
				pageTotal: 0, // 总共多少条数据
				curPage: 1, // 初始时在第几页
				tableData: [], // 列表数据
				addShowFlag: false,
				editShowFlag: false,
				statusOptions: [{ // 下拉框-状态
		          value: 1,
		          label: '启用'
		        }, {
		          value: 0,
		          label: '禁用'
		        }],
				queryFlag: { // 是否可发送请求
			    	type: true
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
				this.queryType()
			},
			queryType() {
				const url = typeQueryType;
				const _this = this;
				if(this.queryFlag.type == true){
            		this.queryFlag.type = false
            		this.loading.table = true
            		let params = {
            			pageNum: this.pageNum,
            			pageSize: this.pageSize,
            			typeId: this.searchKeywords.typeId,
            			typeName: this.searchKeywords.typeName,
            			status: this.searchKeywords.status
            		}
            		fetch(url,params)
					.then(res =>{
						if(res.code == 10000){
							let data=res.data

							let list = data.list

							_this.tableData = data.list
							_this.pageTotal = data.count

							_this.queryFlag.type = true
							_this.loading.table = false
						}
					})
				}

			},
			// 改变pageSize
			handleSizeChange(val){
				this.pageSize = val;
				this.init();
			},
			// 改变pageNum
			handleCurrentChange(val) {
				this.pageNum = val;
		    	this.init();
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
		    	this.queryType()
		    	this.curPage = 1
		  	},
		  	deleteHandle(typeId) {
		  		const url = typeDeleteType;
				const _this = this
				let params = {
					typeId: typeId
				}
				fetch(url,params)
				.then(res =>{
					if(res.code == 10000){
						let data=res.data
						this.queryType()
						bs.toast('删除成功','success',false)
					}
				})		  		
		  	},
		  	editHandle(typeId) {
		  		this.editShowFlag = true
		    	this.$nextTick(() => {
		    		this.$refs.edit.init(typeId);
		    	})
		  	},
		  	updateStatus(typeId, status) {
		  		const url = typeUpdateStatus;
				const _this = this
				let params = {
					typeId: typeId,
					status: status
				}
				fetch(url,params)
				.then(res =>{
					if(res.code == 10000){
						let data=res.data
						this.queryType()
						bs.toast('修改状态成功','success',false)
					}
				})
		  	},
		  	editTableData() {
		  		this.queryType()
		  	},
			// 搜索查询
		    onSubmit(searchKeywords){
				this.pageNum = 1
				this.queryType()
				this.curPage = 1
		    },
	    	// 重置
	    	resetForm(formName) {
	    		this.$refs[formName].resetFields()
	    		this.pageNum = 1
				this.queryType()
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