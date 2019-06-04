var models = require('../db');
var express = require('express');
var router = express.Router();
var mysql = require('mysql');
var $sql = require('../sqlMap');
// 连接数据库
var conn = mysql.createConnection(models.mysql);
conn.connect();
var jsonWrite = function(res, ret) {
    if(typeof ret === 'undefined') {
        res.send('err')
    } else {
        res.json(ret);
        // res.send('ok')
    }
};


//查找用户接口
router.post('/selectAdmin', (req,res) => {
    var select_article = $sql.blog.select_article;

    select_article += " and title like ?"; // 模糊查询
    select_article += " order by id desc"; // id倒序排
    select_article+= " limit ?,?"; // 分页查询

    var params = req.body;

    /*分页查询入参 start*/
    var limitFirst = (params.pageNum-1)*params.pageSize;
    var limitLast = params.pageSize;
    /*分页查询入参 end*/
    var objParams = ["%"+req.body.name+"%", limitFirst, limitLast];

    conn.query(select_article, objParams, function(err, result) {
        if(err) {
            console.log(err)
        }
        if(result[0]===undefined) {
            res.send([])    //username正确后，password错误，data返回 0
        }else {
            jsonWrite(res, result);
        }
    })
});
module.exports = router;






