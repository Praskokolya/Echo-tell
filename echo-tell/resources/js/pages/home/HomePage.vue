<template>
    <div class="container">
      <nav class="sidebar">
        <ul>
          <li>
            <label>
              <input type="checkbox" v-model="notificationsEnabled" class="checkbox" />
              <i class="fas fa-envelope"></i> Send notifications to email
            </label>
          </li>
          <li>
            <label>
              <input type="checkbox" v-model="securityEnabled" class="checkbox" />
              <i class="fas fa-shield-alt"></i>Send daily messages to email
            </label>
          </li>
        </ul>
      </nav>
      <main class="main-content">
        <header>
          <h1>Dashboard</h1>
        </header>
  
        <div v-if="user" class="user-info">
          <div class="card profile-card">
            <h2>Profile Information</h2>
            <div class="profile-details">
              <div class="profile-item">
                <i class="fas fa-user"></i>
                <div>
                  <span class="label">Name</span>
                  <span class="value">{{ user.name }}</span>
                </div>
              </div>
              <div class="profile-item">
                <i class="fas fa-envelope"></i>
                <div>
                  <span class="label">Email</span>
                  <span class="value">{{ user.email }}</span>
                </div>
              </div>
              <div class="profile-item">
                <i class="fas fa-calendar-alt"></i>
                <div>
                  <span class="label">Joined</span>
                  <span class="value">{{ formattedDate }}</span>
                </div>
              </div>
            </div>
          </div>
  
          <div class="card url-card">
            <h2>Share URL</h2>
            <div class="url-container">
              <input type="text" :value="user.url" readonly class="url-input" />
              <button @click="copyUrl" class="copy-btn" :class="{ copied: urlCopied }">
                <i class="fas fa-copy"></i>
                <span>{{ urlCopied ? 'Copied!' : 'Copy' }}</span>
              </button>
            </div>
          </div>
        </div>
      </main>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        user: null, 
        urlCopied: false,
        notificationsEnabled: false,
        securityEnabled: false,
        alertsEnabled: false,
        preferencesEnabled: false,
      };
    },
    methods: {
      getData() {
        axios.get('/api/user/home-data')
          .then((response) => {
            this.user = response.data;
            console.log(response);
          })
          .catch((error) => {
            console.error('Error fetching data:', error);
          });
      },
      copyUrl() {
        if (this.user && this.user.url) {
          navigator.clipboard.writeText(this.user.url).then(() => {
            this.urlCopied = true;
            setTimeout(() => (this.urlCopied = false), 2000);
          });
        }
      }
    },
    computed: {
      formattedDate() {
        if (this.user && this.user.created_at) {
          return new Date(this.user.created_at).toLocaleDateString();
        }
        return '';
      }
    },
    created() {
      this.getData();
    }
  };
  </script>
  
  <style scoped>
  .container {
    display: flex;
    min-height: 100vh;
    background-color: #f0f2f5;
    font-family: 'Poppins', sans-serif;
  }
  
  .sidebar {
    width: 250px;
    background-color: #ffffff;
    color: #333;
    padding: 2rem;
    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
  }
  
  .sidebar ul {
    list-style-type: none;
    padding: 0;
  }
  
  .sidebar ul li {
    margin: 1rem 0;
  }
  
  .sidebar ul li label {
    display: flex;
    align-items: center;
    cursor: pointer;
    font-size: 1rem;
  }
  
  .sidebar ul li label .checkbox {
    margin-right: 10px;
    accent-color: #1a73e8;
  }
  
  .main-content {
    flex: 1;
    padding: 2rem;
  }
  
  header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
  }
  
  h1 {
    color: #333;
    font-size: 2rem;
    font-weight: 600;
  }
  
  .user-info {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
  }
  
  .card {
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    padding: 2rem;
    transition: all 0.3s ease;
  }
  
  .card:hover {
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    transform: translateY(-5px);
  }
  
  .card h2 {
    color: #333;
    font-size: 1.5rem;
    margin-bottom: 1.5rem;
    font-weight: 600;
  }
  
  .profile-details {
    display: grid;
    gap: 1rem;
  }
  
  .profile-item {
    display: flex;
    align-items: center;
  }
  
  .profile-item i {
    font-size: 1.5rem;
    color: #1a73e8;
    margin-right: 1rem;
  }
  
  .profile-item .label {
    font-size: 0.9rem;
    color: #666;
    display: block;
  }
  
  .profile-item .value {
    font-size: 1.1rem;
    color: #333;
    font-weight: 500;
  }
  
  .url-container {
    display: flex;
    align-items: center;
  }
  
  .url-input {
    flex: 1;
    padding: 0.75rem;
    border: 1px solid #ddd;
    border-radius: 5px 0 0 5px;
    font-size: 1rem;
    color: #333;
  }
  
  .copy-btn {
    background-color: #1a73e8;
    color: white;
    border: none;
    padding: 0.75rem 1rem;
    font-size: 1rem;
    cursor: pointer;
    border-radius: 0 5px 5px 0;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
  }
  
  .copy-btn i {
    margin-right: 5px;
  }
  
  .copy-btn:hover {
    background-color: #1557b0;
  }
  
  .copy-btn.copied {
    background-color: #34a853;
  }
  </style>
  