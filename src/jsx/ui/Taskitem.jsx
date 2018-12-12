'use strict';

const { Draggable } = ReactBeautifulDnd;

import { fetchItem } from '../app/fetchItem.js';
import { parseDateTime } from '../app/parseDateTime.js';

export class Taskitem extends React.Component {
    constructor(props) {
        super(props);
      
        this.state = {};
        this.refresh(props.data);
    }

    refresh(data) {
        if (!data) {
            fetchItem(this, this.state.boardId || this.props.boardId,
                            this.state.listId || this.props.listId,
                            this.state.itemId || this.props.itemId);
            return;
        }

        this.setState({
            itemId: data._id,
            listId: data.listId,
            boardId: data.boardId,
            content: data.content,
            index: data.index,
            createdOn: parseDateTime(data.createdOn),
            updatedOn: parseDateTime(data.updatedOn)
        });
    }

    render() {
        return (
            <Draggable
                key={this.state.itemId}
                draggableId={this.state.itemId.toString()}
                index={this.state.index}
            >
                {(provided, snapshot) => (
                    <div
                        ref={provided.innerRef}
                        className="taskitem"
                        {...provided.draggableProps}
                        {...provided.dragHandleProps}
                    >
                        <p>
                            {this.state.content}
                        </p>
                        <footer>
                            Last edited {this.state.createdOn}<br />
                            Last updated {this.state.updatedOn || "never"}<br />
                        </footer>
                    </div>
                )}
            </Draggable>
        );
    }
}
