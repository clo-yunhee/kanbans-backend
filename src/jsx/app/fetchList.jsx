'use strict';

import { requestGET } from './ajax.js';

export function fetchList(list, boardId, listId) {
    requestGET(`/api/get/${boardId}/${listId}`, (res) => {
        let data = JSON.parse(res.responseText);
        if (data.error) {
            console.error("Fetching list error: " + data.msg);
            return;
        }

        self.refresh(data.res);
    });
}
