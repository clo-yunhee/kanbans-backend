'use strict';

import { Taskboard, Tasklist, Taskitem } from '../ui/taskComponents.js';

/* Init and render the thing */

const e = React.createElement;

let boardElt = document.querySelector('#taskboard-container');

ReactDOM.render(e(Taskboard, { board_id: 1 }), boardElt);
