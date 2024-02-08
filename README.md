<div dir="rtl">

# درباره برنامه

این یک برنامه ساده است که به شما نشان می دهد چطور بخشی از یک فروشگاه کتاب ساده را با لاراول را به صورت استاندارد پیاده سازی کنید.


# راه اندازی برنامه
برای راه اندازی برنامه ابتدا باید پایگاه داده خود را ایجاد کنید سپس متغییر های محیطی تنظیم کنید. برای اینکار باید فایل .env را تنظیم کنید. میتوانید با استفاده از دستور زیر این فایل را با متغییر های مورد نیاز ایجاد کنید:
```shell
cp .env.example .env
```
سپس مشخصات پایگاه داده خود را به جای مقادیر زیر جایگذاری کنید: 
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=
DB_PASSWORD=
```
سپس با استفاده از دستور زیر مایگریشن های را اجرا نمایید:
```
php artisan migrate
```

و در نهایت برنامه را اجرا کنید:
```
php artisan serve
```
# اجرای تست ها
برای اطمینان از عملکرد صحیح برنامه بهتر است تست ها برنامه را اجرا کنید. برای این کار دستور زیر را در ترمینال خود و در مسیر اصلی برنامه وارد نمایید.

```shell
php artisan test
```
</div>
