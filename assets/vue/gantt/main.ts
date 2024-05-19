import { createApp } from "vue";
import { createPinia } from 'pinia';
import "./styles.scss";
import App from "./views/Gantt.vue";
const pinia = createPinia()
//import "./css/frappe-gantt.css"
//import App from "./App.vue";


createApp(App)
.use(pinia)
.mount("#app");
