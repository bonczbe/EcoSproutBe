import axiosClient from '@/utils/axiosClient';
import { Dialog, DialogPanel, DialogTitle } from '@headlessui/react';
import { X } from 'lucide-react';
import { useEffect, useState } from 'react';
import toast from 'react-hot-toast';
import { Button } from '../ui/button';
import DropdownSelect from '../ui/DropdownSelect';
import CustomAutocomplete from './CustomAutoComplete';

function AddPlant({ onPlantAdded, devices, plantFamilies }: any) {
    const [isOpen, setIsOpen] = useState(false);
    const [plants, setPlants] = useState([]);
    const [family, setFamily] = useState('');
    const [selectedPlant, setSelectedPlants] = useState('');
    const [form, setForm] = useState({
        device: -1,
    });

    useEffect(() => {
        setSelectedPlants('');
        const fetchChartData = async () => {
            if (family != '') {
                await axiosClient
                    .post('/api/plant/index', {
                        family: family,
                    })
                    .then((res) => setPlants(res.data));
            }
        };
        fetchChartData();
    }, [family]);

    const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const { name, value, type, checked } = e.target;
        setForm((prev) => ({
            ...prev,
            [name]: type === 'checkbox' ? checked : value,
        }));
    };

    const submit = async () => {
        toast.success('Plant added successfully!');
    };

    const toOptionList = (items: any) => items.map((item: any) => ({ label: '(' + item.id + ') ' + item.city + ': ' + item.name, value: item.id }));

    return (
        <>
            <Button onClick={() => setIsOpen(true)} className="w-fit bg-green-700 text-white hover:bg-green-800">
                Add New Plant
            </Button>
            <Dialog open={isOpen} onClose={() => setIsOpen(false)} className="relative z-50">
                <div className="fixed inset-0 bg-black/40" aria-hidden="true" />

                <div className="fixed inset-0 flex items-center justify-center p-4">
                    <DialogPanel className="w-full max-w-xl rounded bg-white p-6 shadow-xl dark:bg-gray-800">
                        <div className="mb-4 flex items-center justify-between">
                            <DialogTitle className="w-full text-center text-2xl font-semibold">Add New Plant</DialogTitle>
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
                            <DropdownSelect
                                label="Device"
                                value={form.device}
                                options={toOptionList(devices)}
                                onChange={(value) => setForm({ ...form, device: value })}
                                className="w-full max-w-md"
                            />
                            <CustomAutocomplete
                                label="Plant Family"
                                className="w-full max-w-md"
                                options={plantFamilies}
                                value={family}
                                onChange={setFamily}
                            />
                            <CustomAutocomplete
                                label="Plant"
                                className="w-full max-w-md"
                                options={plants}
                                value={selectedPlant}
                                onChange={setSelectedPlants}
                            />
                            devices
                            <div>other parts to create the customer plant</div>
                            <div className="flex justify-center">
                                <button type="submit" className="rounded bg-green-700 px-4 py-2 text-white hover:bg-green-800">
                                    Register Plant
                                </button>
                            </div>
                        </form>
                    </DialogPanel>
                </div>
            </Dialog>
        </>
    );
}

export default AddPlant;
