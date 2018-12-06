'use strict';

import { requestGET } from './ajax.js';

import { Taskitem } from '../ui/Taskitem.js';

export function fetchList(self, boardId, listId) {
    requestGET(`/api/get/${boardId}/${listId}`, (res) => {
        let data = JSON.parse(res.responseText);

        self.listName = data.listName;
        self.items = [];

        for (let itemId of data.items) {
            self.items.push(
              <Taskitem key={itemId}
                        boardId={boardId}
                        listId={listId}
                        itemId={itemId} />
            );           
        }

        self.createdOn = data.createdOn;
        self.updatedOn = data.updatedOn;
    });
}
