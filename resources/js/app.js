require('./bootstrap');

import { createApp } from 'vue'
import App from './App.vue'

const app = createApp({})

app.component('App', App)

app.mount('#app')
