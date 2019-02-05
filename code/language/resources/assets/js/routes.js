import VueRouter from 'vue-router';
import Main from './components/layout/Main.vue';
import Login from './components/Login';
import Register from './components/Register';
import Home from './components/Home';
import ProjectCreate from './components/Project/ProjectCreate';
import ProjectList from './components/Project/ProjectList';
import ProjectEdit from './components/Project/ProjectEdit';

import LanguageList from './components/Language/LanguageList';

import UserList from './components/User/UserList';
import UserEdit from './components/User/UserEdit';

import NotFound from './components/NotFound';
import Logout from './components/Logout';
import {i18n} from "./i18n";
import store from "./components/store";


const routes = [
  { path: '/:lang/logout', component: Logout, name: 'logout'},
  { path: '/:lang/login', component: Login, name: 'login'},
  { path: '/:lang/register', component: Register, name: 'register'},
  { path: '/:lang',
    component: Main,
    children: [
      { path: 'home', component: Home, name: 'home' },

      // project
      { path: 'project', component: ProjectList, name: 'project_list' },
      { path: 'project/create', component: ProjectCreate, name: 'project_create' },
      { path: 'project/:id/edit', component: ProjectEdit, name: 'project_edit' },

      // user
      { path: 'user', component: UserList, name: 'user_list' },
      { path: 'user/:id/edit', component: UserEdit, name: 'user_edit' },

      // language
      { path: 'language/:id', component: LanguageList, name: 'language_list' },

    ],
    meta: { requiresAuth: true }
  },
  { path: '*', component: NotFound },
];

const router = new VueRouter({ routes});

router.beforeEach((to, from, next) => {
  const lang = to.params.lang;

  if (!['en', 'zh_tw'].includes(lang)) return next('en');
  else i18n.locale = lang;

  // check if the route requires authentication and user is not logged in
  if (to.matched.some(route => route.meta.requiresAuth) && !store.state.isLoggedIn) {
    // redirect to login page
    next({ name: 'login', params: {lang} })
    return
  }

  // if logged in redirect to dashboard
  if(to.path === '/login' && store.state.isLoggedIn) {
    next({ name: 'project_list', params: {lang} })
    return
  }


  return next();
});

export default router;
