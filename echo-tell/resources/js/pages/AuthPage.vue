<template>
    <div class="auth-container">
        <div class="auth-form">
            <h1 class="form-title main-title">Echo Tell</h1>
            <h2 class="form-title">Log In to Your Account</h2>
            <form>
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
                        v-model="form.password"
                        type="password"
                        id="password"
                        required
                        placeholder="Enter your password"
                    />
                </div>

                <div class="form-footer">
                    <div type="submit" class="submit-btn" @click="logIn">
                        Log In
                    </div>

                    <div class="auth-footer">
                        <p>
                            Don't have an account?
                            <span
                                ><a href="/auth/registration"
                                    >Create one</a
                                ></span
                            >
                        </p>
                    </div>
                </div>
            </form>

            <div class="social-login">
                <div class="social-buttons">
                    <span class="social-btn google" @click="signInWithGoogle">
                        <i class="fab fa-google"></i> <a href="/">Google</a>
                    </span>
                    <span
                        class="social-btn facebook"
                        @click="signInWithFacebook"
                    >
                        <i class="fab fa-facebook-f"></i>
                        <a href="/">Facebook</a>
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: {
                email: "",
                password: "",
            },
        };
    },
    methods: {
        logIn() {
            axios.post("/auth/login", this.form).then((response) => {
                if(response.data.access_token){
                    localStorage.setItem("access_token", response.data.access_token);
                    window.location.href = "/";
                } 
            });
        },
        signInWithGoogle() {},
        signInWithFacebook() {},
    },
};
</script>

<style scoped>
.main-title {
    font-size: 30rem;
    font-weight: bold;
    color: #4a90e2;
    margin-bottom: 10px;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
}
.auth-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #f4f7fc;
}

.auth-form {
    background-color: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
}

.form-title {
    text-align: center;
    color: #333;
    font-size: 24px;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 15px;
}

label {
    font-size: 14px;
    color: #666;
    display: block;
    margin-bottom: 6px;
}

input {
    width: 100%;
    padding: 12px;
    font-size: 14px;
    border: 1px solid #ddd;
    border-radius: 4px;
    background-color: #f9f9f9;
}

input:focus {
    outline: none;
    border-color: #4c8bf5;
    background-color: #fff;
}

.submit-btn {
    text-align: center;
    width: 100%;
    padding: 12px;
    font-size: 16px;
    background-color: #4c8bf5;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-top: 20px;
}

.submit-btn:hover {
    background-color: #3578e5;
}

.auth-footer {
    text-align: center;
    margin-top: 20px;
}

.auth-footer span {
    color: #4c8bf5;
    cursor: pointer;
}

.auth-footer span:hover {
    text-decoration: underline;
}

.social-login {
    margin-top: 20px;
    text-align: center;
}

.social-buttons {
    display: block;
    margin-top: 10px;
    text-align: left;
}

.social-btn {
    font-size: 16px;
    font-weight: 500;
    color: #4c8bf5;
    cursor: pointer;
    transition: color 0.3s;
    margin-bottom: 10px;
}

.social-btn:hover {
    color: #3578e5;
}

.social-btn.google {
    display: block;
}

.social-btn.facebook {
    display: block;
}
</style>
