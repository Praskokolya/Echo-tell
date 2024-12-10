<template>
    <div class="registration-form-container">
        <div class="registration-form">
            <h2>Create an Account</h2>
            <form @submit.prevent="submitForm" class="form">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input v-model="form.name" type="text" id="name" required placeholder="Enter your full name" />
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input v-model="form.email" type="email" id="email" required placeholder="Enter your email" />
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input v-model="form.password" type="password" id="password" required
                        placeholder="Enter your password" />
                </div>

                <div class="form-group">
                    <label for="confirm-password">Confirm Password</label>
                    <input v-model="form.confirmPassword" type="password" id="confirm-password" required
                        placeholder="Confirm your password" />
                </div>

                <div class="form-group">
                    <button type="submit" @click="sendData" class="submit-btn">Register</button>
                </div>
                <div class="form-footer">
                    <p>
                        Or <a href="/auth" class="link-to-login">Sign in to an existing account</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
export default {

    data() {
        return {
            form: {
                name: '',
                email: '',
                password: '',
                confirmPassword: ''
            }
        };
    },
    methods: {
        submitForm() {
            if (this.form.password !== this.form.confirmPassword) {
                alert('Passwords do not match!');
                return;
            }
        },
        sendData() {
            axios.post('./registration/create', this.form);
        }
    }
};
</script>

<style scoped>
.form-footer {
    margin-top: 20px;
    text-align: center;
}

.form-footer p {
    font-size: 0.9rem;
    color: #7f8c8d;
}

.form-footer a {
    color: #3498db;
    text-decoration: none;
    font-weight: bold;
}

.form-footer a:hover {
    text-decoration: underline;
}

.registration-form-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background-color: #f0f2f5;
}

.registration-form {
    width: 500px;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
}

.form-group {
    margin-bottom: 15px;
}

label {
    font-size: 14px;
    color: #333;
    display: block;
    margin-bottom: 8px;
}

input {
    width: 100%;
    padding: 10px;
    font-size: 14px;
    border: 1px solid #ddd;
    border-radius: 4px;
    background-color: #fff;
}

input:focus {
    outline: none;
    border-color: #007bff;
}

.submit-btn {
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: #fff;
    font-size: 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.submit-btn:hover {
    background-color: #0056b3;
}
</style>