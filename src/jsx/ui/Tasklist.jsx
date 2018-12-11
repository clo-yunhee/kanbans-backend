'use strict';

const { Droppable } = ReactBeautifulDnd;

import { fetchList } from '../app/fetchList.js';
import { parseDateTime } from '../app/parseDateTime.js';

import { Taskitem } from './Taskitem.js';

export class Tasklist extends React.Component {
    constructor(props) {
        super(props);

        if (props.data) {
            this.refresh(props.data);
        } else if (props.listId && props.boardId) {
            fetchList(this, props.listId, props.boardId);
        }
    }

    refresh(data) {
        this.listId = data._id;
        this.listName = data.listName;
        this.createdOn = parseDateTime(data.createdOn);
        this.updatedOn = parseDateTime(data.updatedOn);
        this.items = [];

        for (let item of data.items) {
            this.items.push(
              <Taskitem
                key={item._id}
                data={item} />
            );
        }
    }

    render() {
        return (
            <Droppable droppableId={this.listId}>
                {(provided, snapshot) => (
                    <div ref={provided.innerRef}
                         className="tasklist"
                         {...provided.droppableProps}>
                        <header>
                           <h4>{this.listName}</h4>
                        </header>
                        {this.items || []}
                    </div>
                )}
            </Droppable>
        );
    }
}
