export function capitalizeWords(words: string) {
    if (!words) {
        return "";
    }

    return words
        .toLowerCase()
        .split(" ")
        .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
        .join(" ");
}

export function truncateText(text: string, length: number) {
    if (!text) {
        return "";
    }
    const result = text.length > length ? `${text.slice(0, length)}...` : text;
    return result;
}

/**
 * Format a number to money format
 * @param {number} value
 * @returns
 */
let formatter: Intl.NumberFormat;
export const moneyFormat = (value: number) => {
    if (value === null || value === undefined) {
        return null;
    }

    if (!formatter) {
        formatter = new Intl.NumberFormat("en-US", {
            style: "currency",
            currency: "USD",
        });
    }
    return formatter.format(value);
};

/**
 * Format a number to percent format
 * @param {number} value
 * @returns
 */
export const percentFormat = (value: number) => {
    if (value === null || value === undefined) {
        return null;
    }

    const formatter = new Intl.NumberFormat("en-US", {
        style: "percent",
        minimumFractionDigits: 2,
    });
    return formatter.format(value);
};
