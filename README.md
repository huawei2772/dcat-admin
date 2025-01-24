## 项目介绍

laravel 11 跟dcat admin结合的多语言网站

## 安装

```bash
# 生产环境  
composer install --no-dev -vvv

# 开发环境
composer install -vvv

# 复制.env.example文件为.env
cp .env.example .env

# 生成key
php artisan key:generate

# 迁移数据库
php artisan migrate

# 安装dcat admin
php artisan admin:install

# 安装后台初始数据
php artisan db:seed

```

## 可选配置

```bash
# 使用本地存储时，需要创建storage软链接
php artisan storage:link
```
