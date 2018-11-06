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
            
            $data['keywords'] = $searchKeywords;
            $data['count'] = $count;
            $data['list'] = $list;

            /*$listCount = count($data['list']);
            if($listCount > 0){
                for($i=0; $i < $listCount; $i++){
                    $content = strval(strip_tags($data['list'][$i]['content']));
                    $contentLength = mb_strlen($content,'utf8');
                    $data['list'][$i]['contentLength'] = $contentLength;
                    if($contentLength > 100){
                        $data['list'][$i]['contentTxt'] = substr($content, 0 , 100);
                    }else{
                        $data['list'][$i]['contentTxt'] = substr($content, 0 , 2);
                    }
                    
                }
            }*/

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
    public function queryClassifyTag(){
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


            $data['tagList'] = $articleTagDB->where($condition)->order('id desc')->select();
            $tagCount = count($data['tagList']);
            if($tagCount > 0){
                for($i=0; $i < $tagCount; $i++){
                    $tagId = $data['tagList'][$i]['id'];

                    $conditionTag['tagId'] = ['like', '%' . $tagId . '%'];  
                    $conditionTag['status'] = 1; 

                    $data['tagList'][$i]['count']= $articleDB->where($conditionTag)->count();
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
          
            $conditionClassify['id'] = $classifyId;
            $conditionClassify['status'] = 1;
            $data['keywords'] = $articleClassifyDB->where($conditionClassify)->value('name');
          
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

    public function queryArticleByTag(){
        $articleTagDB = db('article_tag');
        $articleDB = db('article');

        $request = Request::instance();

        if ($request->isPost()){
            $postParams = $request->post();
            $pageNum = $postParams['pageNum'];
            $pageSize = $postParams['pageSize'];
            $tagId = $postParams['tagId'];
          
            $conditionTag['id'] = $tagId;
            $conditionTag['status'] = 1;
            $data['keywords'] = $articleTagDB->where($conditionTag)->value('name');
          
            $condition['tagId'] = ['like', '%' . $tagId . '%'];
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
