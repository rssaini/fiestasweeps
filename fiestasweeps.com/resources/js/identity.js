import { createApp } from 'vue'
import { launch } from 'devtools-detector';
import Identity from './Identity.vue';

const app = createApp(Identity)

app.mount('#vue-root')
//launch();
