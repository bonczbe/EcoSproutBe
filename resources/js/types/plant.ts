export interface FiltersState {
    plant: string;
    startDate: string | null;
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
