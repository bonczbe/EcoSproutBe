import { PlantProps } from '@/types/plant';
import { useState } from 'react';
import { Button } from '../ui/button';
import DeletePlant from './DeletePlant';
import UpdatePlant from './UpdatePlant';

const DIRT_TYPES = [
    'All-purpose potting mix|all_purpose',
    'Cactus and succulent mix|cactus_succulent',
    'Orchid mix|orchid',
    'Seed starting mix|seed_starting',
    'African violet mix|african_violet',
    'Indoor plant mix|indoor',
    'Moisture control potting mix|moisture_control',
    'Peat-based mix|peat_based',
    'Coco coir mix|coco_coir',
    'Compost-rich mix|compost_rich',
    'Bonsai soil mix|bonsai',
    'Aquatic plant soil|aquatic',
    'Perlite mix|perlite',
    'Vermiculite mix|vermiculite',
    'Sandy loam|sandy_loam',
].map((item) => {
    const [label, value] = item.split('|');
    return { label, value };
});

function Plant({ plant, handleDelete, handleUpdate, devices, plantFamilies }: PlantProps) {
    const [showUpdate, setShowUpdate] = useState(false);
    const [showDelete, setShowDelete] = useState(false);
    return (
        <div className="rounded border border-gray-200 bg-white p-4 shadow dark:border-gray-700 dark:bg-gray-900">
            <h2 className="pb-2 text-lg font-semibold text-gray-900 dark:text-white">{plant.name}</h2>
            <div className="grid grid-cols-1 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4">
                {showUpdate && (
                    <UpdatePlant
                        plant={plant}
                        onClose={() => setShowUpdate(false)}
                        onUpdate={(id) => {
                            handleUpdate(id);
                        }}
                        devices={devices}
                        plantFamilies={plantFamilies}
                    />
                )}
                {showDelete && <DeletePlant plant={plant} onClose={() => setShowDelete(false)} onDelete={(id) => handleDelete(id)} />}
                {plant.plant_img !== null && plant.plant_img.trim().length > 0 ? (
                    <div className="max-h-24 max-w-24 overflow-hidden rounded-2xl md:max-h-18 md:max-w-18 lg:max-h-40 lg:max-w-40">
                        <img src={plant.plant_img} className="h-full w-full" alt={plant.name} loading="lazy"></img>
                    </div>
                ) : null}
                <div className={plant.plant_img !== null && plant.plant_img.trim().length > 0 ? '' : 'col-span-2'}>
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
                        <strong>Dirt Type:</strong> {DIRT_TYPES.find((dirt) => dirt.value == plant.dirt_type)?.label}
                    </p>
                    <p className="text-sm text-gray-700 dark:text-gray-300">
                        <strong>Device:</strong> {devices.find((device) => device.id == plant.device_id)?.name}
                    </p>
                    <p className="text-sm text-gray-700 dark:text-gray-300">
                        <strong>Pin number:</strong> {plant.pin_number}
                    </p>
                </div>
                <div className="flex flex-col items-end justify-between">
                    <div className="flex flex-col space-y-2">
                        <Button onClick={() => setShowUpdate(!showUpdate)} className="bg-blue-600 text-white hover:bg-blue-700">
                            Update
                        </Button>
                        <Button onClick={() => setShowDelete(!showDelete)} className="bg-red-600 text-white hover:bg-red-700">
                            Delete
                        </Button>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default Plant;
