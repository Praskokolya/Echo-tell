<template>
  <div class="message-card" v-if="messageData">
    <div class="message-header">
      <h3>
        <span v-if="messageData.sender_name !== 'Anonymous'">
          <a :href="'/'" class="user-link">{{ messageData.sender_name }}</a>
        </span>
        <span v-else>{{ messageData.sender_name }}</span>
      </h3>
      <span class="message-type" :class="messageData.type.toLowerCase()">{{ messageData.type }}</span>
    </div>
    <div class="message-body">
      <p><i class="fas fa-comment"></i> {{ messageData.message }}</p>
      <p><i class="fas fa-user"></i> {{ messageData.user }}</p>
      <p><i class="far fa-clock"></i> {{ formatDate(messageData.created_at) }}</p>
    </div>
    <div class="message-footer">
      <a :href="'/messages/' + this.id" target="_blank" class="view-button">
        <i class="fas fa-external-link-alt"></i> See more messages from this user
      </a>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      messageData: null,
      id: window.location.pathname.split("/")[2]
    };
  },
  methods: {
    getData() {
      axios.get('/api/message/' + this.id).then((response) => {
        this.messageData = response.data.data;
      });
    },
    formatDate(date) {
      const options = { year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric' };
      return new Date(date).toLocaleDateString('en-US', options);
    }
  },
  mounted() {
    this.getData();
  }
};
</script>

<style scoped>
.message-card {
  border: none;
  border-radius: 15px;
  background-color: #ffffff;
  box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
  width: 400px;
  margin: 30px auto;
  overflow: hidden;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.message-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}

.message-header {
  background-color: #34495e;
  color: white;
  padding: 25px;
  position: relative;
}

.message-header h3 {
  font-size: 1.6em;
  margin: 0;
  font-weight: bold;
}

.message-header a.user-link {
  color: white;
  text-decoration: none;
  font-weight: bold;
}

.message-header a.user-link:hover {
  text-decoration: underline;
}

.message-type {
  position: absolute;
  top: 15px;
  right: 20px;
  padding: 8px 12px;
  border-radius: 25px;
  font-size: 0.9em;
  font-weight: bold;
  text-transform: uppercase;
}

.message-type.info { background-color: #3498db; color: white; }
.message-type.warning { background-color: #f39c12; color: white; }
.message-type.error { background-color: #e74c3c; color: white; }
.message-type.success { background-color: #2ecc71; color: white; }

.message-body {
  padding: 20px;
  background-color: #ecf0f1;
}

.message-body p {
  font-size: 1.1em;
  margin: 12px 0;
  color: #34495e;
}

.message-body i {
  margin-right: 10px;
  color: #7f8c8d;
}

.message-footer {
  padding: 20px;
  background-color: #f9f9f9;
  text-align: right;
  border-top: 1px solid #ddd;
}

.view-button {
  display: inline-block;
  padding: 10px 20px;
  background-color: #3498db;
  color: white;
  text-decoration: none;
  border-radius: 8px;
  font-weight: bold;
  transition: background-color 0.3s ease, transform 0.2s ease;
}

.view-button:hover {
  background-color: #2980b9;
  transform: scale(1.05);
}

.view-button i {
  margin-right: 8px;
}
</style>
