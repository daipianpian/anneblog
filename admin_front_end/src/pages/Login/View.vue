<template>
    <div class="login-page-wrap" :style="{width: clientWidth+'px', height: clientHeight+'px'}">
        <div class="login-page-container">
            <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-position="left" label-width="0px" class="demo-ruleForm login-container">
                <h3 class="title">系统登录</h3>
                <el-form-item prop="account">
                    <el-input type="text" v-model="ruleForm.account" auto-complete="off" placeholder="账号"></el-input>
                </el-form-item>
                <el-form-item prop="checkPass">
                    <el-input type="password" v-model="ruleForm.checkPass" auto-complete="off" placeholder="密码"></el-input>
                </el-form-item>
                <!-- <el-checkbox v-model="checked" checked class="remember">记住密码</el-checkbox> -->
                <el-form-item style="width:100%;">
                    <el-button type="primary" style="width:100%;" @click="handleLogin" :loading="logining">登录</el-button>
                </el-form-item>
            </el-form>
        </div>
    </div>
</template>

<script type="text/ecmascript-6">
    import {login} from "../../config/interface.js"
    export default {
        props: {
        },
        data() {
            return {
                logining: false,
                ruleForm: {
                    account: '',
                    checkPass: ''
                },
                rules: {
                    account: [{
                            required: true,
                            message: '请输入账号',
                            trigger: 'blur'
                        },
                        //{ validator: validaePass }
                    ],
                    checkPass: [{
                            required: true,
                            message: '请输入密码',
                            trigger: 'blur'
                        },
                        //{ validator: validaePass2 }
                    ]
                },
                checked: true
            };
        },
        computed: {
            clientWidth: function() {
                return this.$store.state.clientWidth
            },
            clientHeight: function() {
                return this.$store.state.clientHeight
            }
        },
        methods: {
            handleLogin(ev) {
                const url = login;
                const _this = this;
                _this.$refs.ruleForm.validate((valid) => {
                    if (valid) {
                        _this.logining = true;
                        let params = {
                            name: this.ruleForm.account,
                            password: this.ruleForm.checkPass
                        };
                        fetch(url,params)
                        .then(res =>{
                            if(res.code == 10000){
                                console.log('res.data='+JSON.stringify(res.data))

                                let data = res.data
                                localStorage.setItem("adminId", data.id);
                                localStorage.setItem("token", data.token);
                                localStorage.setItem('adminInfo',JSON.stringify(data))
                                this.$store.dispatch('storageAdminInfo',data)

                                return router.push('/home/article/manage')
                            }
                        })
                        
                    } else {
                        _this.logining = false;
                        _this.$message({
                            message: '登陆失败',
                            type: 'error',
                            duration: 1000
                        });
                        console.log('error submit!!');
                        return false;
                    }
                });
            }
        }
    }
</script>


<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped rel="stylesheet/scss">
    .login-page-wrap{
        position: relative;
        min-width:1440px;
        background-image:url('../../assets/images/login/login_bg.png');
        background-size: 100% 100%;
        .login-page-container{position:absolute;width:100%;height:100%;left:0;top:0;}
    }
    .login-container {
        -webkit-border-radius: 5px;
        border-radius: 5px;
        -moz-border-radius: 5px;
        background-clip: padding-box;
       margin: 280px auto;
        width: 350px;
        padding: 35px 35px 15px;
        background: #fff;
        border: 1px solid #eaeaea;
        box-shadow: 0 0 25px #cac6c6;
    }
    .login-container h3{text-align: center;}
    label.el-checkbox.remember {margin: 0px 0px 35px 0px;}
</style>