'use strict';

function reorder(list, startIndex, endIndex) {
    const result = Array.from(list.items);
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

export function taskItemMoved(self, result) {
    const { source, destination } = result;

    // dropped outside the list
    if (!destination) {
        return;
    }

    if (source.droppableId === destination.droppableId) {
        const items = reorder(
            self.findList(source.droppableId),
            source.index,
            destination.index
        );

        let state = { items };

//        if (source.droppableId === 'droppable2') {
 //           state = { selected: items };
  //      }

        self.setState(state);
    } else {
        const result = move(
            self.findList(source.droppableId),
            self.findList(destination.droppableId),
            source,
            destination
        );

        self.setState({
            items: result.droppable,
            selected: result.droppable2
        });
    }

    self.forceUpdate();
}
