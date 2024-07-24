import Echo from "laravel-echo";

import Pusher from "pusher-js";
(window as any).Pusher = Pusher;

(window as any).Echo = new Echo({
    broadcaster: "pusher",
    key: import.meta.env.VITE_ABLY_PUBLIC_KEY,
    wsHost: "realtime-pusher.ably.io",
    wsPort: 443,
    disableStats: true,
    encrypted: true,
    cluster: "us1",
});
