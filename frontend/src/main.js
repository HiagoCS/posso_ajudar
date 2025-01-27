import './assets/main.css'
import * as Vue from 'vue'
import App from './App.vue'
import router from '@/router'
import { library } from "@fortawesome/fontawesome-svg-core";
import {faFilePdf,faFileLines,faFileExport,faFileImport,faArrowUp,faRightToBracket,faArrowLeft,faArrowRight,faCheck,faCopy,faTrashAlt,faSpinner,faDollarSign,faR,faPlus,faMinus,faMagnifyingGlass,faBan,faFilter, faCog, faCamera, faAngleDoubleLeft, faEye, faBox, faFile, faCalendar, faTableCellsLarge, faUsers, faCashRegister, faPenToSquare, faOutdent } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import '@/api/axios.js';
import FloatingVue from 'floating-vue';
import 'floating-vue/dist/style.css';
import VueTheMask from 'vue-the-mask'
import money from 'v-money3'
import { createI18n } from 'vue-i18n'
import {pt_BR} from '@/components/locales/pt_BR'
import {en} from '@/components/locales/en'
import $ from  'jquery'
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';





const languages ={
    pt_BR,
    en
}
const i18n = createI18n({
    locale:'pt_BR',
    fallbackLocale:'pt_BR',
    messages: languages
})

library.add(faFilePdf,faFileLines,faFileExport,faFileImport,faOutdent,faArrowUp,faRightToBracket,faArrowLeft,faArrowRight,faCheck,faCopy,faTrashAlt,faSpinner,faDollarSign,faR,faPenToSquare,faPlus,faMinus,faMagnifyingGlass,faBan,faFilter, faCog, faCamera, faAngleDoubleLeft, faEye, faBox, faFile, faCalendar, faTableCellsLarge, faUsers, faCashRegister);

window.$ = window.jQuery = $;
const app = 
Vue.createApp(App)
    .use(i18n)
    .component("font-awesome-icon", FontAwesomeIcon)
    .use(VueSweetalert2);
app.use(router)
app.use(VueTheMask);
app.use(FloatingVue);
app.use(money);
app.mount('#app')
