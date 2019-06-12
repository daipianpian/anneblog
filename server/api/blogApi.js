const models = require('../db');
const express = require('express');
const router = express.Router();
const mysql = require('mysql');
const $sql = require('../sqlMap');
// 连接数据库
const conn = mysql.createConnection(models.mysql);
conn.connect();
const jsonWrite = function(res, ret) {
    if(typeof ret === 'undefined') {
        res.send('err')
    } else {
        res.json(ret);
        // res.send('ok')
    }
};


//查找用户接口
router.post('/queryArticleList', (req,res) => {
    let select_article = $sql.blog.select_article;
    let params = req.body;
    let keywords = req.body.keywords;

    /*分页查询入参 start*/
    let limitFirst = (params.pageNum-1)*params.pageSize;
    let limitLast = params.pageSize;
    /*分页查询入参 end*/
    let objParams = [];

    if(!keywords){
        objParams = [limitFirst, limitLast];
    }else{
        objParams = ["%"+req.body.keywords+"%", limitFirst, limitLast];
        select_article += " and title like ?"; // 模糊查询
    }

    select_article += " order by id desc"; // id倒序排
    select_article+= " limit ?,?"; // 分页查询

    conn.query(select_article, objParams, function(err, result) {
        if(err) {
            console.log(err)
        }
        if(result[0]===undefined) {
            res.send([])    //username正确后，password错误，data返回 0
        }else {
            let resultParams = {
                code: 10000,
                data: result
            }
            jsonWrite(res, resultParams);
        }
    })
});
module.exports = router;






