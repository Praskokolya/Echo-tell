<template>
  <div class="messages-page">
    <!-- Header with Gradient -->
    <div class="header text-center">
      <h1 class="display-3">Welcome to Echo Tell</h1>
      <p class="lead">Send and receive anonymous messages with ease.</p>
    </div>

    <!-- Messages Section -->
    <div class="messages-container">
      <div class="message-section">
        <h2 class="section-title">Your Messages</h2>
        <div class="message-box">
          <p class="message-content">"What is your favorite hobby?"</p>
          <small class="message-info">Answered by anonymous user</small>
        </div>
        <div class="message-box">
          <p class="message-content">"Do you have any advice for beginners in coding?"</p>
          <small class="message-info">Answered by anonymous user</small>
        </div>
      </div>

      <!-- View Other Messages -->
      <div class="view-other-messages">
        <button @click="" class="btn btn-lg btn-secondary">View Other Messages</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    viewOtherMessages() {
    },
  },
};
</script>

<style scoped>
.messages-page {
  background: linear-gradient(135deg, #a8e063, #56ab2f, #a8e063);
  color: #fff;
  font-family: 'Poppins', sans-serif;
  padding: 40px 20px;
}

.header {
  background: linear-gradient(135deg, #ffb347, #ffcc33); /* Light gradient for header */
  padding: 40px 20px;
  border-radius: 10px;
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

.header h1 {
  font-size: 3rem;
  font-weight: 700;
  margin-bottom: 20px;
}

.header p {
  font-size: 1.25rem;
  font-weight: 300;
}

.messages-container {
  margin-top: 30px;
  background-color: rgba(0, 0, 0, 0.5);
  border-radius: 15px;
  padding: 20px;
  box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
}

.message-section {
  margin-bottom: 30px;
}

.section-title {
  font-size: 2rem;
  font-weight: 500;
  margin-bottom: 20px;
}

.message-box {
  background-color: #fff;
  color: #333;
  border-radius: 10px;
  padding: 15px;
  margin-bottom: 15px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.message-content {
  font-size: 1.1rem;
  font-weight: 500;
  margin-bottom: 10px;
}

.message-info {
  font-size: 0.9rem;
  font-weight: 300;
  color: #555;
}

.btn-secondary {
  background-color: #ff7f50;  /* Peach soft color */
  color: #fff;
  border: none;
  padding: 12px 30px;
  font-size: 1.2rem;
  font-weight: 500;
  border-radius: 50px;
  transition: background-color 0.3s ease-in-out, transform 0.2s ease-in-out;
}

.btn-secondary:hover {
  background-color: #ff7043; /* Darker peach hover */
  transform: translateY(-5px);
}
</style>
