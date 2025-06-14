import { PlantProps } from '@/types/plant';
import { useState } from 'react';
import { Button } from '../ui/button';

function Plant({ plant, handleDelete, handleUpdate }: PlantProps) {
    const [showUpdate, setShowUpdate] = useState(false);
    const [showDelete, setShowDelete] = useState(false);
    console.log(plant);
    return (
        <div className="rounded border border-gray-200 bg-white p-4 shadow dark:border-gray-700 dark:bg-gray-900">
            <h2 className="pb-2 text-lg font-semibold text-gray-900 dark:text-white">{plant.name}</h2>
            <div className="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <div>
                    <p className="text-sm text-gray-700 dark:text-gray-300">
                        <strong>Type:</strong>{' '}
                        {plant.plant_type_id == null
                            ? plant.plant.plant_type.type
                            : 'Custom ' + (plant.plant_type.type.split(',')[1] ?? plant.plant_type.type)}
                    </p>
                    <p className="text-sm text-gray-700 dark:text-gray-300">
                        <strong>Max moist:</strong>{' '}
                        {plant.plant_type_id == null ? plant.plant.plant_type.max_soil_moisture : plant.plant_type.max_soil_moisture}
                        {'% '}
                        <br></br>
                        <strong>Min moist:</strong>{' '}
                        {plant.plant_type_id == null ? plant.plant.plant_type.min_soil_moisture : plant.plant_type.min_soil_moisture}%
                    </p>
                    {plant.latest_history !== null ? (
                        <p className="text-sm text-gray-700 dark:text-gray-300">
                            <strong>Recent moist:</strong> {plant.latest_history?.moisture_level}%
                        </p>
                    ) : null}
                </div>
                <div>
                    <p className="text-sm text-gray-700 dark:text-gray-300">
                        many more
                    </p>
                    <p className="text-sm text-gray-700 dark:text-gray-300">
                        image for eg
                    </p>
                </div>
                <div className="flex flex-col items-end justify-between">
                    <div className="flex flex-col space-y-2">
                        <Button onClick={() => setShowUpdate(true)} className="bg-blue-600 text-white hover:bg-blue-700">
                            Update
                        </Button>
                        <Button onClick={() => setShowDelete(true)} className="bg-red-600 text-white hover:bg-red-700">
                            Delete
                        </Button>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default Plant;
