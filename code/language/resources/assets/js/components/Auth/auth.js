export default {
  register(context, name, email, password, password_confirmed) {
    axios.post('api/register', {
      name, email, password, password_confirmed
    }).then(response => {
      console.log(response);
    });
  }
}
