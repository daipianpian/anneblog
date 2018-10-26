
import { Message } from 'element-ui';



const commonFn={
	//消息提示
	toast(str,type,showClose,onCloseFn){
		let time=1000;
		if(showClose){
			time=3000;
		}
		Message({
			showClose:showClose,
			message:str,
			type:type,
			duration:time,
			onClose:onCloseFn

		})
	},
	// 刷新当前页面
	shallowRefresh(name) {
	    router.replace({ path: '/refresh', query: { name: name }})
	},
	// 弹框
	msgBox(type, title, message){
	    switch (type) {
	      case 'alert':
	        bus.$alert(message,title,{dangerouslyUseHTMLString: true})
	        	.then(() => {
	        		// 点击确定
	        	})
          		.catch(action => {
          			// 点击取消
          		});;
	        break
	    }
	},
	//图片加载失败
	imgError(type,event){
		if(type==1){
			event.target.src=require("../images/default_one.png");
		}else if(type==2){
			event.target.src=require("../images/userAvatar@2x.png");
		}
		event.srcElement.onerror = null; //控制不要一直跳动
	},
	/*相加运算，避免数据相除小数点后产生多位数和计算精度损失。*/
	andNumber(arg1, arg2){
		return ((arg1*1000)+(arg2*1000))/1000;//防止丢失精度
	},
	/* 减运算，避免数据相除小数点后产生多位数和计算精度损失。*/
	subtractNumber(arg1, arg2){
		return (arg1*1000-arg2*1000)/1000;//防止丢失精度
	},
	/* 乘运算，避免数据相除小数点后产生多位数和计算精度损失。*/
	subNumber(arg1, arg2){
		return (arg1*1000)*(arg2*1000)/1000000;//防止丢失精度
	},
	/* 除运算，避免数据相除小数点后产生多位数和计算精度损失。*/
	divideNumber(arg1, arg2){
		return ((arg1*1000)/(arg2*1000));//防止丢失精度
	}

}


export default commonFn