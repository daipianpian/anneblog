<?php
namespace app\admin\controller;
use think\Request;
vendor('Qiniu.autoload');
use Qiniu\Auth as Auth;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;

class Common
{
	public function upload()
	{
		$adminDB = db('admin');
		$request = Request::instance();
		if ($request->isPost()){
			$adminId = input('adminId');
			$token = Request::instance()->header('userToken');
			$adminMapCondition = [
	            'id' => $adminId,
	            'token' => $token
	        ];
	        $resultAdmin = $adminDB->where($adminMapCondition)->find();

	        if($resultAdmin){
		        $file = request()->file('fileName');
				// 要上传图片的本地路径
				$filePath = $file->getRealPath();
				$ext = pathinfo($file->getInfo('name'), PATHINFO_EXTENSION);  //后缀
				//获取当前控制器名称
				$controllerName = 'Common';
				// 上传到七牛后保存的文件名
				$key =substr(md5($file->getRealPath()) , 0, 5). date('YmdHis') . rand(0, 9999) . '.' . $ext;
				// 需要填写你的 Access Key 和 Secret Key
				$accessKey = config('ACCESSKEY');
				$secretKey = config('SECRETKEY');
				// 构建鉴权对象
				$auth = new Auth($accessKey, $secretKey);
				// 要上传的空间
				$bucket = config('BUCKET');
				$domain = config('DOMAIN');
				$token = $auth->uploadToken($bucket);
				// 初始化 UploadManager 对象并进行文件的上传
				$uploadMgr = new UploadManager();
				// 调用 UploadManager 的 putFile 方法进行文件的上传
				list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
				if ($err !== null) {
				    $callback = [
		                'code' => 20000,
		                'message' => $err
		            ];
		            echo json($callback)->getcontent();

				} else {
				    //返回图片的完整URL
		            $result = $domain .'/'. $ret['key'];
		            $callback = [
		                'code' => 10000,
		                'data' => $result,
		                'message' => '成功'
		            ];
		            echo json($callback)->getcontent();
				}
			}else{
				$callback = [
                    'code' => 20100,
                    'message' => 'token超过有效期，请重新登陆'
                ];
                echo json($callback)->getcontent();
			}
		}else{
            $callback = [
                'code' => 20000,
                'message' => '请求失败'
            ];
            echo json($callback)->getcontent();
        }
	}
}