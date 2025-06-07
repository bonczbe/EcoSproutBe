import { CheckCircle, XCircle } from 'lucide-react';
import { useState } from 'react';
import { Button } from '../ui/button';
import DeleteDevice from './DeleteDevice';
import UpdateDevice from './UpdateDevice';

type DeviceType = {
    id: number;
    name: string;
    location: string;
    city: string;
    is_inside: boolean;
    is_on: boolean;
    created_at?: string;
    updated_at?: string;
};

type WeatherType = {
    city: string;
    average_celsius: string;
    rain_chance: number;
    date: string;
    max_celsius: string;
    min_celsius: string;
    condition: {
        icon: string;
        text: string;
    };
};

type DeviceProps = {
    device: DeviceType;
    weather?: WeatherType;
    handleDelete: (id: number) => void;
    handleUpdate: (id: number) => void;
};
export default function Device({ device, weather, handleDelete, handleUpdate }: DeviceProps) {
    const [showUpdate, setShowUpdate] = useState(false);
    const [showDelete, setShowDelete] = useState(false);

    const renderStatusIcon = (status: boolean) =>
        status ? (
            <CheckCircle className="inline h-5 w-5 text-green-600 dark:text-green-400" />
        ) : (
            <XCircle className="inline h-5 w-5 text-red-600 dark:text-red-400" />
        );

    return (
        <>
            <div className="grid grid-cols-1 gap-4 rounded border border-gray-200 bg-white p-4 shadow sm:grid-cols-2 lg:grid-cols-3 dark:border-gray-700 dark:bg-gray-900">
                {showUpdate && (
                    <UpdateDevice
                        device={device}
                        onClose={() => setShowUpdate(false)}
                        onUpdate={(id, data) => {
                            handleUpdate(id);
                        }}
                    />
                )}
                {showDelete && <DeleteDevice device={device} onClose={() => setShowDelete(false)} onDelete={(id) => handleDelete(id)} />}
                <div>
                    <h2 className="text-lg font-semibold text-gray-900 dark:text-white">{device.name}</h2>
                    <p className="text-sm text-gray-700 dark:text-gray-300">
                        <strong>Location:</strong> {device.location}
                    </p>
                    <p className="text-sm text-gray-700 dark:text-gray-300">
                        <strong>City:</strong>{' '}
                        <a
                            className="text-blue-800 underline dark:text-blue-200"
                            href={'https://www.google.com/search?q=weather+' + device.city}
                            target="blank"
                        >
                            {device.city}
                        </a>
                    </p>
                    <p className="flex items-center gap-1 text-sm text-gray-700 dark:text-gray-300">
                        <strong>Is Inside:</strong> {renderStatusIcon(device.is_inside)}
                    </p>
                    <p className="flex items-center gap-1 text-sm text-gray-700 dark:text-gray-300">
                        <strong>Is On:</strong> {renderStatusIcon(device.is_on)}
                    </p>
                </div>

                <div className="text-sm text-gray-700 dark:text-gray-300">
                    {weather ? (
                        <>
                            <p className="flex items-center gap-2">
                                <strong>Weather:</strong>
                                <img src={`https:${weather.condition.icon}`} alt={weather.condition.text} className="h-6 w-6" />
                                {weather.condition.text}
                            </p>
                            <p>
                                <strong>Max Temp:</strong> {weather.max_celsius}°C
                            </p>
                            <p>
                                <strong>Min Temp:</strong> {weather.min_celsius}°C
                            </p>
                            <p>
                                <strong>Avg Temp:</strong> {weather.average_celsius}°C
                            </p>
                            <p>
                                <strong>Rain Chance:</strong> {weather.rain_chance}%
                            </p>
                            <p className="text-xs text-gray-500 dark:text-gray-400">
                                <strong>Forecast Date:</strong> {weather.date}
                            </p>
                        </>
                    ) : (
                        <p className="text-gray-500 italic">No weather data</p>
                    )}
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
        </>
    );
}
