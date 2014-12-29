--install laravel
composer create-project laravel/laravel project-name-goes-here --prefer-dist

--init vagrant
vagrant init precise32 http://files.vagrantup.com/precise32.box



--start vagrant
vagrant up

--reload vagrant configuration
vagrant reload

--suspend vagrant
vagrant suspend

--destroy vagrant
vagrant destroy


--composer install




Laravel notlar


http://laravel.com/docs/migrations

php artisan migrate
php artisan db:seed



http://driesvints.com/blog/using-laravel-4-model-events

model events






git--------------------------------
butun yeni dosyalari tracked olarak isaretler

git config --global user.name "John Doe"
git config --global user.email "me@here.com"

git clone //server01/Projects/intranet
git add -A
git add .
git add -u .

git commit -m "Use this message and don't open the editor"
git push origin master




manual
git init
git remote add origin //server01/Projects/intranet