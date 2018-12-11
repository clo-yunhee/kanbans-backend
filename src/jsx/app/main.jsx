'use strict';

import { Taskboard } from '../ui/Taskboard.js';

import { fetchBoard } from './fetchBoard.js';

export function appMain() {

    /* Init and render the thing */

    let boardElt = document.querySelector('#taskboard-container');

    let id = "0eb90a1b-fd2a-11e8-955a-80a58966351c";

    let board = ( <Taskboard key={id} id={id} /> );

    ReactDOM.render(board, boardElt);

}
