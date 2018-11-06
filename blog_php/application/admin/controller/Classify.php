<?php
namespace app\admin\controller;
use think\Request;

class Classify
{
	public function index()
    {
    	return '文章分类';
    }

    // 增加分类
    public function addClassify() {
        $adminDB = db('admin');
        $articleClassifyDB = db('article_classify');
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

                if(!empty($name) && !empty($adminId)){
                	$curtime = date('Y-m-d H:i:s');
                	$data = [
                		'name' => $name,
                		'desc' => $desc,
                		'adminId' => $adminId,
                		'createTime' => $curtime,
                		'updateTime' => $curtime,
                        'status' => $status
                	];

                	$result = $articleClassifyDB->insert($data);

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

    // 删除分类
    public function deleteClassify() {
        $adminDB = db('admin');
        $articleClassifyDB = db('article_classify');
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

                $id = $postParams['classifyId'];
                $curtime = date('Y-m-d H:i:s');

                $condition = [
                    'id' => $id
                ];
                $data = [
                    'updateTime' => $curtime,
                    'status' => 0
                ];

                $result = $articleClassifyDB->where($condition)->update($data);
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

    // 编辑分类信息回显
    public function editClassify() {
        $adminDB = db('admin');
        $articleClassifyDB = db('article_classify');
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
                $id = $postParams['classifyId'];
                $condition = [
                    'id' => $id
                ];
                $result =$articleClassifyDB->where($condition)->find();
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

    // 更新分类
    public function updateClassify() {
        $adminDB = db('admin');
        $articleClassifyDB = db('article_classify');
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
                $id = $postParams['classifyId'];
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

                $result = $articleClassifyDB->where($condition)->update($data);
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
        $articleClassifyDB = db('article_classify');
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
                $id = $postParams['classifyId'];
                $status = $postParams['status'];
                $curtime = date('Y-m-d H:i:s');
                $condition = [
                    'id' => $id
                ];
                $data = [
                    'updateTime' => $curtime,
                    'status' => $status
                ];

                $result = $articleClassifyDB->where($condition)->update($data);
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


    // 查询分类
    public function queryClassify() {
        $adminDB = db('admin');
        $articleClassifyDB = db('article_classify');
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
                $id = $postParams['classifyId'];
                $name = $postParams['classifyName'];
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

                $count= $articleClassifyDB->where($condition)->count();
                $data['count'] = $count;
                $data['list'] = $articleClassifyDB->where($condition)->order('id desc')->page($pageNum,$pageSize)->select();
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