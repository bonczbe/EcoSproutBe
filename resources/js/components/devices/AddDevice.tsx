import axiosClient from '@/utils/axiosClient';
import { Dialog, DialogPanel, DialogTitle } from '@headlessui/react';
import axios from 'axios';
import { X } from 'lucide-react';
import { useState } from 'react';
import { Input } from '../ui/input';
import ToastMessage from '../ui/ToastMessage';

export default function AddDevice({ onDeviceAdded }: { onDeviceAdded?: () => void }) {
    const [isOpen, setIsOpen] = useState(false);
    const [successMessage, setSuccessMessage] = useState('');
    const [form, setForm] = useState({
        name: '',
        location: '',
        city: '',
        is_on: false,
        is_inside: false,
    });
    const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const { name, value, type, checked } = e.target;
        setForm((prev) => ({
            ...prev,
            [name]: type === 'checkbox' ? checked : value,
        }));
    };
    const submit = async () => {
        let validCity = false;
        await axios
            .get(`https://nominatim.openstreetmap.org/search?city=${encodeURIComponent(form.city)}&format=json&limit=1&addressdetails=1`)
            .then((res) => {
                validCity = res.data[0]['address'][res.data[0].addresstype].toLowerCase() === form.city.toLowerCase();
            })
            .catch((err) => console.error(err));
        if (validCity) {
            axiosClient
                .post('/api/device/store', form)
                .then((res) => {
                    setSuccessMessage('Device added successfully!');
                    setForm({
                        name: '',
                        location: '',
                        city: '',
                        is_on: false,
                        is_inside: false,
                    });
                    onDeviceAdded?.();
                    setTimeout(() => setSuccessMessage(''), 5000);
                })
                .catch((err) => console.error(err));
        }
    };

    return (
        <>
            <ToastMessage message={successMessage} type={'success'} />
            <button onClick={() => setIsOpen(true)} className="w-fit rounded bg-green-700 px-4 py-2 text-white hover:bg-green-800">
                Add New Device
            </button>

            <Dialog open={isOpen} onClose={() => setIsOpen(false)} className="relative z-50">
                <div className="fixed inset-0 bg-black/40" aria-hidden="true" />

                <div className="fixed inset-0 flex items-center justify-center p-4">
                    <DialogPanel className="w-full max-w-xl rounded bg-white p-6 shadow-xl dark:bg-gray-800">
                        <div className="mb-4 flex items-center justify-between">
                            <DialogTitle className="w-full text-center text-2xl font-semibold">Add New Device</DialogTitle>
                            <button onClick={() => setIsOpen(false)} className="text-gray-500 hover:text-gray-700">
                                <X className="h-5 w-5" />
                            </button>
                        </div>

                        <form
                            onSubmit={(e) => {
                                e.preventDefault();
                                submit();
                                setIsOpen(false);
                            }}
                            className="items-center space-y-4"
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
                                    <input type="checkbox" name="is_inside" checked={form.is_inside} onChange={handleChange} className="h-4 w-4" />
                                    <span>Is Inside</span>
                                </label>
                            </div>

                            <div className="flex justify-center">
                                <button type="submit" className="rounded bg-green-700 px-4 py-2 text-white hover:bg-green-800">
                                    Register Device
                                </button>
                            </div>
                        </form>
                    </DialogPanel>
                </div>
            </Dialog>
        </>
    );
}
