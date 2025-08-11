import { createApp } from 'vue'
import { launch } from 'devtools-detector';
import Main from './Main.vue';

const app = createApp(Main)

app.mount('#vue-root')

launch();
