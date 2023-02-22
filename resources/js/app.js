import './bootstrap';
import {createApp} from "vue";
import router from "./router";
import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap"
import Notifications from '@kyvg/vue3-notification'
import App from "./App.vue";


const app=createApp(App);
app.use(router)
app.use(Notifications)
app.mount('#app')
