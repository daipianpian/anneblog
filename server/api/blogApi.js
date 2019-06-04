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

    // select_article += " WHERE title LIKE ?";

    // select_article+= ' limit ? offset ?';



    var params = req.body;


    params.title = "%"+req.body.name+"%";

    conn.query(select_article, params.title, function(err, result) {
        if(err) {
            console.log(err)
        }
        if(result[0]===undefined) {
            res.send('0')    //username正确后，password错误，data返回 0
        }else {
            jsonWrite(res, result);
        }
    })
});
module.exports = router;






