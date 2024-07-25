import Echo from "@ably/laravel-echo";
import * as Ably from "ably";

(window as any).Ably = Ably;
(window as any).Echo = new Echo({
    broadcaster: "ably",
});

(window as any).Echo.connector.ably.connection.on((stateChange: { current: string }) => {
    if (stateChange.current === "connected") {
        console.log("connected to ably server");
    }
});

// import Echo from "laravel-echo";

// import Pusher from "pusher-js";
// (window as any).Pusher = Pusher;

// (window as any).Echo = new Echo({
//     broadcaster: "pusher",
//     key: import.meta.env.VITE_ABLY_PUBLIC_KEY,
//     wsHost: "realtime-pusher.ably.io",
//     wsPort: 443,
//     disableStats: true,
//     encrypted: true,
//     cluster: "us1",
// });

// Register a callback for listing to connection state change
// (window as any).Echo.connector.ably.connection.on((stateChange: { current: string }) => {
//     if (stateChange.current === "connected") {
//         console.log("connected to ably server!!");
//     }
// });
