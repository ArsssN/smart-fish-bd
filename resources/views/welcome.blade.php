<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vue.js Single File Setup</title>
    <!-- Include Vue.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
</head>
<body>
<div id="app">
    <h1>@{{ message }}</h1>
    <input v-model="inputText" type="text">
    <p>@{{ inputText }}</p>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mqtt/5.3.6/mqtt.min.js"></script>
<!-- Vue.js Code -->
<script>
    const client = mqtt.connect()

    client.on('connect', function () {
        client.subscribe('topic', function (err) {
            if (!err) {
                console.log('Subscribed to topic')
            }
        })
    })

    client.on('message', function (topic, message) {
        console.log('Received message:', message.toString())
    })

</script>
</body>
</html>
