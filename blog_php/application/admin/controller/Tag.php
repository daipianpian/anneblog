<?php
namespace app\admin\controller;
use think\Request;
use think\Session;

class Tag
{
	public function index()
    {
    	return '标签管理';
    }

    // 增加标签
    public function addTag() {
        $adminDB = db('admin');
        $articleTagDB = db('article_tag');
        $request = Request::instance();
        
        if ($request->isPost()){
            $postParams = $request->post();

            $adminId = $postParams['adminId'];
            $token = Request::instance()->header('userToken');
            $adminMapCondition = [
                'id' => $adminId,
                'token' => $token
            ];
            $resultAdmin = $adminDB->where($adminMapCondition)->find();

            if($resultAdmin){
                $name = $postParams['name'];
                $desc  = $postParams['desc'];
                $status  = $postParams['status'];
                
                if(!empty($name)){
                    $curtime = date('Y-m-d H:i:s');
                    $data = [
                        'name' => $name,
                        'desc' => $desc,
                        'adminId' => $adminId,
                        'createTime' => $curtime,
                        'updateTime' => $curtime,
                        'status' => $status
                    ];

                    $result = $articleTagDB->insert($data);

                    if($result){
                        $callback = [
                            'code' => 10000,
                            'message' => '成功'
                        ];
                        echo json($callback)->getcontent();
                    }else{
                        $callback = [
                            'code' => 20000,
                            'message' => '失败'
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
                    'message' => '名称或管理员不能为空'
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

    // 删除标签
    public function deleteTag() {
        $adminDB = db('admin');
        $articleTagDB = db('article_tag');
        $request = Request::instance();
        
        if ($request->isPost()){
            $postParams = $request->post();

            $adminId = $postParams['adminId'];
            $token = Request::instance()->header('userToken');
            $adminMapCondition = [
                'id' => $adminId,
                'token' => $token
            ];
            $resultAdmin = $adminDB->where($adminMapCondition)->find();

            if($resultAdmin){

                $id = $postParams['tagId'];
                $curtime = date('Y-m-d H:i:s');

                $condition = [
                    'id' => $id
                ];
                $data = [
                    'updateTime' => $curtime,
                    'status' => 0
                ];

                $result = $articleTagDB->where($condition)->update($data);
                if($result){
                    $callback = [
                        'code' => 10000,
                        'message' => '成功'
                    ];
                    echo json($callback)->getcontent();
                }else{
                    $callback = [
                        'code' => 20000,
                        'message' => '失败'
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

    // 编辑标签信息回显
    public function editTag() {
        $adminDB = db('admin');
        $articleTagDB = db('article_tag');
        $request = Request::instance();
        
        if ($request->isPost()){
            $postParams = $request->post();

            $adminId = $postParams['adminId'];
            $token = Request::instance()->header('userToken');
            $adminMapCondition = [
                'id' => $adminId,
                'token' => $token
            ];
            $resultAdmin = $adminDB->where($adminMapCondition)->find();

            if($resultAdmin){
                $id = $postParams['tagId'];
                $condition = [
                    'id' => $id
                ];
                $result =$articleTagDB->where($condition)->find();
                if($result){
                    $callback = [
                        'code' => 10000,
                        'data' => $result,
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

    // 更新标签
    public function updateTag() {
        $adminDB = db('admin');
        $articleTagDB = db('article_tag');
        $request = Request::instance();
        
        if ($request->isPost()){
            $postParams = $request->post();

            $adminId = $postParams['adminId'];
            $token = Request::instance()->header('userToken');
            $adminMapCondition = [
                'id' => $adminId,
                'token' => $token
            ];
            $resultAdmin = $adminDB->where($adminMapCondition)->find();

            if($resultAdmin){
                $id = $postParams['tagId'];
                $name = $postParams['name'];
                $desc  = $postParams['desc'];
                $status  = $postParams['status'];
                $curtime = date('Y-m-d H:i:s');

                $condition = [
                    'id' => $id
                ];
                $data = [
                    'name' => $name,
                    'desc' => $desc,
                    'updateTime' => $curtime,
                    'status' => $status
                ];

                $result = $articleTagDB->where($condition)->update($data);
                if($result){
                    $callback = [
                        'code' => 10000,
                        'message' => '成功'
                    ];
                    echo json($callback)->getcontent();
                }else{
                    $callback = [
                        'code' => 20000,
                        'message' => '失败'
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

    // 更新状态
    public function updateStatus() {
        $adminDB = db('admin');
        $articleTagDB = db('article_tag');
        $request = Request::instance();
        
        if ($request->isPost()){
            $postParams = $request->post();

            $adminId = $postParams['adminId'];
            $token = Request::instance()->header('userToken');
            $adminMapCondition = [
                'id' => $adminId,
                'token' => $token
            ];
            $resultAdmin = $adminDB->where($adminMapCondition)->find();

            if($resultAdmin){
                $id = $postParams['tagId'];
                $status = $postParams['status'];
                $curtime = date('Y-m-d H:i:s');

                $condition = [
                    'id' => $id
                ];
                $data = [
                    'updateTime' => $curtime,
                    'status' => $status
                ];

                $result = $articleTagDB->where($condition)->update($data);
                if($result){
                    $callback = [
                        'code' => 10000,
                        'message' => '成功'
                    ];
                    echo json($callback)->getcontent();
                }else{
                    $callback = [
                        'code' => 20000,
                        'message' => '失败'
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

    // 查询标签
    public function queryTag() {
        $adminDB = db('admin');
        $articleTagDB = db('article_tag');
        $request = Request::instance();
        
        if ($request->isPost()){
            $postParams = $request->post();

            $adminId = $postParams['adminId'];
            $token = Request::instance()->header('userToken');
            $adminMapCondition = [
                'id' => $adminId,
                'token' => $token
            ];
            $resultAdmin = $adminDB->where($adminMapCondition)->find();

            if($resultAdmin){
                $pageNum = $postParams['pageNum'];
                $pageSize = $postParams['pageSize'];
                $id = $postParams['tagId'];
                $name = $postParams['tagName'];
                $status = $postParams['status'];
                $condition = [];
                if($id){  
                    $condition['id'] = ['like',"%".$id."%"];  
                }
                if($name){  
                    $condition['name'] = ['like',"%".$name."%"];  
                } 
                if($status){  
                    $condition['status'] = ['like',"%".$status."%"];  
                }  

                $count= $articleTagDB->where($condition)->count();
                $data['count'] = $count;
                $data['list'] = $articleTagDB->where($condition)->order('id desc')->page($pageNum,$pageSize)->select();
                $dataCount = count($data['list']);
                for($i=0; $i < $dataCount; $i++){
                    $admin['id'] = $data['list'][$i]['adminId'];
                    $data['list'][$i]['adminName'] = $adminDB->where($admin)->value('name');
                }

                $callback = [
                    'code' => 10000,
                    'data' => $data,
                    'message' => '成功'
                ];
                echo json($callback)->getcontent();

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