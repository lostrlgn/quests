 сервис с API для записи пользователей на квесты в реальности.

Технологии: PHP 7.4+/8+, Yii2.

1. Клонируем репозиторий:
git clone https://github.com/lostrlgn/quests.git

2. Настраиваем подключение к базе данных в config/db.php:

3. Применяем миграции:
php yii migrate

4. Авторизация

POST /auth/register — регистрация
Параметры: name, phone, email, password_hash
Возвращает: access_token

POST /auth/login — вход
Параметры: email, password_hash
Возвращает: access_token

Квесты

GET /quests — список всех квестов

GET /quest/{id} — информация о квесте

Слоты квеста

GET /quest-slots/{id}?date=YYYY-MM-DD
Требует Bearer токен
Возвращает все слоты квеста по дате (занятые + свободные)

Бронирование

POST /reserve/{id}
Требует Bearer токен
Параметры: date, time
Проверяет: слот свободен, квест работает, пользователь свободен

GET /bookings — список всех бронирований пользователя

POST /booking-cancel/{id} — отмена бронирования

5. OpenAPI / Swagger
Файл: openapi.yaml

6. Unit-тесты.
   Запуск тестов: php vendor/bin/phpunit
