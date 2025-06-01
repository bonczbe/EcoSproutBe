import axiosClient from '@/utils/axiosClient';
import { Dialog, DialogPanel, DialogTitle } from '@headlessui/react';
import { X } from 'lucide-react';
import { useState } from 'react';
import toast from 'react-hot-toast';
import { Button } from '../ui/button';
import { Input } from '../ui/input';

export default function UpdateDevice({ device, onClose, onUpdate }: { device: any; onClose: () => void; onUpdate: (id: number, data: any) => void }) {
    const [form, setForm] = useState({ ...device });

    const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const { name, value, type, checked } = e.target;
        setForm((prev: any) => ({
            ...prev,
            [name]: type === 'checkbox' ? checked : value,
        }));
    };

    const submit = () => {
        axiosClient.put('/api/device/update', form).then(() => {
            onUpdate(device.id, form);
            onClose();
            toast.success(device.name + ' updated');
        });
    };

    return (
        <Dialog open onClose={onClose} className="relative z-50">
            <div className="fixed inset-0 bg-black/40" aria-hidden="true" />
            <div className="fixed inset-0 flex items-center justify-center p-4">
                <DialogPanel className="w-full max-w-xl rounded bg-white p-6 shadow-xl dark:bg-gray-800">
                    <div className="mb-4 flex items-center justify-between">
                        <DialogTitle className="w-full text-center text-2xl font-semibold">Update {device.name}</DialogTitle>
                        <button onClick={onClose} className="text-gray-500 hover:text-gray-700">
                            <X className="h-5 w-5" />
                        </button>
                    </div>
                    <form
                        onSubmit={(e) => {
                            e.preventDefault();
                            submit();
                        }}
                        className="space-y-4"
                    >
                        {[
                            { id: 'name', label: 'Device Name', required: true },
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

                        <div className="flex justify-center pt-4">
                            <Button type="submit" className="bg-blue-600 text-white hover:bg-blue-700">
                                Update
                            </Button>
                        </div>
                    </form>
                </DialogPanel>
            </div>
        </Dialog>
    );
}
