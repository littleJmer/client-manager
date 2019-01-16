var $loginForm;
var $registerForm;

function setVariables() {
    return new Promise((resolve, reject) => {
        $loginForm = $('#loginForm');
        $registerForm = $('#registerForm');
        resolve();
    });
}

function setEvents() {
    return new Promise((resolve, reject) => {


        $loginForm ? $loginForm.submit((e) => {

            submitButton($loginForm, DOM.spinner, true);

            e.preventDefault();
            let data = $loginForm.serializeObject();
            let error = false;

            for (let key in data) {
                if (data[key] == '') {
                    feedback($(`input[name="${key}"]`), "Please enter a valid " + key, false);
                    error = true;
                } else {
                    feedback($(`input[name="${key}"]`), "", true, true);
                }
            }

            if (error) {
                submitButton($loginForm);
                return;
            }

            request
                .post('login', data)
                .then(response => {
                    submitButton($loginForm);
                    if(response.status === 200) {
                        window.location = '/app/dashboard';
                    } else {
                        if(response.data.errors) {
                            for(let key in response.data.errors) {
                                feedback($(`input[name="${key}"]`), response.data.errors[key][0], false);
                            }
                        }
                    }
                }).catch(error => {
                    submitButton($loginForm);
                    console.error(error);
                });

        }) : undefined;



        $registerForm ? $registerForm.submit((e) => {

            submitButton($registerForm, DOM.spinner, true);

            e.preventDefault();

            let data = $registerForm.serializeObject();
            let error = false;

            for (let key in data) {
                if (data[key] == '') {
                    feedback($(`input[name="${key}"]`), "Please enter a valid " + key, false);
                    error = true;
                } else {
                    feedback($(`input[name="${key}"]`), "", true, true);
                }
            }

            if( data.password != data.password_confirmation ) {
                error = true;
                feedback($(`input[name="password_confirmation"]`), "The Password does not match", false);
            }

            if (error) {
                submitButton($registerForm);
                return;
            }

            request
                .post('register', data)
                .then(response => {
                    submitButton($registerForm);
                    if(response.status === 201) {
                        window.location = '/app/dashboard';
                    } else {
                        if(response.data.errors) {
                            for(let key in response.data.errors) {
                                feedback($(`input[name="${key}"]`), response.data.errors[key][0], false);
                            }
                        }
                    }
                }).catch(error => {
                    submitButton($registerForm);
                    console.error(error);
                });


        }) : undefined;

        resolve();

    });
}

$(document).ready(() => {

    setVariables()
        .then(() => setEvents())
        .then(response => console.log("Login: Variables & Events loaded."))
        .catch(error => console.error(error));

});