# PHP 8.5 MVC Core Starter

`mvc-core`, paylasimli hosting uyumlu, modern PHP yaklasimlarini benimseyen ve gercek projelere hizli baslangic yapmayi hedefleyen bir MVC starter paketidir.

Bu sistem, sadece "hello world" seviyesinde bir iskelet degil; auth, middleware, policy, coklu dil, upload yonetimi, cron, observer, mail ve bildirim gibi kritik katmanlari birlikte sunan, gelistirilebilir bir temel platformdur.

## Bu Sistem Ne Sunuyor?

### Cekirdek Mimari

- PHP `8.5` uyumlu
- FastRoute tabanli routing
- Middleware pipeline (guvenlik + is kurali odakli)
- PSR-4 autoload + DI container
- `.env` tabanli konfig yonetimi
- Paylasimli hosting icin `public/` webroot modeli

### Uygulama Katmanlari

- Controller -> Service -> Repository ayrimi
- Policy/Gate tabanli yetki modeli
- Observer ve event tabanli is akislar
- Cron task kernel + script runner
- Startup lock mekanizmasi (ilk acilista migration/seeder)

### Hazir Islevler

- Coklu dil (TR/EN varsayilan) + opsiyonel locale prefix routing
- Auth sayfalari:
  - login, register
  - forgot password, confirm password, reset password
  - profile, verify email
- Admin route ayrimi (`admin` middleware)
- Permission middleware altyapisi
- Legal sayfalar:
  - cookie policy
  - terms of use
  - privacy policy

### Dosya ve Medya Yonetimi

- Public/private upload ayrimi
  - `public/uploads`
  - `storage/private/uploads`
- Image helper:
  - resize/crop/quality
- PDF/Excel/CSV helper:
  - import/export/download

### Bildirim ve Iletisim

- Mail sistemi (Symfony Mailer)
- Verify email mail temasi
- Notification kanallari:
  - mail
  - sms
  - web push
  - in-app
- OAuth2 benzeri API token altyapisi (client_credentials/password/refresh_token)
- SMS provider mimarisi:
  - Twilio
  - Vodafone
  - Turkcell
  - Turktelekom
- Browser tabanli, Firebase'siz Web Push (VAPID + Service Worker)

### Frontend Altyapisi

- TailwindCSS
- PostCSS + Autoprefixer
- Esbuild bundling
- `npm run dev` / `npm run build` akislari

## Bu Sistemle Neler Yapabilirsiniz?

- Kurumsal veya KOBI seviyesinde bir web uygulamasini sifirdan hizlica ayaga kaldirabilirsiniz.
- Login/register disinda daha kapsamli auth akislarini (sifre sifirlama, email verification) hizla adapte edebilirsiniz.
- Admin panel + rol/izin bazli yetkilendirme ile cok kullanicili bir SaaS temeli olusturabilirsiniz.
- Coklu dil destekli, SEO dostu ve locale-aware routing kullanan sayfa yapilari kurabilirsiniz.
- Raporlama, export/import ve dosya yukleme ihtiyaclarini tek bir starter icinde yonetebilirsiniz.
- Cron ve observer katmanlari ile periyodik ve event-driven is akislarini ayristirabilirsiniz.
- Notification sistemi sayesinde ayni olayi birden fazla kanala (mail/sms/web-push/in-app) dagitabilirsiniz.

## Hızlı Baslangic

1. Bagimliliklari kur:
   - `composer install`
   - `npm install`
2. Ortam dosyasini olustur:
   - Windows: `copy .env.example .env`
   - Linux/macOS: `cp .env.example .env`
3. `APP_KEY` uret ve `.env` icine koy:
   - PowerShell: `php -r "echo bin2hex(random_bytes(32)), PHP_EOL;"`
   - Bash: `php -r 'echo bin2hex(random_bytes(32)), PHP_EOL;'`
4. Veritabanini olustur (ornek: `mvc_core`) ve baglanti bilgilerini `.env` dosyasina yaz.
5. Veritabani kurulumunu calistir:
   - `composer run migrate-seed`
6. Asset build al:
   - `npm run build`
7. Web root'u `public/` olarak ayarla.
8. Ortam kontrolu calistir:
   - `php scripts/deploy-check.php`

## Temel Komutlar

- Test:
  - `composer test`
- Migration:
  - `composer run migrate`
- Seeder:
  - `composer run seed`
- Migration + Seeder:
  - `composer run migrate-seed`
- Cron:
  - `composer run cron`
- VAPID key üret:
  - `composer run generate-vapid`
- Asset build:
  - `npm run build`

## Hazir Route Gruplari (Ozet)

- Public:
  - `/`
  - `/cookie-policy`, `/terms-of-use`, `/privacy-policy`
- Auth:
  - `/login`, `/register`
  - `/forgot-password`, `/confirm-password`, `/reset-password`
  - `/profile`, `/verify-email`
- OAuth/API:
  - `/oauth/token`
  - `/api/me`
- Admin:
  - `/admin/dashboard`
- Sistem:
  - `/_components/{name}/{action}`
  - `/notifications/web-push/subscribe`

## Neden Bu Starter?

- "Sadece calisan kod" degil, "buyuyebilen mimari" sunar.
- Yeni ozellik eklerken kodu kirmaz; katmanlar ayrik oldugu icin bakimi kolaydir.
- Paylasimli hosting dahil olmak uzere farkli deployment senaryolarina uygundur.
- Gercek dunya gereksinimlerini (guvenlik, i18n, bildirim, dosya, cron) erken fazda cozer.

## Uretim Notlari

- SMS kanali sadece kullanicida telefon bilgisi varsa calisir; hardcoded hedef kullanilmaz.
- Web-push payload'larinda hassas dogrulama tokeni gonderilmez.
- Locale routing su an `tr|en` desenine sabitlenmistir; yeni locale icin route regex ve dil dosyalari genisletilmelidir.
- Confirm-password adimi demo seviyesindedir; reset/verify akislarinda token persistence + expiry aktif olarak uygulanmistir.

## Dokumantasyon

Tum detayli anlatimlar `Docs/` altindadir:

- `Docs/00-Getting-Started.md`
- `Docs/01-Architecture.md`
- `Docs/02-Installation.md`
- `Docs/03-Routing-Middleware.md`
- `Docs/04-Auth-Policy.md`
- `Docs/05-Service-Repository.md`
- `Docs/06-Deployment-Shared-Hosting.md`
- `Docs/07-Examples.md`
- `Docs/08-Advanced-Features.md`
- `Docs/09-Components-System.md`
- `Docs/10-Tailwind-Setup.md`
- `Docs/11-Migrations-Seeders-AutoRun.md`
- `Docs/12-Security-Hardening-Checklist.md`
- `Docs/13-Uploads-Cron-Observers-Notifications.md`
- `Docs/14-OAuth2.md`
