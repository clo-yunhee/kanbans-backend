'use strict';

import { fetchItem } from '../app/fetchItem.js';

export class Taskitem extends React.Component {
    constructor(props) {
        super(props);
        fetchItem(this, props.boardId, props.listId, props.itemId);
    }

    render() {
        return (
            <div className="taskitem">
              <p>
                {this.content}
              </p>
              <footer>
                Last edited {this.createdOn}
              </footer>
            </div>
        );
    }
}
