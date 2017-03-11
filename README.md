# JianJi-PHP

JianJi Project PHP Server v2

## 协议 Protocol
1. auth\_key: sha1(当前UNIX时间戳, 盐)后得到的一个拥有 32 个字符的字符串
	注意：密钥有效期为1秒，也就是说 auth\_key  是一个动态密钥
  如果出现验证错误，主要原因是网络延时造成的，建议重复请求三次
2. user\_token: auth::generate\_token(用户ID.当前UNIX时间戳, 盐) 后得到的一个拥有 32 个字符的字符串
	字符串由服务器生成并返回，无需校验其有效性，只需要需要保存到本地以备后续使用即可。
  另外，user\_token 没有时间限制
3. 请注意用户密码传输过程前需要使用 sha1 加密

### 通信测试
- POST
```
{
  "method": "ping",
  "auth_key:" <auth_key>,
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
### 用户类
#### 用户注册
- POST
```
{
   "method": "user_register",
    "name": <register_name>,
    "pwd": <register_pwd>,
    "mail": <register_mail>
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
1. You have registered 您已注册
```
{
  "status": 4051,
  "info": "You have registered",
  "timestamp": 1489240413,
  "version": "2.0"
}
```
2. Name Conflict 用户名冲突
```
{
  "status": 4052,
  "info": "Name Conflict",
  "timestamp": 1489241637,
  "version": "2.0"
}
```
3. Mail Conflict 邮箱冲突
```
{
  "status": 4053,
  "info": "Mail Conflict",
  "timestamp": 1489241392,
  "version": "2.0"
}
```
### 文章类
- 正在开发中