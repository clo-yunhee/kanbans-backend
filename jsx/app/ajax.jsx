'use strict';

// use json transactions

export function requestGET(url, callback) {
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4
                && this.status == 200) {
            callback(this);
        }
    }
    xhr.open("GET", url, true);
    xhr.send();
}

export function requestPOST(url, data) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-type", "application/json");
    xhr.send(JSON.stringify(data));
}
