
export interface TaxoConfirmationModalInterface {
    size?: 'sm' | 'md' | 'lg' | 'xl';
    title: string;
    subtitle?: string;
    message?: string;
    okButton?: string;
    cancelButton?: string;
    buttons?: ButtonsTypeInterface[];
    closeOnEscOption?: boolean;
    xcloseButtonOption?: boolean;
}


interface ButtonsTypeInterface {
    label: string;
    emit: string;
    type: 'primary' | 'secondary';
}
