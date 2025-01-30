<template>
    <div class="responses-container">
        <div
            v-for="(item, index) in responses"
            :key="index"
            class="response-card"
        >
            <div class="card-header">
                <div class="name-visibility">
                    <p>
                        <strong>Name visibility:</strong>
                        {{
                            item.name_visibility === 0
                                ? "Hidden"
                                : "Visible"
                        }}
                    </p>
                </div>
            </div>
            <div class="card-body">
                <div v-if="item.type === 'response'">
                    <p>
                        <strong>Question:</strong>
                        {{ getQuestionSnippet(item.question) }}
                    </p>
                    <p><strong>Response:</strong> {{ item.response }}</p>
                </div>

                <div v-else-if="item.type === 'message'">
                    <p><strong>Message:</strong> {{ item.message }}</p>
                    <p><strong>User:</strong> {{ item.user }}</p>
                </div>

                <div class="card-footer">
                    <button
                        class="delete-btn"
                        @click="deleteResponse(item.id)"
                    >
                        Delete
                    </button>
                    <span class="time-ago">{{ formatTime(item.created_at) }}</span>
                </div>
            </div>
        </div>
    </div>
</template>



<script>
export default {
    data() {
        return {
            responses: [], // Містить як відповіді, так і повідомлення
        };
    },
    methods: {
    getResponses() {
        axios
            .get("/api/user/interactions")
            .then((response) => {
                this.responses = Object.values(response.data).map((item) => {
                    if (item.type === 'message') {
                        item.user = item.user || "Anonymous"; 
                    } else if (item.type === 'response') {
                        item.user = item.user_name || "Anonymous"; 
                    }
                    return item;
                });
                console.log(this.responses);
            })
            .catch((error) => {
                console.error("Error fetching responses:", error);
            });
    },
    formatTime(date) {
        const timeAgo = new Date(date);
        const now = new Date();
        const diff = Math.floor((now - timeAgo) / (1000 * 60));
        if (diff < 60) {
            return `${diff} minutes ago`;
        } else if (diff < 1440) {
            return `${Math.floor(diff / 60)} hours ago`;
        } else {
            return `${Math.floor(diff / 1440)} days ago`;
        }
    },
    getQuestionSnippet(question) {
        return question.length > 200 ? question.slice(0, 200) + "..." : question;
    },
    deleteResponse(responseId) {
        const responseToDelete = this.responses.find(
            (response) => response.id === responseId
        );
        if (responseToDelete) {
            axios
                .delete(`/api/response/${responseId}`)
                .then((response) => {
                    if (response.status === 200) {
                        this.responses = this.responses.filter(
                            (response) => response.id !== responseId
                        );
                    } else {
                        console.error(response.status);
                    }
                });
        }
    },
},

    mounted() {
        this.getResponses(); 
    },
};
</script>

<style scoped>
.responses-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 30px;
    margin: 40px;
}

.response-card {
    background: linear-gradient(135deg, #ffffff, #f4f7fc);
    border-radius: 18px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: transform 0.4s ease, box-shadow 0.3s ease,
        background-color 0.4s ease, border 0.3s ease;
    position: relative;
    cursor: pointer;
    border-left: 8px solid transparent;
    display: flex;
    flex-direction: column;
    height: 350px; 
}

.response-card:hover {
    transform: translateY(-15px) scale(1.05);
    box-shadow: 0 15px 45px rgba(0, 0, 0, 0.2);
    background-color: #f1f3f6;
    border-left-color: #4caf50;
}

.card-header {
    background-color: #2c3e50;
    color: #ecf0f1;
    padding: 20px;
    border-bottom: 2px solid #4caf50;
    text-align: center;
    border-radius: 18px 18px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
}

.card-body {
    padding: 20px 25px;
    color: #34495e;
    font-size: 1.1rem;
    overflow-y: auto; 
}

.card-body p {
    margin: 15px 0;
    line-height: 1.8;
}

.card-body strong {
    color: #2c3e50;
}

.card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 20px;
    padding: 10px 0;
    border-top: 1px solid #ddd;
    flex-shrink: 0;
}

.card-footer .delete-btn {
    background-color: #e74c3c;
    color: white;
    border: none;
    padding: 8px 15px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.card-footer .delete-btn:hover {
    background-color: #c0392b;
}

.card-footer .time-ago {
    font-size: 0.9rem;
    color: #7f8c8d;
    font-style: italic;
}

.card-footer .time-ago::before {
    content: "• ";
}

@media (max-width: 768px) {
    .card-header .user-details h3 {
        font-size: 1.6rem;
    }
    .card-body p {
        font-size: 1rem;
    }
}
</style>
