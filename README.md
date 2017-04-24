# JianJi-PHP

JianJi Project PHP Server v2

Designed by 0xJacky

Copyright © 2013-2017 UoziTech 2017

The program is distributed under the terms of the GNU Affero General Public License.

This program is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License along with this program. If not, see http://www.gnu.org/licenses/.

## Nginx Config
```
try_files $uri $uri/ /index.php;
location ^~ /system {
  deny all;
}
```

## Todos
- 后台管理系统
## 协议 Protocol
1. auth\_key: sha1(当前 UNIX 时间戳.后端密钥)

	注意：密钥有效期为1000毫秒，如果出现验证错误，主要原因是网络延时造成的，建议重复请求三次
2. token: 8-4-4-12 的 UUID 结构

	储存 sha1 加密后的 用户 ID 及 最后活跃时间

	token 由服务器生成并返回，无需校验其有效性，只需要需要保存到本地以备后续使用即可。

	PS: token 没有时间限制，考虑到多个设备的登录问题，所以 API v2 采用了验证最后活跃时间的方法，并判断 token 是过期的还是无效的。
3. 请注意用户密码传输过程前需要使用 sha1 加密

### 通信测试 & 基本状态
- GET /
- 通信成功
```json
{
  "status": 200,
  "info": "200 OK",
  "timestamp": 1489213245,
  "version": "2.0"
}
```
- 通信错误
```json
{
  "status": 400,
  "info": "400 Bad Request",
  "timestamp": 1489213274,
  "version": "2.0"
}
```
-  503 DataBase Error 数据库错误
```json
{
  "status": 503,
  "info": "DataBase Error",
  "timestamp": 1489244822,
  "version": "2.0"
}
```

### 用户类
#### 用户注册
- POST
```json
{
    "method": "user",
    "action": "register",
    "name": "0xJacky",
    "pwd": "****************",
    "mail": "jacky@uozi.org",
    "auth_key": "****************"
}
```

#### 成功
```json
{
  "status": 200,
  "info": "Register Successflly",
  "timestamp": 1489240887,
  "version": "2.0"
}
```

#### 错误
- You have registered 您已注册
```json
{
  "status": 4051,
  "info": "You have registered",
  "timestamp": 1489240413,
  "version": "2.0"
}
```
- Name Conflict 用户名冲突
```json
{
  "status": 4052,
  "info": "Name Conflict",
  "timestamp": 1489241637,
  "version": "2.0"
}
```
 - Mail Conflict 邮箱冲突
```json
{
  "status": 4053,
  "info": "Mail Conflict",
  "timestamp": 1489241392,
  "version": "2.0"
}
```

#### 用户登录
```json
{
   "method": "user",
   "action": "login",
   "mail": "jacky@uozi.org",
   "pwd": "****************",
   "auth_key": "****************"
}
```

#### 成功
```json
{
  "status": 200,
  "info": "Login Successfully",
  "content": {
    "user_id": "1",
    "token": "7627F9AD-5E05-2566-BEE5-EE8AE8AC9B6A"
  }
}
```

#### 失败
- 406 Account Not Found & Wrong Password 认证错误
```json
{
  "status": 406,
  "info": "Account Not Found & Wrong Password",
  "timestamp": 1489245377,
  "version": "2.0"
}
```
- 407 Account Banned 用户被禁止
```json
{
  "status": 407,
  "info": "Account Banned",
  "timestamp": 1489245286,
  "version": "2.0"
}
```
#### 用户注销
- POST
```json
{
    "method": "user",
    "action": "logout",
    "user_id": 1,
    "token": "7627F9AD-5E05-2566-BEE5-EE8AE8AC9B6A",
    "auth_key": "****************"
 }
```
- 成功
```json
{
  "status": 200,
  "info": "Logout Success",
  "timestamp": 1489256669,
  "version": "2.0"
}
```
#### 用户信息获取
- POST
```json
{
    "method": "user",
    "action": "info",
    "user_id": 1,
    "mail": "other@uozi.org",
    "token": "7627F9AD-5E05-2566-BEE5-EE8AE8AC9B6A",
    "auth_key": "****************"
 }
```

- 成功
```json
{
  "status": 200,
  "info": "User info get successfully",
  "content": {
    "user_id": "1",
    "Name": "0xJacky",
    "registered_time": "2017-03-11 21:09:24",
    "lastest_active": "2017-03-12 02:24:29",
    "avatar": "avatar/default.png",
    "introduction": "NULL",
    "favour": "0",
    "token": "7627F9AD-71A6-3512-AF19-8AEE76D13F3B"
  }
}
```

- 失败 404 User Not Found 未找到该用户
```json
{
  "status": 404,
  "info": "User Not Found",
  "timestamp": 1489257939,
  "version": "2.0"
}
```
#### 用户信息修改
request: 头像: avatar, 简介(\<255): introduction, 名称: name
```json
{
    "method": "user",
    "action": "edit_profile",
    "user_id": 1,
    "request": "introduction",
    "token": "7627F9AD-71A6-3512-AF19-8AEE76D13F3B",
    "auth_key": "****************"
}
```
- 成功
```json
{
  "status": 200,
  "info": "Edit Successfully",
  "content": {
    "token": "7627F9AD-8FCF-4A53-8A1D-86186C8C3077"
  }
}
```
### 文章类
#### 发布文章
type: 文章类型，目前默认为 1
```json
{
    "method": "post",
    "action": "post",
    "user_id": 1,
    "title": "test",
    "content": "test content",
    "img": "img_relative_url.png",
    "type": 1,
    "auth_key": "****************",
    "token": "7627F9AD-8FCF-4A53-8A1D-86186C8C3077"
}
```
- 成功
```json
{
  "status": 200,
  "info": "Post Successfully",
  "content": {
    "token": "7627F9AD-9406-8EB1-B61F-1A98969AAA42"
  }
}
```
- 失败 Account Banned 账号被锁定
```json
{
  "status": 407,
  "info": "Account Banned",
  "timestamp": 1489764761,
  "version": "2.0"
}
```
#### 编辑文章
- POST
type: 文章类型，目前默认为 1
```json
{
    "method": "post",
    "action": "edit",
    "user_id": 1,
    "post_id": 1,
    "title": "test 1",
    "content": "Post edit",
    "img": "img_relative_url.png",
    "type": 1,
    "auth_key": "****************",
    "token": "7627F9AD-9406-8EB1-B61F-1A98969AAA42"
}
```
- 成功
```json
{
  "status": 200,
  "info": "Edit Successfully",
  "content": {
    "token": "7627F9AD-9ACF-B63F-E53F-612EE7E0BC90"
  }
}
```
- 失败 Forbidden 无权限修改 User ID 与 Post ID 不匹配
```json
{
  "status": 403,
  "info": "Forbidden",
  "timestamp": 1489764687,
  "version": "2.0"
}
```
- 失败 Post Not Found 文章未找到
```json
{
  "status": 404,
  "info": "Post Not Found",
  "timestamp": 1489764819,
  "version": "2.0"
}
```
- 失败 Account Banned 账号被锁定
```json
{
  "status": 407,
  "info": "Account Banned",
  "timestamp": 1489764761,
  "version": "2.0"
}
```
#### 点赞
- POST
```json
{
    "method": "post",
    "action": "favour",
    "user_id": 1,
    "post_id": 1,
    "token": "7627F9AD-9ACF-B63F-E53F-612EE7E0BC90",
    "auth_key": "****************"
}
```
- 成功
```json
{
  "status": 200,
  "info": "Favour Successfully",
  "content": {
    "token": "7627F9AD-AD9B-0C9F-496A-E8330A013586"
  }
}
```

- 失败 Post Not Fount or was deleted just now
```json
{
  "status": 404,
  "info": "Post Not Fount or was deleted just now",
  "timestamp": 1489767413,
  "version": "2.0"
}
```
#### 获取社区文章
page: 分页操作（每页 10 篇文章），建议限制 page 最大增长 ≤ 5
```json
{
    "method": "post",
    "action": "list",
    "page": 1,
    "auth_key": "****************"
}
```

- 获取成功
```json
{
  "status": 200,
  "info": "Geted the page 1",
  "content": {
    "post_list": [
      {
        "user_id": "1",
        "author": "1",
        "post_date": "2017-03-17 22:47:13",
        "title": "测试 title1",
        "img": "null",
        "favours": "6",
        "avatar": "avatar/default.png"
      }
    ]
  }
}
```

#### 获取自己的文章
page: 分页操作（每页 10 篇文章），建议限制 page 最大增长 ≤ 5
```json
{
    "method": "post",
    "action": "self_list",
    "page": 1,
    "user_id": 1,
    "auth_key": "****************"
}
```

- 获取成功
```json
{
  "status": 200,
  "info": "Geted the page 1",
  "content": {
    "post_list": [
      {
        "post_date": "2017-03-17 22:47:13",
        "title": "测试 title1",
        "img": "null",
        "favours": "6"
      }
    ]
  }
}
```
