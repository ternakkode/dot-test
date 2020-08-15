# Laravel REST API & Admin Panel Article

Admin Panel & REST API Untuk keperluan manajemen artikel blog. Silahkan kunjungi __[Dokumentasi API](https://documenter.getpostman.com/view/10422266/T1LPD6nk?version=latest)__ untuk detail API

### Development Stack, Package, Template

1. __[Laravel 7.4](https://laravel.com/docs/7.x/)__ -- Frameworks Backend
2. __[JWT auth](https://github.com/tymondesigns/jwt-auth)__ - Autentikasi
3. __[Bootstrap 4.3](https://getbootstrap.com/docs/4.3/getting-started/introduction/)__ -- Frameworks Frontend
4. __[jQuery 3.3.1](https://api.jquery.com/)__ -- Javascript Frontend
5. __[Stisla](https://github.com/stisla/stisla)__ -- UI Template
6. __[Sweetalert2](https://github.com/sweetalert2/sweetalert2)__ -- Popup Template

### Cara Memulai
1. Silahkan clone repository ini ke desktop kamu.
2. Import database mysql yang terletak di `documentation/dot-test.sql`
3. Ketik `composer install` melalui terminal untuk menginstall package.
4. Ketik `cp .env.example .env` melalui terminal untuk menambahkan environment file.
5. Ubah beberapa setting di environment file menjadi : `APP_ENV=production`, `APP_DEBUG=false`
6. Generate APP Key dan juga JWT Secret Key melalui terminal dengan command `php artisan key:generate` dan `php artisan jwt:secret`
7. Sebelum melakuan deployment lakukan optimasi dengan optimasi package, caching config, routes dan views melalui terminal dengan command `composer install --optimize-autoloader --no-dev`, `php artisan config:cache`, `php artisan route:cache`, `php artisan view:cache`

### Database Design
![Desain Database](https://github.com/ternakkode/dot-test/blob/develop/documentation/database-design.png?raw=true)

### Screenshoot
- Halaman Login
![Halaman Login](https://github.com/ternakkode/dot-test/blob/develop/documentation/login.png?raw=true)

- Halaman Awal / List Artikel
![Halaman awal / List Artikel ](https://github.com/ternakkode/dot-test/blob/develop/documentation/list-artikel.png?raw=true)

- Tambah Artikel
![Tambah Artikel](https://github.com/ternakkode/dot-test/blob/develop/documentation/tambah-artikel.png?raw=true)

- Edit Artikel
![Edit Artikel](https://github.com/ternakkode/dot-test/blob/develop/documentation/edit-artikel.png?raw=true)

- List Kategori
![List Kategori](https://github.com/ternakkode/dot-test/blob/develop/documentation/list-kategori.png?raw=true)

- Tambah Kategori
![Tambah Kategori](https://github.com/ternakkode/dot-test/blob/develop/documentation/tambah-kategori.png?raw=true)

- Edit Kategori
![Edit Kategori](https://github.com/ternakkode/dot-test/blob/develop/documentation/edit-kategori.png?raw=true)


