export interface FiltersState {
    device: string;
    startDate: string;
    endDate: string;
}

export interface FiltersOptions {
    cities: string[];
    startDate: string | null;
}

export interface weatherOption {
    label: string;
    value: string;
}
