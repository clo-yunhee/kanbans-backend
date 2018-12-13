'use strict';

const { Droppable } = ReactBeautifulDnd;

import { fetchList } from '../app/fetch.js';
import { parseDateTime } from '../app/parseDateTime.js';

import { Taskitem } from './Taskitem.js';

export class Tasklist extends React.Component {
    constructor(props) {
        super(props);

        this.refresh = this.refresh.bind(this);
        this.findIndexIndex = this.findItemIndex.bind(this);
        this.getId = this.getId.bind(this);

        this.state = {};
    }

    componentWillMount() {
        this.refresh(this.props.data);
    }

    refresh(data) {
        if (!data) {
            fetchList(this, this.state.boardId || this.props.boardId,
                            this.state.listId || this.props.listId);
            return;
        }

        this.setState({
            listId: data._id,
            boardId: data.boardId,
            listName: data.listName,
            createdOn: parseDateTime(data.createdOn),
            updatedOn: parseDateTime(data.updatedOn),
            items: [],
        });

        let domItems = [];

        for (const item of data.items) {
            const domItem = (
                <Taskitem
                    key={item._id}
                    data={item}
                    ref={it => {
                        this.state.items[item.listIndex] = it;
                        this.setState({
                            ...this.state,
                            items: this.state.items
                        });
                    }}
                />
            );

            domItems[item.listIndex] = domItem;
        }

        this.setState({
            ...this.state,
            domItems: domItems
        })
    }

    findItemIndex(id) {
        return this.state.items.findIndex(item =>
            item.getId().toString() == id
        )
    }

    getId() {
        return this.state.listId;
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
                        {this.state.domItems || []}
                    </div>
                )}
            </Droppable>
        );
    }
}
