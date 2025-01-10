<template>
    <div class="page-container">
        <!-- Create Question Page -->
        <div class="create-question-page">
            <div class="header text-center">
                <h1 class="display-3">Create Your Question</h1>
                <h2 class="form-title">
                    So that others can respond anonymously
                </h2>
            </div>

            <div class="form-container text-center">
                <p class="display-3">Time to hear the truth!</p>

                <form @submit.prevent="submitQuestion">
                    <div class="form-group">
                        <textarea
                            v-model="question"
                            placeholder="Honestly it's..."
                            :maxlength="200"
                            rows="4"
                            required
                            class="form-control"
                        ></textarea>
                        <small>{{ question.length }} / 200 characters</small>
                    </div>

                    <button type="submit" class="btn btn-lg btn-primary">
                        Create Question
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
            question: "",
        };
    },
    methods: {
        submitQuestion() {
            if (!this.question.trim()) {
                alert("Please enter a question before submitting!");
                return;
            } else {
                axios
                    .post("/api/question", { question: this.question })
                    .then((response) => {
                        window.location.href = response.data.question_url;
                    });
            }
        },
    },
};
</script>

<style scoped>
.page-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background: #f9f9f9;
    color: #333;
    font-family: "Poppins", sans-serif;
    padding: 20px;
}

.create-question-page {
    background-color: #fff;
    border-radius: 15px;
    padding: 50px 30px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    max-width: 700px;
    width: 100%;
}

.header h1 {
    font-size: 2.5rem;
    font-weight: 600;
    margin-bottom: 20px;
    color: #333;
}

.form-container {
    margin-top: 20px;
}

.form-title {
    font-size: 1.5rem;
    font-weight: 500;
    margin-bottom: 20px;
    color: #555;
}

.form-group {
    margin-bottom: 20px;
    width: 100%;
}

.form-control {
    width: 100%;
    padding: 12px;
    font-size: 1rem;
    border-radius: 8px;
    border: 1px solid #ddd;
    outline: none;
    resize: none;
    color: #333;
    transition: border-color 0.3s ease;
    background-color: #fff;
}

.form-control:focus {
    border-color: #5e81ac;
    box-shadow: 0 0 5px rgba(94, 129, 172, 0.3);
}

.btn-primary {
    background-color: #5e81ac; /* Soft blue */
    color: #fff;
    border: none;
    padding: 12px 30px;
    font-size: 1.2rem;
    font-weight: 500;
    border-radius: 50px;
    transition: background-color 0.3s ease-in-out, transform 0.2s ease-in-out;
}

.btn-primary:hover {
    background-color: #4c6a92; /* Darker blue */
    transform: translateY(-3px);
}
</style>
