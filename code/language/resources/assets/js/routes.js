import VueRouter from 'vue-router';
import Home from './components/Home.vue';
import Login from './components/Login';
import Register from './components/Register';

const routes = [
  { path: '/', component: Home},
  { path: '/login', component: Login},
  { path: '/register', component: Register},
];

export default new VueRouter({
  routes
});