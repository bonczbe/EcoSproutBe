type PlantType = {
  id: number;
  type: string;
  type_hu: string;
  min_soil_moisture: number;
  max_soil_moisture: number;
  created_at: string | null;
  updated_at: string | null;
};

type Plant = {
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

type PlantListItem = {
  id: number;
  name: string;
  device_id: number;
  dirt_type: string;
  minimum_moisture: number;
  maximum_moisture: number;
  pot_size: string;
  plant_id: number;
  plant_img: string | null;
  created_at: string;
  updated_at: string;
  plant: Plant;
  plant_type: PlantType;
};

type Props = {
  plants: PlantListItem[];
};

function PlantList({ plants }: Props) {
    return <div>PlantList</div>;
}

export default PlantList;
