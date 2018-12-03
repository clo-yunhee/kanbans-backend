'use strict';

import { Taskboard } from '../ui/taskBoard.js';

/* Init and render the thing */

let boardElt = document.querySelector('#taskboard-container');

ReactDOM.render(<Taskboard board_id="1"></Taskboard>, boardElt);
