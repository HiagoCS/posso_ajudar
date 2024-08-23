import './assets/main.css'
import * as Vue from 'vue'
import App from './App.vue'
import router from '@/router'
import { library } from "@fortawesome/fontawesome-svg-core";
import {faMagnifyingGlass,faBan,faFilter, faCog, faCamera, faAngleDoubleLeft, faEye, faBox, faFile, faCalendar, faTableCellsLarge, faUsers, faCashRegister } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import '@/api/axios.js';

import { createI18n } from 'vue-i18n'
import {pt_BR} from '@/components/locales/pt_BR'
import {en} from '@/components/locales/en'
import $ from  'jquery'
const languages ={
    pt_BR,
    en
}
const i18n = createI18n({
    locale:'pt_BR',
    fallbackLocale:'pt_BR',
    messages: languages
})

library.add(faMagnifyingGlass,faBan,faFilter, faCog, faCamera, faAngleDoubleLeft, faEye, faBox, faFile, faCalendar, faTableCellsLarge, faUsers, faCashRegister);

window.$ = window.jQuery = $;
const app = 
Vue.createApp(App)
    .use(i18n)
    .component("font-awesome-icon", FontAwesomeIcon)
    .use(VueSweetalert2);

app.use(router)

app.mount('#app')
