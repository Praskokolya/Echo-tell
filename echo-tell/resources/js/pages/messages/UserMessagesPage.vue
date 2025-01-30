<template>
    <div class="user-messages-page">
        <h1 class="page-title">All messages from {{ senderName }} to you</h1>
        
        <!-- Повідомлення -->
        <div v-for="message in messages" :key="message.id" class="message-item">
            <div class="message-header">
                <strong>{{ message.sender_name }}</strong> 
                <span class="message-date">{{ new Date(message.created_at).toLocaleString() }}</span>
            </div>
            <div class="message-content">
                <p>{{ message.message }}</p>
            </div>
        </div>

        <!-- Пагінація -->
        <div class="pagination">
            <button 
                v-if="pagination.prev_page_url"
                @click="changePage(pagination.prev_page_url)" 
                class="pagination-btn"
            >
                &laquo; Previous
            </button>
            
            <span>Page {{ pagination.current_page }} of {{ pagination.last_page }}</span>

            <button 
                v-if="pagination.next_page_url"
                @click="changePage(pagination.next_page_url)" 
                class="pagination-btn"
            >
                Next &raquo;
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: 'UserMessagesPage',
    data() {
        return {
            id: window.location.pathname.split("/")[2],
            messages: [], 
            senderName: "", 
            pagination: {
                current_page: 1,
                last_page: 1,
                next_page_url: null,
                prev_page_url: null
            }
        };
    },
    methods: {
        getMessages(pageUrl = '/api/messages/' + this.id) {
            axios.get(pageUrl).then((response) => {
                const data = response.data.data;
                this.pagination = response.data;  // Оновлюємо дані пагінації
                if (data.length > 0) {
                    this.senderName = data[0].sender_name;  
                    this.messages = data;  
                }
            });
        },
        changePage(url) {
            this.getMessages(url); // Завантажуємо нову сторінку за URL
        }
    },
    mounted() {
        this.getMessages(); // Завантажуємо першу сторінку
    }
};
</script>

<style scoped>
.user-messages-page {
    max-width: 900px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 10px;
}

.page-title {
    font-size: 2rem;
    color: #333;
    text-align: center;
    margin-bottom: 30px;
}

.message-item {
    background-color: #fff;
    padding: 20px;
    margin-bottom: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.message-header {
    display: flex;
    justify-content: space-between;
    font-size: 1rem;
    color: #555;
}

.message-date {
    font-size: 0.875rem;
    color: #777;
}

.message-content {
    margin-top: 10px;
    font-size: 1.1rem;
    color: #333;
    line-height: 1.5;
}

.message-content p {
    margin: 0;
}

.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 30px;
}

.pagination-btn {
    padding: 8px 15px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1rem;
    margin: 0 10px;
}

.pagination-btn:disabled {
    background-color: #ccc;
    cursor: not-allowed;
}

.pagination span {
    font-size: 1rem;
    color: #444;
}
</style>
