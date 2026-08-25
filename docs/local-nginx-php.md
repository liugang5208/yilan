# yilan 本地 Nginx + PHP 配置

## 1. 项目访问方式

- 仓库根目录就是站点根目录：`/Users/liugang/data/workspace/yilan`
- 入口文件：`index.php`
- 本地建议访问地址：`http://localhost:8088`

项目已经兼容 `nginx try_files` 模式，并会按当前 `HTTP_HOST` 生成本地 URL。

## 2. Nginx 站点配置

把示例配置复制到：

- `/usr/local/etc/nginx/servers/yilan.conf`

示例文件在：

- `docs/nginx/yilan.conf.example`

## 3. PHP-FPM 需要确认的点

`nginx` 还需要能连到 `php-fpm`。请先确认你本机 PHP-FPM 的监听地址，常见有两种：

- TCP：`127.0.0.1:9000`
- Unix Socket：`/usr/local/var/run/php-fpm.sock`

如果你的 PHP 是 Homebrew 安装，通常可以用下面几条命令确认：

```bash
brew list --versions | rg '^php(@| )'
brew services list | rg php
find /usr/local/etc -maxdepth 3 \( -name 'php-fpm.conf' -o -name 'www.conf' \)
```

然后把 `docs/nginx/yilan.conf.example` 里的 `fastcgi_pass` 改成对应值。

## 4. 重载服务

```bash
nginx -t
nginx -s reload
```

如果 `php-fpm` 还没启动，也需要启动它。Homebrew 常见方式：

```bash
brew services start php
```

如果你装的是版本化包，例如 `php@8.2`，则改成对应名字。

## 5. 自检

打开：

- `http://localhost:8088`

如果首页空白或 502，优先检查：

- `php-fpm` 是否已启动
- `fastcgi_pass` 是否和 PHP-FPM 监听地址一致
- `App/Common/Conf/config.php` 的数据库连接是否可用
