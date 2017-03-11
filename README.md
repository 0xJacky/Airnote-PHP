# JianJi-PHP

JianJi Project PHP Server v2

##协议 Protocol
1. auth\_key: md5(当前UNIX时间戳, 盐)后得到的一个拥有 32 个字符的字符串
	注意：密钥有效期为1秒，也就是说 auth\_key  是一个动态密钥
  如果出现验证错误，主要原因是网络延时造成的，建议重复请求三次
2. user\_token: auth::generate_token(用户ID.当前UNIX时间戳, 盐) 后得到的一个拥有 32 个字符的字符串
	字符串由服务器生成并返回，无需校验其有效性，只需要需要保存到本地以备后续使用即可。
  另外，user\_token 没有时间限制
3. 通讯方式为 POST

###通信测试
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
###用户类
-正在开发中
###文章类
- 正在开发中
