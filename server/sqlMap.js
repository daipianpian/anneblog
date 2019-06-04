var sqlMap = {
    blog: {
        select_article: 'select * from anne_article where title like ? and status=1'
    }
}
module.exports = sqlMap;