import { UpdatePlantProps } from '@/types/plant';
import axiosClient from '@/utils/axiosClient';
import { Dialog, DialogPanel, DialogTitle } from '@headlessui/react';
import { X } from 'lucide-react';
import { useEffect, useState } from 'react';
import toast from 'react-hot-toast';
import DropdownSelect from '../ui/DropdownSelect';
import { Input } from '../ui/input';
import CustomAutocomplete from './CustomAutoComplete';
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

function UpdatePlant({ plant, onClose, onUpdate, devices, plantFamilies }: UpdatePlantProps) {
    const toOptionList = (items: any) => items.map((item: any) => ({ label: '(' + item.id + ') ' + item.city + ': ' + item.name, value: item.id }));
    let deviceList = toOptionList(devices);
    const [form, setForm] = useState({
        ...plant,
        plantType: '',
        minMoist: 0,
        maxMoist: 0,
        device: plant.device_id,
        plantImage:'',
    });
    const [plants, setPlants] = useState([]);
    const [family, setFamily] = useState(plant.plant.family);
    const [selectedPlant, setSelectedPlant] = useState(plant.plant.name_en);
    const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const { name, value, type, checked } = e.target;
        setForm((prev: any) => ({
            ...prev,
            [name]: type === 'checkbox' ? checked : value,
        }));
    };

    useEffect(() => {
        if(plant.plant.name_en!==form.plant.name_en)setSelectedPlant('');
        setPlants([]);
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

    const submit = () => {
            if (form.plantImage) {
                //formData.append('plantImage', form.plantImage);
            }
        axiosClient.put('/api/device/update', form).then(() => {
            onUpdate(plant.id, form);
            onClose();
            toast.success(plant.name + ' updated');
        });
    };
    console.log(plant);
    return (
        <Dialog open onClose={onClose} className="relative z-50">
            <div className="fixed inset-0 bg-black/40" aria-hidden="true" />
            <div className="fixed inset-0 flex items-center justify-center p-4">
                <DialogPanel className="w-full  max-w-8/12 rounded bg-white p-6 text-center dark:bg-gray-800">
                    <div className="mb-4 flex items-center justify-between">
                        <DialogTitle className="w-full text-center text-2xl font-semibold">Update {plant.name}</DialogTitle>
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
                            <div className="grid grid-cols-1 content-center gap-2 overflow-y-auto pr-2 pb-5 md:grid-cols-2">
                        <Input
                            className="w-full max-w-md rounded bg-gray-100 p-2 px-4 dark:bg-gray-700"
                            type="text"
                            name={'name'}
                            required={true}
                            value={form.name}
                            onChange={handleChange}
                            placeholder={`Enter the name of the plant`}
                            label={'Name'}
                        />
                        <DropdownSelect
                            label="Device"
                            value={form.device}
                            options={deviceList}
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
                                {plants.length > 0 ? (
                                    <CustomAutocomplete
                                        label="Plant"
                                        className="w-full max-w-md"
                                        options={plants}
                                        value={selectedPlant}
                                        onChange={setSelectedPlant}
                                    />
                                ) : (
                                    <Input
                                        className="w-full max-w-md rounded bg-gray-100 p-2 px-4 underline decoration-pink-500 dark:bg-gray-700"
                                        type="text"
                                        value={form.plant.name_en}
                                        disabled={true}
                                        placeholder={`Select family first!`}
                                        label={'Plant'}
                                    />
                                )}
                                <Input
                                    className="w-full max-w-md rounded bg-gray-100 p-2 px-4 dark:bg-gray-700"
                                    type="number"
                                    name={'pot_size'}
                                    required={true}
                                    value={form.pot_size}
                                    onChange={handleChange}
                                    placeholder={`Enter Pot Size`}
                                    label={'Pot Size (ml)'}
                                    min={0}
                                />
                                <DropdownSelect
                                    required={true}
                                    label="Dirt Type"
                                    value={form.dirt_type}
                                    options={DIRT_TYPES}
                                    onChange={(value) => setForm({ ...form, dirt_type: value })}
                                    className="w-full max-w-md"
                                />
                                <Input
                                    className="w-full max-w-md rounded bg-gray-100 p-2 px-4 dark:bg-gray-700"
                                    type="text"
                                    name={'plant_type'}
                                    disabled
                                    value={form.plant_type.type}
                                    onChange={handleChange}
                                    placeholder={`Plant Type`}
                                    label={'Plant type'}
                                />
                                <Input
                                    className="w-full max-w-md rounded bg-gray-100 p-2 px-4 dark:bg-gray-700"
                                    type="number"
                                    name={'minimum_moisture'}
                                    required={true}
                                    value={form.plant_type.min_soil_moisture == -1 ? null : form.plant_type.min_soil_moisture}
                                    onChange={handleChange}
                                    placeholder={`Min moisture level of the soil under the plant`}
                                    label={'Min moisture (%)'}
                                    min="0"
                                    max={Math.min(100, form.plant_type.max_soil_moisture)}
                                />
                                <Input
                                    className="w-full max-w-md rounded bg-gray-100 p-2 px-4 dark:bg-gray-700"
                                    type="number"
                                    name={'maximum_moisture'}
                                    required={true}
                                    value={form.plant_type.max_soil_moisture == -1 ? null : form.plant_type.max_soil_moisture}
                                    onChange={handleChange}
                                    placeholder={`Max moisture level of the soil under the plant`}
                                    label={'Max moisture (%)'}
                                    min={Math.max(0, form.plant_type.min_soil_moisture)}
                                    max={100}
                                />
                                <Input
                                    type="file"
                                    name="plantImage"
                                    accept="image/*"
                                    onChange={(e: any) => {
                                        if (e.target.files?.[0]) {
                                            setForm((prev) => ({
                                                ...prev,
                                                plantImage: e.target.files[0],
                                            }));
                                        }
                                    }}
                                    label={'Image of the Plant'}
                                />
                                </div>
                        {plant.plant_img !== null && plant.plant_img.trim().length > 0 ? (
                    <div className="max-h-24 max-w-24 overflow-hidden rounded-2xl md:max-h-18 md:max-w-18 lg:max-h-40 lg:max-w-40">
                        <img src={plant.plant_img} className="h-full w-full" alt={plant.name} loading="lazy"></img>
                    </div>
                ) : null}
                    </form>
                </DialogPanel>
            </div>
        </Dialog>
    );
}

export default UpdatePlant;
