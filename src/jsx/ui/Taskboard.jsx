'use strict';

const { DragDropContext } = ReactBeautifulDnd;

import { fetchBoard } from '../app/fetchBoard.js';
import { parseDateTime } from '../app/parseDateTime.js';

import { taskItemMoved } from '../app/taskItemMoved.js';

import { Tasklist } from './Tasklist.js';

export class Taskboard extends React.Component {
    constructor(props) {
        super(props);

        if (props.data) {
            this.refresh(props.data);
        } else if (props.id) {
            fetchBoard(this, props.id);
        }
    }

    refresh(data) {
        if (!data) {
            fetchBoard(this, this.boardId);
            return;
        }

        this.boardId = data._id;
        this.boardName = data.boardName;
        this.createdOn = parseDateTime(data.createdOn);
        this.updatedOn = parseDateTime(data.updatedOn);
        this.lists = [];

        for (const list of data.lists) {
            this.lists.push(
              <Tasklist
                key={list._id}
                data={list} />
            );
        }

        this.forceUpdate();
    }

    render() {
        return (
            <DragDropContext onDragEnd={taskItemMoved}>
              <div className="taskboard">
                <header>
                  <h2>{this.boardName}</h2>
                </header>
                {this.lists || []}
              </div>
            </DragDropContext>
        );
    }
}
