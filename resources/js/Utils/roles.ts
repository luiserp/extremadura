import { usePage } from "@inertiajs/vue3"

export const can = (permission: string): boolean => {

    const page = usePage();
    const user = page.props.auth.user;

    if (!user) {
        return false;
    }

    for (let role of user.roles) {
        for (let perm of role.permissions) {
            if (perm.name === permission) {
                return true;
            }
        }
    }

    return false;
}

export const hasRole = (role: string): boolean => {

    const page = usePage();
    const user = page.props.auth.user;

    if (!user) {
        return false;
    }

    for (let r of user.roles) {
        if (r.name === role) {
            return true;
        }
    }

    return false;
}
