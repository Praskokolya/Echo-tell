<template>
    <div class="profile-page">
        <div class="profile-header">
            <h2>{{ user.name }}'s Profile</h2>
            <p>Joined: {{ formattedDate }}</p>
        </div>

        <div class="profile-info">
            <p>
                <strong>Profile URL:</strong>
                <a :href="user.url" target="_blank">{{ user.url }}</a>
            </p>
        </div>

        <div class="message-form">
            <textarea
                v-model="message"
                placeholder="Write a message..."
                rows="4"
            ></textarea>

            <label>
                <input type="checkbox" v-model="name_visibility" />
                Send anonymously
            </label>

            <button @click="sendMessage" :disabled="!message">Send</button>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            name: window.location.pathname.split("/")[2],
            user: {},
            message: "",
            id: null,
            name_visibility: false,
        };
    },
    computed: {
        formattedDate() {
            const date = new Date(this.user.created_at);
            return date.toLocaleDateString();
        },
    },
    methods: {
        getData() {
            axios.get("/api/profile/" + this.name).then((response) => {
                this.user = response.data.data;
                this.id = this.user.id;
            });
        },
        sendMessage() {
            console.log(this.name_visibility); 
            if (this.message && this.id) {
                axios
                    .post("/api/message/" + this.user.name, {
                        message: this.message,
                        id: this.id,
                        name_visibility: this.name_visibility ? 0 : 1,
                    })
                    .then(() => {
                        console.log(this.name_visibility); 
                    })
                    .catch((error) => {
                        console.error(error);
                    });
            }
        },
    },
    mounted() {
        this.getData();
    },
};
</script>

<style scoped>
.profile-page {
    padding: 20px;
    background-color: #f7f9fc;
    border-radius: 8px;
    max-width: 800px;
    margin: 0 auto;
}

.profile-header {
    text-align: center;
    margin-bottom: 20px;
}

.profile-header h2 {
    font-size: 2rem;
    color: #333;
}

.profile-header p {
    font-size: 1rem;
    color: #666;
}

.profile-info {
    margin-bottom: 30px;
}

.profile-info p {
    font-size: 1rem;
    color: #444;
}

.message-form {
    display: flex;
    flex-direction: column;
}

.message-form textarea {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 8px;
    margin-bottom: 10px;
    font-size: 1rem;
    resize: none;
}

.message-form label {
    display: flex;
    align-items: center;
    font-size: 1rem;
    color: #444;
    margin-bottom: 10px;
}

.message-form input[type="checkbox"] {
    margin-right: 8px;
}

.message-form button {
    padding: 10px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 1rem;
}

.message-form button:disabled {
    background-color: #ccc;
}
</style>
