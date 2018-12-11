'use strict';

import { requestGET } from './ajax.js';

export function fetchItem(list, boardId, listId, itemId) {
    requestGET(`/api/get/${boardId}/${listId}/${itemId}`, (res) => {
        let data = JSON.parse(res.responseText);
        if (data.error) {
            console.error("Fetching list error: " + data.msg);
            return;
        }

        self.refresh(data.res);
    });
}
