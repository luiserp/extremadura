
import { router } from "@inertiajs/vue3";

export const useNavigation = () => {
    const back = () => {
        router.get(route("back"));
    };
    return {
        back,
    };
}
