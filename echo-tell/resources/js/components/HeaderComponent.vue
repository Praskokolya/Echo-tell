<template>
    <header>
        <nav class="nav">
            <div class="nav-container">
                <a href="/home" class="brand">Echo tell</a>
                <button v-if="!isDesktop"@click="toggleMenu" class="menu-toggle">☰</button>
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
                        <a href="/notifications">
                            <span @mouseover="hideIndicator"
                                >Notifications</span
                            >
                            <div
                                v-if="showIndicator == 1"
                                class="notification-indicator"
                            >
                                !
                            </div>
                        </a>

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
                            <p
                                v-if="notifications.length === 0"
                                class="no-notifications"
                            >
                                No new notifications.
                            </p>
                        </div>
                    </li>
                    <li>
                        <a href="/user/interactions" class="nav-item"
                            >Your interactions</a
                        >
                    </li>
                </ul>
            </div>
        </nav>
    </header>
</template>

<script>
import Echo from "laravel-echo";
import Pusher from "pusher-js";
import axios from "axios";

window.Pusher = Pusher;

export default {
    data() {
        return {
            isDesktop: window.innerWidth >= 1024,
            notificationCount: 0,
            notifications:
            JSON.parse(localStorage.getItem("notifications")) || [],
            showMenu: false,
            showIndicator: localStorage.getItem('showIndicator'),
        };
    },
    methods: {
        hideIndicator() {
            console.log(this.showIndicator)
            this.showIndicator = 0
            localStorage.setItem('showIndicator', 0)
        },
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
        fetchUserData() {
            console.log(this.showIndicator)

            axios
                .get("/api/user/user-data")
                .then((response) => {
                    this.userId = response.data.id;
                    this.connectToChannel();
                })
                .catch((error) => {
                    console.error("Error fetching user data:", error);
                });
        },
        connectToChannel() {
            if (this.userId) {
                window.Echo = new Echo({
                    broadcaster: "pusher",
                    key: import.meta.env.VITE_PUSHER_APP_KEY,
                    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
                    forceTLS: true,
                    encrypted: true,
                    authEndpoint: "/broadcasting/auth",
                    auth: {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem(
                                "access_token"
                            )}`,
                        },
                    },
                });

                window.Echo.private(`notification.` + this.userId).listen(
                    "NewInteraction",
                    (data) => {

                        console.log("New response received:", data);
                        this.notifications.push(...data.response);
                        this.limitNotifications();
                        this.updateLocalStorage();

                        localStorage.setItem('showIndicator', 1)
                        this.showIndicator = 1
                        this.isNotificationVisible = true;

                        setTimeout(() => {
                            this.isNotificationVisible = false;
                        }, 2000);
                    }
                );
            }
        },
        hideNotificationIndicator() {
            this.showIndicator = false;
        },
        showNotificationIndicator() {
            this.showIndicator = true;
        },
    },
    mounted() {
        this.fetchUserData();
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

.notification-indicator {
    background-color: red;
    color: white;
    font-size: 14px;
    font-weight: bold;
    border-radius: 30%;
    padding: 2px 10px;
    margin-left: 8px;
    display: inline-block;
    text-align: center;
    transition: opacity 0.3s ease-in-out;
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
    margin-top: 10px;
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

.no-notifications {
    color: #888;
    font-size: 14px;
    text-align: center;
    margin-top: 20px;
}

@media (max-width: 768px) {
    .nav-menu {
        display: none;
        flex-direction: column;
        position: absolute;
        top: 60px;
        left: 0;
        width: 100%;
        background-color: #fff;
        border-top: 1px solid #ddd;
    }

    .nav-menu.active {
        display: flex;
    }

    .nav-menu li {
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }

    .menu-toggle {
        display: block;
        background: none;
        border: none;
        cursor: pointer;
        padding: 10px;
    }

    .menu-toggle {
        font-size: 30px;
        color: #333;
    }

    .menu-toggle:focus .menu-icon {
        background-color: #5e81ac;
    }
}
</style>
