'use strict';

import { fetchBoard, fetchList, fetchItem } from '../app/fetch.js';

const e = React.createElement;

export class Taskboard extends React.Component {
    constructor(props) {
        super(props);
        fetchBoard(this, props.board_id);
    }

    render() {
        return e('div', { className: 'taskboard' }, this.lists);
    }
}

export class Tasklist extends React.Component {
    constructor(props) {
        super(props);
        fetchList(this, props.board_id, props.list_id);
    }

    render() {
        return e('div', { className: 'tasklist' }, this.items);
    }
}

export class Taskitem extends React.Component {
    constructor(props) {
        super(props);
        fetchItem(this, props.board_id, props.list_id, props.item_id);
    }

    render() {
        return e('div', { className: 'taskitem' }, this.content);
    }
}
