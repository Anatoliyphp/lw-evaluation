# Установка проекта

## 1. Устанавливаем node.js  и npm
https://nodejs.org/ru/download/package-manager/

## 2. Устанавливаем typescript глобально
```shell
npm install -g typescript
```

## 3. Устанавливаем локальные зависимости
Выполняем команду в папке с проектом:
```shell
npm install
```

## 4. Запуск приложения
```shell
npm start
```

## 5. Просмотр приложения в браузере
Из-за особенностей CORS-policy для того, что приложение заработало в режиме дебага нужно запустить Google Chrome без CORS:
https://alfilatov.com/posts/run-chrome-without-cors/
