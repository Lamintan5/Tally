const otpGenerator = require("otp-generator");
const crypto = require("crypto");
const key = "Lamintan";
const emailServices = require("../services/emailer.service");

async function sendOTP(params, callback){
    const otp = otpGenerator.generate(6, {
            digits: true,
            upperCaseAlphabets: false,
            specialChars: false,
            lowerCaseAlphabets: false,
        }
    );

    const ttl = 10 * 60 * 1000;
    const  expires = Date.now() + ttl;
    const data = `${params.email}.${otp}.${expires}`;
    const hash = crypto.createHmac("sha256", key).update(data).digest("hex");
    const fullHash = `${hash}.${expires}`;

    var otpMessage = `Dear Customer, \n\n I hope this email finds you well. My name is [Your Name], and I am reaching out to you on behalf of Studio5ive. We have received a request that requires your confirmation through a one-time password (OTP).\n
Please find the OTP provided below:\n\n${otp}\n\n For security purposes, we kindly request you to keep this information confidential and not share it with anyone.
If you did not initiate this request or have any concerns, please contact our support team immediately. \n\nThank you for your prompt attention to this matter. 
If you require any further assistance, feel free to reply to this email or contact our support team at https://www.studio-5ive.com\n\n
Best regards,\n\n
Lamintan
Chief Executive Officer
Studio5ive`;

    var model = {
        email: params.email,
        subject: "Registration OTP",
        body: otpMessage
    };

    emailServices.sendEmail(model, (error, result) => {
        if(error){
            return callback(error);
        } 
        return callback(null, fullHash);
    });
}

async function verifyOTP(params, callback){
    let [hashValue, expires] = params.hash.split('.');

    let now = Date.now();

    if(now > parseInt(expires)) return callback("OTP Expired");

    let data = `${params.email}.${params.otp}.${expires}`;
    let newCalculateHash = crypto.createHmac("sha256", key).update(data).digest("hex");
    if(newCalculateHash === hashValue) {
        return callback(null, "Success");
    }

    return callback("Invalid OTP");
}

module.exports = {
    sendOTP,
    verifyOTP
}