<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Api Documentation</title>
</head>
<body>
<script type="module">

    // import SwaggerUIStandalonePreset

    import {SwaggerUIBundle} from "../../node_modules/swagger-ui-swagger/swagger-ui-bundle.js";

    const ui = SwaggerUIBundle({
        url: "https://petstore.swagger.io/v2/swagger.json",
        dom_id: '#swaggesr-ui',
        presets: [
            SwaggerUIBundle.presets.apis,
            SwaggerUIBundle.SwaggerUIStandalonePreset
        ],
        layout: "StandaloneLayout"
    })

</script>
</body>
</html>
