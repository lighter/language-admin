import store from "../store";

export default {

  register(context, name, email, password, password_confirmation) {
    return axios.post('api/register', {
      name, email, password, password_confirmation
    }).then(response => {
      store.commit('loginUser');
    });
  },

  login(email, password) {
    return axios.post('api/login', { email, password })
      .then(response => {

        if ('data' in response.data) {
          store.commit('loginUser');
          localStorage.setItem('token', response.data.data.api_token);
          return true;
        }
      })
      .catch(function (error) {
        return false;
      });
  }
}
