<template>
  <div class="welcome-page">
    <div class="welcome-content">
      <div class="welcome-header text-center">
        <h1 class="display-3">Welcome to Echo Tell</h1>
        <p class="lead">Your place to send and receive anonymous messages.</p>
      </div>

      <div class="info-section text-center">
        <h2 class="section-title">How it Works</h2>
        <p class="section-description">
          Share your thoughts anonymously with complete peace of mind. Rest assured, your privacy is our top
          priority—we're dedicated to protecting your identity and ensuring secure, honest feedback. </p>
        <button @click="redirectToAuth" class="btn btn-lg btn-primary shadow-lg">Start Sending Messages</button>
      </div>

      <div class="footer text-center">
        <p>&copy; 2024 Echo Tell. All rights reserved.</p>
        <p>Made with ❤️ by Echo Tell Team</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    redirectToAuth() {
        window.location.href = '/auth'
    }
  }
}
</script>

<style scoped>
.welcome-page {
  background: linear-gradient(135deg, #ff6a00, #ee0979);
  color: #fff;
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: 'Poppins', sans-serif;
}

.welcome-content {
  background-color: rgba(0, 0, 0, 0.5);
  border-radius: 15px;
  padding: 50px 30px;
  box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
  max-width: 700px;
  width: 100%;
}

.welcome-header h1 {
  font-size: 3.5rem;
  font-weight: 600;
  margin-bottom: 20px;
}

.welcome-header p {
  font-size: 1.25rem;
  font-weight: 300;
}

.info-section {
  margin-top: 40px;
}

.section-title {
  font-size: 2.5rem;
  font-weight: 500;
  margin-bottom: 20px;
  text-transform: uppercase;
}

.section-description {
  font-size: 1.2rem;
  margin-bottom: 30px;
  font-weight: 300;
}

.btn-primary {
  background-color: #6c5ce7;
  border: none;
  padding: 12px 30px;
  font-size: 1.2rem;
  font-weight: 500;
  border-radius: 50px;
  transition: background-color 0.3s ease-in-out, transform 0.2s ease-in-out;
}

.btn-primary:hover {
  background-color: #4e3bdb;
  transform: translateY(-5px);
}

.footer {
  margin-top: 50px;
  font-size: 0.9rem;
  color: #ddd;
}

.footer p {
  margin: 0;
  font-weight: 300;
}
</style>