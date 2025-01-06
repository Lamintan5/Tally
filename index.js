const { ONE_SIGNAL_CONFIG } = require("./config/app.config.js")
const pushNotificationService = require("./services/push-notification.services.js");
const express = require("express");
const http = require("http");
const app = express();
const port = process.env.PORT || 4000;
const server = http.createServer(app);
const io = require("socket.io")(server);
const routes = require("./routes");

const Mpesa = require("mpesa-api").Mpesa;
const axios = require('axios');
const moment = require("moment");
const fs = require("fs");
const mysql = require("mysql2");

// Middleware
app.use(express.json());
app.use("/api", routes);
app.use("/uploads", express.static("uploads"));


const clients = {};
var stkToken;

io.on("connection", (socket) => {
    console.log("connected");
    console.log(socket.id, "has joined");

    socket.on("signin", (id) => {
        console.log(`User ${id} has signed in`);
        clients[id] = socket; 
        // console.log("Connected clients:", clients);
    });

    socket.on("signout", (id) => {
        console.log(`User ${id} has signed out`);
        delete clients[id]; 
        console.log("Connected clients:", clients);
    });
    
    socket.on("message", (msg)=>{
        console.log(msg);
        let targetId = msg.targetId;
        let messageText = msg.message;
        let username = msg.title;
        let recipientToken = msg.token;
        let profile = msg.profile;
        let image = msg.path;

        if (clients[targetId]) {
            clients[targetId].emit("message", msg);
            console.log(`Sent message to user ${targetId}`);
        } else {
            console.log(`User ${targetId} not found`);
        }
        var message = {
            app_id: ONE_SIGNAL_CONFIG.APP_ID,
            contents: {en : messageText,},
            headings: {en: username,},
            included_segments: ["Subscribed Users"],
            buttons: [
                { id: "1", text: "Reply", action: { url: `Tally://message?userId=${targetId}` } },
                { id: "2", text: "Ignore",},
            ],
            include_player_ids: recipientToken,
            content_available: true,
            small_icon: "ic_app_log",
            groupSummaryIcon: "ic_app_log",
            large_icon: "https://static.wikia.nocookie.net/boondocks/images/a/ac/Cindy_wide_eyes.jpg/revision/latest?cb=20120718190104",
            // big_picture: "https://10.17.9.72/Tally/profile/riley.jpg",
            data: {
                PushTitle: "STUDIO5IVE",
                group: "123456",
            },
            ios_sound: "default", 
            android_sound: "default",
            priority: 10,
        };
        pushNotificationService.SendNotification(message, (error, results) => {
            if(error){
                console.log(`Error`);
            } else {
                console.log(`Success`)
            }
            
        });
    });

    socket.on("group", (msg) => {
    console.log("Received group message:", msg);

    let targetIds = msg.targetId || [];
    let messageText = msg.message;
    let title = msg.title;
    let recipientToken = msg.token;
    let profile = msg.profile;
    let image = msg.path;
    let username = msg.username;

        targetIds.forEach(targetId => {
            if (clients[targetId]) {
                clients[targetId].emit("group", msg);
                console.log(`Sent group message to user ${targetId}`);
            } else {
                console.log(`User ${targetId} not found`);
            }
        });
        var message = {
            app_id: ONE_SIGNAL_CONFIG.APP_ID,
            contents: {en : `${username} : ${messageText}`,},
            headings: {en: title,},
            included_segments: ["Grouped Users"],
            buttons: [
                { id: "1", text: "Reply", action: { url: `Tally://message?userId=123` } },
                { id: "2", text: "Ignore",},
            ],
            include_player_ids: recipientToken,
            content_available: true,
            small_icon: "ic_app_log",
            large_icon: profile,
            big_picture: image,
            data: {
                PushTitle: "STUDIO5IVE"
            },
            ios_sound: "default", 
            android_sound: "default",
            priority: 10,
        };
        pushNotificationService.SendNotification(message, (error, results) => {
            if(error){
                return console.log(`Error`)
            } else {
                console.log(`Success`)
            }
            
        });
    });
    
    socket.on("notif", (msg)=>{
        console.log(msg);
        let targetIds = msg.pid || [];
        let messageText = msg.message;
        let title = msg.title;
        let recipientToken = msg.token;
        let profile = msg.profile;

        targetIds.forEach(pid => {
            if (clients[pid]) {
                clients[pid].emit("notif", msg);
                console.log(`Sent Notification to user ${pid}`);
            } else {
                console.log(`User ${pid} not found`);
            }
        });
        var message = {
            app_id: ONE_SIGNAL_CONFIG.APP_ID,
            contents: {en : messageText,},
            headings: {en: title,},
            included_segments: ["Subscribed Users"],
            
            include_player_ids: recipientToken,
            content_available: true,
            small_icon: "ic_app_log",
            groupSummaryIcon: "ic_app_log",
           
           
            data: {
                PushTitle: "STUDIO5IVE",
                group: "123456",
            },
            ios_sound: "default", 
            android_sound: "default",
            priority: 10,
        };
        pushNotificationService.SendNotification(message, (error, results) => {
            if(error){
                console.log(`Error`);
            } else {
                console.log(`Success`)
            }
            
        });
    });

    socket.on("cancel-notification", (msg) => {
        console.log("Cancel notification request received:", msg);
        let notificationId = msg.mid;

        pushNotificationService.CancelNotification(notificationId, (error, results) => {

            if (error) {
                console.log(`Error canceling notification: ${error.message}, ${msg.mid}`);
            } else {
                console.log(`Notification canceled successfully`, results);
             
                socket.emit("notification-canceled", { mid: notificationId, status: "success" });
            }
        });
    });

    socket.on("disconnect", (_) => {
        console.log("Disconnected. Reconnecting :", new Date().toLocaleTimeString().substring(0, 5));
        
    });

    socket.on("connect_error", (err) => {
        console.log("Connection error: ", err);

    });

    console.log(`${socket.connected}: ${new Date().toLocaleTimeString().substring(0, 5)}`);
});

//ACCESS TOKEN ROUTE
app.get("/api/access_token", async (req, res) => {
    try {
      const accessTokenResponse = await getAccessToken();
      res.status(200).json(accessTokenResponse); 
    } catch (error) {
      console.error(error);
      res.status(500).json({
        success: false,
        message: "Failed to fetch access token",
        error: error.message,
      });
    }
  });

async function getAccessToken() {
    const consumer_key = "F4kGqNsTpB91Hg7xqQ6JMALnZWlAbkIpyzfsNu7DBAFRFyw5";
    const consumer_secret = "vpLfuvxZuXSX0wlDRsqT62jepHk7F4NqcEyXZXNQfBFcowrqt4eUJoNLamNQBWAa";
    const url = "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
    const auth = "Basic " + Buffer.from(consumer_key + ":" + consumer_secret).toString("base64");
  
    try {
      const response = await axios.get(url, {
        headers: { Authorization: auth },
      });
      return response.data; // Return the full response body
    } catch (error) {
      // Return error details for better debugging
      return {
        success: false,
        message: error.message,
        details: error.response ? error.response.data : null,
      };
    }
}

// REGISTER URL FOR C2B
app.post("/api/registerurl", async (req, res) => {
    try {
      const { accessToken, ShortCode } = req.body;
  
      // Validate the required parameters
      if (!accessToken || !ShortCode) {
        return res.status(400).json({
          success: false,
          message: "Access token and ShortCode are required.",
        });
      }
  
      const url = "https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl";
      const auth = "Bearer " + accessToken;
  
      const payload = {
        ShortCode,
        ResponseType: "Complete",
        ConfirmationURL: "https://more-crow-hardly.ngrok-free.app/api/confirmation",
        ValidationURL: "http://more-crow-hardly.ngrok-free.app/api/validation",
      };
  
      const response = await axios.post(url, payload, {
        headers: { Authorization: auth },
      });
  
      res.status(200).json({
        success: true,
        data: response.data,
      });
    } catch (error) {
      console.error("Error in registerUrl:", error.message);
  
      res.status(500).json({
        success: false,
        message: "Failed to register URL",
        details: error.response ? error.response.data : null,
      });
    }
});

//MPESA STK PUSH ROUTE
app.post("/api/stkpush", async (req, res) => {
    try {
      const { accessToken, BusinessShortCode, Amount, PhoneNumber, AccountReference } = req.body;
      
      if (!accessToken || !BusinessShortCode || !Amount || !PhoneNumber || !AccountReference) {
        return res.status(400).json({
          success: false,
          message: "AccessToken, BusinessShortCode, Amount, AccountReference and PhoneNumber are required.",
        });
      }
  
      stkToken = accessToken;
      
      const url = "https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest";
      const auth = "Bearer " + accessToken;
      const timestamp = moment().format("YYYYMMDDHHmmss");
      const password = Buffer.from(
        BusinessShortCode +
          "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919" +
          timestamp
      ).toString("base64");
  
      const payload = {
        BusinessShortCode:BusinessShortCode,
        Password: password,
        Timestamp: timestamp,
        TransactionType: "CustomerPayBillOnline",
        Amount:Amount,
        PartyA: PhoneNumber,
        PartyB: BusinessShortCode,
        PhoneNumber: PhoneNumber,
        CallBackURL: "https://more-crow-hardly.ngrok-free.app/api/callback",
        AccountReference:AccountReference,
        TransactionDesc: "Mpesa Daraja API STK Push test",
      };
  
      const response = await axios.post(url, payload, {
        headers: {
          Authorization: auth,
        },
      });
  
      res.status(200).json({
        success: true,
        data: response.data,
      });
    } catch (error) {
      console.error("Error response from Mpesa API:", error.response?.data || error.message);
  
      res.status(500).json({
        success: false,
        message: "Failed to initiate STK Push",
        details: error.response ? error.response.data : error.message,
      });
    }
  });

  app.get("/api/confirmation", (req, res) => {
  console.log("All transaction will be sent to this URL");
  console.log(req.body);
});

app.post("/api/callback", (req, res) => {
    console.log("STK PUSH CALLBACK");
    const resultCode = req.body.Body.stkCallback.ResultCode;
    const resultDesc = req.body.Body.stkCallback.ResultDesc;
  
    console.log("ResultCode:", resultCode);
    console.log("ResultDesc:", resultDesc);
    
  
    var json = JSON.stringify(req.body);
    fs.writeFile("stkcallback.json", json, "utf8", function (err) {
      if (err) {
        return console.log(err);
      }
      console.log("STK PUSH CALLBACK STORED SUCCESSFULLY");
    });
});

app.get("/api/validation", (req, resp) => {
    console.log("Validating payment");
    console.log(req.body);
});

app.route("/check").get((req, res) => {
    return res.json("Your app is working fine");
});

server.listen(port, "0.0.0.0", () => {
    console.log("server started");
});
