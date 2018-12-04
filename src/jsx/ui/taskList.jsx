'use strict';

import { fetchList } from '../app/fetchList.js';

export class Tasklist extends React.Component {
    constructor(props) {
        super(props);
        fetchList(this, props.board_id, props.list_id);
    }

    render() {
        return (
            <div className="tasklist">
              {this.items}
            </div>
        );
    }
}
