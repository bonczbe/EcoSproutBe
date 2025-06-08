import axiosClient from '@/utils/axiosClient';
import { Dialog, DialogPanel, DialogTitle } from '@headlessui/react';
import { X } from 'lucide-react';
import { useEffect, useState } from 'react';
import toast from 'react-hot-toast';
import { Button } from '../ui/button';
import DropdownSelect from '../ui/DropdownSelect';
import { Input } from '../ui/input';
import CustomAutocomplete from './CustomAutoComplete';

function AddPlant({ onPlantAdded, devices, plantFamilies }: any) {
    const [isOpen, setIsOpen] = useState(false);
    const [plants, setPlants] = useState([]);
    const [family, setFamily] = useState('');
    const [selectedPlant, setSelectedPlant] = useState('');
    const [form, setForm] = useState({
        device: -1,
        potSize: 0,
        maxMoist: -1,
        minMoist: -1,
        dritType: '',
        name: '',
        plantType: '',
    });

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

    useEffect(() => {
        setSelectedPlant('');
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

    useEffect(() => {
        const fetchPlant = async () => {
            if (selectedPlant != '') {
                await axiosClient
                    .post('/api/plant/show/' + selectedPlant, {
                        family: family,
                    })
                    .then((res) => {
                        const plantdatas = res.data;
                        console.log(plantdatas);
                        setForm({
                            ...form,
                            name: 'My ' + plantdatas.name_en,
                            plantType: plantdatas.plant_type.type,
                            minMoist: plantdatas.plant_type.min_soil_moisture,
                            maxMoist: plantdatas.plant_type.max_soil_moisture,
                        });
                    });
            }
        };
        fetchPlant();
    }, [selectedPlant]);

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
                    <DialogPanel className="flex max-h-[90vh] w-full max-w-xl flex-col overflow-hidden rounded bg-white p-6 shadow-xl dark:bg-gray-800">
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
                            className="flex-1 space-y-4 overflow-y-auto pr-2"
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
                                disabled={family.trim() == '' && plants.length > 0}
                                className="w-full max-w-md"
                                options={plants}
                                value={selectedPlant}
                                onChange={setSelectedPlant}
                            />
                            <Input
                                className="w-full max-w-md rounded bg-gray-100 p-2 px-4 dark:bg-gray-700"
                                type="text"
                                name={'name'}
                                value={form.name}
                                onChange={handleChange}
                                placeholder={`Named as`}
                                label={'Own Name of "plant"'}
                            />
                            <Input
                                className="w-full max-w-md rounded bg-gray-100 p-2 px-4 dark:bg-gray-700"
                                type="number"
                                name={'potSize'}
                                required={true}
                                value={form.potSize}
                                onChange={handleChange}
                                placeholder={`Enter Pot Size`}
                                label={'Pot Size (ml)'}
                                min="0"
                            />
                            <DropdownSelect
                                label="Dirt Type"
                                value={form.dritType}
                                options={DIRT_TYPES}
                                onChange={(value) => setForm({ ...form, dritType: value })}
                                className="w-full max-w-md"
                            />
                            <Input
                                className="w-full max-w-md rounded bg-gray-100 p-2 px-4 dark:bg-gray-700"
                                type="text"
                                name={'plantType'}
                                disabled
                                value={form.plantType}
                                onChange={handleChange}
                                placeholder={`Plant Type`}
                                label={'Plant type'}
                            />
                            <Input
                                className="w-full max-w-md rounded bg-gray-100 p-2 px-4 dark:bg-gray-700"
                                type="number"
                                name={'minMoist'}
                                required={true}
                                value={form.minMoist == -1 ? null : form.minMoist}
                                onChange={handleChange}
                                placeholder={`Min moisture level of the soil under the plant`}
                                label={'Min moisture (%)'}
                                min="0"
                                max={Math.min(100, form.maxMoist)}
                            />
                            <Input
                                className="w-full max-w-md rounded bg-gray-100 p-2 px-4 dark:bg-gray-700"
                                type="number"
                                name={'maxMoist'}
                                required={true}
                                value={form.maxMoist == -1 ? null : form.maxMoist}
                                onChange={handleChange}
                                placeholder={`Max moisture level of the soil under the plant`}
                                label={'Max moisture (%)'}
                                min={Math.max(0, form.minMoist)}
                                max={100}
                            />
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
