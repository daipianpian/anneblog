var sqlMap = {
    blog: {
        select_admin: "select * from anne_article 
                      where status = 1
                      and title like '%'";
    }
}
module.exports = sqlMap;