'use strict';

const { DragDropContext } = ReactBeautifulDnd;

import { fetchBoard } from '../app/fetchBoard.js';
import { parseDateTime } from '../app/parseDateTime.js';

import { taskItemMoved } from '../app/taskItemMoved.js';

import { Tasklist } from './Tasklist.js';

export class Taskboard extends React.Component {
    constructor(props) {
        super(props);

        this.state = {};
        this.refresh(props.data);
    }

    refresh(data) {
        if (!data) {
            fetchBoard(this, this.state.boardId || this.props.boardId);
            return;
        }

        this.setState({
            boardId: data._id,
            boardName: data.boardName,
            createdOn: parseDateTime(data.createdOn),
            updatedOn: parseDateTime(data.updatedOn),
            lists: data.lists.map((list) =>
                <Tasklist
                    key={list._id}
                    data={list} />
            )
        });
    }

    findList(id) {
        return this.state.lists.find((list) => list.props.listId == id);
    }

    render() {
        return (
            <DragDropContext onDragEnd={(res) => taskItemMoved(this, res)}>
                <div className="taskboard">
                    <header>
                        <h2>{this.state.boardName}</h2>
                    </header>
                    {this.state.lists || []}
                </div>
            </DragDropContext>
        );
    }
}
