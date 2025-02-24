<template>
    <div class="container">
        <h2 class="question-title">
            <span class="question-explanation">Your question:</span>
            {{ question.question }}
        </h2>

        <div v-if="responses.length > 0">
            <div v-for="(response, index) in responses" :key="index" class="response-card">
                <div class="response-header">
                    <strong>Response #{{ index + 1 }}</strong>
                </div>
                <div class="response-body">
                    <p>{{ response.response }}</p>
                </div>
                <div class="response-footer">
                    <span class="response-date">Created on: {{ formatDate(response.created_at) }}</span>
                </div>
                <span class="response-user-name">by {{ response.user_name }}</span>

            </div>
        </div>
        <div v-else>
            <p class="no-responses">No responses yet.</p>
        </div>

        <div v-if="paginationLinks.length > 0" class="pagination">
            <button
                v-if="paginationLinks.prev"
                @click="loadPage(paginationLinks.prev)"
                :disabled="!paginationLinks.prev"
                class="pagination-btn"
            >
                &laquo; Previous
            </button>
            <button
                v-for="link in paginationLinks.pages"
                :key="link.url"
                @click="loadPage(link.url)"
                :disabled="link.active"
                :class="{ 'active': link.active }"
                class="pagination-btn"
            >
                {{ link.label }}
            </button>
            <button
                v-if="paginationLinks.next"
                @click="loadPage(paginationLinks.next)"
                :disabled="!paginationLinks.next"
                class="pagination-btn"
            >
                Next &raquo;
            </button>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            id: window.location.pathname.split("/")[2],
            responses: [],
            paginationLinks: {
                prev: null,
                next: null,
                pages: [],
            },
            question: {
                question: '',
            },
        };
    },
    methods: {
        getResponses(page = 1) {
            axios.get(`/api/question/responses/${this.id}?page=${page}`).then((response) => {
                console.log(response);
                this.responses = response.data.responses.data;
                this.paginationLinks = this.formatPaginationLinks(response.data.responses.links);
                this.question = response.data.question;
            });
        },
        loadPage(url) {
            const page = new URL(url).searchParams.get('page');
            this.getResponses(page);
        },
        formatPaginationLinks(links) {
            const pages = links.filter(link => link.label !== '&laquo; Previous' && link.label !== 'Next &raquo;');
            const prev = links.find(link => link.label === '&laquo; Previous')?.url || null;
            const next = links.find(link => link.label === 'Next &raquo;')?.url || null;
            return {
                prev,
                next,
                pages,
            };
        },
        formatDate(dateString) {
            const date = new Date(dateString);
            const options = { year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric' };
            return date.toLocaleString('en-US', options);
        }
    },
    mounted() {
        this.getResponses();
    },
};
</script>

<style scoped>
.container {
    max-width: 900px;
    margin: 0 auto;
    padding: 20px;
}

.question-title {
    text-align: center;
    font-size: 28px;
    font-weight: 700;
    color: #2b3e50;
    background: linear-gradient(45deg, #454545, #2b3e50);
    color: white;
    padding: 25px;
    border-radius: 8px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    margin-bottom: 40px;
}

.question-explanation {
    font-size: 16px;
    font-style: italic;
    color: #b0c4de;
    display: block;
    margin-top: 10px;
}

.response-card {
    background-color: #f3f7fc; 
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
    padding: 20px;
    transition: transform 0.2s ease-in-out;
}

.response-card:hover {
    transform: translateY(-5px);
}

.response-header {
    font-size: 18px;
    font-weight: 600;
    color: #4e9fcf;
    margin-bottom: 10px;
}

.response-user-name {
    font-style: italic;
    color: #666;
}

.response-body {
    font-size: 16px;
    color: #555;
    line-height: 1.5;
}

.response-footer {
    font-size: 14px;
    color: #888;
    margin-top: 10px;
    text-align: right;
}

.no-responses {
    text-align: center;
    color: #888;
    font-size: 18px;
}

.pagination {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 30px;
}

.pagination-btn {
    padding: 10px 20px;
    background-color: #4e9fcf;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.pagination-btn:hover {
    background-color: #357a99;
}

.pagination-btn:disabled {
    background-color: #ddd;
    cursor: not-allowed;
}

.pagination-btn.active {
    background-color: #357a99;
    font-weight: bold;
}
</style>
