'use strict';

import { requestGET } from './ajax.js'

export function fetchBoard(self, boardId) {
    requestGET(`/api/get/${boardId}`, (res) => {
        let data = JSON.parse(res.responseText);
        if (data.error) {
            console.error("Fetching board error: " + data.msg);
            return;
        }
        
        self.refresh(data.res);
    });
}
