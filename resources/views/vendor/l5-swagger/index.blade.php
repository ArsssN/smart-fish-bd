<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{config('l5-swagger.documentations.'.$documentation.'.api.title')}}</title>
    <link rel="stylesheet" type="text/css" href="{{ l5_swagger_asset($documentation, 'swagger-ui.css') }}">
    <link rel="icon" type="image/png" href="{{ l5_swagger_asset($documentation, 'favicon-32x32.png') }}" sizes="32x32"/>
    <link rel="icon" type="image/png" href="{{ l5_swagger_asset($documentation, 'favicon-16x16.png') }}" sizes="16x16"/>
    <style>
        html {
            box-sizing : border-box;
            overflow   : -moz-scrollbars-vertical;
            overflow-y : scroll;
        }

        *,
        *:before,
        *:after {
            box-sizing : inherit;
        }

        body {
            margin     : 0;
            background : #fafafa;
        }
    </style>
</head>

<body>
@if(!backpack_auth()->check())
    <script>
        window.location = "{{ route('your.route.name') }}";
    </script>
@endif
<div id="swagger-ui"></div>

<script src="{{ l5_swagger_asset($documentation, 'swagger-ui-bundle.js') }}"></script>
<script src="{{ l5_swagger_asset($documentation, 'swagger-ui-standalone-preset.js') }}"></script>
<script>
    const dom_id  = "#swagger-ui"
    window.onload = function () {
        // Build a system
        const ui = SwaggerUIBundle({
            dom_id           : dom_id,
            url              : "{!! $urlToDocs !!}",
            operationsSorter : {!! isset($operationsSorter) ? '"' . $operationsSorter . '"' : 'null' !!},
            configUrl        : {!! isset($configUrl) ? '"' . $configUrl . '"' : 'null' !!},
            validatorUrl     : {!! isset($validatorUrl) ? '"' . $validatorUrl . '"' : 'null' !!},
            oauth2RedirectUrl: "{{ route('l5-swagger.'.$documentation.'.oauth2_callback', [], $useAbsolutePath) }}",

            requestInterceptor: function (request) {
                request.headers['X-CSRF-TOKEN'] = '{{ csrf_token() }}';
                return request;
            },

            presets: [
                SwaggerUIBundle.presets.apis,
                SwaggerUIStandalonePreset,
            ],

            plugins: [
                SwaggerUIBundle.plugins.DownloadUrl,
            ],

            layout              : "StandaloneLayout",
            docExpansion        : "{!! config('l5-swagger.defaults.ui.display.doc_expansion', 'none') !!}",
            deepLinking         : true,
            filter              : {!! config('l5-swagger.defaults.ui.display.filter') ? 'true' : 'false' !!},
            persistAuthorization: "{!! config('l5-swagger.defaults.ui.authorization.persist_authorization') ? 'true' : 'false' !!}",

        })

        window.ui = ui

        @if(in_array('oauth2', array_column(config('l5-swagger.defaults.securityDefinitions.securitySchemes'), 'type')))
        ui.initOAuth({
            usePkceWithAuthorizationCodeGrant: "{!! (bool)config('l5-swagger.defaults.ui.authorization.oauth2.use_pkce_with_authorization_code_grant') !!}",
        })
        @endif

        let btnAuthorize = document.querySelector('.auth-wrapper .btn.authorize')
        const dom        = document.querySelector(dom_id);
        const observer   = new MutationObserver(function (mutations) {
            mutations.forEach(function (mutation) {
                if (!btnAuthorize) {
                    btnAuthorize = document.querySelector('.auth-wrapper .btn.authorize');
                    if (btnAuthorize && !btnAuthorize.classList.contains('locked')) {
                        authorizeToken(btnAuthorize);
                    }
                }
            });
        });
        // observe if any change in dom
        observer.observe(dom, {attributes: true, childList: true, subtree: true, characterData: true});
    }

    const authorizeToken = async function (openAuthFormButton) {
        let jwt_token    = localStorage.getItem("jwt_token");
        let no_jwt_token = !jwt_token || jwt_token === "undefined" || jwt_token === "null";

        if (no_jwt_token) {
            await fetch("{{ route('access-token.create') }}", {
                method : "GET",
                headers: {
                    "Content-Type": "application/json",
                    "Accept"      : "application/json",
                },
            })
                .then(response => response.json())
                .then(data => {
                    if (data.access_token) {
                        openAuthFormButton.click();
                        localStorage.setItem("jwt_token", data.access_token);
                        no_jwt_token = false;
                        jwt_token    = localStorage.getItem("jwt_token");
                    }
                });
        } else {
            openAuthFormButton.click();
        }


        setTimeout(function () {
            let tokenInput  = document.querySelector(".auth-container input");
            let authButton  = document.querySelector(".auth-btn-wrapper .modal-btn.auth");
            let closeButton = document.querySelector("button.btn-done");

            if (no_jwt_token) {
                closeButton.click();
                return;
            }

            let nativeInputValueSetter = Object.getOwnPropertyDescriptor(window.HTMLInputElement.prototype, "value").set;
            nativeInputValueSetter.call(tokenInput, jwt_token);

            let inputEvent = new Event('input', {bubbles: true});
            tokenInput.dispatchEvent(inputEvent);
            authButton.click();
            closeButton.click();
        }, 500);
    }
</script>
</body>
</html>
