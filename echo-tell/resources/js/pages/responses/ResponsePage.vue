<template>
  <div class="container">
    <!-- Виведення даних -->
    <div v-if="response && question" class="content">
      <div class="question-section">
        <h2 class="title">Question:</h2>
        <p class="question-text">{{ question.question }}</p>
        <a :href="question.question_url" class="question-link" target="_blank">View Question</a>
      </div>

      <div class="response-section">
        <h2 class="title">Response:</h2>
        <p class="response-text">{{ response.response }}</p>
        <p class="response-meta">
          <strong>Responded by: </strong>
          <span v-if="response.user_name !== 'Anonymous'" 
                class="username" 
                @click="goToUserProfile(response.user_name)">
            {{ response.user_name }}
          </span>
          <span v-else>Anonymous</span>
        </p>
        <p class="response-meta">
          <strong>Response created at:</strong> {{ response.created_at}}
        </p>
      </div>
    </div>

    <div v-else class="loading">
      <p>Loading data...</p>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      response: null,  
      question: null,  
      id: window.location.pathname.split('/')[5]        
    };
  },
  methods: {
    getResponse() {
      axios.get('/api/response/' + this.id)  
        .then(response => {
          this.response = response.data.response;  
          this.question = response.data.question;  
        })
        .catch(error => {
          console.error('Error fetching response:', error); 
        });
    },
    goToUserProfile(userName) {
      window.location.href = `/user/${userName}`;
    },
    formatTime(date) {
        const timeAgo = new Date(date);
        const now = new Date();
        const diff = Math.floor((now - timeAgo) / (1000 * 60));
        if (diff < 60) {
            return `${diff} minutes ago`;
        } else if (diff < 1440) {
            return `${Math.floor(diff / 60)} hours ago`;
        } else {
            return `${Math.floor(diff / 1440)} days ago`;
        }
    },
  },
  mounted() {
    this.getResponse();
  },
  filters: {
    formatDate(value) {
      if (!value) return ''; 
      const date = new Date(value);
      return date.toLocaleString();  
    }
  }
};
</script>

<style scoped>
.container {
  max-width: 900px;
  margin: 0 auto;
  padding: 40px;
  font-family: 'Arial', sans-serif;
  background-color: #fafafa;
  border-radius: 12px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
}

.content {
  background-color: #fff;
  padding: 25px;
  border-radius: 12px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
  transition: all 0.3s ease-in-out;
}

.content:hover {
  box-shadow: 0 12px 40px rgba(0, 0, 0, 0.1);
}

.title {
  font-size: 2rem;
  color: #2e2e2e;
  margin-bottom: 15px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.question-text, .response-text {
  font-size: 1.2rem;
  line-height: 1.8;
  color: #333;
  margin-bottom: 20px;
}

.question-link {
  display: inline-block;
  margin-top: 12px;
  color: #007bff;
  text-decoration: none;
  font-weight: 600;
  border-bottom: 2px solid #007bff;
  transition: color 0.2s ease;
}

.question-link:hover {
  color: #0056b3;
  border-color: #0056b3;
}

.response-meta {
  font-size: 1rem;
  color: #777;
  margin-top: 15px;
}

.response-meta strong {
  font-weight: 600;
  color: #444;
}

.username {
  color: #0056b3;
  font-weight: 600;
  cursor: pointer;
  text-decoration: underline;
}

.username:hover {
  color: #003366;
}

.loading {
  text-align: center;
  font-size: 1.3rem;
  color: #888;
  font-style: italic;
  margin-top: 50px;
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

.content {
  animation: fadeIn 0.5s ease-out;
}
</style>
