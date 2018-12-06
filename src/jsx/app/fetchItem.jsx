'use strict';

import { requestGET } from './ajax.js';

export function fetchItem(self, boardId, listId, itemId) {
    requestGET(`/api/get/${boardId}/${listId}/${itemId}`, (res) => {
        let data = JSON.parse(res.responseText);

        self.content = data.content;

        self.createdOn = data.createdOn;
        self.updatedOn = data.updatedOn;
    });
}
