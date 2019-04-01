import VueRouter from 'vue-router';
import Main from '#/components/layout/Main.vue';
import Login from '#/components/Login';
import Register from '#/components/Register';
import ForgotPassword from '#/components/ForgotPassword';
import ResetPassword from '#/components/ResetPassword';
import VerifyUser from '#/components/VerifyUser';

import Home from '#/components/Home';
import ProjectCreate from '#/components/Project/ProjectCreate';
import ProjectList from '#/components/Project/ProjectList';
import ProjectEdit from '#/components/Project/ProjectEdit';
import ProjectOwner from '#/components/Project/ProjectOwner';
import ProjectInvite from '#/components/Project/ProjectInvite';

import LanguageList from '#/components/Language/LanguageList';

import UserList from '#/components/User/UserList';
import UserEdit from '#/components/User/UserEdit';

import NotFound from '#/components/NotFound';
import Logout from '#/components/Logout';
import {i18n} from "#/i18n";
import store from "#/components/store";
import OAuthCallback from "#/OAuthCallback";

const routes = [
  { path: '/oauth/:driver/:token', component: OAuthCallback, name: 'oauth_callback'},
  { path: '/:lang/reset_pass/:code', component: ResetPassword, name: 'reset_pass'},
  { path: '/:lang/logout', component: Logout, name: 'logout'},
  { path: '/:lang/login', component: Login, name: 'login'},
  { path: '/:lang/register', component: Register, name: 'register'},
  { path: '/:lang/forgot_pass', component: ForgotPassword, name: 'forgot_pass'},
  { path: '/:lang/user/verify/:code', component: VerifyUser, name: 'verify_user'},
  { path: '/:lang',
    component: Main,
    children: [
      { path: 'home', component: Home, name: 'home' },

      // project
      { path: 'project', component: ProjectList, name: 'project_list' },
      { path: 'project/create', component: ProjectCreate, name: 'project_create' },
      { path: 'project/:id/edit', component: ProjectEdit, name: 'project_edit' },
      { path: 'project/:id/owner', component: ProjectOwner, name: 'project_owner' },
      { path: 'project/invite/:token', component: ProjectInvite, name: 'project_invite'},

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

const router = new VueRouter({
  routes,
  mode: 'history',
  base: '/',
  fallback: true
});

router.beforeEach((to, from, next) => {
  const lang = to.params.lang;

  if (to.name == 'oauth_callback') return next();

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
