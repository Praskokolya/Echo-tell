<template>
    <div class="questions-container">
        <h1 class="title">Questions by {{ questions.data[0]?.user_name || 'Unknown User' }}</h1>
        <div class="question-cards">
            <div
                v-for="question in questions.data"
                :key="question.id"
                class="question-card"
            >
                <div class="question-header">
                    <h3 class="question-title">{{ question.question }}</h3>
                    <small class="created-at">{{ formatDate(question.created_at) }}</small>
                </div>
                <div class="question-footer">
                    <a
                        :href="question.question_url"
                        target="_blank"
                        class="view-button"
                    >View</a>
                    <a :href="question.question_url + '/responses'">
                        <p class="responses-count">
                            {{ question.responses_count }} responses
                        </p>
                    </a>
                </div>
            </div>
        </div>

        <!-- Pagination -->
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
import axios from 'axios';

export default {
    data() {
        return {
            questions: {
                data: [],
                current_page: 1,
                last_page: 1,
                total: 0,
            },
            pagination: {
                current_page: 1,
                last_page: 1,
                total: 0,
            },
        };
    },
    methods: {
        getAllQuestions(page = 1) {
            axios
                .get(`/api/user/questions?page=${page}`)
                .then((response) => {
                    this.questions = response.data;
                    this.pagination = response.data.meta;
                })
                .catch((error) => {
                    console.error('Error fetching questions:', error);
                });
        },
        changePage(page) {
            if (page > 0 && page <= this.pagination.last_page) {
                this.getAllQuestions(page);
            }
        },
        formatDate(date) {
            const d = new Date(date);
            return d.toLocaleString();
        }
    },
    mounted() {
        this.getAllQuestions();
    },
};
</script>

<style scoped>
.questions-container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 30px;
    background: #f9f9f9;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.title {
    text-align: center;
    font-size: 2rem;
    margin-bottom: 20px;
    color: #333;
    font-family: "Poppins", sans-serif;
}

.question-cards {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px;
}

.question-card {
    background: #ffffff;
    border: 1px solid #e1e1e1;
    border-radius: 8px;
    padding: 20px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: auto;
    min-height: 150px;
    max-height: 400px;
    overflow: hidden;
    transition: box-shadow 0.3s, transform 0.3s;
}

.question-card:hover {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    transform: translateY(-5px);
}

.question-header {
    flex-grow: 1;
}

.question-title {
    font-size: 1.2rem;
    color: #2c3e50;
    margin: 0 0 10px;
    word-wrap: break-word;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
}

.responses-count {
    font-size: 0.9rem;
    color: #16a085;
}

.question-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.8rem;
    color: #7f8c8d;
}

.view-button {
    background-color: #3498db;
    color: #fff;
    padding: 8px 15px;
    border-radius: 5px;
    text-decoration: none;
    font-size: 0.9rem;
    transition: background-color 0.3s;
}

.view-button:hover {
    background-color: #2980b9;
}

.created-at {
    font-size: 0.8rem;
    color: #95a5a6;
}

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
