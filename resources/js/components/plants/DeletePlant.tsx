import axiosClient from '@/utils/axiosClient';
import { Dialog, DialogPanel, DialogTitle } from '@headlessui/react';
import toast from 'react-hot-toast';
import { Button } from '../ui/button';

type PlantType = {
    id: number;
    name: string;
};
interface DeletePlantProps {
    plant: PlantType;
    onClose: () => void;
    onDelete: (id: number) => void;
}

function DeletePlant({ plant, onClose, onDelete }: DeletePlantProps) {
    const handleDelete = () => {
        axiosClient.delete('/api/plant/customer/destroy', { data: { id: plant.id } }).then(() => {
            onDelete(plant.id);
            onClose();
            toast.success(plant.name + ' deleted');
        });
    };
    return (
        <Dialog open onClose={onClose} className="relative z-50">
            <div className="fixed inset-0 bg-black/40" aria-hidden="true" />
            <div className="fixed inset-0 flex items-center justify-center p-4">
                <DialogPanel className="w-full max-w-md rounded bg-white p-6 text-center dark:bg-gray-800">
                    <DialogTitle className="mb-4 text-xl">Delete {plant.name}?</DialogTitle>
                    <p>Are you sure you want to delete this plant?</p>
                    <div className="mt-4 flex justify-center space-x-8">
                        <Button onClick={onClose} className="bg-gray-600 text-white hover:bg-gray-700">
                            Cancel
                        </Button>
                        <Button onClick={handleDelete} className="bg-red-600 text-white hover:bg-red-700">
                            Delete
                        </Button>
                    </div>
                </DialogPanel>
            </div>
        </Dialog>
    );
}

export default DeletePlant;
