'use strict';

import { Taskboard } from '../ui/Taskboard.js';

import { fetchBoard } from './fetch.js';

export function appMain() {

    /* Init and render the thing */

    let boardElt = document.querySelector('#taskboard-container');

    let id = "26d301d2-ff22-11e8-ac5d-42010a84008d";

    let board = ( <Taskboard key={id} boardId={id} /> );

    ReactDOM.render(board, boardElt);

}
