'use strict';

const { Draggable } = ReactBeautifulDnd;

import { fetchItem } from '../app/fetch.js';
import { parseDateTime } from '../app/parseDateTime.js';

export class Taskitem extends React.Component {
    constructor(props) {
        super(props);

        this.refresh = this.refresh.bind(this);
        this.getId = this.getId.bind(this);

        this.state = {};
    }

    componentWillMount() {
        this.refresh(this.props.data);
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
            index: data.listIndex,
            createdOn: parseDateTime(data.createdOn),
            updatedOn: parseDateTime(data.updatedOn)
        });
    }

    getId() {
        return this.state.itemId;
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
                            Last edited {this.state.createdOn.toLocaleString()}<br />
                            Last updated {this.state.updatedOn ? this.state.updatedOn.toLocaleString() : "never"}<br />
                        </footer>
                    </div>
                )}
            </Draggable>
        );
    }
}
