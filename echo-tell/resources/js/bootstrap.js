import "bootstrap";

import axios from "axios";
window.axios = axios;

const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
if (csrfTokenMeta) {
    const csrfToken = csrfTokenMeta.getAttribute("content");
    axios.defaults.headers.common["X-CSRF-TOKEN"] = csrfToken;
} else {
    console.error("CSRF token meta tag not found!");
}
axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;
const accessToken = localStorage.getItem("access_token");
if (accessToken) {
    axios.defaults.headers.common["Authorization"] = `Bearer ${accessToken}`;
}
