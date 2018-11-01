<?php
namespace app\index\controller;
use think\Request;

class Index
{
    public function index()
    {
        return '个人博客系统-前端';
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
            	$$title = $searchKeywords;
            	$condition['title'] = ['like', '%' . $title . '%'];
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
        }
    }
}
