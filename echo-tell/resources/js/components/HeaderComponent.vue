<template>
    <header>
        <nav class="nav">
            <div class="nav-container">
                <a href="/home" class="brand">Echo tell</a>
                <ul class="nav-menu" :class="{ active: isMenuOpen }">
                    <li>
                        <a href="/create/question" class="nav-item"
                            >Create question</a
                        >
                    </li>
                    <li>
                        <a href="/questions" class="nav-item">Your questions</a>
                    </li>
                    <li
                        class="nav-item"
                        @mouseover="showNotificationsMenu"
                        @mouseleave="hideNotificationsMenu"
                    >
                        <a href="/notifications">Notifications</a>
                        <span
                            v-if="notificationCount > 0"
                            class="notification-badge"
                            >{{ notificationCount }}</span
                        >
                        <div v-if="showMenu" class="notifications-dropdown">
                            <ul>
                                <li
                                    v-for="(
                                        notification, index
                                    ) in notifications"
                                    :key="index"
                                    class="notification-card"
                                >
                                    <a :href="notification.url">
                                        <div class="notification-header">
                                            <strong>{{
                                                notification.title
                                            }}</strong>
                                        </div>
                                        <div class="notification-body">
                                            {{ notification.message }}
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li><a href="/user/interactions" class="nav-item">Your interactions</a></li>
                </ul>
            </div>
        </nav>
    </header>
</template>

<script>
import Echo from "laravel-echo";
import Pusher from "pusher-js";

window.Pusher = Pusher;

export default {
    data() {
        return {
            isMenuOpen: false,
            notificationCount: 0,
            notifications:
                JSON.parse(localStorage.getItem("notifications")) || [],
            showMenu: false,
        };
    },
    methods: {
        toggleMenu() {
            this.isMenuOpen = !this.isMenuOpen;
        },
        showNotificationsMenu() {
            this.showMenu = true;
        },
        hideNotificationsMenu() {
            this.showMenu = false;
        },
        updateLocalStorage() {
            localStorage.setItem(
                "notifications",
                JSON.stringify(this.notifications)
            );
            this.notificationCount = this.notifications.length;
        },
        limitNotifications() {
            if (this.notifications.length > 3) {
                this.notifications = this.notifications.slice(-3);
            }
        },
    },
    mounted() {
        window.Echo = new Echo({
            broadcaster: "pusher",
            key: import.meta.env.VITE_PUSHER_APP_KEY,
            cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
            forceTLS: true,
            encrypted: true,
        });

        window.Echo.channel("notifications").listen("NewResponse", (data) => {
            console.log("New response received:", data);
            this.notifications.push(...data.response);
            this.limitNotifications();
            this.updateLocalStorage();
            console.log("Notification count:", this.notifications);
        });
    },
};
</script>
<style scoped>
.nav {
    background-color: #fff;
    padding: 15px 20px;
    position: sticky;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000;
    border-bottom: 1px solid #ddd;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    height: 60px;
}

.nav-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
}

.brand {
    color: #333;
    font-size: 24px;
    text-decoration: none;
}

.nav-menu {
    list-style: none;
    display: flex;
    margin: 0;
    padding: 0;
}

.nav-menu li {
    margin-left: 20px;
}

.nav-item {
    color: #333;
    text-decoration: none;
    font-size: 16px;
    font-weight: 500;
}

.nav-item:hover {
    color: #5e81ac;
}

.notification-card {
    cursor: pointer;
    border: 1px solid #ddd;
    padding: 15px;
    margin-bottom: 15px;
    border-radius: 10px;
    background-color: #f9f9f9;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease-in-out;
}

.notification-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    background-color: #e9f2fe;
}

.notification-header {
    font-weight: bold;
    font-size: 16px;
    color: #5e81ac;
    margin-bottom: 8px;
}

.notification-body {
    font-size: 14px;
    color: #333;
    line-height: 1.5;
}

.notification-card a {
    text-decoration: none;
    color: inherit;
}

.notification-card a:hover {
    text-decoration: underline;
}

.notification-card:active {
    background-color: #d0e3ff;
}
.notifications-dropdown {
    position: absolute;
    top: 55%;
    right: 0;
    background-color: white;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    border: 1px solid #ddd;
    padding: 10px;
    width: 300px;
    max-height: 400px;
    overflow-y: auto;
    z-index: 100;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    margin-top: 10px;
}


@media (max-width: 768px) {
    .nav-menu {
        position: absolute;
        top: 60px;
        left: 0;
        width: 100%;
        background-color: #fff;
        display: none;
        flex-direction: column;
        padding: 0;
        border-top: 1px solid #ddd;
    }

    .nav-menu.active {
        display: flex;
    }

    .nav-menu li {
        margin: 0;
        padding: 10px 20px;
        border-bottom: 1px solid #ddd;
    }
}
</style>
