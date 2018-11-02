<?php
namespace app\index\controller;
use think\Request;

class Article
{
    public function index()
    {
        return '';
    }
    public function queryArticle(){
    	$articleDB = db('article');
    	$articleTypeDB = db('article_type');
	    $articleClassifyDB = db('article_classify');
	    $articleTagDB = db('article_tag');

	    $request = Request::instance();

	    if ($request->isPost()){
            $postParams = $request->post();
            $pageNum = $postParams['pageNum'];
            $pageSize = $postParams['pageSize'];

            $searchKeywords = $postParams['searchKeywords'];

            $condition['status'] = 1;
            if($searchKeywords){
            	$title = $searchKeywords;
            	$condition['title'] = ['like', '%' . $title . '%'];
                $count= $articleDB->where($condition)->count();
                $list = $articleDB->where($condition)->order('id desc')->page($pageNum,$pageSize)->select();
            }else{
            	$count= $articleDB->where($condition)->count();
                $list = $articleDB->where($condition)->order('id desc')->page($pageNum,$pageSize)->select();
            }

            $data['count'] = $count;
            $data['list'] = $list;

            $callback = [
                'code' => 10000,
                'data' => $data,
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
    }
    public function queryClassifyType(){
        $articleClassifyDB = db('article_classify');
        $articleTagDB = db('article_tag');
        $articleDB = db('article');

        $request = Request::instance();

        if ($request->isPost()){
            $condition['status'] = 1;
            $data['classifyList'] = $articleClassifyDB->where($condition)->order('id desc')->select();

            $classifyCount = count($data['classifyList']);
            if($classifyCount > 0){
                for($i=0; $i < $classifyCount; $i++){
                    $classifyId = $data['classifyList'][$i]['id'];

                    $conditionClassify['classifyId'] = ['like', '%' . $classifyId . '%'];  
                    $conditionClassify['status'] = 1; 

                    $data['classifyList'][$i]['count']= $articleDB->where($conditionClassify)->count();
                }
            }


            $data['typeList'] = $articleTagDB->where($condition)->order('id desc')->select();
            $typeCount = count($data['typeList']);
            if($typeCount > 0){
                for($i=0; $i < $typeCount; $i++){
                    $typeId = $data['typeList'][$i]['id'];

                    $conditionType['typeId'] = ['like', '%' . $typeId . '%'];  
                    $conditionType['status'] = 1; 

                    $data['typeList'][$i]['count']= $articleDB->where($conditionType)->count();
                }
            }


            $callback = [
                'code' => 10000,
                'data' => $data,
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
    }

    public function queryArticleByClassify(){
        $articleClassifyDB = db('article_classify');
        $articleDB = db('article');

        $request = Request::instance();

        if ($request->isPost()){
            $postParams = $request->post();
            $pageNum = $postParams['pageNum'];
            $pageSize = $postParams['pageSize'];
            $classifyId = $postParams['classifyId'];
            $condition['classifyId'] = ['like', '%' . $classifyId . '%'];
            $condition['status'] = 1;

            $count= $articleDB->where($condition)->count();
            $list = $articleDB->where($condition)->order('id desc')->page($pageNum,$pageSize)->select();
            $data['count'] = $count;
            $data['list'] = $list;

            $callback = [
                'code' => 10000,
                'data' => $data,
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
    }

    public function queryArticleByType(){
        $articleTypeDB = db('article_Type');
        $articleDB = db('article');

        $request = Request::instance();

        if ($request->isPost()){
            $postParams = $request->post();
            $pageNum = $postParams['pageNum'];
            $pageSize = $postParams['pageSize'];
            $typeId = $postParams['typeId'];
            $condition['typeId'] = ['like', '%' . $typeId . '%'];
            $condition['status'] = 1;

            $count= $articleDB->where($condition)->count();
            $list = $articleDB->where($condition)->order('id desc')->page($pageNum,$pageSize)->select();
            $data['count'] = $count;
            $data['list'] = $list;

            $callback = [
                'code' => 10000,
                'data' => $data,
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
    }

    public function queryArticleDetail(){
        $articleDB = db('article');
        $request = Request::instance();

        if ($request->isPost()){
            $postParams = $request->post();

            $condition['id'] = $postParams['articleId'];
            $condition['status'] = 1;

            $result = $articleDB->where($condition)->find();

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
    }
}
