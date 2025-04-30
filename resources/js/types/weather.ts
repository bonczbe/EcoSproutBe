export interface FiltersState {
    city: string;
    startDate: string;
    endDate: string;
}

export interface FiltersOptions {
    cities: string[];
    startDate: string | null;
}

export interface ColourOption {
    label: string;
    value: string;
}
