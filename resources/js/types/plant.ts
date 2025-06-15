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

export type PlantType = {
    id: number;
    type: string;
    type_hu: string;
    min_soil_moisture: number;
    max_soil_moisture: number;
    created_at: string | null;
    updated_at: string | null;
};

export type Plant = {
    id: number;
    name_botanical: string;
    name_en: string;
    name_hu: string;
    genus: string;
    family: string;
    family_hu: string;
    species_epithet: string;
    default_image: string | null;
    created_at: string;
    updated_at: string;
    plant_type_id: number;
    plant_type: PlantType;
};

export type PlantListItem = {
    id: number;
    name: string;
    device_id: number;
    dirt_type: string;
    minimum_moisture: number;
    maximum_moisture: number;
    pot_size: string;
    plant_id: number;
    pin_number: number;
    plant_img: string | null;
    created_at: string;
    updated_at: string;
    plant: Plant;
    plant_type: PlantType;
    plant_type_id: number | null;
    latest_history?: PlantHistory | null;
};

export type PlantHistory = {
    id: number;
    customer_plant_id: number;
    moisture_level: number;
    created_at: string;
    updated_at: string;
};

export type PlantListProps = {
    plants: PlantListItem[];
    reloadPage: () => void;
    devices: Device[];
    plantFamilies: any;
};
export interface Device {
    id: number;
    name: string;
    city: string;
    location: string;
    is_inside: boolean;
    is_on: boolean;
    created_at: string;
    updated_at: string;
}

export type PlantProps = {
    plant: PlantListItem;
    handleDelete: (id: number) => void;
    handleUpdate: (id: number) => void;
    devices: Device[];
    plantFamilies: any;
};

export type UpdatePlantProps = {
    plant: PlantListItem;
    onClose: () => void;
    onUpdate: (id: number, form: PlantListItem) => void;
    devices: any;
    plantFamilies: any;
};
