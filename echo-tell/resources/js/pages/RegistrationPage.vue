<template>
    <div class="registration-form-container">
        <div class="registration-form">
            <h2>Create an Account</h2>
            <form @submit.prevent="submitForm" class="form">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input
                        v-model="form.name"
                        type="text"
                        id="name"
                        required
                        placeholder="Enter your full name"
                    />
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input
                        v-model="form.email"
                        type="email"
                        id="email"
                        required
                        placeholder="Enter your email"
                    />
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                        @input="passwordStatus = false"
                        v-model="form.password"
                        type="password"
                        id="password"
                        required
                        placeholder="Enter your password"
                    />
                </div>

                <div class="form-group">
                    <label for="confirm-password">Confirm Password</label>
                    <input
                        @input="passwordStatus = false"
                        v-model="form.confirmPassword"
                        type="password"
                        id="confirm-password"
                        required
                        placeholder="Confirm your password"
                    />
                    <div
                        :style="passwordDontMatch"
                        class="error-message"
                        v-show="passwordStatus"
                    >
                        {{ this.errorMessage }}
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="submit-btn">Register</button>
                </div>
                <div class="form-footer">
                    <p>
                        Or
                        <a href="/auth" class="link-to-login"
                            >Sign in to an existing account</a
                        >
                    </p>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import axios from "axios";
export default {
    data() {
        return {
            form: {
                name: "",
                email: "",
                password: "",
            },
            errorMessage: "",
            passwordStatus: false,
        };
    },
    methods: {
        submitForm() {
            if (this.form.password !== this.form.confirmPassword) {
                this.passwordStatus = true;
                this.errorMessage = "Passwords do not match";
                return;
            }
            this.sendData();
        },
        sendData() {
            axios
                .post("/auth/registration/store", this.form)
                .then((response) => {
                    window.location.href = "/auth/registration/confirm";
                })
                .catch((error) => {
                    this.passwordStatus = true;
                    this.errorMessage = error.response?.data?.message;
                });
        },
    },
};
</script>

<style scoped>
.registration-form-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background: linear-gradient(135deg, #6a11cb, #2575fc);
    font-family: "Poppins", sans-serif;
}

.registration-form {
    width: 450px;
    padding: 30px;
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    animation: fadeIn 0.8s ease-in-out;
}

h2 {
    text-align: center;
    color: #333;
    font-size: 24px;
    margin-bottom: 20px;
    font-weight: 600;
}

.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    font-size: 14px;
    font-weight: 500;
    color: #555;
    margin-bottom: 8px;
}

input {
    width: 100%;
    padding: 12px;
    font-size: 14px;
    border: 1px solid #ddd;
    border-radius: 8px;
    transition: border-color 0.3s, box-shadow 0.3s;
}

input:focus {
    outline: none;
    border-color: #6a11cb;
    box-shadow: 0 0 10px rgba(106, 17, 203, 0.2);
}

.error-message {
    font-size: 13px;
    color: #e74c3c;
    margin-top: 5px;
}

.submit-btn {
    width: 100%;
    padding: 12px;
    background: linear-gradient(135deg, #6a11cb, #2575fc);
    color: #fff;
    font-size: 16px;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.3s, box-shadow 0.3s;
}

.submit-btn:hover {
    background: linear-gradient(135deg, #5a0fb5, #1e5dbc);
    box-shadow: 0 4px 15px rgba(90, 15, 181, 0.4);
}

.form-footer {
    text-align: center;
    margin-top: 15px;
}

.form-footer p {
    font-size: 14px;
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

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
