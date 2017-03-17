# JianJi-PHP

JianJi Project PHP Server v2

Designed by 0xJacky

Copyright © 2013-2017 UoziTech 2017

The program is distributed under the terms of the GNU Affero General Public License.

This program is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License along with this program. If not, see http://www.gnu.org/licenses/.

## Nginx URL Rewrite
```
try\_files $uri $uri/ @rewrite;
location @rewrite {
    rewrite ^([^/]+) /index.php;
}
```
## 协议 Protocol
1. auth\_key: sha1(当前UNIX时间戳, 盐) 加密后得到的一个拥有 32 个字符的字符串
	注意：密钥有效期为1秒，也就是说 auth\_key  是一个动态密钥
  如果出现验证错误，主要原因是网络延时造成的，建议重复请求三次
2. user\_token: auth::generate\_token(用户ID.当前UNIX时间戳, 盐) 加密后得到的一个拥有 32 个字符的字符串
	字符串由服务器生成并返回，无需校验其有效性，只需要需要保存到本地以备后续使用即可。PS: user\_token 没有时间限制
3. 请注意用户密码传输过程前需要使用 sha1 加密

### 通信测试 & 基本状态
- POST
```
{
  "method": "ping",
  "auth_key:" <auth_key>
}
```
- 通信成功
```
{
  "status": 200,
  "info": "200 OK",
  "timestamp": 1489213245,
  "version": "2.0"
}
```
- 通信错误
```
{
  "status": 400,
  "info": "400 Bad Request",
  "timestamp": 1489213274,
  "version": "2.0"
}
```
-  503 DataBase Error 数据库错误
```
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
```
{
   "method": "user_register",
    "name": <register_name>,
    "pwd": <register_pwd>,
    "mail": <register_mail>,
    "auth_key:" <auth_key>
}
```

#### 成功
```
{
  "status": 200,
  "info": "Register Successflly",
  "timestamp": 1489240887,
  "version": "2.0"
}
```

#### 错误
- You have registered 您已注册
```
{
  "status": 4051,
  "info": "You have registered",
  "timestamp": 1489240413,
  "version": "2.0"
}
```
- Name Conflict 用户名冲突
```
{
  "status": 4052,
  "info": "Name Conflict",
  "timestamp": 1489241637,
  "version": "2.0"
}
```
 - Mail Conflict 邮箱冲突
```
{
  "status": 4053,
  "info": "Mail Conflict",
  "timestamp": 1489241392,
  "version": "2.0"
}
```

#### 用户登录
```
{
  "method": "user_login",
   "mail": <mail>,
   "pwd": <sha1_pwd>,
   "auth_key:" <auth_key>
}
```

#### 成功
```
{
  "status": 200,
  "info": "Login Successfully",
  "content": {
    "ID": "1",
    "token": "MS0xNDg5MjQ0NTc5LSpUSlhGT3JaMzJqTEtVUGk="
  }
}
```

#### 失败
- 406 Account Not Found & Wrong Password 认证错误
```
{
  "status": 406,
  "info": "Account Not Found & Wrong Password",
  "timestamp": 1489245377,
  "version": "2.0"
}
```
- 407 Account Banned 用户被禁止
```
{
  "status": 407,
  "info": "Account Banned",
  "timestamp": 1489245286,
  "version": "2.0"
}
```
#### 用户注销
- POST
```
{
    "method": "user_logout",
    "id": <id>,
    "token": <token>,
    "auth_key:" <auth_key>
 }
```
- 成功
```
{
  "status": 200,
  "info": "Logout Success",
  "timestamp": 1489256669,
  "version": "2.0"
}
```
#### 用户信息获取
- POST
```
{
    "method": "user_info",
    "id": <id>, //self id
    "mail": <mail>, //
    "token": <token>,
    "auth_key:" <auth_key>
 }
```

- 成功
```
{
  "status": 200,
  "info": "User info get successfully",
  "content": {
    "ID": "1",
    "Name": "0xJacky",
    "registered_time": "2017-03-11 21:09:24",
    "lastest_active": "2017-03-12 02:24:29",
    "avatar": "NULL",
        "introduction": "NULL",
    "favour": "0",
    "token": "LTE0ODkyNTc4OTUtTSViI0E2UGdBVnpaRFd0Kg=="
  }
}
```

- 失败 404 User Not Found 未找到该用户
```
{
  "status": 404,
  "info": "User Not Found",
  "timestamp": 1489257939,
  "version": "2.0"
}
```
#### 用户信息修改
```
{
    "method": "user_info",
    "id": <id>,
    "request": <profile_type>, // 头像: avatar 简介(<255): introduction 名称: name
    "token": <token>,
    "auth_key": <auth_key>
}
```
- 成功
```
{
  "status": 200,
  "info": "Edit Successfully",
  "content": {
    "token": "MS0xNDg5MzA4ODUyLSFlOHRuWnU3ZHVxdyNSM1Q="
  }
}
```
### 文章类
#### 发布文章
```
{
    "method": "post",
    "action": "post",
    "user_id": <user_id>,
    "title": <title>,
    "content": <content>,
    "img": <img_relative_url>,
    "type": <type>, //文章类型，目前默认为 1
    "auth_key": <auth_key>，
    "token": <token>
}
```
- 成功
```
{
  "status": 200,
  "info": "Post Successfully",
  "content": {
    "token": "MS0xNDg5NzYyMDMzLW9HVHNEUiFQc2lMTUomYWk="
  }
}
```
#### 编辑文章