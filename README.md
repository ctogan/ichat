<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Instalation
1. Run php artisan key:generate => create env file
2. create and setup database in env file
3. Run php artisan optimize:clear  => clear cache
4. Run php artisan migrate => migrate database
5. Run php artisan db:seed => insert data to database.
    if not working, we can run one by one
    - php artisan db:seed --class=CustomersSeeder
    - php artisan db:seed --class=EventSeeder
    - php artisan db:seed --class=PurchaseTransactionSeeder
    - php artisan db:seed --class=VouchersSeeder
6. Go to http::127.0.0.1:8000/api/documentation => Swagger Page *port is depend your local

##How it work

Ada 5 alamat api yang saya buat. Anda dapat menemukan nya di folder routes/api.php 
1. Frontend akan mengambil semua data event dengan menggunakan alamat api : api/event
2. Untuk melihat voucher pada event tersebut yang masih aktif menggunakan api : api/event/detail
3. Untuk Reedem Voucher gunakan api : api/event/reedem. validasi yang digunakan adalah
    - check voucher apakah tersedia
    - existing user
    - minimal transaksi
    - minimal melakukan transaksi
4. Untuk upload image akan menggunakan api api/event/reedem/upload. validasi yang digunakan adalah  
   - waktu upload < 10 menit. Jika waktu lebih dari 10 menit, maka status is_used di voucher akan di kembalikan menjadi false
   - Jika waktu kurang dari 10 menit, maka akan memanggil API IMAGE CHECKER.
   * mohon diperhatikan agar melakukan upload menggunakan aplikasi seperti postman, dikarenakan ada kesalahan configurasi di swagger sehingga swagger tidak dapat melakukan upload
5. Untuk API IMAGE CHECKER dapat mengirimkan response, maka akan memanggil api /callback/validation/image.
6. Terdapat function task scheduler untuk melakukan perintah pengembalian voucher secara otomatis (is_used = false) apabila user tidak melakukan upload lebih dari 10 menit.
   Saat ini task scheduler berjalan daily, tetapi jika menggunakan nya secara manual jalankan perintah "php artisan schedule:run"
