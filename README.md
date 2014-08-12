jquery_update: to 1.7
http://drupalcode.org/project/jquery_update.git/snapshot/baff5d15a438cfa8216997e067518f3c1a28bd5e.tar.gz


安装指南


* 微信服务号菜单设置地址 

http://new.love2in1.com/?q=admin/structure/menu/manage/wechat 

* 微信服务号API设置地址 

http://new.love2in1.com/?q=admin/config/wechat


* 微信模块的位置

love2in1/sites/all/modules/customs/wechat_plus

*  为微信服务号后台程序配置访问love2in1.com数据库的权限

在sites/default/settings.php文件里添加以下代码

   $databases['love2in1']['default'] = array(
    'driver' => 'mysql',
    'database' => 'databasename',
    'username' => 'username',
    'password' => 'password',
     'host' => 'localhost',
     'prefix' => '',
   );



