<?php
namespace app\admin\controller;
use think\Request;

class Article
{
	public function index()
    {
    	return '文章管理';
    }

    // 增加文章
    public function addArticle() {
        $adminDB = db('admin');
        $articleDB = db('article');
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

                $title = $postParams['title'];
                $content  = $postParams['content'];
                $typeId  = $postParams['typeId'];
                $classifyId  = $postParams['classifyId'];
                $tagId  = $postParams['tagId'];
                $status  = $postParams['status'];
                $adminId = $postParams['adminId'];

                if(!empty($title) && !empty($typeId)){
                    $curtime = date('Y-m-d H:i:s');
                    $data = [
                        'title' => $title,
                        'content' => $content,
                        'typeId' => $typeId,
                        'classifyId' => implode(',',$classifyId),
                        'tagId' =>implode(',',$tagId),
                        'adminId' => $adminId,
                        'createTime' => $curtime,
                        'updateTime' => $curtime,
                        'status' => $status
                    ];

                    $result = $articleDB->insert($data);

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

    // 删除文章
    public function deleteArticle() {
        $adminDB = db('admin');
        $articleDB = db('article');
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

                $id = $postParams['articleId'];
                $curtime = date('Y-m-d H:i:s');

                $condition = [
                    'id' => $id
                ];
                $data = [
                    'updateTime' => $curtime,
                    'status' => 0
                ];

                $result = $articleDB->where($condition)->update($data);
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

    // 编辑文章信息回显
    public function editArticle() {
        $adminDB = db('admin');
        $articleDB = db('article');
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
                $id = $postParams['articleId'];
                $condition = [
                    'id' => $id
                ];
                $result = $articleDB->where($condition)->find();
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

    // 更新文章
    public function updateArticle() {
        $adminDB = db('admin');
        $articleDB = db('article');
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
                $id = $postParams['articleId'];
                $title = $postParams['title'];
                $content  = $postParams['content'];
                $typeId  = $postParams['typeId'];
                $classifyId  = $postParams['classifyId'];
                $tagId  = $postParams['tagId'];
                $status  = $postParams['status'];
                
                $curtime = date('Y-m-d H:i:s');

                $condition = [
                    'id' => $id
                ];
                $data = [
                    'title' => $title,
                    'content' => $content,
                    'typeId' => $typeId,
                    'classifyId' => implode(',',$classifyId),
                    'tagId' =>implode(',',$tagId),
                    'updateTime' => $curtime,
                    'status' => $status
                ];

                $result = $articleDB->where($condition)->update($data);
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
        $articleDB = db('article');
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
                $id = $postParams['articleId'];
                $status = $postParams['status'];
                $curtime = date('Y-m-d H:i:s');
                $condition = [
                    'id' => $id
                ];
                $data = [
                    'updateTime' => $curtime,
                    'status' => $status
                ];

                $result = $articleDB->where($condition)->update($data);
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
        }
    }

    // 查询文章
    public function queryArticle() {
        $adminDB = db('admin');
        $articleDB = db('article');
        $articleTypeDB = db('article_type');
        $articleClassifyDB = db('article_classify');
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
                $id = $postParams['articleId'];
                $title = $postParams['articleName'];
                $status = $postParams['status'];
                $condition = [];
                if($id){  
                    $condition['id'] = ['like', '%' . $id . '%'];  
                }
                if($title){  
                    $condition['title'] = ['like', '%' . $title . '%'];  
                } 
                if($status){  
                    $condition['status'] = ['like','%' . $status . '%'];  
                }else{
                    $condition['status'] = ['>', 0];  
                }

                $count= $articleDB->where($condition)->count();
                $data['count'] = $count;
                $list = $articleDB->where($condition)->order('id desc')->page($pageNum,$pageSize)->select();
                $dataCount = count($list);
                if($dataCount > 0){
                    for($i=0; $i < $dataCount; $i++){



                        $admin['id'] = $list[$i]['adminId'];
                        $admin['status'] = 1;
                        $list[$i]['adminName'] = $adminDB->where($admin)->value('name');

                        $type['id'] = $list[$i]['typeId'];
                        $type['status'] = 1;
                        $list[$i]['typeName'] = $articleTypeDB->where($type)->value('name');

                        $classifyArray = explode(',', $list[$i]['classifyId']);
                        $classifyCount = count($classifyArray);
                        $classifyResult = [];
                        if($classifyCount > 0){
                            for($j=0; $j < $classifyCount; $j++){
                                $classify['id'] = $classifyArray[$j];
                                $classify['status'] = 1;
                                $objResult = $articleClassifyDB->where($classify)->field('id,name')->find();
                                if($objResult){
                                    array_push($classifyResult, $objResult);
                                }
                            }
                        }
                        
                        $list[$i]['classify'] = $classifyResult;

                        $tagArray = explode(',', $list[$i]['tagId']);
                        $tagCount = count($tagArray);
                        $tagResult = [];
                        for($j=0; $j < $tagCount; $j++){
                            $tag['id'] = $tagArray[$j];
                            $tag['status'] = 1;
                            $objResult = $articleTagDB->where($tag)->field('id,name')->find();
                            if($objResult){
                                array_push($tagResult, $objResult);
                            }
                        }
                        $list[$i]['tag'] = $tagResult;

                        $data['list'][$i] = [
                            'id' => $list[$i]['id'],
                            'title' => $list[$i]['title'],
                            'adminName' => $list[$i]['adminName'],
                            'typeName' => $list[$i]['typeName'],
                            'classify' => $list[$i]['classify'],
                            'tag' => $list[$i]['tag'],
                            'createTime' => $list[$i]['createTime'],
                            'updateTime' => $list[$i]['updateTime'],
                            'status' => $list[$i]['status']
                        ];

                    }
                }else{
                    $data['list'] = [];
                }

                /*$data['list'] = $list;*/

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