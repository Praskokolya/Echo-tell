<template>
    <header class="header">
      <!-- Logo Section -->
      <div class="logo">
        <router-link to="/" class="logo-link">
          <img src="/images/logo.png" alt="App Logo" class="logo-img" />
        </router-link>
      </div>
  
      <!-- Navigation Menu -->
      <nav class="nav">
        <ul class="nav-list">
          <li><router-link to="/" class="nav-item">Home</router-link></li>
          <li><router-link to="/about" class="nav-item">About</router-link></li>
          <li><router-link to="/contact" class="nav-item">Contact</router-link></li>
        </ul>
      </nav>
  
      <!-- User Profile Section (If authenticated) -->
      <div class="user-profile">
        <div v-if="user" class="user-info">
          <img :src="user.avatar" alt="User Avatar" class="avatar" />
          <span class="username">{{ user.name }}</span>
        </div>
        <div v-else class="login">
          <router-link to="/login" class="login-link">Login</router-link>
        </div>
      </div>
    </header>
  </template>
  
  <script>
  export default {
    data() {
      return {
        user: null, // Replace with real user data (if authenticated)
      };
    },
    created() {
      // You can use Vuex or a similar method to get the authenticated user
      // For demonstration, we are using mock data.
      this.user = {
        name: "John Doe",
        avatar: "/images/avatar.jpg", // Use the actual avatar URL
      };
    },
  };
  </script>
  
  <style scoped>
  /* General Styles */
  .header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 40px;
    background-color: #2c3e50;
    color: white;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }
  
  .logo-link {
    display: flex;
    align-items: center;
  }
  
  .logo-img {
    height: 40px;
    width: auto;
  }
  
  .nav {
    flex-grow: 1;
  }
  
  .nav-list {
    display: flex;
    justify-content: center;
    list-style: none;
    margin: 0;
    padding: 0;
  }
  
  .nav-item {
    margin: 0 20px;
    text-decoration: none;
    color: white;
    font-weight: bold;
    transition: color 0.3s;
  }
  
  .nav-item:hover {
    color: #3498db;
  }
  
  .user-profile {
    display: flex;
    align-items: center;
  }
  
  .user-info {
    display: flex;
    align-items: center;
  }
  
  .avatar {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    margin-right: 10px;
  }
  
  .username {
    font-weight: bold;
  }
  
  .login-link {
    color: white;
    text-decoration: none;
    padding: 10px;
    border-radius: 5px;
    background-color: #3498db;
    transition: background-color 0.3s;
  }
  
  .login-link:hover {
    background-color: #2980b9;
  }
  
  /* Mobile Responsiveness */
  @media (max-width: 768px) {
    .header {
      flex-direction: column;
      text-align: center;
    }
  
    .nav-list {
      flex-direction: column;
      margin-top: 20px;
    }
  
    .nav-item {
      margin: 10px 0;
    }
  
    .user-profile {
      margin-top: 20px;
    }
  }
  </style>
  