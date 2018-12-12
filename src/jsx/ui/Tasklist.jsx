'use strict';

const { Droppable } = ReactBeautifulDnd;

import { fetchList } from '../app/fetch.js';
import { parseDateTime } from '../app/parseDateTime.js';

import { Taskitem } from './Taskitem.js';

export class Tasklist extends React.Component {
    constructor(props) {
        super(props);

        this.state = {};
        this.refresh(props.data);
    }

    refresh(data) {
        if (!data) {
            fetchlist(this, this.state.boardId || this.props.boardId,
                            this.state.listId || this.props.listId);
            return;
        }

        this.setState({
            listId: data._id,
            boardId: data.boardId,
            listName: data.listName,
            createdOn: parseDateTime(data.createdOn),
            updatedOn: parseDateTime(data.updatedOn),
            items: data.items.map((item) =>
                <Taskitem
                    key={item._id}
                    data={item} />
            )
        });
    }

    findItem(id) {
        return this.items.find((item) => item.props.itemId == id);
    }

    render() {
        return (
            <Droppable droppableId={this.state.listId.toString()}>
                {(provided, snapshot) => (
                    <div
                        ref={provided.innerRef}
                        className="tasklist"
                        {...provided.droppableProps}
                    >
                        <header>
                           <h4>{this.state.listName}</h4>
                        </header>
                        {this.state.items || []}
                    </div>
                )}
            </Droppable>
        );
    }
}
