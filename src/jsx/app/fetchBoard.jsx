'use strict';

import { requestGET } from './ajax.js'

import { Tasklist } from '../ui/Tasklist.js';

export function fetchBoard(self, boardId) {
    requestGET(`/api/get/${boardId}`, (res) => {
        let data = JSON.parse(res.responseText);

        self.boardName = data.boardName;
        self.lists = [];

        for (let listId of data.lists) {
            self.lists.push(
              <Tasklist key={listId}
                        boardId={boardId}
                        listId={listId} />
            );
        }

        self.createdOn = data.createdOn;
        self.updatedOn = data.updatedOn;
    });
}
