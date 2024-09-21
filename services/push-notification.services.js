const {ONE_SIGNAL_CONFIG} = require("../config/app.config");

async function SendNotification(data, callback){
    var headers = {
        "Content-Type": "application/json; charset=utf-8",
        Authorization: "Basic " + ONE_SIGNAL_CONFIG.API_KEY,
    };

    var options = {
        host: "onesignal.com",
        port: 443,
        path: "/api/v1/notifications",
        method: "POST",
        headers: headers
    };

    var https = require("https");
    var req = https.request(options, function(res){
        res.on("data", function(data){
            console.log(JSON.parse(data));
            return callback(null, JSON.parse(data));
        });
    });
    req.on("error", function(e){
        return callback({
            message: e
        });
    });

    req.write(JSON.stringify(data));
    req.end();
}

async function CancelNotification(notificationId, callback) {
    var headers = {
        "Content-Type": "application/json; charset=utf-8",
        Authorization: "Basic " + ONE_SIGNAL_CONFIG.API_KEY,
    };

    var options = {
        host: "onesignal.com",
        port: 443,
        path: `/api/v1/notifications/${notificationId}?app_id=${ONE_SIGNAL_CONFIG.APP_ID}`,
        method: "DELETE",
        headers: headers
    };

    var https = require("https");
    var req = https.request(options, function (res) {
        res.on("data", function (data) {
            console.log(JSON.parse(data));
            return callback(null, JSON.parse(data));
        });
    });

    req.on("error", function (e) {
        return callback({
            message: e.message
        });
    });

    req.end();
}

module.exports = {
    SendNotification,
    CancelNotification
}