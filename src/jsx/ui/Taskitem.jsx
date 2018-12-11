'use strict';

const { Draggable } = ReactBeautifulDnd;

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
            <Draggable key={this.itemId}
                       draggableId={this.itemId}>
                {(provided, snapshot) => (
                    <div ref={provided.innerRef}
                         className="taskitem"
                         {...provided.draggableProps}
                         {...provided.dragHandleProps}>
                        <p>
                            {this.content}
                        </p>
                        <footer>
                            Last edited {this.createdOn}<br />
                            Last updated {this.updatedOn || "never"}<br />
                        </footer>
                    </div>
                )}
            </Draggable>
        );
    }
}
