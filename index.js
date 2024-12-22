const { ONE_SIGNAL_CONFIG } = require("./config/app.config.js")
const pushNotificationService = require("./services/push-notification.services.js");
const express = require("express");
const http = require("http");
const app = express();
const port = process.env.PORT || 4000;
const server = http.createServer(app);
const io = require("socket.io")(server);


// Middleware
app.use(express.json());
const routes = require("./routes");
app.use("/api", routes);
app.use("/uploads", express.static("uploads"));


const clients = {};

io.on("connection", (socket) => {
    console.log("connected");
    console.log(socket.id, "has joined");

    socket.on("signin", (id) => {
        console.log(`User ${id} has signed in`);
        clients[id] = socket; // CHECK IF SIGNING IN WITH DIRRENT DEVICES WITH THE SAME ID WILL AND THE SAME IT MORE THAN ONCE
        console.log("Connected clients:", clients);
    });


    
});

