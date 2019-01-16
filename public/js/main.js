const loader = {
    hide: function () {
        $('.loaderHolder').fadeOut();
    },
    show: function () {
        $('.loaderHolder').fadeIn();
    }
}

$(document).ready(() => { loader.hide(); });

function submitButton($form, html = "Sign In", disabled = false) {
    $form.find('[type="submit"]').html(html);
    $form.find('[type="submit"]').prop('disabled', disabled);
}

(function ($) {
    $.fn.serializeObject = function () {

        var self = this,
            json = {},
            push_counters = {},
            patterns = {
                "validate": /^[a-zA-Z][a-zA-Z0-9_]*(?:\[(?:\d*|[a-zA-Z0-9_]+)\])*$/,
                "key": /[a-zA-Z0-9_]+|(?=\[\])/g,
                "push": /^$/,
                "fixed": /^\d+$/,
                "named": /^[a-zA-Z0-9_]+$/
            };


        this.build = function (base, key, value) {
            base[key] = value;
            return base;
        };

        this.push_counter = function (key) {
            if (push_counters[key] === undefined) {
                push_counters[key] = 0;
            }
            return push_counters[key]++;
        };

        $.each($(this).serializeArray(), function () {

            // skip invalid keys
            if (!patterns.validate.test(this.name)) {
                return;
            }

            var k,
                keys = this.name.match(patterns.key),
                merge = this.value,
                reverse_key = this.name;

            while ((k = keys.pop()) !== undefined) {

                // adjust reverse_key
                reverse_key = reverse_key.replace(new RegExp("\\[" + k + "\\]$"), '');

                // push
                if (k.match(patterns.push)) {
                    merge = self.build([], self.push_counter(reverse_key), merge);
                }

                // fixed
                else if (k.match(patterns.fixed)) {
                    merge = self.build([], k, merge);
                }

                // named
                else if (k.match(patterns.named)) {
                    merge = self.build({}, k, merge);
                }
            }

            json = $.extend(true, json, merge);
        });

        return json;
    };
})(jQuery);

const DOM = {
    spinner: `<div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div>`,
}

function feedback($dom, msg, success, reset = false) {
    $dom.removeClass('is-valid');
    $dom.removeClass('is-invalid');
    $dom.siblings().filter('.valid-feedback').html('');
    $dom.siblings().filter('.invalid-feedback').html('');
    if (reset) return;
    if (success) {
        $dom.addClass('is-valid');
        $dom.siblings().filter('.valid-feedback').html(msg);
    }
    else {
        $dom.addClass('is-invalid');
        $dom.siblings().filter('.invalid-feedback').html(msg);
    }
}

const API_URL = 'http://104.248.217.67';

axios.defaults.withCredentials = true;

const request = axios.create({
    baseURL: API_URL,
    withCredentials: true,
    responseType: 'json',
    transformResponse: [(data) => {
        if (data && data.error && data.data) {
            if (data.data.code === 401) {
                // ..
            }
        }
        return data;
    }],
    validateStatus: function (status) {
        if (status === 401) {
            // ..
        }
        return true;
    },
});

// request.interceptors.request.use(request => {
//     console.log('>>> Starting Request <<<');
//     console.log('> URL: ', request.baseURL + '/' + request.url);
//     console.log('> METHOD: ', request.method);
//     console.log('> DATA: ', request.data || null);
//     return request;
// });

// request.interceptors.response.use(response => {
//     console.log('> RESPONSE STATUS: ', response.status);
//     console.log('> RESPONSE DATA: ', response.data);
//     console.log('>>> Ending Request <<<');
//     return response;
// });