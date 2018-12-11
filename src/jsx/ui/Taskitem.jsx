'use strict';

import { fetchItem } from '../app/fetchItem.js';
import { parseDateTime } from '../app/parseDateTime.js';

export class Taskitem extends React.Component {
    constructor(props) {
        super(props);

        if (props.data) {
            this.refresh(props.data);
        } else if (props.itemId && props.listId && props.boardId) {
            fetchItem(this, props.itemId, props.listId, props.boardId);
        }
    }

    refresh(data) {
        this.itemId = data._id;
        this.content = data.content;
        this.createdOn = parseDateTime(data.createdOn);
        this.updatedOn = parseDateTime(data.updatedOn);
    }

    render() {
        return (
            <div className="taskitem">
              <p>
                {this.content}
              </p>
              <footer>
                Last edited {this.createdOn}<br />
                Last updated {this.updatedOn || "never"}<br />
              </footer>
            </div>
        );
    }
}
