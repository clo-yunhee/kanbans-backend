'use strict';

import { Taskboard } from '../ui/Taskboard.js';

export function appMain() {

    /* Init and render the thing */

    let boardElt = document.querySelector('#taskboard-container');

    ReactDOM.render(<Taskboard boardId="1" />, boardElt);

}
