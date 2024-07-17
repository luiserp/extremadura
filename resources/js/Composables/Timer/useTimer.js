import { computed, ref } from "vue";

export default function useResumableTimer(callback, delay, ...args) {
    const timer = new Timer(callback, delay, args);
    timer.start();

    const progress = computed(() => {
        return timer.progress;
    });

    return {
        start: timer.start.bind(timer),
        pause: timer.pause.bind(timer),
        resume: timer.resume.bind(timer),
        progress,
    }
}

class Timer {
    constructor(callback, delay, args) {
        this.cb = callback;
        this.delay = delay;
        this.elapsed = 0;
        this.remaining = this.delay - self.elapsed;
        this.args = args;
        this.progress = ref(0);
    }

    start() {
        let self = this;
        if (self.elapsed < self.delay) {
            clearInterval(self.interval);
            self.interval = setInterval(function () {
                self.elapsed += 50;
                self.remaining = self.delay - self.elapsed;
                let progressVal = parseFloat(self.elapsed / self.delay * 100).toFixed(8);
                self.progress.value = Math.min(progressVal, 100);

                if (self.elapsed >= self.delay) {
                    clearInterval(self.interval);
                    self.cb();
                }
            }, 50);
        }

    }

    pause() {
        let self = this;
        clearInterval(self.interval);
    }

    resume() {
        let self = this;
        clearInterval(self.interval);
        self.start();
    }
}
