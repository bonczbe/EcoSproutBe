import { PlantListProps } from '@/types/plant';
import Plant from './Plant';

function PlantList({ plants, reloadPage, devices, plantFamilies }: PlantListProps) {
    const handleUpdate = (plantId: number) => {
        console.log('Update plant:', plantId);
        reloadPage();
    };

    const handleDelete = (plantId: number) => {
        console.log('Delete plant:', plantId);
        reloadPage();
    };

    return (
        <div className="grid gap-4 pt-4">
            {plants.map((plant) => (
                <Plant
                    key={plant.id}
                    plant={plant}
                    handleDelete={handleDelete}
                    handleUpdate={handleUpdate}
                    devices={devices}
                    plantFamilies={plantFamilies}
                />
            ))}
        </div>
    );
}

export default PlantList;
