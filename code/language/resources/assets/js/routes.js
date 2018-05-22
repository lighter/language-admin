import VueRouter from 'vue-router';
import Main from './components/layout/Main.vue';
import Login from './components/Login';
import Register from './components/Register';
import Home from './components/Home';
import NotFound from './components/NotFound';

const routes = [
  { path: '/login', component: Login},
  { path: '/register', component: Register},
  { path: '/',
    component: Main,
    children: [
      {
        path: 'home',
        component: Home,
      }
    ]
  },
  { path: '*', component: NotFound },
];

export default new VueRouter({
  routes
});