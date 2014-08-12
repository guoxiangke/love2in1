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






Drupal微信公众平台模块

github地址 https://github.com/yplam/wechat

#### 功能

* 微信菜单管理
* 消息事件钩子
* 设置默认回复信息，包括用户输入与菜单点击
* 微信登录与用户授权绑定相关的API

#### 配置

根据需要填入您的公众账号appid，appsecret，token，以及默认回复信息

#### 菜单管理

安装模块后会自动生成一个名称为wechat的菜单，可以通过此菜单来配置，配置好后通过模块配置页面来更新菜单。

#### 消息事件钩子

当接收到信息后提供 wechat_message，wechat_message_alter两个hook，开发者可以通过实现这两个hook来对特定消息进行响应。

#### 微信登录与用户授权API

如果访客在微信中打开网站页面，可以通过调用 wechat_snsapi_base 或者 wechat_snsapi_userinfo 进行微信授权认证，此两个方法均会通过获取微信用户openid，然后自动注册、登录用户，然后将访客以一个已登录的状态跳转到开发者提供的页面，方便开发者在一些web app中进行用户管理。



