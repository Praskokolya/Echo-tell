/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});

import HeaderComponent from './components/HeaderComponent.vue';
import WelcomePage from './pages/WelcomePage.vue';
import AuthPage from './pages/AuthPage.vue';
import RegistrationPage from './pages/RegistrationPage.vue';
import QuestionPage from './pages/questions/QuestionPage.vue';
import InteractionsPage from './pages/responses/InteractionsPage.vue';
import AllQuestionsPage from './pages/questions/AllQuestionsPage.vue';
import NotificationsPage from './pages/NotificationsPage.vue';
import ResponsePage from './pages/responses/ResponsePage.vue';
import QuestionResponsesPage from './pages/responses/QuestionResponsesPage.vue';
import CreateQuestionPage from './pages/questions/CreateQuestionPage.vue';
import HomePage from './pages/home/HomePage.vue';
import ProfilePage from './pages/ProfilePage.vue';
import MessagePage from './pages/messages/MessagePage.vue';
import UserMessagesPage from './pages/messages/UserMessagesPage.vue';

app.component('home-page', HomePage)
app.component('header-component', HeaderComponent);
app.component('welcome-page', WelcomePage);
app.component('auth-page', AuthPage) 
app.component('registration-page', RegistrationPage) 
app.component('create-question-page', CreateQuestionPage)
app.component('question-page', QuestionPage)
app.component('interactions-page', InteractionsPage)
app.component('all-questions-page', AllQuestionsPage);
app.component('notifications-page', NotificationsPage);
app.component('response-page', ResponsePage)
app.component('question-responses-page', QuestionResponsesPage);
app.component('profile-page', ProfilePage)
app.component('message-page', MessagePage)
app.component('user-messages-page', UserMessagesPage)

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

app.mount('#app');
