import axios from 'axios'
import qs from 'qs'
import store from '../store/index.js'
import router from '../router/index.js'

axios.defaults.timeout = 10000;
axios.defaults.baseURL = 'http://blog.api.daipianpian.com/admin';

export const baseURL = axios.defaults.baseURL

axios.interceptors.request.use((config)=>{
	if (config.method === 'post') {
	    config.headers['Content-Type'] = 'application/json';

      // console.log('token='+store.state.token);

        config.headers['userToken'] = store.state.token
        config.data = JSON.stringify(config.data);
        return config;
		}	
	},(error) => {
		var str = "输入有误，请核对";
		bs.toast(str,'error', false);
		return;
	}
)

axios.interceptors.response.use(response => {
    let code = response.data.code;
    if(code && typeof(code) != 'undefined'){
    	if(code == 20100){
          router.replace({
              path: '/'
          });
      }else if(code != 20100 && code != 10000){
        bs.toast(response.data.message,'error', false);
      }
    }
    /*console.log(response)*/
    return response;
}, err => {
    if (err && err.response) {
      switch (err.response.status) {
        case 400:
          err.message = '错误请求'
          bs.toast(err.message,'error', false);
          break;
        case 403:
          err.message = '拒绝访问'
          bs.toast(err.message,'error', false);
          break;
        case 404:
          err.message = '请求错误,未找到该资源'
          bs.toast(err.message,'error', false);
          break;
        case 405:
          err.message = '请求方法未允许'
          bs.toast(err.message,'error', false);
          break;
        case 408:
          err.message = '请求超时';
          bs.toast(err.message,'error', false);
          break;
        case 502:
          err.message = '网络错误';
          bs.toast(err.message,'error', false);
          break;
        case 504:
          err.message = '网络超时';
          bs.toast(err.message,'error', false);
          break;
        default:
          err.message = '连接错误${err.response.status}'
          bs.toast(err.message,'error', false);
      }
    } else {
      err.message = "连接到服务器失败"
      bs.toast(err.message,'error', false);
    }
     return Promise.resolve(err.response)
})

export function fetch(url, params, responseType) {
    return new Promise((resolve, reject) => {
      /*let adminId = localStorage.getItem('adminId')*/
      let adminId = store.state.adminId
      if(adminId && adminId>0){
        params.adminId = adminId;
      }else{
        params.adminId = 0;
      }

      if(!responseType || typeof(responseType) == 'undefined'){
        // 普通post请求
        axios.post(url, params)
        .then(response => {
            resolve(response.data);
        }, err => {
            reject(err);
        })
        
      }else{
        // 导出下载文件
        axios.post(url, params, {responseType: responseType})
        .then(response => {
            resolve(response);
        }, err => {
            reject(err);
        })

      }
    })
}