export default function (Vue) {
    Vue.laravelErrors = {
        handle (err) {
            var messages = [];
            var html = "";
            let status = err.response.status;

            if ( status == 500 )
            {
                messages.push("Error del servidor.");
                html = "Error del servidor";

                return {
                    messages,
                    html,
                    errors: [], status
                };
            }

            if ( status == 401 )
            {
                messages.push("No esta autorizado.");
                html = "No esta autorizado";

                return {
                    messages,
                    html,
                    errors: [], status
                };
            }

            if ( status == 404 )
            {
                messages.push("No se ha encontrado la información.");
                html = "No se ha encontrado la información";

                return {
                    messages,
                    html,
                    errors: [], status
                };
            }

            let errors = err.response.data;
            for (var key in errors) {
                if (err.response.data[key] instanceof Array) {
                    for (var i = 0; i < err.response.data[key].length; i++) {
                        messages.push(err.response.data[key][i]);
                    }
                }
                if (typeof err.response.data[key] === 'string') {
                    messages.push(err.response.data[key]);
                }
            }

            messages.forEach((item) => {
                if ( html != '' )
                    html = `${html} <br>`;
                html = `${html} ${item}`;
            })

            return {
                messages,
                html,
                errors,
                status
            };
        }
    };

    Object.defineProperties(Vue.prototype, {
        $laravelErrors: {
            get: () => {
                return Vue.laravelErrors
            }
        }
    })
}