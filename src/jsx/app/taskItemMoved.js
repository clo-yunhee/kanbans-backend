'use strict';

/*function reorder(list, startIndex, endIndex) {
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
};*/

export function taskItemMoved(result) {
    const { source, destination } = result;

    // dropped outside the list
    if (!destination) {
        return;
    }

    const srcInd = this.findListIndex(source.droppableId);
    const src = this.state.lists[srcInd];
    const domSrc = this.state.domLists[srcInd];

    if (source.droppableId === destination.droppableId) {
        src.reorder([source.index, destination.index]);

        this.state.lists[srcInd] = src;
        this.state.domLists[srcInd] = src.render();

        this.setState({
            ...this.state,
            lists: this.state.lists,
            domLists: this.state.domLists
        });
    } else {
        const destInd = this.findListIndex(destination.droppableId);
        const dest = this.state.lists[destInd];
        const domDest = this.state.domLists[destInd];

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
