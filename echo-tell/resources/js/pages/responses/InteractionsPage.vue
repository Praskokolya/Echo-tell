<template>
    <div class="sidebar">
        <div class="filter-buttons">
            <button
                @click="loadInteractions('responses')"
                :class="{ active: filterType === 'responses' }"
            >
                Responses
            </button>
            <button
                @click="loadInteractions('messages')"
                :class="{ active: filterType === 'messages' }"
            >
                Messages
            </button>
        </div>
    </div>

    <div class="interactions-container" v-if="interactions.length > 0">
        <div
            v-for="item in interactions"
            :key="item.id"
            class="interaction-card"
        >
            <div class="card-header">
                <p>
                    <strong>Name visibility:</strong>
                    {{ item.name_visibility === 0 ? "Hidden" : "Visible" }}
                </p>
            </div>
            <div class="card-body">
                <template v-if="item.type === 'response'">
                    <p>
                        <strong>Question:</strong>
                        {{ getQuestionSnippet(item.question) }}
                    </p>
                    <p><strong>Response:</strong> {{ item.response }}</p>
                </template>

                <template v-else-if="item.type === 'message'">
                    <p><strong>Message:</strong> {{ item.message }}</p>
                    <p><strong>Sender:</strong> {{ item.sender_name }}</p>
                </template>

                <div class="card-footer">
                    <button
                        class="delete-btn"
                        @click="deleteItem(item.id, item.type)"
                    >
                        Delete
                    </button>
                    <span class="time-ago">{{
                        formatTime(item.created_at)
                    }}</span>
                </div>
            </div>
        </div>
    </div>

    <div v-else class="no-interactions">
        <p>You haven't interacted with anybody yet.</p>
    </div>

    <div class="pagination" v-if="meta">
        <button
            @click="loadPage(meta.current_page - 1)"
            :disabled="meta.current_page === 1"
        >
            « Prev
        </button>

        <button
            v-for="link in meta.links"
            :key="link.label"
            @click="loadPage(link.url)"
            :class="{ active: link.active }"
            v-if="link && link.url"
        >
            {{ link.label }}
        </button>

        <button
            @click="loadPage(meta.current_page + 1)"
            :disabled="meta.current_page === meta.last_page"
        >
            Next »
        </button>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            interactions: [],
            filterType: "responses",
            meta: null,
        };
    },
    methods: {
        async loadInteractions(type, page = 1) {
            this.filterType = type;
            this.interactions = [];

            try {
                const res = await axios.get(
                    `/api/user/${this.filterType}?page=${page}`
                );
                const data = res.data.data;

                this.interactions = data;
                this.meta = res.data.meta || null;
            } catch (error) {
                console.error(`Error fetching ${type}:`, error);
            }
        },
        async deleteItem(id, type) {
            try {
                let url = "";

                if (type === "message") {
                    url = `/api/message/${id}`;
                } else if (type === "response") {
                    url = `/api/response/${id}`;
                }

                const response = await axios.delete(url);

                if (response.status === 200) {
                    this.interactions = this.interactions.filter(
                        (item) => item.id !== id
                    );
                }
            } catch (error) {
                console.error(`Error deleting ${type}:`, error);
            }
        },
        formatTime(date) {
            const timeAgo = new Date(date);
            const now = new Date();
            const diff = Math.floor((now - timeAgo) / (1000 * 60));

            if (diff < 60) return `${diff} minutes ago`;
            if (diff < 1440) return `${Math.floor(diff / 60)} hours ago`;
            return `${Math.floor(diff / 1440)} days ago`;
        },
        getQuestionSnippet(question) {
            return question?.length > 200
                ? `${question.slice(0, 200)}...`
                : question;
        },
        loadPage(page) {
            if (page > 0 && page <= this.meta.last_page) {
                this.loadInteractions(this.filterType, page);
            }
        },
    },
    mounted() {
        this.loadInteractions(this.filterType);
    },
};
</script>

<style scoped>
.filter-buttons {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-bottom: 20px;
}

.filter-buttons button {
    padding: 8px 15px;
    font-size: 1rem;
    border: none;
    cursor: pointer;
    background-color: #bdc3c7;
    color: white;
    border-radius: 5px;
    transition: 0.3s;
    min-width: 120px;
    height: 40px;
}

.filter-buttons button:hover {
    background-color: #95a5a6;
}

.filter-buttons .active {
    background-color: #3498db;
    font-weight: bold;
}

.interactions-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 30px;
    margin: 40px;
}

.interaction-card {
    background: linear-gradient(135deg, #ffffff, #f4f7fc);
    border-radius: 18px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: 0.4s ease;
    cursor: pointer;
    height: 350px;
    display: flex;
    flex-direction: column;
}

.interaction-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 45px rgba(0, 0, 0, 0.2);
}

.card-header {
    background-color: #2c3e50;
    color: #ecf0f1;
    padding: 20px;
    text-align: center;
    border-radius: 18px 18px 0 0;
}

.card-body {
    padding: 20px;
    color: #34495e;
    font-size: 1.1rem;
    overflow-y: auto;
}

.card-body p {
    margin: 15px 0;
    line-height: 1.8;
}

.card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-top: 1px solid #ddd;
    flex-shrink: 0;
}

.delete-btn {
    background-color: #e74c3c;
    color: white;
    border: none;
    padding: 8px 15px;
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s ease;
}

.delete-btn:hover {
    background-color: #c0392b;
}

.time-ago {
    font-size: 0.9rem;
    color: #7f8c8d;
    font-style: italic;
}

.pagination {
    display: flex;
    justify-content: center;
    gap: 8px;
    margin-top: 20px;
}

.pagination button {
    padding: 8px 12px;
    border: none;
    cursor: pointer;
    background-color: #bdc3c7;
    color: white;
    border-radius: 5px;
    transition: 0.3s;
}

.pagination button.active {
    background-color: #3498db;
    font-weight: bold;
}

.pagination button:disabled {
    background-color: #95a5a6;
    cursor: not-allowed;
}

.no-interactions {
    text-align: center;
    margin-top: 20px;
    font-size: 1.2rem;
    color: #7f8c8d;
}
</style>
