# EntityVersioning
Ця програма дозволяє зливати різні версії сутностей у єдине ціле.
# Встановлення:
```sh
composer require salabun/entity-versioning
```
Підключи неймспейс у контроллері:
```sh
use Salabun\EntityVersioning;
```
# Використання:
Створи сутність:
```sh
$entity = new EntityVersioning;
```
Вкажи для яких властивостей сутності слід перевіряти версії:
```sh
$entity->addComparativeProperties(['title', 'description']);
```
Передай нові властивості сутності:
```sh
$entity->addIncomingProperties([
    'title' => 'Новий титул'
]);
```
Вкажи версії нових властивостей сутності:
```sh
$entity->addIncomingPropertiesVersions([
    'title' => 2
]);
```

Передай сутності збережені властивості:
```sh
$entity->addStoredProperties([
    'id' => 1,
    'title' => 'title 1',
]);
```
Вкажи версії збережених властивостей сутності:
```sh
$entity->addStoredPropertiesVersions([
    'id' => 1,
    'title' => 1,
]);
```
Виконай злиття властивостей:
```sh
$entity->merge();
```
Отримай нову версію сутності (лише властивості):
```sh
$entity->getEntity();
```
Отримай нову версію сутності включно з версіями:
```sh
$entity->getEntityWithVersions();
```
Отримай нові версії сутності:
```sh
$entity->getEntityVersions();
```

У злитій сутності версії будуть такими, які вказав фронтенд.
 
# Корисні методи:   

Отримати перелік властивостей, які мають версії:
```sh
$entity->getComparativeProperties();
```

Отримати інформацію про усі здійснені зміни:
```sh
$entity->getStoredPropertyChanges();
```
Отримати лише нові властивості для оновлення у БД:
```sh
$entity->getNewProperties();
```
Отримати лише нові версії для оновлення у БД:
```sh
$entity->getNewVersions();
```



# Важливо для фронтенда:   
При будь-якій зміні сутності, її версію слід збільшувати на +1 лише один раз, доки не відбудеться синхронізація із сервером.


# Контакти:
Влад Салабун  
vlad@salabun.com  
[https://salabun.com](https://salabun.com)