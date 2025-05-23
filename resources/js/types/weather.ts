export interface FiltersState {
    city: string;
    startDate: string;
    endDate: string;
}

export interface FiltersOptions {
    plants: string[];
    startDate: string | null;
}

export interface weatherOption {
    label: string;
    value: string;
}
