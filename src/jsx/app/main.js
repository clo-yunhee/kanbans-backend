'use strict';

import { Taskboard } from '../ui/Taskboard.js';

import { fetchBoard } from './fetch.js';

export function appMain() {

    /* Init and render the thing */

    let boardElt = document.querySelector('#taskboard-container');

    let id = "0eb90a1b-fd2a-11e8-955a-80a58966351c";
//    let id = "0e5a733e-fcb9-11e8-8ee0-d7211f38bafb";

    let board = ( <Taskboard key={id} boardId={id} /> );

    ReactDOM.render(board, boardElt);

}
