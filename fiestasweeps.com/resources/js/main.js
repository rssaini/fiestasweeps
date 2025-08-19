import { createApp } from 'vue'
import { launch } from 'devtools-detector';
import Main from './Main.vue';

import '@fortawesome/fontawesome-free/css/all.css'

const app = createApp(Main)

app.mount('#vue-root')

//launch();
