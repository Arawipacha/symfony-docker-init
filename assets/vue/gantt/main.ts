import './bootstrap';
import ToastPlugin from './../Pugins/Toast';
import { createApp } from "vue";
import { createPinia } from 'pinia';
import "./styles.scss";
import App from "./views/Gantt.vue";
import './axios.interceptor';
const pinia = createPinia();
//import App from "./App.vue";


createApp(App)
.use(pinia)
.use(ToastPlugin)
.mount("#app");
