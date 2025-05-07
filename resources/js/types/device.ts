export interface FiltersState {
    device: number;
    startDate: string;
    endDate: string;
}

export interface FiltersOptions {
    devices: string[];
    startDate: string | null;
}

export interface weatherOption {
    label: string;
    value: string;
}
