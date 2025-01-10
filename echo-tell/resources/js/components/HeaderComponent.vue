<template>
  <header>
    <nav class="nav">
      <div class="nav-container">
        <a href="/" class="brand">Echo tell</a>
        <ul class="nav-menu" :class="{ 'active': isMenuOpen }">
          <li><a href="/create/question" class="nav-item">Create question</a></li>
          <li><a href="/questions" class="nav-item">Your questions</a></li>
          <li><a href="/services" class="nav-item">Notifcations</a></li>
          <li><a href="/contact" class="nav-item">Item 4</a></li>
        </ul>
      </div>
    </nav>
  </header>
</template>

<script>
export default {
  name: 'AnonymousHeader',
  data() {
    return {
      isMenuOpen: false,
    };
  },
  methods: {
    toggleMenu() {
      this.isMenuOpen = !this.isMenuOpen;
    },
  },
};
</script>

<style scoped>
.nav {
  background-color: #fff;
  padding: 15px 20px;
  position: sticky;
  top: 0;
  left: 0;
  width: 100%;
  z-index: 1000;
  border-bottom: 1px solid #ddd;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  height: 60px;
}

.nav-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  position: relative;
}

.brand {
  color: #333;
  font-size: 24px;
  text-decoration: none;
}

.nav-menu {
  list-style: none;
  display: flex;
  margin: 0;
  padding: 0;
}

.nav-menu li {
  margin-left: 20px;
}

.nav-item {
  color: #333;
  text-decoration: none;
  font-size: 16px;
  font-weight: 500;
}

.nav-item:hover {
  color: #5e81ac;
}

body {
  margin: 0;
}

/* Media query for mobile */
@media (max-width: 768px) {
  .nav-menu {
    position: absolute;
    top: 60px;
    left: 0;
    width: 100%;
    background-color: #fff;
    display: none;
    flex-direction: column;
    padding: 0;
    border-top: 1px solid #ddd;
  }

  .nav-menu.active {
    display: flex;
  }

  .nav-menu li {
    margin: 0;
    padding: 10px 20px;
    border-bottom: 1px solid #ddd;
  }

}
</style>
