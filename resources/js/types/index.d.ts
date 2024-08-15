export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string;
    roles: Role[];
}
export interface Role {
    id: number;
    name: string;
    permissions: Permission[];
}

export interface Permission {
    id: number;
    name: string;
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
};
