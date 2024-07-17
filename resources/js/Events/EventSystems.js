import { reactive } from "vue";
import {v4 as uuidv4} from 'uuid';

class Events {

    constructor() {
        this.events = {};
    }

    on(event, callback) {
        // calculate key for the event
        const key = uuidv4();

        if (!this.events[event]) {
            this.events[event] = [];
        }

        this.events[event].push({
            key,
            callback
        });
        return key;
    }

    emit(event, data = null) {
        if (this.events[event]) {
            this.events[event].forEach(({key, callback}) => {
                callback(data);
            });
        }
    }

    off(event, key) {
        if (this.events[event]) {
            this.events[event] = this.events[event].filter(event => {
                return event.key !== key;
            });
        }
    }
}

export default reactive({
    events: new Events(),
    on(event, callback) {
        return this.events.on(event, callback);
    },
    emit(event, data = null) {
        this.events.emit(event, data);
    },
    off(event, key) {
        this.events.off(event, key);
    }
})
