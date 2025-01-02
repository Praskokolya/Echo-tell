<template>
    <div class="page-container">
        <!-- Create Question Page -->
        <div class="create-question-page">
            <div class="header text-center">
                <h1 class="display-3">Create Your Anonymous Question</h1>
                <p class="lead">Ask your question anonymously.</p>
            </div>

            <div class="form-container text-center">
                <h2 class="form-title">Ask Your Question</h2>
                <form @submit.prevent="submitQuestion">
                    <div class="form-group">
                        <textarea
                            v-model="question"
                            placeholder="Ask your question anonymously..."
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
                    .post("/api/create", { question: this.question })
                    .then((response) => {
                        console.log(response.data);
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
    background: linear-gradient(135deg, #00b894, #00d75b, #55efc4, #3c9e5f);
    color: #fff;
    font-family: "Poppins", sans-serif;
}

.create-question-page {
    background-color: rgba(0, 0, 0, 0.5);
    border-radius: 15px;
    padding: 50px 30px;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    max-width: 700px;
    width: 100%;
}

.header h1 {
    font-size: 3rem;
    font-weight: 600;
    margin-bottom: 20px;
}

.form-container {
    margin-top: 20px;
}

.form-title {
    font-size: 2rem;
    font-weight: 500;
    margin-bottom: 20px;
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
}

.form-control:focus {
    border-color: #2d6a4f;
}

.btn-primary {
    background-color: #ff7f50; /* Peach button color */
    color: #fff;
    border: none;
    padding: 12px 30px;
    font-size: 1.2rem;
    font-weight: 500;
    border-radius: 50px;
    transition: background-color 0.3s ease-in-out, transform 0.2s ease-in-out;
}

.btn-primary:hover {
    background-color: #ff7043; /* Darker peach hover */
    transform: translateY(-5px);
}
</style>
