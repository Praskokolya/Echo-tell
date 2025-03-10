<template>
    <div class="page-container">
        <div class="main-card">
            <div class="header text-center">
                <h1 class="page-title">Your honest feedback</h1>
            </div>
            <div class="question-section" v-if="questionData">
                <h2 class="question-title">{{ questionData.question }}</h2>
                <div class="question-meta">
                    <span>
                        User:
                        <strong>{{
                            questionData.user_name
                        }}</strong>
                    </span>
                    <span><strong>Created:</strong> {{ formatDate(questionData.created_at) }}</span>
                </div>
                <p>
                    <strong>Copy and share url: </strong>
                    <a
                        :href="questionData.question_url"
                        target="_blank"
                        @click.prevent="copyToClipboard(questionData.question_url)"
                        class="copyable-url"
                    >
                        {{ questionData.question_url }}
                    </a>
                </p>
            </div>

            <div class="create-question">
                <p class="form-heading">What do you think about it?</p>
                <form @submit.prevent="submitQuestion">
                    <div class="form-group">
                        <textarea
                            v-model="response"
                            placeholder="Honestly it's..."
                            :maxlength="200"
                            rows="4"
                            required
                            class="form-control"
                        ></textarea>
                        <small>{{ response.length }} / 200 characters</small>
                    </div>

                    <!-- Перемикач для анонімності -->
                    <div class="form-group">
                        <label>
                            <input type="checkbox" v-model="name_visibility" />
                            <span>Send anonymously</span>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-submit">
                        Send answer
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            response: "",
            questionData: null,
            name_visibility: false, 
            id: window.location.pathname.split("/")[2]
        };
    },
    methods: {
        submitQuestion() {
            if (!this.response.trim()) {
                alert("Please enter a response before submitting!");
                return;
            } else {
                const data = {
                    response: this.response,
                    name_visibility: this.name_visibility ? 0 : 1,
                };
                axios.post(`/api/response/${this.id}`, data)
                    .then(() => {
                        console.log(data);
                        // window.location.href = `/user/interactions`;
                    });
            }
        },
        getQuestionData() {
            axios
                .get(`/api/question/${this.id}`)
                .then((response) => {
                    this.questionData = response.data.data;
                })
                .catch((error) => {
                    console.error("Error fetching question data:", error);
                });
        },
        formatDate(date) {
            const options = {
                year: "numeric",
                month: "long",
                day: "numeric",
                hour: "2-digit",
                minute: "2-digit",
            };
            return new Date(date).toLocaleDateString(undefined, options);
        },
        copyToClipboard(url) {
            navigator.clipboard
                .writeText(url)
                .then(() => {
                    alert("URL copied to clipboard!");
                })
                .catch((err) => {
                    console.error("Failed to copy text: ", err);
                });
        },
    },
    mounted() {
        this.getQuestionData();
    },
};
</script>

<style scoped>
.page-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background-color: #fff;
    font-family: "Roboto", sans-serif;
}

.main-card {
    background: #fff;
    border-radius: 12px;
    padding: 40px;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    max-width: 800px;
    width: 100%;
    text-align: center;
}

.page-title {
    font-size: 2.5rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 30px;
}

.question-section {
    margin-bottom: 40px;
}

.question-title {
    font-size: 2rem;
    font-weight: 500;
    color: #2d6a4f;
    margin-bottom: 15px;
}

.question-meta {
    font-size: 1rem;
    color: #555;
    margin-bottom: 15px;
}

.question-meta span {
    margin-right: 15px;
}

.create-question {
    background-color: rgba(0, 0, 0, 0.05);
    padding: 30px;
    border-radius: 8px;
    margin-top: 30px;
}

.form-heading {
    font-size: 1.8rem;
    font-weight: 500;
    margin-bottom: 20px;
    color: #333;
}

.form-group {
    margin-bottom: 20px;
}

.form-control {
    width: 100%;
    padding: 15px;
    font-size: 1.2rem;
    border-radius: 8px;
    border: 1px solid #ddd;
    outline: none;
    resize: none;
}

.form-control:focus {
    border-color: #2d6a4f;
}

.btn-submit {
    background-color: #ff6f61;
    color: white;
    padding: 15px 30px;
    font-size: 1.2rem;
    font-weight: 500;
    border-radius: 30px;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease-in-out;
}

.btn-submit:hover {
    background-color: #ff3d2d;
}

.copyable-url {
    color: #ff1a00;
    text-decoration: none;
    cursor: pointer;
}

.copyable-url:hover {
    text-decoration: underline;
}

/* Простий стиль для перемикача */
label input {
    margin-right: 10px;
}
</style>
