'use strict';

export function parseDateTime(obj) {
    if (obj === null) return null;

//    let date = new Date(obj.date);

    // todo: timezones

    return obj.date;
}
