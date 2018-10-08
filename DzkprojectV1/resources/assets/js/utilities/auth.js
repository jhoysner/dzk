let user = JSON.parse(localStorage.getItem('userdata'));

module.exports = {
	computed: {
		user(){
			return user;
		}
	}
};