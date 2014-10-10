try {
    if (!WebSocket) {
        console.log("no websocket support");
    } else {
        var socket = new WebSocket("ws://127.0.0.1:7778/");
        socket.addEventListener("open", function (e) {
            console.log("open: ", e);
        });
        socket.addEventListener("error", function (e) {
            console.log("error: ", e);
        });
        socket.addEventListener("message", function (e) {
            console.log("message: ", JSON.parse(e.data));
        });
        console.log("socket:", socket);
        window.socket = socket;
    }
} catch (e) {
    console.log("exception: " + e);
}