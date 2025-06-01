import axiosClient from '@/utils/axiosClient';
import { Dialog, DialogPanel, DialogTitle } from '@headlessui/react';
import { CheckCircle, X, XCircle } from 'lucide-react';
import { useState } from 'react';
import { Input } from '../ui/input';
import ToastMessage from '../ui/ToastMessage';

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
    const [isUpdateOpen, setIsUpdateOpen] = useState(false);
    const [isDeleteOpen, setIsDeleteOpen] = useState(false);
    const [successMessage, setSuccessMessage] = useState('');
    const [form, setForm] = useState({
        id: device.id,
        name: device.name,
        location: device.location,
        city: device.city,
        is_on: device.is_on,
        is_inside: device.is_inside,
    });
    const resetForm = () => {
        setForm({
            id: device.id,
            name: device.name,
            location: device.location,
            city: device.city,
            is_on: device.is_on,
            is_inside: device.is_inside,
        });
    };

    const renderStatusIcon = (status: boolean) =>
        status ? (
            <CheckCircle className="inline h-5 w-5 text-green-600 dark:text-green-400" />
        ) : (
            <XCircle className="inline h-5 w-5 text-red-600 dark:text-red-400" />
        );

    const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const { name, value, type, checked } = e.target;
        setForm((prev) => ({
            ...prev,
            [name]: type === 'checkbox' ? checked : value,
        }));
    };

    const submit = () => {
        axiosClient
            .put('/api/device/update', form)
            .then((res) => {
                setSuccessMessage('Device updated successfully!');
                resetForm();
                handleUpdate(device.id);
                setTimeout(() => setSuccessMessage(''), 5000);
            })
            .catch((err) => console.error(err));
    };

    const deleteDevice = () => {
        axiosClient
            .delete(`/api/device/destroy/`, {
                data: { id: device.id },
            })
            .then((res) => {
                setSuccessMessage('Device deleted successfully!');
                handleDelete(device.id);
                setTimeout(() => setSuccessMessage(''), 5000);
            })
            .catch((err) => console.error(err));
    };

    return (
        <>
            <ToastMessage message={successMessage} type={'success'} />
            <div className="grid grid-cols-1 gap-4 rounded border border-gray-200 bg-white p-4 shadow sm:grid-cols-2 lg:grid-cols-3 dark:border-gray-700 dark:bg-gray-900">
                <Dialog
                    open={isUpdateOpen}
                    onClose={() => {
                        setIsUpdateOpen(false);
                        resetForm();
                    }}
                    className="relative z-50"
                >
                    <div className="fixed inset-0 bg-black/40" aria-hidden="true" />

                    <div className="fixed inset-0 flex items-center justify-center p-4">
                        <DialogPanel className="w-full max-w-xl rounded bg-white p-6 shadow-xl dark:bg-gray-800">
                            <div className="mb-4 flex items-center justify-between">
                                <DialogTitle className="w-full text-center text-2xl font-semibold">Update {device.name}</DialogTitle>
                                <button
                                    onClick={() => {
                                        setIsUpdateOpen(false);
                                        resetForm();
                                    }}
                                    className="text-gray-500 hover:text-gray-700"
                                >
                                    <X className="h-5 w-5" />
                                </button>
                            </div>
                            <form
                                className="items-center space-y-4"
                                onSubmit={(e) => {
                                    e.preventDefault();
                                    submit();
                                    resetForm();
                                    setIsUpdateOpen(false);
                                }}
                            >
                                {[
                                    { id: 'name', label: 'Device Name*', required: true },
                                    { id: 'location', label: 'Location' },
                                    { id: 'city', label: 'City' },
                                ].map(({ id, label, required }) => (
                                    <div key={id} className="flex justify-center">
                                        <Input
                                            className="w-full max-w-md rounded bg-gray-100 p-2 px-4 dark:bg-gray-700"
                                            type="text"
                                            id={id}
                                            name={id}
                                            required={required}
                                            value={form[id as keyof typeof form] as string}
                                            onChange={handleChange}
                                            placeholder={`Enter ${label.toLowerCase()}`}
                                            label={label}
                                        />
                                    </div>
                                ))}

                                <div className="flex items-center justify-center gap-4">
                                    <label className="flex items-center space-x-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                        <input type="checkbox" name="is_on" checked={form.is_on} onChange={handleChange} className="h-4 w-4" />
                                        <span>Is On</span>
                                    </label>
                                    <label className="flex items-center space-x-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                        <input
                                            type="checkbox"
                                            name="is_inside"
                                            checked={form.is_inside}
                                            onChange={handleChange}
                                            className="h-4 w-4"
                                        />
                                        <span>Is Inside</span>
                                    </label>
                                </div>
                                <div className="flex justify-center pt-4">
                                    <button type="submit" className="rounded bg-blue-600 px-3 py-1 text-sm text-white hover:bg-blue-700">
                                        Update
                                    </button>
                                </div>
                            </form>
                        </DialogPanel>
                    </div>
                </Dialog>

                <Dialog open={isDeleteOpen} onClose={() => setIsDeleteOpen(false)} className="relative z-50">
                    <div className="fixed inset-0 bg-black/40" aria-hidden="true" />

                    <div className="fixed inset-0 flex items-center justify-center p-4">
                        <DialogPanel className="w-full max-w-xl rounded bg-white p-6 shadow-xl dark:bg-gray-800">
                            <div className="mb-4 flex items-center justify-between">
                                <DialogTitle className="w-full text-center text-2xl font-semibold">Delete {device.name}</DialogTitle>
                                <button onClick={() => setIsDeleteOpen(false)} className="text-gray-500 hover:text-gray-700">
                                    <X className="h-5 w-5" />
                                </button>
                            </div>
                            <div className="w-full text-center">Are you sure about delete {device.name}?</div>
                            <div className="flex justify-center pt-4">
                                <button onClick={() => deleteDevice()} className="rounded bg-red-600 px-3 py-1 text-sm text-white hover:bg-red-700">
                                    Delete
                                </button>
                            </div>
                        </DialogPanel>
                    </div>
                </Dialog>
                <div>
                    <h2 className="text-lg font-semibold text-gray-900 dark:text-white">{device.name}</h2>
                    <p className="text-sm text-gray-700 dark:text-gray-300">
                        <strong>Location:</strong> {device.location}
                    </p>
                    <p className="text-sm text-gray-700 dark:text-gray-300">
                        <strong>City:</strong> {device.city}
                    </p>
                    <p className="flex items-center gap-1 text-sm text-gray-700 dark:text-gray-300">
                        <strong>Is Inside:</strong> {renderStatusIcon(device.is_inside)}
                    </p>
                    <p className="flex items-center gap-1 text-sm text-gray-700 dark:text-gray-300">
                        <strong>Is On:</strong> {renderStatusIcon(device.is_on)}
                    </p>
                </div>

                {/* Weather Info */}
                <div className="text-sm text-gray-700 dark:text-gray-300">
                    {weather ? (
                        <>
                            <p className="flex items-center gap-2">
                                <strong>Weather:</strong>
                                <img src={`https:${weather.condition.icon}`} alt={weather.condition.text} className="h-6 w-6" />
                                {weather.condition.text}
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

                {/* Actions & Meta */}
                <div className="flex flex-col items-end justify-between">
                    <div className="flex flex-col space-y-2">
                        <button onClick={() => setIsUpdateOpen(true)} className="rounded bg-blue-600 px-3 py-1 text-sm text-white hover:bg-blue-700">
                            Update
                        </button>
                        <button onClick={() => setIsDeleteOpen(true)} className="rounded bg-red-600 px-3 py-1 text-sm text-white hover:bg-red-700">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </>
    );
}
