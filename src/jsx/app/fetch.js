'use strict';

import { requestGET } from './ajax.js';

function makeRequest(urlBuilder) {
    return function() {
        let args = Array.from(arguments);

        let self = args.shift();
        let url = urlBuilder(args);

        requestGET(url, res => {
            let data = JSON.parse(res.responseText);
            if (data.error) {
                console.error("Fetching board error: " + data.msg);
                return;
            }

            self.refresh(data.res);
        });
    }
}

export const fetchBoard = makeRequest((boardId) =>
                            `/api/get/${boardId}`);
//                            `/api/get_board.php?boardId=${boardId}`);

export const fetchList = makeRequest((boardId, listId) =>
                           `/api/get/${boardId}/${listId}`);
//                           `/api/get_list.php?boardId=${boardId}&&listId=${listId}`);

export const fetchItem = makeRequest((boardId, listId, itemId) =>
                           `/api/get/${boardId}/${listId}/${itemId}`);
//                           `/api/get_item.php?boardId=${boardId}&&listId=${listId}&&itemId=${itemId}`);
