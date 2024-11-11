/**
 * Custom implementation for the FingerPrint
 * Reader and other JS functions
 * @authors Dahir Muhammad Dahir (dahirmuhammad3@gmail.com)
 * @date    2020-04-14 17:06:41
 * @version 1.0.0
 */


let currentFormat = Fingerprint.SampleFormat.Intermediate;
var userID = 123;
var enrollReaderSelect = '';

var indexfinger = {
    "type": "SamplesAcquired",
    "deviceUid": "932FA2A9-B2C5-4D41-82B8-00EDC4B816F9",
    "sampleFormat": 2,
    "samples": "[{\"Data\":\"AOg5Acgp43NcwEE381mKK55cZ2YzXrW0kzA948-sKd_nSH1lvGek31JLtTzG4ioIUcHf8NbfRF7_y7qwzVR9zPcG7v19RVHSnULMXp8N4BpNR_i_FPx7a4N2QZ9w2e5JsG-ZnylMjP_qSLZ-cyUr8n9rKhm2OBDK1oU_gR2WKNfoZ6zq1kBRRp3iW576hPTbF4JFLyEEFbG5Bi-QTi1ICSE1PZFJkNncdV7tRP6d32pVQ6KA5BlTUWmSVsCpFiZsc36CffM3oxevOTHuvKdvc0owlhWzGd7ZCL9Jz_Lxzc8aXSsslPEsOtm8KboOkp1M5nyvub5yiQ8lui8NkQLI3QBQoPjS9yb0lxUXxQPfFZsNGmDi8tvHTFu0slpPgAhlBvkvPgcETl7iYZmaHR1HEGbHJcZpDfQ4NZppKI1v\",\"Header\":{\"Encryption\":0,\"Factor\":8,\"Format\":{\"FormatID\":0,\"FormatOwner\":51},\"Purpose\":0,\"Quality\":-1,\"Type\":2},\"Version\":1}]\n"
};
let FingerprintSdkTest = (function () {
    function FingerprintSdkTest() {
        let _instance = this;
        this.operationToRestart = null;
        this.acquisitionStarted = false;
        // instantiating the fingerprint sdk here
        this.sdk = new Fingerprint.WebApi;
        this.sdk.onDeviceConnected = function (e) {
            // Detects if the device is connected for which acquisition started
            showMessage("Scan Appropriate Finger on the Reader", "success");
        };
        this.sdk.onDeviceDisconnected = function (e) {
            // Detects if device gets disconnected - provides deviceUid of disconnected device
            showMessage("Device is Disconnected. Please Connect Back");
        };
        this.sdk.onCommunicationFailed = function (e) {
            // Detects if there is a failure in communicating with U.R.U web SDK
            showMessage("Communication Failed. Please Reconnect Device")
        };
        this.sdk.onSamplesAcquired = function (s) {

            // Sample acquired event triggers this function

            storeSample(s);
        };
        this.sdk.onQualityReported = function (e) {
            // Quality of sample acquired - Function triggered on every sample acquired
            //document.getElementById("qualityInputBox").value = Fingerprint.QualityCode[(e.quality)];
        }
    }
    function compareSamples(sampleA, sampleB) {
        // Compare sampleA and sampleB to determine if they match
        // Implement your comparison logic here
        // For example, you might compare certain properties or values

        // Example comparison (adjust based on your actual sample structure):
        return JSON.stringify(sampleA) === JSON.stringify(sampleB);
    }
    // this is were finger print capture takes place
    FingerprintSdkTest.prototype.startCapture = function () {
        if (this.acquisitionStarted) // Monitoring if already started capturing
            return;
        let _instance = this;
        showMessage("");
        this.operationToRestart = this.startCapture;
        this.sdk.startAcquisition(currentFormat, "").then(function () {
            _instance.acquisitionStarted = true;

            //Disabling start once started
            //disableEnableStartStop();

        }, function (error) {
            showMessage(error.message);
        });
    };

    FingerprintSdkTest.prototype.stopCapture = function () {
        if (!this.acquisitionStarted) //Monitor if already stopped capturing
            return;
        let _instance = this;
        showMessage("");
        this.sdk.stopAcquisition().then(function () {
            _instance.acquisitionStarted = false;

            //Disabling stop once stopped
            //disableEnableStartStop();

        }, function (error) {
            showMessage(error.message);
        });
    };

    FingerprintSdkTest.prototype.getInfo = function () {
        let _instance = this;
        return this.sdk.enumerateDevices();
    };

    FingerprintSdkTest.prototype.getDeviceInfoWithID = function (uid) {
        let _instance = this;
        return this.sdk.getDeviceInfo(uid);
    };

    return FingerprintSdkTest;
})();


class Reader {
    constructor() {
        this.reader = new FingerprintSdkTest();
        this.selectFieldID = null;
        this.currentStatusField = null;
        /**
         * @type {Hand}
         */
        this.currentHand = null;
    }

    readerSelectField(selectFieldID) {
        this.selectFieldID = selectFieldID;
    }

    setStatusField(statusFieldID) {
        this.currentStatusField = statusFieldID;
    }

    displayReader() {
        let readers = this.reader.getInfo();  // grab available readers here
        let id = this.selectFieldID;
        let selectField = document.getElementById(id);
        selectField.innerHTML = `<option>Select Fingerprint Reader</option>`;
        readers.then(function (availableReaders) {  // when promise is fulfilled
            if (availableReaders.length > 0) {
                showMessage("");
                for (let reader of availableReaders) {
                    selectField.innerHTML += `<option value="${reader}" selected>${reader}</option>`;
                }
            }
            else {
                showMessage("Please Connect the Fingerprint Reader");
            }
        })
    }
}

class Hand {
    constructor() {
        this.id = 0;
        this.index_finger = [];
        this.middle_finger = [];
    }

    addIndexFingerSample(sample) {
        this.index_finger.push(sample);
    }

    addMiddleFingerSample(sample) {
        this.middle_finger.push(sample);
    }

    generateFullHand() {
        let id = this.id;
        let index_finger = this.index_finger;
        let middle_finger = this.middle_finger;
        return JSON.stringify({ id, index_finger, middle_finger });
    }
}

let myReader = new Reader();

function beginEnrollment() {
    setReaderSelectField("enrollReaderSelect");
    myReader.setStatusField("enrollmentStatusField");

}

function beginIdentification() {
    setReaderSelectField("verifyReaderSelect");
    myReader.setStatusField("verifyIdentityStatusField");
}

function setReaderSelectField(fieldName) {
    myReader.readerSelectField(fieldName);
    myReader.displayReader();
}

function showMessage(message, message_type = "error") {
    console.log(message);
    // let types = new Map();
    // types.set("success", "my-text7 my-pri-color text-bold");
    // types.set("error", "text-danger");
    // let statusFieldID = myReader.currentStatusField;
    // if(statusFieldID){
    //     let statusField = document.getElementById(statusFieldID);
    //     statusField.innerHTML = `<p class="my-text7 my-pri-color my-3 ${types.get(message_type)} font-weight-bold">${message}</p>`;
    // }
}

function beginCapture() {
    if (!readyForEnroll()) {
        // console.log("asd");
        return;
    }
    myReader.currentHand = new Hand();
    storeUserID();  // for current user in Hand instance
    myReader.reader.startCapture();
    showNextNotEnrolledItem();
}

function captureForIdentify() {
    if (!readyForIdentify()) {
        return;
    }
    myReader.currentHand = new Hand();
    storeUserID();
    myReader.reader.startCapture();
    showNextNotEnrolledItem();
}

/**
 * @returns {boolean}
 */
function readyForEnroll() {
    return ((userID !== "") && (document.getElementById("enrollReaderSelect").value !== "Select Fingerprint Reader"));
}

/**
* @returns {boolean}
*/
function readyForIdentify() {
    return ((document.getElementById("userIDVerify").value !== "") && (document.getElementById("verifyReaderSelect").value !== "Select Fingerprint Reader"));
}

function clearCapture() {
    clearInputs();
    clearPrints();
    clearHand();
    myReader.reader.stopCapture();
    document.getElementById("userDetails").innerHTML = "";
}

function clearInputs() {
    document.getElementById("userID").value = "";
    document.getElementById("userIDVerify").value = "";
    //let id = myReader.selectFieldID;
    //let selectField = document.getElementById(id);
    //selectField.innerHTML = `<option>Select Fingerprint Reader</option>`;
}

function clearPrints() {
    let indexFingers = document.getElementById("indexFingers");
    let middleFingers = document.getElementById("middleFingers");
    let verifyFingers = document.getElementById("verificationFingers");

    if (indexFingers) {
        for (let indexfingerElement of indexFingers.children) {
            indexfingerElement.innerHTML = `<span class="icon icon-indexfinger-not-enrolled" title="not_enrolled"></span>`;
        }
    }

    if (middleFingers) {
        for (let middlefingerElement of middleFingers.children) {
            middlefingerElement.innerHTML = `<span class="icon icon-middlefinger-not-enrolled" title="not_enrolled"></span>`;
        }
    }

    if (verifyFingers) {
        for (let finger of verifyFingers.children) {
            finger.innerHTML = `<span class="icon icon-indexfinger-not-enrolled" title="not_enrolled"></span>`;
        }
    }
}

function clearHand() {
    myReader.currentHand = null;
}

function showSampleCaptured() {
    let nextElementID = getNextNotEnrolledID();
    let markup = null;
    if (nextElementID.startsWith("index") || nextElementID.startsWith("verification")) {
        markup = `<span class="icon icon-indexfinger-enrolled" title="enrolled"></span>`;
    }

    if (nextElementID.startsWith("middle")) {
        markup = `<span class="icon icon-middlefinger-enrolled" title="enrolled"></span>`;
    }

    if (nextElementID !== "" && markup) {
        let nextElement = document.getElementById(nextElementID);
        nextElement.innerHTML = markup;
    }
}

function showNextNotEnrolledItem() {
    let nextElementID = getNextNotEnrolledID();
    let markup = null;
    if (nextElementID.startsWith("index") || nextElementID.startsWith("verification")) {
        markup = `<span class="icon capture-indexfinger" title="not_enrolled"></span>`;
    }

    if (nextElementID.startsWith("middle")) {
        markup = `<span class="icon capture-middlefinger" title="not_enrolled"></span>`;
    }

    if (nextElementID !== "" && markup) {
        let nextElement = document.getElementById(nextElementID);
        nextElement.innerHTML = markup;
    }
}

/**
 * @returns {string}
 */
function getNextNotEnrolledID() {
    let indexFingers = document.getElementById("indexFingers");
    let middleFingers = document.getElementById("middleFingers");
    let verifyFingers = document.getElementById("verificationFingers");

    let enrollUserId = userID;
    // let verifyUserId = document.getElementById("userIDVerify").value;

    let indexFingerElement = findElementNotEnrolled(indexFingers);
    let middleFingerElement = findElementNotEnrolled(middleFingers);
    let verifyFingerElement = findElementNotEnrolled(verifyFingers);

    //assumption is that we will always start with
    //indexfinger and run down to middlefinger
    if (indexFingerElement !== null && enrollUserId !== "") {
        return indexFingerElement.id;
    }

    if (middleFingerElement !== null && enrollUserId !== "") {
        return middleFingerElement.id;
    }

    if (verifyFingerElement !== null && verifyUserId !== "") {
        return verifyFingerElement.id;
    }

    return "";
}

/**
 * 
 * @param {Element} element
 * @returns {Element}
 */
function findElementNotEnrolled(element) {
    if (element) {
        for (let fingerElement of element.children) {
            if (fingerElement.firstElementChild.title === "not_enrolled") {
                return fingerElement;
            }
        }
    }

    return null;
}

function storeUserID() {
    // let enrollUserId = userID;
    // let identifyUserId = document.getElementById("userIDVerify").value;
    // myReader.currentHand.id = enrollUserId !== "" ? enrollUserId : identifyUserId;
}
var fingerprint_verify = '';
var count = 0;
function clearPrint() {
    fingerprint_verify = '';
    count = 0;
}
var pleaseWait = false;
function storeSample(sample) {
    if (pleaseWait) {
        return;
    }
    let samples = JSON.parse(sample.samples);
    $.blockUI();
    pleaseWait = true;
    const title = "J.R Builders - Information Management System";
    $('title').html(title);
    $('#employee_error_modal').modal('hide');
    $('#employee_modal').modal('hide');
    const api = new APIRequest();
    let sampleData = samples[0].Data;
    let id = "1";
    var index_finger = [sampleData];
    var middle_finger = '';
    var data = (JSON.stringify({ id, index_finger, middle_finger }));
    let payload = `data=${data}`;

    setTimeout(() => {
        api.post('/src/core/verify.php', payload)
            .then(data => {
                $.unblockUI();
                pleaseWait = false;
                $('#employee_error_modal').modal('hide');
                if (data.status == 'success') {
                    api.post('/setAttendance', { id: data.id })
                        .then(dd => {
                            $('#attendance_date').html(dd.date);
                            $('#attendance_time').html(dd.time);
                            $('#timeStatus').html(dd.timeStatus);
                            $('#employee_photo').attr('src', `uploads/${data.photo}`);
                            $('#employee_position').html(data.position);
                            $('#employee_name').html(data.full_name);
                            $('#employee_id').html(data.id.toString().padStart(4, '0'));
                            $('title').html(`${data.full_name} Verified ${title}`);
                            $('#employee_modal').modal('show');
                        }).catch(err => {

                        });
                } else {
                    $('#employee_modal').modal('hide');
                    $('#employee_error_modal').modal('show');

                }

                console.log('GET data:', data);
            })
            .catch(error => {
                console.error('GET error:', error);
            });
    }, 300);
}

