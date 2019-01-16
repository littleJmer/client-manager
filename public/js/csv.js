const CSV = {

    init: function () {
        self = this;

        function readFile() {
            if (this.files && this.files[0]) {
                var FR = new FileReader();
                FR.addEventListener("load", function (e) {
                    self.submit();
                });
                FR.readAsDataURL(this.files[0]);
            }

        }
        document.getElementById("fileCsv").addEventListener("change", readFile);

        $('#formCsv').submit(function (e) {
            e.preventDefault();
            var d = new Date();
            $.ajax({
                url: "/api/clients/import?_=" + d.getTime(),
                method: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function () {
                    // show loader
                    self.error(false);
                    self.message('', false);
                    loader.show();
                },
                success: function (data, status, xhr) {
                    // redirec to dashboard..
                    if (xhr.status === 201) {
                        window.location.href = "/app/dashboard";
                    }
                    // 0 clients imported
                    else {
                        self.message(data.message);
                    }
                },
                error: function (xhr, status, error) {
                    // show error msg 
                    // xhr.status === 500..
                    self.error(true, xhr.responseJSON.errors);
                },
                complete: function () {
                    // hide loader
                    loader.hide();
                    // clear input
                    document.getElementById("fileCsv").value = null;
                }
            });
        });

    },

    select: function () {
        $('#fileCsv').click();
    },

    submit: function () {
        $('#formCsv').submit();
    },

    error: function (tt = true, errors) {
        $('[data-extra-errors]').html('');
        if (tt) {
            $("#errorCsv").removeClass("invisible");
            for (let i = 0; i < errors.length; i++) {
                let line = errors[i].line;
                let objErrors = errors[i].errors;
                for(let key in objErrors) {
                    $('[data-extra-errors]').append(`
                        <li>
                            line: ${line}<br>field: ${key}<br>error: ${objErrors[key][0]}
                        </li>
                    `);
                }
            }
        }
        else {
            $("#errorCsv").addClass("invisible");
        }
    },

    message: function (msg = '', show = true) {

        $("#msgCsv span").html(msg);

        if (show)
            $("#msgCsv").removeClass("invisible");
        else
            $("#msgCsv").addClass("invisible");
    },

};


$(document).ready(() => CSV.init());