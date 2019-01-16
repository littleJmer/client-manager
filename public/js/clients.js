var $clientForm;
var ignore = ['work_phone', 'cell_phone'];

function setVariables() {
    return new Promise((resolve, reject) => {
        $clientForm = $('#clientForm');
        resolve();
    });
}

function setEvents() {
    return new Promise((resolve, reject) => {

        $clientForm.submit((e) => {

            submitButton($clientForm, DOM.spinner, true);

            e.preventDefault();
            let data = $clientForm.serializeObject();
            let error = false;
            let code = 201
            let method = "post";
            let url = "api/clients";

            for (let key in data) {
                if( ignore.includes(key) ) {
                    continue;
                }
                if (data[key] == '') {
                    feedback($(`input[name="${key}"]`), "Please enter a valid " + key, false);
                    error = true;
                } else {
                    feedback($(`input[name="${key}"]`), "", true, true);
                }
            }

            if (error) {
                submitButton($clientForm);
                return;
            }

            loader.show();

            if( data.id != 0 ) {
                code = 200;
                method = "put";
                url ="api/clients"+"/"+data.id;
            }

            request[method](url, data)
                .then(response => {
                    submitButton($clientForm);
                    loader.hide();
                    
                    if(response.status === code) {
                        window.location = '/app/dashboard';
                    } else {
                        if(response.data.errors) {
                            for(let key in response.data.errors) {
                                feedback($(`input[name="${key}"]`), response.data.errors[key][0], false);
                            }
                        }
                    }

                }).catch(error => {
                    submitButton($clientForm);
                    loader.hide();
                    console.error(error);
                });

        });

        resolve();

    });
}

$(document).ready(() => {

    setVariables()
        .then(() => setEvents())
        .then(response => console.log("Client: Variables & Events loaded."))
        .catch(error => console.error(error));

});