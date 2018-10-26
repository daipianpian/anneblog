<?php
namespace app\admin\controller;
use think\Request;
use think\Session;

class Login
{

    public function index()
    {
        return '登录';
    }
    public function login()
    {
        $request = Request::instance();
        $postParams = $request->post();

        $name = $postParams['name'];
        $password  = $postParams['password'];
        $curtime = date('Y-m-d H:i:s');

        $condition = [
            'name' => $name,
            'password' => $password,
            'status' => 1
        ];

        $adminDB= db('admin');

        $resultQuery = $adminDB->where($condition)->find();

        $updateCondition = [
            'id' => $resultQuery['id']
        ];

        $data = [
            'token' => create_uuid(),
            'updateTime' => $curtime
        ];
        $resultUpdate = $adminDB->where($updateCondition)->update($data);

        if($updateCondition && $resultUpdate){

            $resultQuery['token'] = $data['token'];

            $callback = [
                'code' => 10000,
                'data' => $resultQuery,
                'message' => '成功'
            ];
            echo json($callback)->getcontent();
        }else{
            $callback = [
                'code' => 20000,
                'message' => '请求失败'
            ];
            echo json($callback)->getcontent();
        }
        exit();
       
    }

    // 退出登录
    public function logout(){
        $adminDB= db('admin');
        $request = Request::instance();
        $postParams = $request->post();

        if ($request->isPost()){
            $adminId = $postParams['adminId'];
            $curtime = date('Y-m-d H:i:s');

            $condition = [
                'id' => $adminId
            ];

            $data = [
                'token' => create_uuid(),
                'updateTime' => $curtime
            ];

            $result = $adminDB->where($condition)->update($data);

    	    if ($result) {
                $callback = [
                    'code' => 10000,
                    'message' => '成功'
                ];
        	    echo json($callback)->getcontent();
                exit();
    	    }else{
                $callback = [
                    'code' => 20000,
                    'message' => '请求失败'
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
