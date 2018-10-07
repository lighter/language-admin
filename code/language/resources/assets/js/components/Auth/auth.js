export default {
  register(context, name, email, password, password_confirmation) {
    axios.post('api/register', {
      name, email, password, password_confirmation
    }).then(response => {
      console.log(response);
    });
  }
}
