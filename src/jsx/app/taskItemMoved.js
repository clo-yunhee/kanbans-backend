'use strict';

function reorder(list, startIndex, endIndex) {
    const result = Array.from(list.state.items);
    const [removed] = result.splice(startIndex, 1);
    result.splice(endIndex, 0, removed);

    return result;
};

function move(source, destination, droppableSource, droppableDestination) {
    const sourceClone = Array.from(source);
    const destClone = Array.from(destination);
    const [removed] = sourceClone.splice(droppableSource.index, 1);

    destClone.splice(droppableDestination.index, 0, removed);

    const result = {};
    result[droppableSource.droppableId] = sourceClone;
    result[droppableDestination.droppableId] = destClone;

    return result;
};

export function taskItemMoved(result) {
    const { source, destination } = result;

    console.log(source);
    console.log(destination);

    // dropped outside the list
    if (!destination) {
        return;
    }

    if (source.droppableId === destination.droppableId) {
        const listInd = this.findListIndex(source.droppableId);

        console.log(listInd);

        const list = this.state.lists[listInd];

        this.state.lists[listInd] = reorder.bind(list)(
            list,
            source.index,
            destination.index
        );
    } else {
        const result = move(
            this.findList(source.droppableId),
            this.findList(destination.droppableId),
            source,
            destination
        );

        this.setState({
            items: result.droppable,
            selected: result.droppable2
        });
    }
}
