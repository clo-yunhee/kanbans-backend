'use strict';

const { DragDropContext } = ReactBeautifulDnd;

import { fetchBoard } from '../app/fetch.js';
import { parseDateTime } from '../app/parseDateTime.js';

import { taskItemMoved } from '../app/taskItemMoved.js';

import { Tasklist } from './Tasklist.js';

export class Taskboard extends React.Component {
    constructor(props) {
        super(props);

        this.refresh = this.refresh.bind(this);
        this.findListIndex = this.findListIndex.bind(this);
        this.reorder = this.reorder.bind(this);
        this.getId = this.getId.bind(this);
        this.taskItemMoved = taskItemMoved.bind(this);

        this.state = {};
    }

    componentWillMount() {
        this.refresh(this.props.data);
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
            lists: [],
        });

        let domLists = [];

        for (const list of data.lists) {
            const domList = (
                <Tasklist
                    key={list._id}
                    data={list}
                    ref={it => {
                        this.state.lists.push(it);
                        this.setState({
                            ...this.state,
                            lists: this.state.lists
                        });
                    }}
                />
            );

            domLists.push(domList);
        }

        this.setState({
            ...this.state,
            domLists: domLists
        });
    }

    findListIndex(id) {
        return this.state.lists.findIndex(list =>
            list.state.listId == id);
    }

    reorder(startIndex, endIndex) {
        let lists = Array.from(this.state.lists);
        let doms = Array.from(this.state.domLists);

        const [remList] = lists.splice(firstIndex, 1);
        const [remDom] = doms.splice(firstIndex, 1);

        lists.splice(endIndex, 0, remList);
        doms.splice(endIndex, 0, remDom);

        this.setState({
            ...this.state,
            lists: lists,
            domLists: doms
        });
    }

    getId() {
        return this.state.boardId;
    }

    render() {
        return (
            <DragDropContext onDragEnd={this.taskItemMoved}>
                <div className="taskboard">
                    <header>
                        <h2>{this.state.boardName}</h2>
                    </header>
                    {/*{(this.state.lists || []).map(list => (
                        <Taskboard
                            key={list._id}
                            data={list} />
                    */}
                    {this.state.domLists}
                </div>
            </DragDropContext>
        );
    }
}
