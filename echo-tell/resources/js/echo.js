import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher', // Використовуємо Pusher як провайдера
    key: 'YOUR_APP_KEY', // Вставте ваш ключ
    cluster: 'YOUR_APP_CLUSTER', // Вставте ваш кластер
    forceTLS: true, // Використовувати SSL
});
