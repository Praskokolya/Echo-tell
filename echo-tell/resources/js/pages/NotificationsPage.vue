<template>
    <div>
        <div v-if="notifications.length" class="notifications-container">
            <a  
                v-for="(notification, index) in notifications"
                :key="index"
                :href="notification.data.url"
                class="notification-card"
            >
                <p>{{ notification.data.message }}</p>
            </a>
        </div>
        <div v-else>
            <p>No new notifications.</p>
        </div>

        <div v-if="pagination.total > 1" class="pagination">
            <button
                :disabled="pagination.current_page === 1"
                @click="changePage(pagination.current_page - 1)"
                class="pagination-button"
            >
                Previous
            </button>
            <span class="pagination-info">
                Page {{ pagination.current_page }} of {{ pagination.last_page }}
            </span>
            <button
                :disabled="pagination.current_page === pagination.last_page"
                @click="changePage(pagination.current_page + 1)"
                class="pagination-button"
            >
                Next
            </button>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            notifications: [],
            pagination: {
                current_page: 1,
                last_page: 1,
                total: 0,
            },
        };
    },
    methods: {
        getNotifications(page = 1) {
            axios
                .get(`/api/notifications?page=${page}`)
                .then((response) => {
                    this.notifications = response.data.data;
                    this.pagination = response.data.meta;
                })
                .catch((error) => {
                    console.error("Error fetching notifications:", error);
                });
        },
        changePage(page) {
            this.getNotifications(page);
        },
    },
    mounted() {
        this.getNotifications();
    },
};
</script>

<style scoped>
.notifications-container {
    display: flex;
    flex-direction: column;
    gap: 20px;
    padding: 20px;
}

.notification-card {
    background-color: #fff;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.notification-card:hover {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transform: translateY(-5px);
}

.notification-card p {
    font-size: 16px;
    color: #333;
    margin: 0;
}

.notifications-container p {
    text-align: center;
    color: #888;
}

/* Pagination Styles */
.pagination {
    display: flex;
    justify-content: space-between;
    padding: 20px;
    align-items: center;
}

.pagination-button {
    background-color: #5e81ac;
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.pagination-button:hover {
    background-color: #4c6b96;
}

.pagination-button:disabled {
    background-color: #ddd;
    cursor: not-allowed;
}

.pagination-info {
    font-size: 16px;
    color: #333;
    font-weight: 500;
}
</style>
