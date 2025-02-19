<template>
    <div class="container">
        <nav class="sidebar">
            <ul>
                <li v-if="user">
                    <label>
                        <input
                            type="checkbox"
                            v-model="notificationsEnabled"
                            @change="updateMailNotifications"
                            class="checkbox"
                        />
                        <i class="fas fa-envelope"></i> Send notifications to
                        mail
                    </label>
                </li>
                <li v-if="user">
                    <label>
                        <input
                            type="checkbox"
                            v-model="statMails"
                            @change="updateDailyMails"
                            class="checkbox"
                        />
                        <i class="fas fa-shield-alt"></i> Send daily statistics
                        to mail
                    </label>
                </li>
            </ul>
        </nav>

        <main class="main-content">
            <header>
                <h1>Dashboard</h1>
            </header>

            <div v-if="user" class="user-info">
                <div class="card profile-card">
                    <h2>Profile Information</h2>
                    <div class="profile-details">
                        <div class="profile-item">
                            <i class="fas fa-user"></i>
                            <div>
                                <span class="label">Name</span>
                                <span class="value">{{ user.name }}</span>
                            </div>
                        </div>
                        <div class="profile-item">
                            <i class="fas fa-envelope"></i>
                            <div>
                                <span class="label">Email</span>
                                <span class="value">{{ user.email }}</span>
                            </div>
                        </div>
                        <div class="profile-item">
                            <i class="fas fa-calendar-alt"></i>
                            <div>
                                <span class="label">Joined</span>
                                <span class="value">{{ formattedDate }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card url-card">
                    <h2>Share URL</h2>
                    <div class="url-container">
                        <input
                            type="text"
                            :value="user.url"
                            readonly
                            class="url-input"
                        />
                        <button
                            @click="copyUrl"
                            class="copy-btn"
                            :class="{ copied: urlCopied }"
                        >
                            <i class="fas fa-copy"></i>
                            <span>{{ urlCopied ? "Copied!" : "Copy" }}</span>
                        </button>
                    </div>
                </div>
            </div>
            <div>
                <button class="btn-green" @click="sendMail">
                    Send your daily statistics
                </button>
            </div>
            <div>
                <button class="btn-red" @click="logout">
                    Logout from account
                </button>
            </div>
        </main>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            user: null,
            urlCopied: false,
            statMails: false,
            notificationsEnabled: false,
        };
    },
    methods: {
        getData() {
            axios
                .get("/api/user/user-data")
                .then((response) => {
                    this.user = response.data;
                    this.notificationsEnabled = Boolean(
                        response.data.settings.email_notifications_enabled
                    );
                    this.statMails = Boolean(
                        response.data.settings.daily_mails_enabled
                    );
                })
                .catch((error) => console.error("Error fetching data:", error));
        },
        updateMailNotifications() {
            axios
                .patch("api/settings/mail-notifications", {
                    email_notifications_enabled: this.notificationsEnabled,
                })
                .then((response) =>
                    console.log("Mail notifications updated:", response.data)
                )
                .catch((error) =>
                    console.error("Error updating mail notifications:", error)
                );
        },
        updateDailyMails() {
            axios
                .patch("api/settings/daily-mails", {
                    daily_mails_enabled: this.statMails,
                })
                .catch((error) => {
                    console.error("Error updating daily mails:", error);
                    this.statMails = !this.statMails;
                });
        },
        logout() {
            isConfirmed = confirm(
                "Are you sure you want logout from your account?"
            );
            if (isConfirmed) {
                axios.post("logout").then(() => {
                    window.location.href = "/auth";
                    localStorage.removeItem("access_token");
                });
            }
        },
        sendMail() {
            axios
                .post("/api/send-daily-statistics")
                .then((response) => {
                    console.log("Email sent successfully:", response.data);
                })
                .catch((error) => {
                    console.error("Error sending email:", error);
                });
        },
        copyUrl() {
            if (this.user?.url) {
                navigator.clipboard.writeText(this.user.url).then(() => {
                    this.urlCopied = true;
                    setTimeout(() => (this.urlCopied = false), 2000);
                });
            }
        },
    },
    computed: {
        formattedDate() {
            return this.user?.created_at
                ? new Date(this.user.created_at).toLocaleDateString()
                : "";
        },
    },
    created() {
        this.getData();
    },
};
</script>

<style scoped>
.container {
    display: flex;
    min-height: 100vh;
    background-color: #f0f2f5;
    font-family: "Poppins", sans-serif;
}

.sidebar {
    width: 250px;
    background-color: #ffffff;
    color: #333;
    padding: 2rem;
    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
}

.sidebar ul {
    list-style-type: none;
    padding: 0;
}

.sidebar ul li {
    margin: 1rem 0;
}

.sidebar ul li label {
    display: flex;
    align-items: center;
    cursor: pointer;
    font-size: 1rem;
}

.sidebar ul li label .checkbox {
    margin-right: 10px;
    accent-color: #1a73e8;
}

.main-content {
    flex: 1;
    padding: 2rem;
}
.btn-red {
    margin-top: 20px;
    background-color: #dc3545;
    color: white;
    padding: 0.5rem 1rem;
    font-size: 1rem;
    font-weight: 500;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.2s ease-in-out;
}
.btn-green {
    margin-top: 20px;
    background: linear-gradient(135deg, #4caf50, #45a049);
    color: white;
    padding: 0.6rem 1.2rem;
    font-size: 1rem;
    font-weight: 500;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.2s ease-in-out;
}

.btn-green:hover {
    background: linear-gradient(135deg, #3e8e41, #388e3c);
}

.btn-green:active {
    background: linear-gradient(135deg, #357a38, #2e7d32);
}

.btn-red:hover {
    background-color: #c82333;
}

.btn-red:active {
    background-color: #bd2130;
}
header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

h1 {
    color: #333;
    font-size: 2rem;
    font-weight: 600;
}

.user-info {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
}

.card {
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    padding: 2rem;
    transition: all 0.3s ease;
}

.card:hover {
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    transform: translateY(-5px);
}

.card h2 {
    color: #333;
    font-size: 1.5rem;
    margin-bottom: 1.5rem;
    font-weight: 600;
}

.profile-details {
    display: grid;
    gap: 1rem;
}

.profile-item {
    display: flex;
    align-items: center;
}

.profile-item i {
    font-size: 1.5rem;
    color: #1a73e8;
    margin-right: 1rem;
}

.profile-item .label {
    font-size: 0.9rem;
    color: #666;
    display: block;
}

.profile-item .value {
    font-size: 1.1rem;
    color: #333;
    font-weight: 500;
}

.url-container {
    display: flex;
    align-items: center;
}

.url-input {
    flex: 1;
    padding: 0.75rem;
    border: 1px solid #ddd;
    border-radius: 5px 0 0 5px;
    font-size: 1rem;
    color: #333;
}

.copy-btn {
    background-color: #1a73e8;
    color: white;
    border: none;
    padding: 0.75rem 1rem;
    font-size: 1rem;
    cursor: pointer;
    border-radius: 0 5px 5px 0;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
}

.copy-btn i {
    margin-right: 5px;
}

.copy-btn:hover {
    background-color: #1557b0;
}

.copy-btn.copied {
    background-color: #34a853;
}
@media (max-width: 1024px) {
    .container {
        flex-direction: column;
    }

    .sidebar {
        width: 100%;
        padding: 1rem;
        box-shadow: none;
    }

    .main-content {
        padding: 1rem;
    }

    .user-info {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .sidebar ul li label {
        font-size: 0.9rem;
    }

    .btn-red {
        width: 100%;
        text-align: center;
    }

    .profile-item i {
        font-size: 1.2rem;
    }

    .profile-item .label {
        font-size: 0.8rem;
    }

    .profile-item .value {
        font-size: 1rem;
    }

    .url-input {
        font-size: 0.9rem;
        padding: 0.5rem;
    }

    .copy-btn {
        font-size: 0.9rem;
        padding: 0.5rem;
    }
}

@media (max-width: 480px) {
    h1 {
        font-size: 1.5rem;
    }

    .card {
        padding: 1.5rem;
    }

    .copy-btn {
        flex: 1;
        justify-content: center;
    }

    .url-container {
        flex-direction: column;
        gap: 0.5rem;
    }

    .url-input {
        width: 100%;
        border-radius: 5px;
    }

    .copy-btn {
        border-radius: 5px;
    }
}
</style>
